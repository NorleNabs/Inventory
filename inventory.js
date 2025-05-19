const data = {
    daily: {
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        pieData: [15, 25, 20, 30, 10, 15, 25],
        lineData: [65, 59, 80, 81, 56, 55, 40],
        barData: {
            revenue: [120, 150, 180, 190, 210, 180, 160],
            expenses: [90, 100, 140, 130, 150, 120, 110],
            profit: [30, 50, 40, 60, 60, 60, 50]
        }
    },
    weekly: {
        labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
        pieData: [40, 30, 20, 10],
        lineData: [70, 80, 60, 90],
        barData: {
            revenue: [520, 580, 620, 710],
            expenses: [420, 450, 480, 520],
            profit: [100, 130, 140, 190]
        }
    },
    monthly: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
        pieData: [30, 20, 25, 15, 20, 30],
        lineData: [65, 75, 70, 80, 85, 90],
        barData: {
            revenue: [1200, 1300, 1400, 1500, 1600, 1700],
            expenses: [900, 950, 1000, 1050, 1100, 1150],
            profit: [300, 350, 400, 450, 500, 550]
        }
    },
    yearly: {
        labels: ['2020', '2021', '2022', '2023', '2024'],
        pieData: [15, 20, 25, 30, 35],
        lineData: [60, 70, 80, 90, 95],
        barData: {
            revenue: [12000, 14000, 16000, 18000, 20000],
            expenses: [9000, 10000, 11000, 12000, 13000],
            profit: [3000, 4000, 5000, 6000, 7000]
        }
    }
};

// Chart objects
let pieChart, lineChart, barChart;

// Function to get random colors
function getRandomColors(count) {
    const colors = [];
    for (let i = 0; i < count; i++) {
        const r = Math.floor(Math.random() * 200) + 55;
        const g = Math.floor(Math.random() * 200) + 55;
        const b = Math.floor(Math.random() * 200) + 55;
        colors.push(`rgba(${r}, ${g}, ${b}, 0.7)`);
    }
    return colors;
}

// Initialize charts
function initCharts() {
    // Pie Chart
    const pieCtx = document.getElementById('pieChart').getContext('2d');
    pieChart = new Chart(pieCtx, {
        type: 'pie',
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right'
                },
                title: {
                    display: true,
                    text: 'Revenue Sources'
                }
            }
        }
    });

    // Line Chart
    const lineCtx = document.getElementById('lineChart').getContext('2d');
    lineChart = new Chart(lineCtx, {
        type: 'line',
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top'
                },
                title: {
                    display: true,
                    text: 'Sales Trend Over Time'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Bar Chart
    const barCtx = document.getElementById('barChart').getContext('2d');
    barChart = new Chart(barCtx, {
        type: 'bar',
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top'
                },
                title: {
                    display: true,
                    text: 'Revenue vs Expenses'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Update charts with initial data
    updateCharts();
}

// Update charts based on selected time range
function updateCharts() {
    const timeRange = document.getElementById('dataRange').value;
    const currentData = data[timeRange];
    const colors = getRandomColors(currentData.labels.length);

    // Update Pie Chart
    pieChart.data = {
        labels: currentData.labels,
        datasets: [{
            data: currentData.pieData,
            backgroundColor: colors,
            borderWidth: 1
        }]
    };
    pieChart.update();

    // Update Line Chart
    lineChart.data = {
        labels: currentData.labels,
        datasets: [{
            label: 'Sales',
            data: currentData.lineData,
            borderColor: 'rgba(75, 192, 192, 1)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderWidth: 2,
            tension: 0.3,
            fill: true
        }]
    };
    lineChart.update();

    // Update Bar Chart
    barChart.data = {
        labels: currentData.labels,
        datasets: [
            {
                label: 'Revenue',
                data: currentData.barData.revenue,
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            },
            {
                label: 'Expenses',
                data: currentData.barData.expenses,
                backgroundColor: 'rgba(255, 99, 132, 0.7)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            },
            {
                label: 'Profit',
                data: currentData.barData.profit,
                backgroundColor: 'rgba(75, 192, 192, 0.7)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }
        ]
    };
    barChart.update();
}

const sidebar = document.getElementById('sidebar');
const menuTexts = sidebar.querySelectorAll('.menu-text, .submenu-text, .logo-text, .sidebar-footer span');

document.getElementById('sidebarCollapse').addEventListener('click', function() {
    document.getElementById('sidebar').classList.toggle('collapsed');
    document.getElementById('content').classList.toggle('expanded');
    const isCollapsed = sidebar.classList.contains('collapsed');

    
        

        setTimeout(() => {
            menuTexts.forEach(el => el.style.opacity = '1');
        }, 1000); 
   
        menuTexts.forEach(el => el.style.opacity = '0');
});



const hasSubmenuLinks = document.querySelectorAll('.has-submenu');
hasSubmenuLinks.forEach(function(link) {
    link.addEventListener('click', function(e) {
        e.preventDefault();
        
        this.classList.toggle('open');
        
        const submenuId = this.getAttribute('href');
        const submenu = document.querySelector(submenuId);
        
        if (submenu) {
            submenu.classList.toggle('show');
        }
    });
});


