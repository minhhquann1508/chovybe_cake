<?php 
    include_once './config/helper.php';
    include_once './models/database.php';
    include_once './models/Order.php';

    if(isset($_GET['order_id'])) {
        $order_id = $_GET['order_id'];
        $order_data = Order::get_order_by_id($conn, $order_id);
        if(isset($_POST['confirm_order'])) {
            $confirm_order = Order::update_order_status($conn,$order_id, $order_data['data']['orders']);
            if($confirm_order['data']) {
                echo '<script>
                    showToast("'.$confirm_order['message'].'");
                    setTimeout(() => {
                        window.location.href = "admin.php?page=orders";
                    }, 700);
                </script>';
            } else {
                echo '<script>
                    showToast("'.$confirm_order['message'].'");
                </script>';
            }
        }
    }
?>

<section>
    <div class="container-fluid">
        <h4 class="p-3 text-center">Thông tin đơn hàng</h4>
        <div class="p-4 border rounded">
            <div class="mb-4">
                <h5 style="margin-bottom: 10px;">Thông tin khách hàng</h5>
                <p style="margin: 0;">Họ và tên:
                    <strong><?php echo $order_data['data']['order_info']['name'] ?></strong>
                </p>
                <p style="margin: 0;">Email: <strong><?php echo $order_data['data']['order_info']['email'] ?></strong>
                </p>
                <p style="margin: 0;">Số điện thoại:
                    <strong><?php echo $order_data['data']['order_info']['phone'] ?></strong>
                </p>
                <p style="margin: 0;">Địa chỉ:
                    <strong><?php echo $order_data['data']['order_info']['address'] ?></strong>
                </p>
            </div>
            <div>
                <h5 style="margin-bottom: 10px;">Thông tin sản phẩm</h5>
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr style="text-align: center;">
                            <th style="width: 10%;">#</th>
                            <th style="width: 25%;">Sản phẩm</th>
                            <th style="width: 10%;">Hình ảnh</th>
                            <th style="width: 15%;">Giá</th>
                            <th style="width: 10%;">Số lượng</th>
                            <th style="width: 15%;">Tùy chọn</th>
                            <th style="width: 15%;">Tổng tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            foreach ($order_data['data']['orders'] as $key => $order_item) {
                                echo '
                                    <tr style="text-align: center;">
                                        <td>'.($key + 1).'</td>
                                        <td style="text-align: left;">'.$order_item['title'].'</td>
                                        <td>
                                            <img class="w-100" src="'.$order_item['thumbnail'].'" alt="">
                                        </td>
                                        <td>'.format_price($order_item['price']).' VNĐ</td>
                                        <td>'.$order_item['quantity'].'</td>
                                        <td>'.$order_item['size'].' - '.$order_item['sweetness'].'</td>
                                        <td>'.format_price($order_item['price'] * $order_item['quantity']).' VNĐ</td>
                                    </tr>
                                ';
                            }
                        ?>
                    </tbody>
                </table>
            </div>
            <form action="" method="post">
                <div class="text-end">
                    <?php 
                        if($order_data['data']['order_info']['status'] == 0) {
                            echo '
                                <button name="confirm_order" type="submit" class="btn btn-primary">Xác nhận đã giao</button>
                            ';
                        }
                    ?>
                </div>
            </form>
        </div>
    </div>
</section>