<?php 
    include_once './config/send_mail.php';
    include_once './config/helper.php';

    if(isset($_POST['forgot_password'])) {
        $email = $_POST['email'];
        $token = randomString();
        send_mail_forgot_password($email,$token);
    }
?>

<div class="card" style="width: 100%;">
    <div class="card-body">
        <h5 class="card-title fw-bold text-center mb-3">Lấy lại mật khẩu</h5>
        <h6 class="card-subtitle text-body-secondary text-center mb-3">Đừng quên mật khẩu nữa nhéee !!</h6>
        <form method="post">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email</label>
                <input name="email" type="email" placeholder="Nhập vào email của bạn" class="form-control"
                    id="exampleInputEmail1" aria-describedby="emailHelp">
            </div>
            <div class="text-end mb-3">
                <button name="forgot_password" type="submit" class="btn btn-primary">Lấy lại mật khẩu</button>
            </div>
        </form>
    </div>
</div>