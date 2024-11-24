@extends('layouts.admin')
@section('title', 'Trang Thống Kê')
@section('content')

    <h1 class="text-center my-5" style="font-size: 2.5rem; font-weight: bold; color: #343a40;">Bảng Thống Kê</h1>

    <style>
        body {
            background-color: #f9fafb;
        }

        .card {
            background-color: #ffffff;
            border: none;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .card-header {
            background-color: #343a40;
            color: white;
            font-size: 1.2rem;
            font-weight: bold;
            padding: 15px 20px;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }

        .card-body {
            padding: 25px;
            font-size: 1.1rem;
        }

        .total-revenue {
            font-size: 1.5rem;
            color: #28a745;
            font-weight: bold;
        }

        .stats-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .stats-item {
            flex: 0 0 48%;
            margin-bottom: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: relative;
            transition: all 0.3s ease-in-out;
        }

        .stats-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .stats-item i {
            position: absolute;
            right: 20px;
            top: 20px;
            font-size: 1.5rem;
        }

        .stats-item .fa-check-circle {
            color: #28a745;
        }

        .stats-item .fa-times-circle {
            color: #dc3545;
        }

        .stats-item .fa-shopping-cart {
            color: #007bff;
        }

        .stats-item .fa-users {
            color: #ffc107;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        table th, table td {
            text-align: left;
            padding: 15px;
            border-bottom: 1px solid #dee2e6;
        }

        table th {
            background-color: #f1f3f5;
            color: #343a40;
            font-weight: bold;
        }

        table td {
            color: #555555;
        }

        table tr:hover {
            background-color: #e9ecef;
        }

        .charts-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            gap: 20px;
        }

        .card {
            flex: 1;
            min-width: 300px;
        }

        canvas {
            max-width: 100%;
            height: 300px;
        }

        @media (max-width: 768px) {
            .stats-item {
                flex: 0 0 100%;
            }

            .charts-container {
                flex-direction: column;
            }

            h1 {
                font-size: 2rem;
            }
        }
    </style>

<div class="container-fluid">
    <div class="stats-container">
        <div class="stats-item">
            <h5>Tổng Số Đơn Hàng:</h5>
            <p>{{ $totalOrders }}</p>
            <i class="fas fa-shopping-cart" style="color: #007bff;"></i> <!-- Blue for orders -->
        </div>
        <div class="stats-item">
            <h5>Tổng Số Khách Hàng:</h5>
            <p>{{ $totalCustomers }}</p>
            <i class="fas fa-users" style="color: #ffc107;"></i> <!-- Yellow for customers -->
        </div>
        <div class="stats-item">
            <h5>Tổng Doanh Thu (Đã Hoàn Thành):</h5>
            <p class="total-revenue">{{ number_format($totalRevenueCompleted, 0, ',', '.') }} đ</p>
            <i class="fas fa-wallet" style="color: #28a745;"></i> <!-- Green for completed revenue -->
        </div>
        <div class="stats-item">
            <h5>Tổng Số Đơn Chưa Hoàn Thành:</h5>
            <p>{{ $totalPendingOrders }}</p>
            <i class="fas fa-hourglass-half" style="color: #17a2b8;"></i> <!-- Cyan for pending orders -->
        </div>
        <div class="stats-item">
            <h5>Tổng Số Đơn Đã Hoàn Thành:</h5>
            <p>{{ $totalCompletedOrders }}</p>
            <i class="fas fa-check-circle" style="color: #28a745;"></i> <!-- Green for completed orders -->
        </div>
        <div class="stats-item">
            <h5>Tổng Số Đơn Đã Hủy:</h5>
            <p>{{ $totalCancelledOrders }}</p>
            <i class="fas fa-ban" style="color: #dc3545;"></i> <!-- Red for cancelled orders -->
        </div>
    </div>

    <div class="charts-container">
        <div class="card flex">
            <div class="card-header">Doanh Thu Theo Thời Gian</div>
            <div class="card-body">
                <form id="revenue-form" class="mb-4">
                    <div class="form-group">
                        <label for="timeframe">Chọn Thời Gian:</label>
                        <select id="timeframe" class="form-control" onchange="updateChart()">
                            <option value="day">Theo Ngày</option>
                            <option value="month">Theo Tháng</option>
                            <option value="year">Theo Năm</option>
                        </select>
                    </div>
                </form>
                <canvas id="revenueChart" width="300" height="150"></canvas>
            </div>
        </div>

        <div class="card flex">
            <div class="card-header">Doanh Thu Theo Danh Mục</div>
            <div class="card-body">
                <canvas id="categoryChart" width="300" height="150"></canvas>
            </div>
        </div>

        <div class="card flex">
    <div class="card-header">Theo Phương Thức Thanh Toán</div>
    <div class="card-body">
        <canvas id="paymentChart" width="300" height="150"></canvas>
    </div>
