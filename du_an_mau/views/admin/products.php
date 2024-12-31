<?php 
    include_once './models/database.php';
    include_once './models/Product.php';
    include_once './config/helper.php';
    include_once './views/core/_pagination.php';
    include_once '_option.php';

    if(isset($_GET['page_index'])) {
        $page = $_GET['page_index'];
    } else {
        $page = 1;
    }

    $data = Product::get_all_products_by_admin($conn,$PAGE_SIZE,$page);

    function render_products($products) {
        $content = '';
        foreach ($products as $key => $product) {
            $is_show = $product['is_show'] == 1 ? 'Hiện' : 'Ẩn';
            $content .= '
                <tr>
                    <td>'.($key + 1).'</td>
                    <td>'.$product['title'].'</td>
                    <td><img width="45" height="45" src="'.$product['thumbnail'].'" alt="'.$product['title'].'"></td>
                    <td>'.format_price($product['price']).'</td>
                    <td>'.$product['sub_desc'].'</td>
                    <td>'.$product['sold'].'</td>
                    <td>'.$product['category_name'].'</td>
                    <td class="text-center">'.$is_show.'</td>
                    <td class="text-center">
                        <button class="btn btn-info edit-btn">
                            <a href="admin.php?page=update_product&product_id='.$product['product_id'].'"><i class="fa-regular fa-pen-to-square"></i></a>
                        </button>
                        <span class="dropdown">
                            <button class="btn btn-danger" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-regular fa-trash-can"></i>
                            </button>
                            <div class="dropdown-menu p-3" style="width: 250px">
                                <span>Bạn muốn xóa sản phẩm này?</span>
                                <div class="text-end mt-2">
                                    <a class="btn btn-primary text-white" href="admin.php?page=delete_product&product_id='.$product['product_id'].'">Xác nhận</a>
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

<div class="container-fluid">
    <?php render_option('Danh sách sản phẩm', 'admin.php?page=add_product') ?>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Tên sản phẩm</th>
                <th scope="col">Hình ảnh</th>
                <th scope="col">Giá (VNĐ)</th>
                <th scope="col">Mô tả ngắn</th>
                <th scope="col">Lượt bán</th>
                <th scope="col">Danh mục</th>
                <th scope="col" style="text-align: center;">Ẩn hiện</th>
                <th scope="col" style="text-align: center;">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php render_products($data['data']) ?>
        </tbody>
    </table>
    <?php render_pagination($page, $data['total'], $PAGE_SIZE, 'admin.php?page=products'); ?>
</div>