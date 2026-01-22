<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Core\QueryCache;
use PDO;

class ExpenseController extends Controller
{
    private $db;
    private $userId;
    private $cache;

    public function __construct()
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
        $this->db = Database::getInstance()->getConnection();
        $this->userId = $_SESSION['user_id'];
        $this->cache = new QueryCache();
    }

    public function index()
    {
        // Fetch categories for the dropdown
        $stmt = $this->db->prepare("SELECT * FROM categories WHERE user_id IS NULL OR user_id = ?");
        $stmt->execute([$this->userId]);
        $categories = $stmt->fetchAll();

        $this->view('dashboard/index', ['categories' => $categories, 'user_name' => $_SESSION['user_name']]);
    }

    public function list()
    {
        // Filters
        $cat = $_GET['category'] ?? '';
        $dateFrom = $_GET['from'] ?? '';
        $dateTo = $_GET['to'] ?? '';

        $sql = "SELECT e.*, c.name as category_name, c.color as category_color 
                FROM expenses e 
                JOIN categories c ON e.category_id = c.id 
                WHERE e.user_id = ?";

        $params = [$this->userId];

        if ($cat) {
            $sql .= " AND e.category_id = ?";
            $params[] = $cat;
        }
        if ($dateFrom) {
            $sql .= " AND e.date >= ?";
            $params[] = $dateFrom;
        }
        if ($dateTo) {
            $sql .= " AND e.date <= ?";
            $params[] = $dateTo;
        }

        $sql .= " ORDER BY e.date DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $expenses = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Also calculate stats for the chart (Green Coding: Cached)
        // We use a simplified cache key based on basic filters or just global user stats
        // For accurate filtering + caching, we'd need complex keys. 
        // Strategy: Cache only the "All time" or "Current Month" stats if no filters applied.

        $stats = [];
        if (empty($cat) && empty($dateFrom) && empty($dateTo)) {
            $cacheKey = "user_{$this->userId}_stats_global";
            $cachedStats = $this->cache->get($cacheKey);

            if ($cachedStats) {
                $stats = $cachedStats;
                header('X-Cache-Hit: true');
            } else {
                $groupSql = "SELECT c.name, c.color, SUM(e.amount) as total 
                             FROM expenses e 
                             JOIN categories c ON e.category_id = c.id 
                             WHERE e.user_id = ? 
                             GROUP BY c.id";
                $gStmt = $this->db->prepare($groupSql);
                $gStmt->execute([$this->userId]);
                $stats = $gStmt->fetchAll(PDO::FETCH_ASSOC);
                $this->cache->set($cacheKey, $stats);
                header('X-Cache-Hit: false');
            }
        }

        $this->json(['expenses' => $expenses, 'stats' => $stats]);
    }

    public function create()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        if (!$data) {
            $this->json(['error' => 'Invalid input'], 400);
        }

        $amount = $data['amount'];
        $categoryId = $data['category_id'];
        $description = $data['description'];
        $date = $data['date'];
        $location = $data['location'] ?? null;

        $stmt = $this->db->prepare("INSERT INTO expenses (user_id, category_id, amount, description, date, location) VALUES (?, ?, ?, ?, ?, ?)");

        try {
            $stmt->execute([$this->userId, $categoryId, $amount, $description, $date, $location]);

            // Invalidate Cache
            $this->cache->invalidate($this->userId);

            $this->json(['success' => true]);
        } catch (\Exception $e) {
            $this->json(['error' => $e->getMessage()], 500);
        }
    }

    public function delete()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $data['id'] ?? 0;

        $stmt = $this->db->prepare("DELETE FROM expenses WHERE id = ? AND user_id = ?");
        $stmt->execute([$id, $this->userId]);

        // Invalidate Cache
        $this->cache->invalidate($this->userId);

        $this->json(['success' => true]);
    }
}
