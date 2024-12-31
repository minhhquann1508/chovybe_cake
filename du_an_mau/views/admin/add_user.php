<?php 
    include_once './models/database.php';
    include_once './models/User.php';

    if(isset($_POST['add_user'])) {
        $user = [
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'phone' => $_POST['phone'],
            'address' => $_POST['address'],
            'password' => $_POST['password'],
            'role' => isset($_POST['role']) ? 1 : 0,
        ];

        $user_data = User::add_user_by_admin($conn, $user);

        if($user_data['data'] === true) {
            echo '<script>
                showToast("'.$user_data['message'].'");
                setTimeout(() => {
                    window.location.href = "admin.php?page=users";
                }, 2000);
            </script>';
        } else {
            echo '<script>
                showToast("'.$user_data['message'].'");
            </script>';
        }
    }
?>

<section class="p-3">
    <div class="container-fluid">
        <h4 class="text-center mb-4">Tạo người dùng</h4>
        <div class="d-flex justify-content-center">
            <form method="post" action="" class="w-50 rounded border p-3">
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Họ tên</label>
                    <input name="name" type="text" class="form-control" placeholder="Nhập vào họ và tên">
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Email</label>
                    <input name="email" type="email" class="form-control" placeholder="Nhập vào email">
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Số điện thoại</label>
                    <input name="phone" type="text" class="form-control" placeholder="Nhập vào số điện thoại">
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Địa chỉ</label>
                    <input name="address" type="text" class="form-control" placeholder="Nhập vào địa chỉ">
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Mật khẩu</label>
                    <input name="password" type="password" class="form-control" placeholder="Nhập vào mật khẩu">
                </div>
                <div class="form-check form-switch">
                    <input name="role" class="form-check-input" type="checkbox" role="switch"
                        id="flexSwitchCheckDefault">
                    <label class="form-check-label" for="flexSwitchCheckDefault">Quyền quản trị</label>
                </div>
                <div class="text-end">
                    <button class="btn btn-primary" name="add_user">Thêm người dùng</button>
                </div>
            </form>
        </div>
    </div>
</section>