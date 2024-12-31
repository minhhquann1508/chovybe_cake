<?php 
    include_once './models/database.php';
    include_once './models/User.php';

    if(isset($_GET['token']) && isset($_SESSION['token']) && isset($_GET['email'])) {
        $token = $_GET['token'];
        if($token == $_SESSION['token']) {
            if(isset($_POST['change_password'])) {
                $password = $_POST['password'];
                $confirm_password = $_POST['confirm_password'];
                if($password !== $confirm_password) {
                    echo '<script>
                        showToast("Mật khẩu không trùng khớp");
                    </script>';
                } else {
                    $email = $_GET['email'];
                    $change_password_data = User::change_password_forgot($conn, $email, $password);
                    if($change_password_data['data']) {
                        echo '<script>
                            showToast("'.$change_password_data['message'].'");
                            setTimeout(() => {
                                window.location.href = "index.php?page=login";
                            }, 1000);
                        </script>';
                    } else {
                        echo '<script>
                            showToast("'.$change_password_data['message'].'");
                        </script>';
                    }
                }
            }
        } else {
            header('Location: index.php');
        }
    } else {
        header('Location: index.php');
    }

?>

<div class="card" style="width: 100%;">
    <div class="card-body">
        <h5 class="card-title fw-bold text-center mb-3">Nhập lại mật khẩu</h5>
        <h6 class="card-subtitle text-body-secondary text-center mb-3">Hãy điền mật khẩu mới và mã xác nhận nhé !!</h6>
        <form method="post">
            <div class="mb-3">
                <label class="form-label">Nhập mật khẩu mới</label>
                <input name="password" type="password" placeholder="Nhập vào mật khẩu mới của bạn" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Xác nhận mật khẩu</label>
                <input name="confirm_password" type="password" placeholder="Nhập vào mật khẩu mới của bạn"
                    class="form-control">
            </div>
            <div class="text-end mb-3">
                <button name="change_password" type="submit" class="btn btn-primary">Cập nhật mật khẩu</button>
            </div>
        </form>
    </div>
</div>