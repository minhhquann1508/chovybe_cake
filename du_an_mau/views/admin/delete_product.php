<?php 
    include_once './models/database.php';
    include_once './models/Product.php';

    if(isset($_GET['product_id'])) {
        $product_id = $_GET['product_id'];
        
        $delete_product_data = Product::delete_product($conn, $product_id);

        if($delete_product_data['data']) {
            echo '<script>
                showToast("'.$delete_product_data['message'].'");
                setTimeout(() => {
                    window.location.href = "admin.php?page=products";
                }, 700);
            </script>';
        } else {
            echo '<script>
                showToast("'.$delete_product_data['message'].'");
                setTimeout(() => {
                    window.location.href = "admin.php?page=products";
                }, 3000);
            </script>';
        }
    } else {
        echo "Sản phẩm không tồn tại.";
    }
?>