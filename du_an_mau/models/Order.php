<?php 
    class Order {
        static function add_order($conn, $user_info, $order_product) {
            $sql = "INSERT INTO orders(name, email, address, phone, total, note, user_id)
                    VALUES(?,?,?,?,?,?,?)";
            $sql_order_detail = "INSERT INTO detail_order(order_id, product_id, quantity, total, option_id)
                    VALUES(?,?,?,?,?)";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssi", $user_info['name'], $user_info['email'], 
                                        $user_info['address'], $user_info['phone'], 
                                        $user_info['total'],$user_info['note'], $user_info['user_id']);
            if($stmt->execute()) {
                $order_id = $conn->insert_id;
                foreach ($order_product as $product) {
                    $total = $product['price'] * $product['quantity'];
                    $stmt_1 = $conn->prepare($sql_order_detail);
                    $stmt_1->bind_param('iiidi', $order_id, $product['product_id'],
                                                $product['quantity'], $total, $product['option_id']);
                    $stmt_1->execute();
                }

                return [
                    'data' => $order_id,
                    'message' => 'Thanh toán thành công'
                ];
            } else {
                return [
                    'data' => null,
                    'message' => 'Thanh toán không thành công'
                ];
            }
        }

        static function get_order_by_id($conn, $order_id) {
            $sql = "SELECT * FROM orders o
                    INNER JOIN user u ON u.user_id = o.user_id
                    WHERE o.order_id = ?";

            $sql_order_detail = "SELECT op.size, op.sweetness, d.quantity, p.title, p.price, p.thumbnail, d.product_id FROM detail_order d
                                INNER JOIN orders o ON d.order_id = o.order_id
                                INNER JOIN options op ON op.option_id = d.option_id
                                INNER JOIN product p ON d.product_id = p.product_id
                                WHERE d.order_id = ?";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $order_id);
            $stmt->execute();
            $order_info = $stmt->get_result()->fetch_assoc();

            $stmt_1 = $conn->prepare($sql_order_detail);
            $stmt_1->bind_param('i', $order_id);
            $stmt_1->execute();
            $result_1 = $stmt_1->get_result();
            $orders = [];
            while($row = $result_1->fetch_assoc()) {
                $orders[] = $row;
            }

            return [
                'data' => [
                    'order_info' => $order_info,
                    'orders' => $orders,
                ],
                'message' => 'Lấy đơn hàng thành công'
            ];
        }

        static function get_order_by_user_id($conn, $user_id) {
            $sql = "SELECT * FROM orders o
                    INNER JOIN user u ON u.user_id = o.user_id
                    WHERE o.user_id = ?";
                    
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $user_id);
            if($stmt->execute()) {
                $result = $stmt->get_result();
                $orders = [];
                while($row = $result->fetch_assoc()) {
                    $orders[] = $row;
                }
                return [
                    'data' => $orders,
                    'message' => 'Lấy đơn hàng thành công'
                ];
            } else {
                return [
                    'data' => [],
                    'message' => 'Lấy đơn hàng không thành công'
                ];
            }
        }

        static function get_all_orders($conn, $page_size = 10, $page = 1) {
            $format_page = ((int)$page - 1) * $page_size;
            $sql = "SELECT * FROM orders
                    LIMIT ?, ?";
            $sql_item = "SELECT COUNT(*) AS total FROM orders";
            $stmt_item = $conn->query($sql_item);
            $result_item = $stmt_item->fetch_assoc();
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ii', $format_page, $page_size);
            if($stmt->execute()) {
                $result = $stmt->get_result();
                $orders = [];
                while($row = $result->fetch_assoc()) {
                    $orders[] = $row;
                }
                return [
                    'data' => $orders,
                    'total' => $result_item['total'],
                    'message' => 'Lấy danh sách đơn hàng thành công'
                ];
            } else {
                return [
                    'data' => [],
                    'message' => 'Lấy danh sách đơn hàng không thành công'
                ];
            }
        }

        static function update_order_status($conn, $order_id, $list_order) {
            $sql = "UPDATE orders SET status = 1 WHERE order_id =?";
            $sql_1 = "UPDATE product SET quantity = quantity - ?, sold = sold + ? WHERE product_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $order_id);
            if($stmt->execute()) {
                foreach ($list_order as $order) {
                    $stmt_1 = $conn->prepare($sql_1);
                    $stmt_1->bind_param('iii', $order['quantity'],$order['quantity'], $order['product_id']);
                    $stmt_1->execute();
                }
                return [
                    'data' => true,
                    'message' => 'Cập nhật trạng thái đơn hàng thành công'
                ];
            } else {
                return [
                    'data' => false,
                    'message' => 'Cập nhật trạng thái đơn hàng không thành công'
                ];
            }
        }

        static function delete_order($conn ,$order_id) {
            $sql = "DELETE FROM detail_order WHERE order_id =?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $order_id);
            if($stmt->execute()) {
                $sql_1 = "DELETE FROM orders WHERE order_id =?";
                $stmt_1 = $conn->prepare($sql_1);
                $stmt_1->bind_param('i', $order_id);
                $stmt_1->execute();
                return [
                    'data' => true,
                    'message' => 'Xóa đơn hàng thành công'
                ];
            } else {
                return [
                    'data' => false,
                    'message' => 'Xóa đơn hàng không thành công'
                ];
            }
        }
    }

?>