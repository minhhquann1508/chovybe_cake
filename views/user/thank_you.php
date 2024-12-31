<?php 
    include_once './views/user/_breadcrumb.php';
    include_once './config/helper.php';
    include_once './models/database.php'; 
    include_once './models/Order.php'; 

    if(isset($_GET['order_id'])) {
        $order_id = $_GET['order_id'];
        $order_data = Order::get_order_by_id($conn, $order_id);
        $bread_crumb = [
            ['title' => 'Trang chủ', 'url' => 'index.php'],
            ['title' => 'Đơn hàng', 'url' => 'index.php?page=thank_you&order_id='.$order_id.'']
        ]; 
    } else {
        header('location: index.php');
    }
?>

<section class="py-4" style="min-height: 100vh;">
    <div class="container">
        <?php render_breadcrumbs($bread_crumb) ?>
        <div class="rounded border p-4">
            <h2 class="text-center" style="margin-bottom: 20px; font-weight: bold;">Hóa Đơn Mua Hàng</h2>

            <!-- Thông tin người mua -->
            <div class="mb-4">
                <h4 style="margin-bottom: 10px;">Thông tin khách hàng</h4>
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
                <p style="margin: 0;">Ghi chú:
                    <strong><?php echo $order_data['data']['order_info']['note'] ?></strong>
                </p>
            </div>

            <!-- Danh sách sản phẩm -->
            <div>
                <h4 style="margin-bottom: 15px;">Chi tiết đơn hàng</h4>
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

            <!-- Tổng tiền -->
            <div class="text-end" style="margin-top: 20px; font-size: 18px;">
                <p style="margin: 0;">Tổng cộng:
                    <strong><?php echo format_price($order_data['data']['order_info']['total']) ?> VNĐ</strong>
                </p>
            </div>

        </div>
    </div>
</section>