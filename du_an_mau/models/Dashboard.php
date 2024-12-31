<?php 
    class Dashboard {
        static function get_dashboard_data($conn) {
            $sql_products = "SELECT COUNT(*) AS total_products FROM product";
            $sql_users = "SELECT COUNT(*) AS total_users FROM user";
            $sql_orders = "SELECT COUNT(*) AS total_orders FROM orders";
            $sql_total = "SELECT SUM(total) AS total FROM orders WHERE status = 1";

            $result_products = $conn->query($sql_products);
            $result_users = $conn->query($sql_users);
            $result_orders = $conn->query($sql_orders);
            $result_total = $conn->query($sql_total);

            $row_products = $result_products->fetch_assoc();
            $row_users = $result_users->fetch_assoc();
            $row_orders = $result_orders->fetch_assoc();
            $row_total = $result_total->fetch_assoc();

            return [
                'data' => [
                    $row_products,
                    $row_users,
                    $row_orders,
                    $row_total,
                ],
                'message' => 'Lấy thông tin dashboard thành công'
            ];
        }

        static function get_top_5_products($conn) {
            $sql = "SELECT sold, title, price, views FROM product ORDER BY sold DESC LIMIT 5";
            $result = $conn->query($sql);
            $products = [];
            while($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
            return [
                'data' => $products,
                'message' => 'Lấy top 5 sản phẩm thành công'
            ];
        }
    }
?>