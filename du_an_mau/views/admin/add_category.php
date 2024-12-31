<?php 
    include_once './models/database.php';
    include_once './models/Category.php';

    if(isset($_POST['add_new_category'])) {
        $category = [
            'category_name' => $_POST['category_name'],
            'description' => $_POST['description'],
            'is_show' => isset($_POST['is_show']) ? 1 : 0
        ];

        $category_data = Category::add_new_category($conn, $category);

        if($category_data['data'] == true) {
            echo '<script>
                showToast("'.$category_data['message'].'");
            </script>';
        } else {
            echo '<script>
                showToast("'.$category_data['message'].'");
            </script>';
        }
    }
?>

<div class="p-3">
    <h5 class="text-center">Thêm danh mục mới</h5>
    <div class="d-flex justify-content-center">
        <form action="" method="post" class="w-50 border rounded p-4">
            <div class="mb-3">
                <label for="formGroupExampleInput" class="form-label">Tên danh mục</label>
                <input type="text" name="category_name" class="form-control" id="formGroupExampleInput"
                    placeholder="Nhập tên danh mục">
            </div>

            <div class="mb-3">
                <label for="formGroupExampleInput" class="form-label">Mô tả danh mục</label>
                <textarea name="description" style="height: 180px;" class="form-control"
                    placeholder="Nhập vào mô tả danh mục" id="floatingTextarea"></textarea>
            </div>

            <div class="form-check form-switch mb-3">
                <label class="form-check-label" for="flexSwitchCheckDefault">Ẩn hiện</label>
                <input name="is_show" class="form-check-input" type="checkbox" role="switch"
                    id="flexSwitchCheckDefault">
            </div>

            <div class="text-end">
                <button class="btn btn-primary" type="submit" name="add_new_category">Thêm mới danh mục</button>
            </div>
        </form>
    </div>
</div>