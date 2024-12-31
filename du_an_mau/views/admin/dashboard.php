<?php 
    include_once './models/database.php';
    include_once './models/Dashboard.php';
    include_once './config/helper.php';

    $dashboard_data = Dashboard::get_dashboard_data($conn);
    $top_5_data = Dashboard::get_top_5_products($conn);

    $label_list = [];
    $data_list = [];

    foreach($top_5_data['data'] as $data) {
        $label_list[] = $data['title'];
        $data_list[] = $data['sold'];
    }
?>

<section>
    <div class="container-fluid">
        <div class="px-2 py-5">
            <div class="row">
                <div class="col-3 d-flex justify-content-center`x">
                    <div class="circle">
                        <h2 class="title fs-5">Doanh thu (VNĐ)</h2>
                        <p class="amount"><?php echo format_price($dashboard_data['data'][3]['total']) ?></p>
                    </div>
                </div>
                <div class="col-3 d-flex justify-content-center">
                    <div class="circle">
                        <h2 class="title fs-5">Số sản phẩm</h2>
                        <p class="amount"><?php echo $dashboard_data['data'][0]['total_products'] ?></p>
                    </div>
                </div>
                <div class="col-3 d-flex justify-content-center">
                    <div class="circle">
                        <h2 class="title fs-5">Số người dùng</h2>
                        <p class="amount"><?php echo $dashboard_data['data'][1]['total_users'] ?></p>
                    </div>
                </div>
                <div class="col-3 d-flex justify-content-center">
                    <div class="circle">
                        <h2 class="title fs-5">Số đơn hàng</h2>
                        <p class="amount"><?php echo $dashboard_data['data'][2]['total_orders'] ?></p>
                    </div>
                </div>
            </div>

            <h4 class="my-5">Biểu đồ sản phẩm bán chạy</h4>

            <div>
                <canvas id="myChart"></canvas>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

            <script>
            const ctx = document.getElementById('myChart');

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($label_list); ?>,
                    datasets: [{
                        label: 'Số lượt bán',
                        data: <?php echo json_encode($data_list); ?>,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.6)',
                            'rgba(54, 162, 235, 0.6)',
                            'rgba(255, 206, 86, 0.6)',
                            'rgba(75, 192, 192, 0.6)',
                            'rgba(153, 102, 255, 0.6)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
            </script>
        </div>
    </div>
</section>