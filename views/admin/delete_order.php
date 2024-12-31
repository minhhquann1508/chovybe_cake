<?php 
    include_once './models/database.php';
    include_once './models/Order.php';

    if(isset($_GET['order_id'])) {
        $order_id = $_GET['order_id'];

        $delete_order_data = Order::delete_order($conn, $order_id);

        if($delete_order_data['data']) {
            echo '<script>
                showToast("'.$delete_order_data['message'].'");
                setTimeout(() => {
                    window.location.href = "admin.php?page=orders";
                }, 700);
            </script>';
        } else {
            echo '<script>
                showToast("'.$delete_order_data['message'].'");
                setTimeout(() => {
                    window.location.href = "admin.php?page=orders";
                }, 3000);
            </script>';
        }
    }
?>