<?php 
    include_once './models/database.php';
    include_once './models/User.php';
    
    if(isset($_SESSION['user'])) {
        header('Location: index.php');
        exit();
    }

    if(isset($_POST['login'])) {
        $user_info = [
            'email' => $_POST['email'],
            'password' => $_POST['password'],
        ];
        
        $data = User::login($conn, $user_info);

        if($data['data'] !== null) {
            echo '<script>
                    showToast("'.$data['message'].'");
                    setTimeout(() => {
                        window.history.back();
                    }, 1000);
                </script>';
        } else {
            echo '<script>showToast("'.$data['message'].'");</script>';
        }
    } 
?>

<div class="card" style="width: 100%;">
    <div class="card-body">
        <h5 class="card-title fw-bold text-center mb-3">Chào mừng bạn đến với choVybe</h5>
        <h6 class="card-subtitle text-body-secondary text-center mb-3">Đăng nhập ngay để có những ưu đãi tốt nhất
        </h6>
        <form method="post">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email</label>
                <input name="email" type="email" placeholder="Nhập vào email của bạn" class="form-control"
                    id="exampleInputEmail1" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Mật khẩu</label>
                <input name="password" type="password" placeholder="Nhập vào mật khẩu" class="form-control"
                    id="exampleInputPassword1">
            </div>
            <div class="mb-3 form-check d-flex justify-content-between align-items-center">
                <div>
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Ghi nhớ tài khoản</label>
                </div>
                <a href="index.php?page=forgot_password">Quên mật khẩu?</a>
            </div>
            <div class="text-end mb-3">
                <button name="login" type="submit" class="btn btn-primary">Đăng nhập ngay</button>
            </div>
            <p class="text-center m-0">Chưa có tài khoản? Đăng ký ngay <a href="index.php?page=register">tại đây</a></p>
        </form>
    </div>
</div>