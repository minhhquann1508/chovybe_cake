<?php 
    include_once './models/database.php';
    include_once './models/User.php';

    if(isset($_GET['user_id'])) {
        $user_id = $_GET['user_id'];

        $delete_user_data = User::delete_user($conn, $user_id);

        if($delete_user_data['data']) {
            echo '<script>
                showToast("'.$delete_user_data['message'].'");
                setTimeout(() => {
                    window.location.href = "admin.php?page=users";
                }, 2000);
            </script>';
        } else {
            echo '<script>
                showToast("'.$delete_user_data['message'].'");
                setTimeout(() => {
                    window.location.href = "admin.php?page=users";
                }, 3000);
            </script>';
        }
    }
?>