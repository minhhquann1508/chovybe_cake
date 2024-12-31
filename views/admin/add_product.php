<?php 
    include_once './models/database.php';
    include_once './models/Category.php';
    include_once './models/Product.php';
    include_once './config/upload.php';

    $category_data = Category::get_all_categories($conn);

    if(isset($_POST['add_product'])) {
        if($_FILES['file'] && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['file']['tmp_name'];
            
            $title = $_POST['title'];
            $sub_desc = $_POST['sub_desc'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $sold = $_POST['sold'];
            $category_id = $_POST['category_id'];
            $quantity = $_POST['quantity'];
            $is_show = isset($_POST['is_show']) ? 1 : 0;
            $img_url = upload_file($file);

            $product = [
                'title' => $title,
                'sub_desc' => $sub_desc,
                'description' => $description,
                'price' => $price,
                'sold' => $sold,
                'category_id' => $category_id,
                'is_show' => $is_show,
                'quantity' => (int)$quantity,
                'thumbnail' => $img_url
            ];

            $product_data = Product::add_new_product($conn, $product);

            if($product_data['data'] !== null) {
                echo '<script>
                            showToast("'.$product_data['message'].'");
                            setTimeout(() => {
                                window.location.href = "admin.php?page=update_product&product_id='.$product_data['data'].'";
                            }, 1000);
                        </script>';
            } else {
                echo '<script>
                        showToast("'.$product_data['message'].'");
                    </script>';
            }
            
        }
    }
?>

<div class="p-3">
    <h5 class="text-center">Thêm sản phẩm</h5>
    <form class="mt-4 p-3 rounded" style="border: 1px solid #ccc;" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-7">
                <div class="row">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Tên sản phẩm</label>
                        <input type="text" class="form-control" name="title" placeholder="Nhập vào tên sản phẩm">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Mô tả ngắn</label>
                        <textarea name="sub_desc" style="height: 100px;" class="form-control"
                            placeholder="Nhập mô tả ngắn"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Mô tả đầy đủ</label>
                        <textarea name="description" style="height: 200px;" class="form-control"
                            placeholder="Nhập mô tả chi tiết"></textarea>
                    </div>
                </div>
            </div>
            <div class="col-5">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Giá sản phẩm</label>
                    <input type="text" class="form-control" placeholder="Nhập vào giá sản phẩm" name="price">
                </div>
                <div class="mb-4">
                    <label class="form-label">Danh mục sản phẩm</label>
                    <select name="category_id" class="form-select" id="floatingSelect"
                        aria-label="Floating label select example">
                        <?php 
                            echo '<option selected value="">Chọn danh mục sản phẩm</option>';                        
                            foreach ($category_data['data'] as $category) {
                                echo '<option value="'.$category['category_id'].'">'.$category['category_name'].'</option>';
                            }
                        ?>
                    </select>
                </div>
                <div class="row align-items-center mb-3">
                    <div class="col-4">
                        <div class="form-check form-switch">
                            <label class="form-check-label" for="flexSwitchCheckDefault">Ẩn hiện</label>
                            <input name="is_show" class="form-check-input" type="checkbox" role="switch"
                                id="flexSwitchCheckDefault">
                        </div>
                    </div>
                    <div class="col-8">
                        <input type="number" class="form-control" placeholder="Nhập vào số lượng bán" name="sold">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-4">
                        <label class="form-label">Số lượng tồn</label>
                        <input type="number" name="quantity" class="form-control" value="0">
                    </div>
                    <div class="col-8">
                        <label class="form-label">Hình ảnh</label>
                        <label for="file" class="d-flex justify-content-center align-items-center rounded"
                            style="border: 1px dashed #ccc; width: 200px;height: 200px; cursor: pointer; overflow: hidden;">
                            <img class="w-100 h-100" id="add-product-thumbnail"
                                src="https://media.istockphoto.com/id/688550958/vector/black-plus-sign-positive-symbol.jpg?s=612x612&w=0&k=20&c=0tymWBTSEqsnYYXWeWmJPxMotTGUwaGMGs6BMJvr7X4="
                                alt="plus">
                            <input onchange="handleUploadImg(this,'add-product-thumbnail')" id="file" name="file"
                                type="file" class="d-none">
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-end">
            <button type="submit" name="add_product" class="btn btn-primary">Thêm sản phẩm</button>
        </div>
    </form>
</div>