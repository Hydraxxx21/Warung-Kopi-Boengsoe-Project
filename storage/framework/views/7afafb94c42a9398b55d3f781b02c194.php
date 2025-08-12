<?php echo $__env->make('layouts.navbar-admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('layouts.sidebar-admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<div class="main-content mt-5">
    <div class="container-fluid">
        <style>
            .dashboard-container {
                max-width: 1200px;
                margin: 0 auto;
                padding: 20px;
                font-family: Arial, sans-serif;
            }

            .stats-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 20px;
                margin-bottom: 40px;
            }

            .stat-card {
                background: #D9D9D9;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                text-align: center;
            }

            .stat-value {
                font-size: 2em;
                font-weight: bold;
                color: #2c3e50;
                margin-bottom: 5px;
            }

            .stat-label {
                color: #7f8c8d;
                font-size: 0.9em;
            }

            .chart-container {
                background: #D9D9D9;
                padding: 30px;
                border-radius: 8px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                margin-bottom: 30px;
                max-height: 500px;
                position: relative;
                overflow: hidden;
            }

            .chart-container-pie {
                background: #D9D9D9;
                padding: 30px;
                border-radius: 8px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                margin-bottom: 30px;
                max-height: 450px;
                position: relative;
                overflow: hidden;
            }

            .chart-title {
                font-size: 1.5em;
                margin-bottom: 20px;
                color: #2c3e50;
                text-align: center;
            }

            .chart-wrapper {
                position: relative;
                height: 350px;
                max-height: 350px;
            }

            .chart-wrapper-pie {
                position: relative;
                height: 300px;
                max-height: 300px;
            }

            .charts-row {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 30px;
                margin-bottom: 30px;
            }

            @media (max-width: 768px) {
                .charts-row {
                    grid-template-columns: 1fr;
                }
            }
        </style>

        <h4>Dashboard Admin</h4>

        <!-- Statistics Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-value"><?php echo e($countOrder ?? 0); ?></div>
                <div class="stat-label">Total Orders</div>
            </div>
            <div class="stat-card">
                <div class="stat-value"><?php echo e($countProduct ?? 0); ?></div>
                <div class="stat-label">Total Products</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">Rp <?php echo e(number_format($countAllPrice ?? 0, 0, ',', '.')); ?></div>
                <div class="stat-label">Total Revenue</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">Rp <?php echo e(number_format($countCash ?? 0, 0, ',', '.')); ?></div>
                <div class="stat-label">Cash Revenue</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">Rp <?php echo e(number_format($countQris ?? 0, 0, ',', '.')); ?></div>
                <div class="stat-label">QRIS Revenue</div>
            </div>
        </div>

        <!-- Charts Row 1: Line Chart and Pie Chart -->
        <div class="charts-row">
            <!-- Monthly Revenue Chart -->
            <div class="chart-container">
                <div class="chart-title">Monthly Revenue Trend</div>
                <div class="chart-wrapper">
                    <canvas id="monthlyRevenueChart"></canvas>
                </div>
            </div>

            <!-- Payment Method Pie Chart -->
            <div class="chart-container-pie">
                <div class="chart-title">Payment Methods - <?php echo e($latestMonthName ?? 'Current Month'); ?></div>
                <div class="chart-wrapper-pie">
                    <canvas id="paymentMethodChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Last 12 Months Payment Methods Comparison -->
        <div class="chart-container">
            <div class="chart-title">Payment Methods Comparison - Last 12 Months</div>
            <div class="chart-wrapper">
                <canvas id="paymentComparisonChart"></canvas>
            </div>
        </div>
    </div>
</div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>

<script>
    // Monthly Revenue Line Chart
    const monthlyCtx = document.getElementById('monthlyRevenueChart').getContext('2d');
    const monthlyChart = new Chart(monthlyCtx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($chartLabels ?? [], 15, 512) ?>,
            datasets: [{
                label: 'Monthly Revenue (Rp)',
                data: <?php echo json_encode($chartData ?? [], 15, 512) ?>,
                borderColor: '#3498db',
                backgroundColor: 'rgba(52, 152, 219, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#3498db',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    },
                    grid: {
                        color: 'rgba(0,0,0,0.1)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            },
            elements: {
                point: {
                    hoverBorderWidth: 3
                }
            }
        }
    });

    // Payment Method Pie Chart
    const pieCtx = document.getElementById('paymentMethodChart').getContext('2d');
    const pieChart = new Chart(pieCtx, {
        type: 'pie',
        data: {
            labels: <?php echo json_encode($pieChartLabels ?? [], 15, 512) ?>,
            datasets: [{
                data: <?php echo json_encode($pieChartData ?? [], 15, 512) ?>,
                backgroundColor: [
                    '#3498db', // QRIS - Blue
                    '#2ecc71', // Cash - Green
                    '#e74c3c', // Other - Red (jika ada)
                    '#f39c12', // Additional colors
                    '#9b59b6'
                ],
                borderColor: '#fff',
                borderWidth: 3,
                hoverBorderWidth: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                        font: {
                            size: 12
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.parsed;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((value / total) * 100).toFixed(1);
                            return label + ': Rp ' + value.toLocaleString('id-ID') + ' (' + percentage + '%)';
                        }
                    }
                }
            }
        }
    });

    // Payment Methods Comparison Chart (Last 12 Months)
    const comparisonCtx = document.getElementById('paymentComparisonChart').getContext('2d');
    const comparisonChart = new Chart(comparisonCtx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($last12MonthsLabels ?? [], 15, 512) ?>,
            datasets: [{
                label: 'QRIS Revenue (Rp)',
                data: <?php echo json_encode($last12MonthsQrisData ?? [], 15, 512) ?>,
                borderColor: '#3498db',
                backgroundColor: 'rgba(52, 152, 219, 0.1)',
                borderWidth: 3,
                fill: false,
                tension: 0.4,
                pointBackgroundColor: '#3498db',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7
            }, {
                label: 'Cash Revenue (Rp)',
                data: <?php echo json_encode($last12MonthsCashData ?? [], 15, 512) ?>,
                borderColor: '#2ecc71',
                backgroundColor: 'rgba(46, 204, 113, 0.1)',
                borderWidth: 3,
                fill: false,
                tension: 0.4,
                pointBackgroundColor: '#2ecc71',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    },
                    grid: {
                        color: 'rgba(0,0,0,0.1)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            },
            elements: {
                point: {
                    hoverBorderWidth: 3
                }
            }
        }
    });
</script>
<?php echo $__env->make('layouts.header-admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\warkop-main\resources\views/admin/dashboard/index.blade.php ENDPATH**/ ?>