<?php 
    include_once './config/upload.php';
    include_once './config/helper.php';
    include_once './models/database.php';
    include_once './models/Category.php';
    include_once './views/core/_pagination.php';
    include_once '_option.php';

    if(isset($_GET['page_index'])) {
        $page = $_GET['page_index'];
    } else {
        $page = 1;
    }

    $data = Category::get_categories_pagination($conn, $PAGE_SIZE, $page);

    function render_category($categories) {
        $content = '';
        foreach ($categories as $key => $category) {
            $is_show = $category['is_show'] == 1 ? 'Hiện' : 'Ẩn';
            $content .= '
                <tr>
                    <td>'.($key + 1).'</td>
                    <td>'.$category['category_name'].'</td>
                    <td>'.$category['description'].'</td>
                    <td class="text-center">'.$is_show.'</td>
                    <td class="text-center">
                        <a class="btn btn-info edit-btn" href="admin.php?page=update_category&category_id='.$category['category_id'].'"><i class="fa-regular fa-pen-to-square"></i></a>
                        <span class="dropdown">
                            <button class="btn btn-danger" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-regular fa-trash-can"></i>
                            </button>
                            <div class="dropdown-menu p-3" style="width: 250px">
                                <span>Bạn muốn xóa danh mục này?</span>
                                <div class="text-end mt-2">
                                    <a class="btn btn-primary text-white" href="admin.php?page=delete_category&category_id='.$category['category_id'].'">Xác nhận</a>
                                </div>
                            </div>
                        </span>
                    </td>
                </tr>
            ';
        }
        echo $content;
    }
?>

<section class="container-fluid">
    <?php render_option('Danh mục sản phẩm', 'admin.php?page=add_category')  ?>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Tên danh mục</th>
                <th scope="col" style="width: 50%;">Mô tả</th>
                <th scope="col" style="text-align: center;">Ẩn hiện</th>
                <th scope="col" style="text-align: center;">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php render_category($data['data']) ?>
        </tbody>
    </table>
    <?php render_pagination($page, $data['total'], $PAGE_SIZE, 'admin.php?page=categories'); ?>
</section>