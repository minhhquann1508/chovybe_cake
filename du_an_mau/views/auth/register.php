<?php 
    include_once './models/database.php';
    include_once './models/User.php';

    if(isset($_SESSION['user'])) {
        header('Location: index.php');
        exit();
    }

    if(isset($_POST['register'])) {
        $user = [
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'password' => $_POST['password'],
        ];

        $data = User::register($conn, $user);

        if($data['data'] !== null) {
            echo '<script>
                    showToast("'.$data['message'].'");
                    setTimeout(() => {
                        window.location.href = "index.php?page=login";
                    }, 1000);
                </script>';
        } else {
            echo '<script>showToast("'.$data['message'].'");</script>';
        }
    } 
?>

<div class="card" style="width: 100%;">
    <div class="card-body">
        <h5 class="card-title fw-bold text-center mb-3">Trở thành một thành viên của choVybe</h5>
        <h6 class="card-subtitle text-body-secondary text-center mb-3">Để trải nghiệm trọn vẹn tất cả dịch vụ của
            choVybe
        </h6>
        <form method="post" action="">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Họ và tên</label>
                <input name="name" type="text" placeholder="Nhập vào họ và tên của bạn" class="form-control"
                    id="exampleInputEmail1" aria-describedby="emailHelp">
            </div>
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
            <!-- <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Nhập lại mật khẩu</label>
                <input name="confirm_password" type="password" placeholder="Nhập lại mật khẩu" class="form-control"
                    id="exampleInputPassword1">
            </div> -->
            <div class="text-end mb-3">
                <button name="register" type="submit" class="btn btn-primary">Đăng ký ngay</button>
            </div>
            <p class="text-center m-0">Đã có tài khoản? Đăng nhập ngay <a href="index.php?page=login">tại đây</a></p>
        </form>
    </div>
</div>