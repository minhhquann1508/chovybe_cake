<?php 
    include_once './views/user/_breadcrumb.php';
    include_once './models/database.php';
    include_once './models/Order.php';
    include_once './models/User.php';
    include_once './config/upload.php';

    if(isset($_SESSION['user'])) {
        $user_id = $_SESSION['user']['user_id'];
        $user_data = User::get_user_info($conn, $user_id);
        $order_data = Order::get_order_by_user_id($conn, $user_id);
    } else {
        header('Location: index.php');
    }

    $bread_crumb = [
        ['title' => 'Trang chủ', 'url' => 'index.php'],
        ['title' => 'Hồ sơ người dùng', 'url' => 'index.php?page=user_info'],
    ];

    if(isset($_POST['update_info'])) {
        $avatar = $_FILES['file'] && $_FILES['file']['error'] === UPLOAD_ERR_OK ? upload_file($_FILES['file']['tmp_name'])  : '';
        $user_id = $_SESSION['user']['user_id'];
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];

        $user_info = [
            'user_id' => $user_id,
            'name' => $name,
            'phone' => $phone,
            'address' => $address,
            'avatar' => $avatar
        ];

        $user_data = User::update_user_info($conn, $user_info);

        if($user_data['data'] !== null) {
            $_SESSION['user'] = $user_data['data'];
            echo '<script>
                    showToast("'.$user_data['message'].'");
                    setTimeout(() => {
                        window.location.href = "index.php?page=user_info";
                    }, 1000);
                </script>';
        } else {
            echo '<script>
                showToast("'.$user_data['message'].'");
            </script>';
        }
    }
?>
<section class="py-4" style="min-height: 100vh;">
    <div class="container">
        <?php render_breadcrumbs($bread_crumb); ?>
        <div class="row mt-4">
            <div class="col-12 col-lg-6 mt-3">
                <div class="p-4 border rounded">
                    <h3 class="fw-bold mb-3 text-center">Thông tin người dùng</h3>
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label">Ảnh đại diện</label>
                            <label for="file" class="d-flex justify-content-center align-items-center rounded-circle"
                                style="border: 1px dashed #ccc; width: 150px;height: 150px; cursor: pointer; overflow: hidden;">
                                <img class="w-100 h-100" id="add-avatar" src="<?php 
                                        if($user_data['data']['avatar']) {
                                            echo $user_data['data']['avatar'];
                                        } else {
                                            echo 'https://static.vecteezy.com/system/resources/previews/009/292/244/non_2x/default-avatar-icon-of-social-media-user-vector.jpg';
                                        }
                                    ?>" alt="plus">
                                <input onchange="handleUploadImg(this,'add-avatar')" id="file" name="file" type="file"
                                    class="d-none">
                            </label>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-6">
                                <label class="form-label">Họ và tên</label>
                                <input name="name" type="text" value="<?php echo $user_data['data']['name'] ?>"
                                    class="form-control">
                            </div>
                            <div class="col-6">
                                <label for="exampleInputEmail1" class="form-label">Email</label>
                                <input disabled value="<?php echo $user_data['data']['email'] ?>" type="email"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Số điện thoại</label>
                            <input name="phone" value="<?php echo $user_data['data']['phone'] ?>" type="text"
                                class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Địa chỉ</label>
                            <input name="address" value="<?php echo $user_data['data']['address'] ?>" type="text"
                                class="form-control">
                        </div>
                        <div class="text-end">
                            <a href="index.php?page=change_password" class="btn btn-secondary text-white">Đổi mật
                                khẩu</a>
                            <button class="btn btn-primary" type="submit" name="update_info">Chỉnh sửa</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-12 col-lg-6 mt-3">
                <div class="py-4 px-2 border rounded">
                    <h3 class="fw-bold mb-3 text-center">Đơn hàng của bạn</h3>
                    <?php 
                        if(count($order_data['data']) <= 0) {
                            echo '<p class="text-center">Bạn chưa có đơn hàng nào.</p>';
                        } else {
                            foreach ($order_data['data'] as $order) {
                                echo '
                                    <div class="p-3 border rounded d-flex justify-content-between mb-3">
                                        <h6><strong>Mã đơn hàng:</strong> '.$order['order_id'].'</h6>
                                        <a href="index.php?page=thank_you&order_id='.$order['order_id'].'" class="text-decoration-underline">Xem chi tiết đơn hàng</a>
                                    </div>
                                ';
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>