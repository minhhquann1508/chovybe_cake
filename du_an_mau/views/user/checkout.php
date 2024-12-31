<?php 
    include_once './views/user/_breadcrumb.php';
    include_once './config/helper.php';
    include_once './config/send_mail.php';
    include_once './models/database.php';
    include_once './models/Option.php';
    include_once './models/Order.php';
    include_once './utils/constant.php';

    if(!isset($_SESSION['user'])) {
        header('Location: index.php?page=login');
    }
    
    if(isset($_SESSION['order_list'])) {
        $order_list = $_SESSION['order_list'];
        $total_price = 0;
        foreach ($order_list as $order_item) {
            $total_price += ($order_item['price'] * $order_item['quantity']);
        }
    } else {
        header('Location: index.php');
    }

    $bread_crumb = [
        ['title' => 'Trang chủ', 'url' => 'index.php'],
        ['title' => 'Thanh toán', 'url' => 'index.php?page=checkout'],
    ];

    $option_data = Option::get_all_options($conn);

    if(isset($_POST['confirm-order'])) {
        $user_info = [
            'user_id' => $_SESSION['user']['user_id'],
            'name' => $_POST['name'],
            'phone' => $_POST['phone'],
            'address' => $_POST['address'],
            'email' => $_POST['email'],
            'note' => $_POST['note'],
            'total' => $total_price + $SHIPPING_FEE
        ];

        $order_data = Order::add_order($conn, $user_info, $_SESSION['order_list']);

        if($order_data['data'] !== null) {
            send_mail_order($user_info, $_SESSION['order_list'],($total_price + $SHIPPING_FEE));
            $order_product_ids = array_column($_SESSION['order_list'], 'product_id');
            // Lọc sản phẩm có trong order mà không có trong list cart
            $_SESSION['cart'] = array_filter($_SESSION['cart'], function ($item) use ($order_product_ids) {
                return !in_array($item['product_id'], $order_product_ids);
            });
            $_SESSION['cart'] = array_values($_SESSION['cart']);
            $totalQuantity = count_cart($_SESSION['cart']);
            echo '<script>
                document.getElementById("cart-count").innerHTML = '.$totalQuantity.';
            </script>';
            unset($_SESSION['order_list']);
            header('Location: index.php?page=thank_you&order_id='.$order_data['data'].'');
        } else {
            echo '<script>
                showToast("'.$order_data['message'].'");
            </script>';
        }
    }
?>

<section class="py-4" style="min-height: 100vh;">
    <div class="container">
        <?php render_breadcrumbs($bread_crumb); ?>
        <form class="row" method="post">
            <div class="col-xl-5">
                <ul>
                    <?php 
                        foreach ($_SESSION['order_list'] as $order_item) {
                            $option = '';
                            foreach ($option_data['data'] as $key => $option_item) {
                                if($option_item['option_id'] == $order_item['option_id']) {
                                    $option = ''.$option_item['size'].' - '.$option_item['sweetness'].'';
                                }
                            }
                            echo '
                                <li class="row mb-2 border rounded">
                                    <div class="col-3">
                                        <img class="w-100" src="'.$order_item['thumbnail'].'" alt="">
                                    </div>
                                    <div class="col-9 py-3">
                                        <h6 class="fw-bold mb-1 text-uppercase">'.$order_item['title'].'</h6>
                                        <p class="mb-1"><strong>Đơn giá: </strong>'.format_price($order_item['price']).'</p>
                                        <p class="mb-1"><strong>Số lượng: </strong>'.$order_item['quantity'].'</p>
                                        <p class="mb-1"><strong>Lựa chọn:</strong> '.$option.'</p>
                                        <p><strong>Tổng tiền: </strong>'.format_price(($order_item['price'] * $order_item['quantity'])).' đ</p>
                                    </div>
                                </li>
                            ';
                        }
                    ?>
                </ul>
                <li class="row mb-2 border rounded py-3">
                    <div class="col-6 mb-2">
                        <h6 class="fw-bold">Phí vận chuyển:</h6>
                    </div>
                    <div class="col-6 mb-2 text-end">
                        <p class="m-0"><?php echo format_price($SHIPPING_FEE) ?> đ</p>
                    </div>
                    <hr>
                    <div class="col-6">
                        <h6 class="fw-bold">Tổng cộng:</h6>
                    </div>
                    <div class="col-6 text-end">
                        <p class="m-0"><?php echo format_price($SHIPPING_FEE + $total_price) ?> đ</p>
                    </div>
                </li>
            </div>
            <div class="col-xl-7">
                <div class="border rounded p-3">
                    <div class="mb-3">
                        <label class="form-label">Họ và tên</label>
                        <input name="name" value="<?php echo $_SESSION['user']['name'] ?>" type="text"
                            class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input name="email" value="<?php echo $_SESSION['user']['email'] ?>" type="email"
                            class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Số điện thoại</label>
                        <input name="address" value="<?php echo $_SESSION['user']['phone'] ?>" type="text"
                            class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Địa chỉ</label>
                        <input name="phone" value="<?php echo $_SESSION['user']['address'] ?>" type="text"
                            class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ghi chú</label>
                        <textarea name="note" style="height: 150px;" class="form-control" placeholder="Ghi chú đơn hàng"
                            id="floatingTextarea"></textarea>
                    </div>
                    <div class="text-end">
                        <button type="submit" name="confirm-order" class="btn btn-primary">Xác nhận đặt hàng</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>