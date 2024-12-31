<?php 
    include_once './models/database.php';
    include_once './models/Order.php';
    include_once './config/helper.php';
    include_once './views/core/_pagination.php';
    include_once '_option.php';

    if(isset($_GET['page_index'])) {
        $page = $_GET['page_index'];
    } else {
        $page = 1;
    }

    $order_data = Order::get_all_orders($conn,$PAGE_SIZE,$page);

    function render_orders($orders) {
        $content = '';
        foreach ($orders as $key => $order) {
            $status = $order['status'] == 1 ? 'Đã giao' : 'Đang giao';
            $content .= '
                <tr>
                    <td>'.($key + 1).'</td>
                    <td class="text-center">'.$order['order_id'].'</td>
                    <td>'.$order['name'].'</td>
                    <td>'.$order['email'].'</td>
                    <td>'.$order['address'].'</td>
                    <td>'.format_price($order['total']).'</td>
                    <td>'.$status.'</td>
                    <td class="text-center">
                        <button class="btn btn-info edit-btn">
                            <a href="admin.php?page=detail_order&order_id='.$order['order_id'].'"><i class="fa-solid fa-info px-1"></i></a>
                        </button>
                        <span class="dropdown">
                            <button class="btn btn-danger" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-regular fa-trash-can"></i>
                            </button>
                            <div class="dropdown-menu p-3" style="width: 250px">
                                <span>Bạn muốn xóa đơn hàng này?</span>
                                <div class="text-end mt-2">
                                    <a class="btn btn-primary text-white" href="admin.php?page=delete_order&order_id='.$order['order_id'].'">Xác nhận</a>
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
    <h5 class="py-3 px-2">Danh sách đơn hàng</h5>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col text-center">Mã đơn hàng</th>
                <th scope="col">Họ tên</th>
                <th scope="col">Email</th>
                <th scope="col">Địa chỉ</th>
                <th scope="col">Tổng tiền (VNĐ)</th>
                <th scope="col">Trạng thái</th>
                <th scope="col" style="text-align: center;">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php render_orders($order_data['data']) ?>
        </tbody>
    </table>
    <?php render_pagination($page, $order_data['total'], $PAGE_SIZE, 'admin.php?page=orders'); ?>
</div>