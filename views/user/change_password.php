<?php 
    include_once './views/user/_breadcrumb.php';
    include_once './models/database.php';
    include_once './models/User.php';

    if(isset($_SESSION['user'])) {
        if(isset($_POST['confirm_change_password'])) {
            $old_password = $_POST['old_password'];
            $new_password_1 = $_POST['new_password_1'];
            $new_password_2 = $_POST['new_password_2'];
            if($new_password_1 === $new_password_2) {
                $change_password = User::change_password($conn, $_SESSION['user']['user_id'], $old_password, $new_password_1);
                if($change_password['data'] == true) {
                    echo '<script>
                        showToast("'.$change_password['message'].'");
                        setTimeout(() => {
                            window.location.href = "index.php?page=logout";
                        }, 1000);
                    </script>';
                } else {
                    echo '<script>
                        showToast("'.$change_password['message'].'");
                    </script>';
                }
            } else {
                echo '<script>
                    showToast("Mật khẩu không trùng nhau");
                </script>';
            }
        }
    } else {
        header('Location: index.php');
    }

    $bread_crumb = [
        ['title' => 'Trang chủ', 'url' => 'index.php'],
        ['title' => 'Hồ sơ người dùng', 'url' => 'index.php?page=user_info'],
        ['title' => 'Đổi mật khẩu', 'url' => 'index.php?page=change_password']
    ];
?>

<section class="py-4">
    <div class="container">
        <?php render_breadcrumbs($bread_crumb) ?>

        <div class="d-flex justify-content-center mt-5 mb-3">
            <form action="" method="post" class="border rounded p-4 w-50">
                <h4 class="text-center">Đổi mật khẩu</h4>
                <div class="mb-3">
                    <label class="form-label">Mật khẩu cũ</label>
                    <input name="old_password" placeholder="Nhập vào mật khẩu cũ" type="password" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Mật khẩu mới</label>
                    <input name="new_password_1" placeholder="Nhập vào mật khẩu mới" type="password"
                        class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Xác nhận mật khẩu</label>
                    <input name="new_password_2" placeholder="Nhập lại mật khẩu" type="password" class="form-control">
                </div>
                <div class="text-end">
                    <button class="btn btn-primary" type="submit" name="confirm_change_password">Xác nhận</button>
                </div>
            </form>
        </div>
    </div>
</section>