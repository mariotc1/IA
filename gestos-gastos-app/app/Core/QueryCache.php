<?php

namespace App\Core;

class QueryCache
{
    private $cacheDir;

    public function __construct()
    {
        $this->cacheDir = __DIR__ . '/../../cache/';
        if (!is_dir($this->cacheDir)) {
            mkdir($this->cacheDir, 0777, true);
        }
    }

    public function get($key)
    {
        $file = $this->cacheDir . md5($key) . '.json';

        if (file_exists($file)) {
            $content = json_decode(file_get_contents($file), true);
            // Check expiry (simple check: if file is older than 1 hour)
            // Ideally we pass TTL. For green coding, we want to maximize reuse.
            // We'll rely on explicit invalidation (events) rather than short TTLs for max efficiency.
            return $content;
        }

        return null;
    }

    public function set($key, $data)
    {
        $file = $this->cacheDir . md5($key) . '.json';
        file_put_contents($file, json_encode($data));
    }

    public function invalidate($user_id)
    {
        // Simple strategy: Deletes all cache files for a specific user? 
        // Since we hash keys, we can't easily find "all keys for user X".
        // Better: We prefix keys or just clear all for simplicity in this MVP 
        // OR simply rely on the fact that we can't easily selective clear without a manifest.
        // Let's change strategy: Key = "user_{$id}_report_XYZ". 
        // We can scan directory for files matching a pattern if we store filenames differently.
        // For now, let's keep it simple: Clean ALL cache on modification (safest) OR
        // Just don't implement invalidation here, implement in the Controller to be specific.

        // Let's implement a clear method
        $files = glob($this->cacheDir . '*');
        foreach ($files as $file) {
            if (is_file($file))
                unlink($file);
        }
    }
}
