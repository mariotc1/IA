document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("addExpenseForm");
  const tableBody = document.getElementById("expenseListBody");
  const filterCategory = document.getElementById("filterCategory");
  const filterFrom = document.getElementById("filterFrom");
  const filterTo = document.getElementById("filterTo");

  let chartInstance = null;

  // Load initial data
  loadData();

  // Event Listeners
  form.addEventListener("submit", async (e) => {
    e.preventDefault();
    const formData = new FormData(form);
    const data = Object.fromEntries(formData.entries());

    try {
      const res = await fetch("/api/expenses", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(data),
      });
      const result = await res.json();
      if (result.success) {
        form.reset();
        loadData(); // Refresh list and stats
      } else {
        alert("Error: " + result.error);
      }
    } catch (err) {
      console.error(err);
    }
  });

  [filterCategory, filterFrom, filterTo].forEach((el) => {
    el.addEventListener("change", loadData);
  });

  async function loadData() {
    const cat = filterCategory.value;
    const from = filterFrom.value;
    const to = filterTo.value;

    const query = new URLSearchParams({
      category: cat,
      from: from,
      to: to,
    }).toString();

    try {
      const res = await fetch(`/api/expenses?${query}`);
      const data = await res.json();

      renderTable(data.expenses);
      renderChart(data.expenses, data.stats);
    } catch (err) {
      console.error("Error fetching data:", err);
    }
  }

  function renderTable(expenses) {
    tableBody.innerHTML = "";
    if (expenses.length === 0) {
      tableBody.innerHTML =
        '<tr><td colspan="5" style="text-align:center; color: #666;">Sin gastos registrados</td></tr>';
      return;
    }

    expenses.forEach((exp) => {
      const tr = document.createElement("tr");
      tr.className = "expense-row";
      tr.innerHTML = `
                <td>${exp.date}</td>
                <td><span class="badge-category" style="background-color: ${exp.category_color}20; color: ${exp.category_color}">${exp.category_name}</span></td>
                <td>${exp.description || "-"}</td>
                <td class="amount-expense">${parseFloat(exp.amount).toFixed(2)} €</td>
                 <td><button onclick="deleteExpense(${exp.id})" style="background:none; border:none; color: var(--danger); cursor:pointer;">&times;</button></td>
            `;
      tableBody.appendChild(tr);
    });
  }

  // Global delete function
  window.deleteExpense = async (id) => {
    if (!confirm("¿Eliminar gasto?")) return;
    try {
      await fetch("/api/expenses/delete", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id }),
      });
      loadData();
    } catch (err) {
      console.error(err);
    }
  };

  function renderChart(expenses, stats) {
    const ctx = document.getElementById("expenseChart").getContext("2d");

    // Prepare data: Group by category derived from expenses list OR use backend stats if available
    // If filters are active, backend stats might be empty (based on our logic),
    // so we can fallback to calculating client side for the viewed set.

    let labels = [];
    let dataValues = [];
    let colors = [];

    // Simple client-side aggregation for the current view
    const aggregation = {};
    expenses.forEach((exp) => {
      if (!aggregation[exp.category_name]) {
        aggregation[exp.category_name] = {
          total: 0,
          color: exp.category_color,
        };
      }
      aggregation[exp.category_name].total += parseFloat(exp.amount);
    });

    Object.keys(aggregation).forEach((key) => {
      labels.push(key);
      dataValues.push(aggregation[key].total);
      colors.push(aggregation[key].color);
    });

    if (chartInstance) {
      chartInstance.destroy();
    }

    chartInstance = new Chart(ctx, {
      type: "doughnut",
      data: {
        labels: labels,
        datasets: [
          {
            data: dataValues,
            backgroundColor: colors,
            borderWidth: 0,
          },
        ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: "right",
            labels: { color: "#fff" },
          },
        },
      },
    });
  }
});