</div>



    </div>
</div>


        <script>
            const ctx = document.getElementById('revenueChart').getContext('2d');
            const categoryCtx = document.getElementById('categoryChart').getContext('2d');
            let revenueChart;
            let categoryChart;

            function updateChart() {
                const timeframe = document.getElementById('timeframe').value;

                fetch(`/admin/revenue-data?timeframe=${timeframe}`)
                    .then(response => response.json())
                    .then(data => {
                        const completedLabels = data.completed.map(item => item.label);
                        const completedRevenue = data.completed.map(item => item.revenue);
                        const pendingLabels = data.pending.map(item => item.label);
                        const pendingRevenue = data.pending.map(item => item.revenue);

                        if (revenueChart) {
                            revenueChart.destroy();
                        }

                        revenueChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: completedLabels,
                                datasets: [
                                    {
                                        label: 'Doanh thu (VNĐ)',
                                        data: completedRevenue,
                                        backgroundColor: 'rgba(40, 167, 69, 0.5)',
                                        borderColor: 'rgba(40, 167, 69, 1)',
                                        borderWidth: 1
                                    },
                                ]
                            },
                            options: {
                                responsive: true,
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    })
                    .catch(error => console.error('Lỗi khi lấy dữ liệu doanh thu:', error));

                    const customColors = [
    '#FF5733', // Bright orange
    '#33FF57', // Bright green
    '#3357FF', // Bright blue
    '#FF33A1', // Bright pink
    '#FFFF33', // Bright yellow
    '#33FFF7', // Bright cyan
    '#FF8C33', // Another shade of orange
];


                fetch('/admin/category-revenue-data')
                    .then(response => response.json())
                    .then(data => {
                        const categoryLabels = data.map(item => item.category_name);
                        const categoryRevenue = data.map(item => item.revenue);

                        if (categoryChart) {
                            categoryChart.destroy();
                        }

                        categoryChart = new Chart(categoryCtx, {
                            type: 'doughnut',
                            data: {
                                labels: categoryLabels,
                                datasets: [{
                                    label: 'Doanh Thu Theo Danh Mục',
                                    data: categoryRevenue,
                                    backgroundColor: customColors,
                                    borderColor: '#fff',
                                    borderWidth: 2
                                }]
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        position: 'top',
                                    },
                                    tooltip: {
                                        callbacks: {
                                            label: function(tooltipItem) {
                                                const formattedValue = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(tooltipItem.raw);
                                return `${tooltipItem.label}: ${formattedValue}`;
                                            }
                                        }
                                    }   
                                }
                            }
                        });
                    })
                    .catch(error => console.error('Lỗi khi lấy dữ liệu doanh thu theo danh mục:', error));
            }

            const paymentCtx = document.getElementById('paymentChart').getContext('2d');
let paymentChart;

fetch('/admin/payment-revenue-data')
    .then(response => response.json())
    .then(data => {
        // Map payment methods to more user-friendly labels
        const paymentLabels = data.map(item => {
            switch (item.payment_method) {
                case 'cod':
                    return 'Thanh toán khi nhận hàng';
                case 'momo':
                    return 'MoMo'; 
                case 'momo_qr':
                    return 'MoMo(QR)';
                default:
                    return item.payment_method.charAt(0).toUpperCase() + item.payment_method.slice(1);
            }
        });

        const paymentRevenue = data.map(item => item.revenue);

        paymentChart = new Chart(paymentCtx, {
            type: 'pie',
            data: {
                labels: paymentLabels,
                datasets: [{
                    label: 'Doanh Thu Theo Phương Thức Thanh Toán',
                    data: paymentRevenue,
                    backgroundColor: paymentRevenue.map((_, index) => `hsl(${index * 50}, 70%, 50%)`),
                    borderColor: '#fff',
                    borderWidth: 2  
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                const formattedValue = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(tooltipItem.raw);
                                return `${tooltipItem.label}: ${formattedValue}`;
                            }
                        }
                    }
                }
            }
        });
    })
    .catch(error => console.error('Lỗi khi lấy dữ liệu doanh thu theo phương thức thanh toán:', error));


document.addEventListener('DOMContentLoaded', updateChart);
        </script>
    </div>
@endsection
