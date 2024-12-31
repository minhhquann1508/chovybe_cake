<?php 
    include_once './models/database.php';
    include_once './models/Category.php';
    include_once './models/Product.php';
    include_once './models/Option.php';
    include_once './config/upload.php';
    include_once './config/helper.php';

    $category_data = Category::get_all_categories($conn);
    $option_data = Option::get_all_options($conn);

    if(isset($_GET['product_id'])) {
        $product_id = $_GET['product_id'];
        $product_data = Product::get_product_by_id($conn, $product_id);

        if(isset($_POST['update_product'])) {
            $title = $_POST['title'];
            $sub_desc = $_POST['sub_desc'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $quantity = $_POST['quantity'];
            $sold = $_POST['sold'];
            $category_id = $_POST['category_id'];
            $is_show = isset($_POST['is_show']) ? 1 : 0;
            $img_url = $_FILES['file'] && $_FILES['file']['error'] === UPLOAD_ERR_OK ? upload_file($_FILES['file']['tmp_name']) : $product_data['data']['thumbnail'];
    
            $product = [
                'product_id' => $product_id,
                'title' => $title,
                'sub_desc' => $sub_desc,
                'description' => $description,
                'quantity' => $quantity,
                'price' => (int)$price,
                'sold' => $sold,
                'category_id' => $category_id,
                'is_show' => $is_show,
                'thumbnail' => $img_url
            ];

            $update_product_data = Product::update_product($conn, $product);
            
            if($update_product_data['data']) {
                header('Location: admin.php?page=update_product&product_id='.$product_id.'');
            } else {
                echo '<script>
                        showToast("'.$update_product_data['message'].'");
                </script>';
            }
        }

        if(isset($_POST['add_desc_img'])) {
            if (isset($_FILES['img_file'])) {
                $files = $_FILES['img_file'];
                $img_ids = $_POST['img_id'] ?? []; // ID của ảnh cũ (nếu có)
                $img_srcs = $_POST['img_src'] ?? []; // URL của ảnh cũ
            
                foreach ($files['tmp_name'] as $key => $file) {
                    if (!empty($file)) {
                        $img_url = upload_file($file); // Upload ảnh mới
            
                        // Nếu có ID tương ứng => Cập nhật
                        if (!empty($img_ids[$key])) {
                            Product::update_image_by_id($conn, $img_url, $img_ids[$key]);
                        } else {
                            // Nếu không có ID => Thêm ảnh mới
                            Product::add_images($conn, $img_url, $product_id);
                        }
                    } elseif (!empty($img_srcs[$key])) {
                        // // Không upload ảnh mới, giữ nguyên URL cũ
                        // Product::update_image_by_id($conn, $img_srcs[$key], $img_ids[$key]);
                    }
                }
            
                header('Location: admin.php?page=update_product&product_id=' . $product_id);
            }
            
        }
    }
?>

<div class="p-3">
    <h5>Sửa sản phẩm</h5>
    <form class="mt-4" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-7">
                <div class="row">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Tên sản phẩm</label>
                        <input type="text" value="<?php echo $product_data['data']['title'] ?>" class="form-control"
                            name="title" placeholder="Nhập vào tên sản phẩm">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Mô tả ngắn</label>
                        <textarea name="sub_desc" style="height: 100px;" class="form-control"
                            placeholder="Nhập mô tả ngắn"><?php echo $product_data['data']['sub_desc'] ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Mô tả đầy đủ</label>
                        <textarea name="description" style="height: 200px;" class="form-control"
                            placeholder="Nhập mô tả chi tiết"><?php echo $product_data['data']['description'] ?></textarea>
                    </div>

                </div>
            </div>
            <div class="col-5">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Giá sản phẩm</label>
                    <input type="text" value="<?php echo format_price($product_data['data']['price']) ?>"
                        class="form-control" placeholder="Nhập vào giá sản phẩm" name="price">
                </div>
                <div class="mb-4">
                    <label class="form-label">Danh mục sản phẩm</label>
                    <select name="category_id" class="form-select" id="floatingSelect"
                        aria-label="Floating label select example">
                        <?php 
                            foreach ($category_data['data'] as $category) {
                                if($product_data['data']['category_id'] == $category['category_id']) {
                                    echo '<option selected value="'.$category['category_id'].'">'.$category['category_name'].'</option>';
                                } else {
                                    echo '<option value="'.$category['category_id'].'">'.$category['category_name'].'</option>';
                                }                    
                            }
                        ?>
                    </select>
                </div>
                <div class="row align-items-center mb-3">
                    <div class="col-4">
                        <div class="form-check form-switch">
                            <label class="form-check-label" for="flexSwitchCheckDefault">Ẩn hiện</label>
                            <input name="is_show" <?php echo($product_data['data']['is_show'] == 1 ? 'checked' : '') ?>
                                class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                        </div>
                    </div>
                    <div class="col-8">
                        <input type="number" value="<?php echo $product_data['data']['sold'] ?>" class="form-control"
                            placeholder="Nhập vào số lượng bán" name="sold">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-4">
                        <label class="form-label">Số lượng tồn</label>
                        <input type="number" name="quantity" class="form-control"
                            value="<?php echo $product_data['data']['quantity'] ?>">
                    </div>
                    <div class="col-8">
                        <label class="form-label">Hình ảnh</label>
                        <label for="file" class="d-flex justify-content-center align-items-center rounded"
                            style="border: 1px dashed #ccc; width: 200px;height: 200px; cursor: pointer; overflow: hidden;">
                            <img class="w-100 h-100" id="add-product-thumbnail"
                                src="<?php echo ($product_data['data']['thumbnail'] ? $product_data['data']['thumbnail'] : 'https://media.istockphoto.com/id/688550958/vector/black-plus-sign-positive-symbol.jpg?s=612x612&w=0&k=20&c=0tymWBTSEqsnYYXWeWmJPxMotTGUwaGMGs6BMJvr7X4=') ?>"
                                alt="plus">
                            <input onchange="handleUploadImg(this,'add-product-thumbnail')" id="file" name="file"
                                type="file" class="d-none">
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-end">
            <button type="submit" name="update_product" class="btn btn-primary">Thêm sản phẩm</button>
        </div>
    </form>
    <form action="" style="width: 55%;" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Hình ảnh liên quan</label>
            <div class="d-flex justify-content-between gap-3">
                <?php 
                    for($i = 0; $i < 3; $i++) {
                        $plus_img = 'https://media.istockphoto.com/id/688550958/vector/black-plus-sign-positive-symbol.jpg?s=612x612&w=0&k=20&c=0tymWBTSEqsnYYXWeWmJPxMotTGUwaGMGs6BMJvr7X4=';
                        $img_src = isset($product_data['data']['images'][$i]) ? $product_data['data']['images'][$i]['url'] : $plus_img;
                        echo '
                            <label for="file_'.$i.'" class="d-flex w-100 justify-content-center align-items-center rounded"
                                style="border: 1px dashed #ccc; cursor: pointer; overflow: hidden; height: 240px">
                                <img class="w-100 h-100" id="detail_img_'.$i.'"
                                    style="object-fit: center"
                                    src="'.$img_src.'"
                                    alt="plus">';
                        if(isset($product_data['data']['images'][$i])) {
                            echo '<input type="hidden" name="img_id[]" value="'.$product_data['data']['images'][$i]['image_id'].'">';
                            echo '<input type="hidden" name="img_src[]" value="'.$img_src.'">';
                        } 
                        echo '<input onchange="handleUploadImg(this, \'detail_img_'.$i.'\')" id="file_'.$i.'"
                                    name="img_file[]" type="file" class="d-none">
                            </label>';
                    }
                ?>
            </div>
        </div>

        <div class="text-end">
            <button class="btn btn-primary" type="submit" name="add_desc_img">Thêm hình ảnh</button>
        </div>
    </form>
</div>