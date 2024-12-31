<?php 
    include_once './models/database.php';
    include_once './models/Category.php';

    if(isset($_GET['category_id'])) {
        $category_id = $_GET['category_id'];

        $delete_category_data = Category::delete_category($conn, $category_id);

        if($delete_category_data['data']) {
            echo '<script>
                showToast("'.$delete_category_data['message'].'");
                setTimeout(() => {
                    window.location.href = "admin.php?page=categories";
                }, 700);
            </script>';
        } else {
            echo '<script>
                showToast("'.$delete_category_data['message'].'");
                setTimeout(() => {
                    window.location.href = "admin.php?page=categories";
                }, 3000);
            </script>';
        }
    }
?>