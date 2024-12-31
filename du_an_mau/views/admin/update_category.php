<?php 
    include_once './models/database.php';
    include_once './models/Category.php';

    if(isset($_GET['category_id'])) {
        $category_id = $_GET['category_id'];
        $category_data = Category::get_category_by_id($conn, $category_id, false);

        if(isset($_POST['update_category'])) {
            $category = [
                'category_id' => $_POST['category_id'],
                'category_name' => $_POST['category_name'],
                'description' => $_POST['description'],
                'is_show' => isset($_POST['is_show']) ? 1 : 0
            ];

            $update_category = Category::update_category($conn, $category);
    
            if($update_category['data'] == true) {
                echo '<script>
                    showToast("'.$update_category['message'].'");
                    setTimeout(() => {
                        window.location.href = "admin.php?page=update_category&category_id='.$category_id.'";
                    }, 700);
                </script>';
            } else {
                echo '<script>
                    showToast("'.$update_category['message'].'");
                </script>';
            }
        }
    }

    
?>

<div class="p-3">
    <h5 class="text-center">Sửa danh mục</h5>
    <div class="d-flex justify-content-center">
        <form action="" method="post" class="w-50 border rounded p-4">
            <input type="hidden" name="category_id" value="<?php echo $category_data['data']['category_id'] ?>">
            <div class="mb-3">
                <label for="formGroupExampleInput" class="form-label">Tên danh mục</label>
                <input value="<?php echo $category_data['data']['category_name'] ?>" type="text" name="category_name"
                    class="form-control" id="formGroupExampleInput" placeholder="Nhập tên danh mục">
            </div>

            <div class="mb-3">
                <label for="formGroupExampleInput" class="form-label">Mô tả danh mục</label>
                <textarea name="description" style="height: 180px;" class="form-control"
                    placeholder="Nhập vào mô tả danh mục"
                    id="floatingTextarea"><?php echo $category_data['data']['description'] ?></textarea>
            </div>

            <div class="form-check form-switch mb-3">
                <label class="form-check-label" for="flexSwitchCheckDefault">Ẩn hiện</label>
                <input name="is_show" <?php echo($category_data['data']['is_show'] == 1 ? 'checked' : '') ?>
                    class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
            </div>

            <div class="text-end">
                <button class="btn btn-primary" type="submit" name="update_category">Thêm mới danh mục</button>
            </div>
        </form>
    </div>
</div>