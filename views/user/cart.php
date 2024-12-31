<?php 
    include_once '_breadcrumb.php';
    include_once './config/helper.php';
    include_once './models/database.php';
    include_once './models/Product.php';
    include_once './models/Option.php';

    $product_data = Product::get_all_products($conn);
    $option_data = Option::get_all_options($conn);

    $bread_crumb = [
        ['title' => 'Trang chủ', 'url' => 'index.php'],
        ['title' => 'Giỏ hàng', 'url' => 'index.php?page=cart'],
    ];

    if(isset($_SESSION['cart'])) {
        $cart_list = $_SESSION['cart'];
    } else {
        $cart_list = [];
    }

    function render_list_cart($products, $options) {
        if (count($products) <= 0) {
            echo '<h5 class="p-0 mt-3">Không có sản phẩm trong giỏ hàng</h5>';
        } else {
            foreach ($products as $key => $product) {
                $option_content = '';
                foreach ($options as $option) {
                    $selected = $option['option_id'] === $product['option_id'] ? 'selected' : '';
                    $option_content .= '<option '.$selected.' value="'.$option['option_id'].'">'.$option['size'].' - '.$option['sweetness'].'</option>';
                }
                echo '<li class="mb-3 col-lg-6 p-3">
                        <div class="row border rounded py-2">
                            <div class="col-md-3">
                                <img style="object-fit: scale-down" class="rounded" height="150" src="'.$product['thumbnail'].'" alt="">
                            </div>
                            <div class="col-md-9">
                                <div class="p-2">
                                    <div class="text-end">
                                        <input type="checkbox" name="selected_items[]" value="'.$key.'" class="form-check-input cart-input-check me-2">
                                    </div>
                                    <h5 class="fw-bold mb-2">'.$product['title'].'</h5>
                                    <div>
                                        <p class="mb-1"><strong>Đơn giá:</strong> '.format_price($product['price']).' đ</p>
                                        <p class="mb-1"><strong>Số lượng:</strong> '.$product['quantity'].'</p>
                                    </div>
                                    <p class="mb-1"><strong>Tạm tính:</strong> '.format_price($product['price'] * $product['quantity']).' đ</p>
                                    <p class="mb-1 d-flex gap-2 align-items-center mb-4">
                                        <strong>Tùy chọn:</strong>
                                        <select class="form-select" style="width: 200px;" aria-label="Default select example">
                                            '.$option_content.'
                                        </select>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </li>';
            }
        }
    }

    if(isset($_POST['delete-cart-item'])) {
        if (isset($_POST['selected_items']) && is_array($_POST['selected_items'])) {
            $selected_items = $_POST['selected_items'];
            $_SESSION['cart'] = array_values(array_diff_key($_SESSION['cart'], array_flip($selected_items)));
            $cart_list = $_SESSION['cart'];
            $totalQuantity = count_cart($cart_list);
            echo '<script>
                document.getElementById("cart-count").innerHTML = '.$totalQuantity.';
            </script>';
        } else {
            echo '<script>
                    showToast("Vui lòng chọn sản phẩm cần xóa");
            </script>';
        }
    }

    if(isset($_POST['checkout'])) {
        if(isset($_SESSION['user'])) {
            if (isset($_POST['selected_items']) && is_array($_POST['selected_items'])) {
                $selected_items = $_POST['selected_items'];
                $list_item = [];
                foreach ($selected_items as $item) {
                    $list_item[] = $_SESSION['cart'][$item];
                }
                $_SESSION['order_list'] = $list_item;
                header('Location:index.php?page=checkout');
            } else {
                echo '<script>
                    showToast("Vui lòng chọn sản phẩm cần thanh toán");
                </script>';
            }
        } else {
            echo '<script>
                    showToast("Bạn cần đăng nhập để mua hàng");
            </script>';
        }
    }
?>

<section class="py-4" style="min-height: 100vh;">
    <div class="container">
        <?php render_breadcrumbs($bread_crumb); ?>
        <form method="post">
            <div class="d-flex justify-content-end align-items-end gap-2">
                <span class="d-flex align-items-center">
                    <input onchange="selectAllItem()" id="check-all-input" type="checkbox" class="form-check-input m-0">
                    <span class="ms-1">Chọn tất cả</span>
                </span>
                <button class="btn btn-secondary" name="delete-cart-item" type="submit">Xóa sản phẩm</button>
                <button class="btn btn-primary" name="checkout" type="submit">Thanh toán ngay</button>
            </div>
            <ul class="row">
                <?php render_list_cart($cart_list, $option_data['data']); ?>
            </ul>
        </form>
    </div>
</section>

<script>
const selectAllItem = () => {
    const checkAllBtn = document.getElementById('check-all-input');
    const inputChecks = document.querySelectorAll('.cart-input-check');

    inputChecks.forEach(input => {
        input.checked = checkAllBtn.checked;
    });
}
</script>