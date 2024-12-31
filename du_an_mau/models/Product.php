<?php 
    class Product {
        static function get_all_products($conn, $page_size = 10, $page = 1, $sort = '-price') {
            $format_page = ((int)$page - 1) * $page_size;
            switch ($sort) {
                case '-price':
                    $sql = "SELECT *, c.category_id, c.category_name FROM product p 
                    INNER JOIN category c ON c.category_id = p.category_id
                    WHERE p.is_show = 1
                    ORDER BY p.price ASC
                    LIMIT ?, ?";
                    break;
                case 'price':
                    $sql = "SELECT *, c.category_id, c.category_name FROM product p 
                    INNER JOIN category c ON c.category_id = p.category_id
                    WHERE p.is_show = 1
                    ORDER BY p.price ASC
                    LIMIT ?, ?";
                    break;
                case 'top_views':
                    $sql = "SELECT *, c.category_id, c.category_name FROM product p 
                    INNER JOIN category c ON c.category_id = p.category_id
                    WHERE p.is_show = 1
                    ORDER BY p.views DESC
                    LIMIT ?, ?";
                    break;
                case 'top_sold':
                    $sql = "SELECT *, c.category_id, c.category_name FROM product p 
                    INNER JOIN category c ON c.category_id = p.category_id
                    WHERE p.is_show = 1
                    ORDER BY p.sold DESC
                    LIMIT ?, ?";
                    break;
                default:
                    $sql = "SELECT *, c.category_id, c.category_name FROM product p 
                    INNER JOIN category c ON c.category_id = p.category_id
                    WHERE p.is_show = 1
                    LIMIT ?, ?";
                    break;
            }
            
            $sql_item = "SELECT COUNT(*) AS total FROM product WHERE product.is_show = 1";
            $stmt_item = $conn->query($sql_item);
            $result_item = $stmt_item->fetch_assoc();
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $format_page , $page_size);
            if($stmt->execute()) {
                $result = $stmt->get_result();
                $products = [];
                while($row = $result->fetch_assoc()) {
                    $products[] = $row;
                }
                return [
                    'data' => $products,
                    'total' => $result_item['total'],
                    'message' => 'Lấy danh sách sản phẩm thành công'
                ];
            } else {
                return [
                    'data' => [],
                    'message' => 'Lấy danh sách sản phẩm không thành công'
                ];
            }
        }

        static function get_all_products_by_admin($conn, $page_size = 10, $page = 1, $sort = '-price') {
            $format_page = ((int)$page - 1) * $page_size;
            switch ($sort) {
                case '-price':
                    $sql = "SELECT p.*, c.category_id, c.category_name FROM product p 
                    INNER JOIN category c ON c.category_id = p.category_id
                    ORDER BY p.price ASC
                    LIMIT ?, ?";
                    break;
                case 'price':
                    $sql = "SELECT p.*, c.category_id, c.category_name FROM product p 
                    INNER JOIN category c ON c.category_id = p.category_id
                    ORDER BY p.price ASC
                    LIMIT ?, ?";
                    break;
                case 'top_views':
                    $sql = "SELECT p.*, c.category_id, c.category_name FROM product p 
                    INNER JOIN category c ON c.category_id = p.category_id
                    ORDER BY p.views DESC
                    LIMIT ?, ?";
                    break;
                case 'top_sold':
                    $sql = "SELECT p.*, c.category_id, c.category_name FROM product p 
                    INNER JOIN category c ON c.category_id = p.category_id
                    ORDER BY p.sold DESC
                    LIMIT ?, ?";
                    break;
                default:
                    $sql = "SELECT p.*, c.category_id, c.category_name FROM product p 
                    INNER JOIN category c ON c.category_id = p.category_id
                    LIMIT ?, ?";
                    break;
            }
            
            $sql_item = "SELECT COUNT(*) AS total FROM product";
            $stmt_item = $conn->query($sql_item);
            $result_item = $stmt_item->fetch_assoc();
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $format_page , $page_size);
            if($stmt->execute()) {
                $result = $stmt->get_result();
                $products = [];
                while($row = $result->fetch_assoc()) {
                    $products[] = $row;
                }
                return [
                    'data' => $products,
                    'total' => $result_item['total'],
                    'message' => 'Lấy danh sách sản phẩm thành công'
                ];
            } else {
                return [
                    'data' => [],
                    'message' => 'Lấy danh sách sản phẩm không thành công'
                ];
            }
        }

        static function get_product_by_id($conn, $product_id) {
            $sql = "SELECT *, c.category_name FROM product p INNER JOIN category c ON c.category_id = p.category_id WHERE p.product_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $product_id);

            $sql_2 = "SELECT image_id, url FROM image WHERE product_id = ?";
            $stmt_2 = $conn->prepare($sql_2);
            $stmt_2->bind_param("i", $product_id);

            $sql_3 = "UPDATE product SET views = views + 1 WHERE product_id = ?";
            $stmt_3 = $conn->prepare($sql_3);
            $stmt_3->bind_param("i", $product_id);
            $stmt_3->execute();

            if($stmt->execute()) {
                $result = $stmt->get_result();
                $product = $result->fetch_assoc();  
                $stmt_2->execute();
                $images = [];
                $result_2 = $stmt_2->get_result();
                while($row = $result_2->fetch_assoc()) {
                    $images[] = $row;
                }
                $product['images'] = $images;
                
                return [
                    'data' => $product,
                    'message' => 'Lấy sản phẩm thành công'
                ];
            } else {
                return [
                    'data' => [],
                    'message' => 'Lấy sản phẩm không thành công'
                ];
            }
        }

        static function add_new_product($conn, $product) {
            $sql = "INSERT INTO product(title, sub_desc, description, thumbnail, price, is_show, sold, category_id, quantity)
                    VALUES (?,?,?,?,?,?,?,?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssiiiii", $product['title'], $product['sub_desc'], 
                                $product['description'], $product['thumbnail'], 
                                $product['price'], $product['is_show'], 
                                $product['sold'], $product['category_id'], $product['quantity']);
            if($stmt->execute()) {
                $last_id = $conn->insert_id;
                return [
                    'data' => $last_id,
                    'message' => 'Tạo sản phẩm thành công'
                ];
            } else {
                return [
                    'data' => null,
                    'message' => 'Tạo sản phẩm không thành công'
                ];
            }
        }

        static function get_hot_product($conn) {
            $sql = "SELECT * FROM product WHERE is_hot = 1 AND is_show = 1 LIMIT 4";
            $stmt = $conn->query($sql);
            $products = [];
            if($stmt->num_rows > 0) {
                while($row = $stmt->fetch_assoc()) {
                    $products[] = $row;
                }
                return [
                    'data' => $products,
                    'message' => 'Lấy danh sách sản phẩm hot thành công'
                ];
            } else {
                return [
                    'data' => [],
                    'message' => 'Không tìm thấy sản phẩm hot'
                ];
            }
        }

        static function get_related_products($conn, $product) {
            $sql = "SELECT * FROM product WHERE category_id = ? AND product_id != ? LIMIT 4";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $product['category_id'], $product['product_id']);
            if($stmt->execute()) {
                $result = $stmt->get_result();
                $products = [];
                while($row = $result->fetch_assoc()) {
                    $products[] = $row;
                }
                return [
                    'data' => $products,
                    'message' => 'Lấy danh sách sản phẩm tương tự thành công'
                ];
            } else {
                return [
                    'data' => [],
                    'message' => 'Lấy danh sách sản phẩm tương tự không thành công'
                ];
            }
        }

        static function get_product_by_category($conn, $category_id, $page_size = 10, $page = 1, $sort = '-price') {
            $format_page = ((int)$page - 1) * $page_size;
            switch ($sort) {
                case '-price':
                    $sql = "SELECT *, c.category_id, c.category_name FROM product p 
                    INNER JOIN category c ON c.category_id = p.category_id
                    WHERE p.category_id = ? AND p.is_show = 1
                    ORDER BY p.price ASC
                    LIMIT ?, ?";
                    break;
                case 'price':
                    $sql = "SELECT *, c.category_id, c.category_name FROM product p 
                    INNER JOIN category c ON c.category_id = p.category_id
                    ORDER BY p.price DESC
                    LIMIT ?, ?";
                    break;
                case 'top_views':
                    $sql = "SELECT *, c.category_id, c.category_name FROM product p 
                    INNER JOIN category c ON c.category_id = p.category_id
                    ORDER BY p.views DESC
                    LIMIT ?, ?";
                    break;
                case 'top_sold':
                    $sql = "SELECT *, c.category_id, c.category_name FROM product p 
                    INNER JOIN category c ON c.category_id = p.category_id
                    ORDER BY p.sold DESC
                    LIMIT ?, ?";
                    break;
                default:
                    $sql = "SELECT *, c.category_id, c.category_name FROM product p 
                    INNER JOIN category c ON c.category_id = p.category_id
                    WHERE p.category_id = ? AND p.is_show = 1
                    LIMIT ?, ?";
                    break;
            }

            $sql_item = "SELECT COUNT(*) AS total FROM product p WHERE p.category_id = ? AND p.is_show = 1";
            $stmt_item = $conn->prepare($sql_item);
            $stmt_item->bind_param("i", $category_id);
            
            if($stmt_item->execute()) {
                $result_item = $stmt_item->get_result()->fetch_assoc();
            }

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iii",$category_id, $format_page , $page_size);
            if($stmt->execute()) {
                $result = $stmt->get_result();
                $products = [];
                while($row = $result->fetch_assoc()) {
                    $products[] = $row;
                }
                return [
                    'data' => $products,
                    'total' => $result_item['total'],
                    'message' => 'Lấy danh sách sản phẩm thành công'
                ];
            } else {
                return [
                    'data' => [],
                    'message' => 'Lấy danh sách sản phẩm không thành công'
                ];
            }
        }

        static function get_products_by_keyword($conn, $keyword, $page_size = 10, $page = 1) {
            $format_page = ((int)$page - 1) * $page_size;
            $keyword = "%$keyword%";
            $sql = "SELECT * FROM product WHERE title LIKE ? AND is_show = 1 LIMIT ?, ?";

            $sql_item = "SELECT COUNT(*) AS total FROM product WHERE title LIKE ? AND is_show = 1";
            $stmt_item = $conn->prepare($sql_item);
            $stmt_item->bind_param("s", $keyword);
            
            if($stmt_item->execute()) {
                $result_item = $stmt_item->get_result()->fetch_assoc();
            }

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sii", $keyword, $format_page , $page_size);
            if($stmt->execute()) {
                $result = $stmt->get_result();
                $products = [];
                while($row = $result->fetch_assoc()) {
                    $products[] = $row;
                }
                return [
                    'data' => $products,
                    'total' => $result_item['total'],
                    'message' => 'Lấy danh sách sản phẩm theo từ khoá thành công'
                ];
            } else {
                return [
                    'data' => [],
                    'message' => 'Lấy danh sách sản phẩm theo từ khoá không thành công'
                ];
            }
        }

        static function delete_product($conn, $product_id) {
            try {
                $sql = "DELETE FROM product WHERE product_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $product_id);
                $stmt->execute();
                return [
                    'data' => true,
                    'message' => 'Xóa sản phẩm thành công'
                ];
            } catch (mysqli_sql_exception $e){
                return [
                    'data' => false,
                    'message' => 'Không thể xóa sản phẩm do đã được đặt hàng'
                ];
            }
        }

        static function update_product($conn, $product) {
            $sql = "UPDATE product SET title =?, sub_desc =?, 
                                description =?, quantity =?,
                                price =?, sold =?,
                                category_id =?, is_show =?, thumbnail =? 
                                WHERE product_id =?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssidiiisi", $product['title'], $product['sub_desc'],
                                            $product['description'], $product['quantity'],
                                            $product['price'], $product['sold'],
                                            $product['category_id'], $product['is_show'],
                                            $product['thumbnail'], $product['product_id']);
            $stmt->execute();

            return [
                'data' => true,
                'message' => 'Cập nhật sản phẩm thành công'
            ];
        }

        static function add_images($conn,$url,$product_id) {
            $sql = "INSERT INTO image(url,product_id)
                            VALUES(?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $url, $product_id);
            $stmt->execute();
        }

        static function update_image_by_id($conn,$url,$image_id) {
            $sql = "UPDATE image SET url =? WHERE image_id =?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $url, $image_id);
            $stmt->execute();
        }
    }
?>