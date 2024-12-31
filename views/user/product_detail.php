<?php 
    include_once './config/helper.php';
    include_once './models/database.php';
    include_once './models/Product.php';
    include_once './models/Comment.php';
    include_once './models/Option.php';
    include_once '_product_item.php';
    include_once '_breadcrumb.php';

    $option_data = Option::get_all_options($conn);

    if(isset($_GET['product_id'])) {
        $id = $_GET['product_id'];
        $product_data = Product::get_product_by_id($conn,product_id: $id);
        $thumbnail_item = ['url' => $product_data['data']['thumbnail']];
        array_unshift($product_data['data']['images'], $thumbnail_item);
        $images = $product_data['data']['images'];

        $related_products_data = Product::get_related_products($conn, $product_data['data']);
        $bread_crumb = [
            ['title' => 'Trang chủ', 'url' => 'index.php'],
            ['title' => ''.$product_data['data']['category_name'].'', 'url' => 'index.php?page=category&category_id='.$product_data['data']['category_id'].''],
            ['title' => ''.$product_data['data']['title'].'', 'url' => 'index.php?page=product_detail&product_id='.$product_data['data']['product_id'].''],
        ]; 

        $comment_data = Comment::get_all_comments($conn, $id);

        if(isset($_POST['add_comment'])) {
            if(isset($_SESSION['user'])) {
                $content = $_POST['content'];
                $comment = [
                    'product_id' => $id,
                    'content' => $content,
                    'user_id' => $_SESSION['user']['user_id'],
                ];
                Comment::add_comment($conn, $comment);
                header('Location: index.php?page=product_detail&product_id='.$id.'');
            } else {
                header('Location: index.php?page=login');
            }
        }
    }

    if(isset($_POST['add-to-cart'])) {
        $product_id = $_POST['product_id'];
        $option_id = $_POST['option_id'];
        $title = $_POST['title'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];
        $thumbnail = $_POST['thumbnail'];
        $max_quantity = $_POST['max_quantity'];
        
        $cart_item = [
            'product_id' => $product_id,
            'title' => $title,
            'thumbnail' => $thumbnail,
            'price' => $price,
            'quantity' => $quantity,
            'option_id' => $option_id,
            'max_quantity' => $max_quantity,
        ];

        if(!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
            array_push($_SESSION['cart'], $cart_item);
            $total_quantity = count_cart($_SESSION['cart']);
            echo '<script>
                document.getElementById("cart-count").innerHTML = '.$total_quantity.';
            </script>';
        } else {
            $is_found = false;
            foreach ($_SESSION['cart'] as &$item) { // Thêm tham chiếu để chỉnh sửa trực tiếp
                if ($item['product_id'] == $cart_item['product_id'] && $item['option_id'] == $cart_item['option_id']) {
                    $is_found = true;
                    if ($item['quantity'] < $max_quantity) {
                        $item['quantity'] += $cart_item['quantity'];
                    } else {
                        echo '<script>
                                showToast("Sản phẩm vượt quá số lượng còn lại");
                            </script>';
                    }
                    break;
                }
            }
            if (!$is_found) {
                array_push($_SESSION['cart'], $cart_item);
            }
        }
        $totalQuantity = count_cart($_SESSION['cart']);

        echo '<script>
            document.getElementById("cart-count").innerHTML = '.$totalQuantity.';
        </script>';
    }
?>

<style>
.input-quantity {
    border: none;
    width: 50px;
}

.input-quantity:focus {
    outline: none;
}

.quantity-btn {
    transition: all 0.2s ease-in;
}

.quantity-btn:hover {
    scale: 105%;
}
</style>

