<?php 
    include_once './models/database.php';
    include_once './models/User.php';
    include_once './utils/constant.php';
    include_once './views/core/_pagination.php';
    include_once '_option.php';

    $page = isset($_GET['page_index']) ? $_GET['page_index'] : 1;

    $user_data = User::get_all_users($conn, $PAGE_SIZE, $page);

    function render_users($users) {
        $content = '';
        $default_avatar_img = 'https://static.vecteezy.com/system/resources/previews/002/002/403/non_2x/man-with-beard-avatar-character-isolated-icon-free-vector.jpg';
        foreach ($users as $key => $user) {
            $is_admin = $user['role'] == 1 ? 'Quản trị' : 'Người dùng';
            $avatar_img = $user['avatar'] ?? $default_avatar_img; 
            $content .= '
                <tr>
                    <td>'.($key + 1).'</td>
                    <td>
                        <img src="'.$avatar_img.'" width="50" height="50" alt="">
                    </td>
                    <td>'.$user['name'].'</td>
                    <td>'.$user['email'].'</td>
                    <td>'.$user['phone'].'</td>
                    <td class="text-center">'.$user['address'].'</td>
                    <td class="text-center">'.$is_admin.'</td>
                    <td class="text-center">
                        <span class="dropdown">
                            <button class="btn btn-danger" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-regular fa-trash-can"></i>
                            </button>
                            <div class="dropdown-menu p-3" style="width: 250px">
                                <span>Bạn muốn xóa người dùng này?</span>
                                <div class="text-end mt-2">
                                    <a class="btn btn-primary text-white" href="admin.php?page=delete_user&user_id='.$user['user_id'].'">Xác nhận</a>
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
    <?php render_option('Danh mục người dùng', 'admin.php?page=add_user')  ?>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Avatar</th>
                <th scope="col">Họ và tên</th>
                <th scope="col">Email</th>
                <th scope="col">Số điện thoại</th>
                <th scope="col" style="text-align: center;">Địa chỉ</th>
                <th scope="col" style="text-align: center;">Chức vụ</th>
                <th scope="col" style="text-align: center;">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php render_users($user_data['data']) ?>
        </tbody>
    </table>
    <?php render_pagination($page, $user_data['total'], $PAGE_SIZE, 'admin.php?page=users'); ?>
</section>