<section class="py-5">
    <div class="container">
        <?php render_breadcrumbs($bread_crumb); ?>
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="pe-3">
                    <div class="shadow" style="margin-right: 11px; height: 500px">
                        <img class="w-100 h-100" id="user_img_detail" style="object-fit: center"
                            src="<?php echo $product_data['data']['thumbnail'] ?>" alt="">
                    </div>
                    <ul class="row mt-3">
                        <?php 
                            foreach ($product_data['data']['images'] as $key => $image) {
                                echo '
                                    <li onclick="changeImg(\''.$image['url'].'\')" class="col-3 ps-0" style="cursor: pointer;">
                                        <div class="shadow rounded w-100 h-100">
                                            <img class="w-100 h-100"
                                            src="'.$image['url'].'"
                                            style="object-fit: center"
                                            alt="">
                                        </div>
                                    </li>
                                ';
                            }
                        ?>
                    </ul>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <form action="" method="post" class="pt-4 md-p-4">
                    <h1 class="mb-2"><?php echo $product_data['data']['title'] ?></h1>
                    <p class="d-flex gap-3 fs-5">
                        <span>Lượt bán: <?php echo $product_data['data']['sold']?></span><br>
                        <span>Lượt xem: <?php echo $product_data['data']['views']?></span><br>
                    </p>
                    <input type="hidden" name="product_id" value="<?php echo $product_data['data']['product_id'] ?>">
                    <input type="hidden" name="max_quantity" value="<?php echo $product_data['data']['quantity'] ?>">
                    <input type="hidden" name="title" value="<?php echo $product_data['data']['title'] ?>">
                    <input type="hidden" name="price" value="<?php echo $product_data['data']['price'] ?>">
                    <input type="hidden" name="thumbnail" value="<?php echo $product_data['data']['thumbnail'] ?>">
                    <h4><?php echo format_price($product_data['data']['price']) ?> VNĐ</h4>
                    <p class="fs-5"><?php echo $product_data['data']['sub_desc'] ?></p>
                    <p class="fs-5"><?php echo $product_data['data']['description'] ?></p>
                    <select name="option_id" class="form-select mb-4" style="width: 300px;"
                        aria-label="Default select example">
                        <?php 
                            foreach ($option_data['data'] as $key => $option) {
                                echo '
                                    <option '.($key == 0 ? 'selected' : '').' value="'.$option['option_id'].'">'.$option['size'].'-'.$option['sweetness'].'</option>
                                ';
                            }
                        ?>
                    </select>
                    <?php 
                        if($product_data['data']['quantity'] > 0) {
                            echo '<div class="d-flex align-items-center gap-2 mb-3">
                                    <i onclick="decreaseQuantity('.$product_data['data']['quantity'].')" class="fa-solid fa-circle-minus fs-3 quantity-btn" style="cursor: pointer;"></i>
                                    <input name="quantity" type="text" value="1" class="input-quantity text-center">
                                    <i onclick="increaseQuantity('.$product_data['data']['quantity'].')" class="fa-solid fa-circle-plus fs-3 quantity-btn" style="cursor: pointer;"></i>
                                </div>';
                        } else {
                            echo '<p>Sản phẩm đã hết hàng</p>';
                        }
                    ?>
                    <button type="submit" name="add-to-cart"
                        class="btn fw-bold fs-6 text-uppercase fs-5 rounded-pill px-5 py-3 align-items-center"
                        style="background-color: #451f13; color: white"
                        <?php echo $product_data['data']['quantity'] <= 0 ? 'disabled' : ''; ?>>
                        Thêm vào giỏ hàng
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <h2 class="fw-bold mb-4 text-center">Đánh giá sản phẩm</h2>
        <div class="mb-4">
            <ul class="list-unstyled">
                <?php 
                    if(count($comment_data['data']) <= 0) {
                        echo '<div>Chưa có bình luận nào cả</div>';
                    }
                    foreach ($comment_data['data'] as $comment) {
                        echo '
                            <li class="mb-3 border-bottom pb-2">
                                <p class="mb-1"><strong>'.$comment['name'].'</strong></p>
                                <p>'.$comment['content'].'</p>
                            </li>
                        ';
                    }
                ?>
            </ul>
        </div>

        <div>
            <h5 class="mb-3">Thêm bình luận</h5>
            <form action="" method="post">
                <div class="mb-3">
                    <textarea name="content" class="form-control" rows="5"
                        placeholder="Nhập bình luận của bạn..."></textarea>
                </div>
                <div class="text-end">
                    <button name="add_comment" type="submit" class="btn btn-primary">Gửi bình luận</button>
                </div>
            </form>
        </div>
    </div>
</section>

<section class="py-5" style="background-color: #bae8d4;">
    <div class="container">
        <h1 class="fw-bold text-center mb-5">Có thể bạn sẽ thích</h1>
        <div class="row">
            <?php 
                if($related_products_data['data']) {
                    foreach ($related_products_data['data'] as $key => $product) {
                        echo '<div class="col-sm-6 col-lg-4 col-xl-3">';
                        product_item($product);
                        echo '</div>';
                    }
                } else {
                    echo '<div>Chưa có sản phẩm liên quan</div>';
                }
            ?>
        </div>
    </div>
</section>

<?php include_once '_contact.php' ?>

<script>
const quantityInputEl = document.querySelector('.input-quantity');

const increaseQuantity = (total) => {
    const value = quantityInputEl.value;
    if (value < total) {
        quantityInputEl.value = Number(value) + 1;
    }
}

const decreaseQuantity = (total) => {
    const value = quantityInputEl.value;
    if (value > 1) {
        quantityInputEl.value = Number(value) - 1;
    }
}
</script>