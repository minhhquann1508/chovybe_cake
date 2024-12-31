<?php 
    class Category {
        static function add_new_category($conn, $category) {
            $sql = "INSERT INTO category (category_name, description, is_show) 
                    VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssi", $category['category_name'], $category['description'], $category['is_show']);
            if($stmt->execute()) {
                return [
                    'data' => true,
                    'message' => 'Thêm danh mục sản phẩm thành công'
                ];
            } else {
                return [
                    'data' => false,
                    'message' => 'Thêm danh mục sản phẩm thất bại'
                ];
            }
        }

        static function get_categories_pagination($conn, $page_size = 10, $page = 1) {
            $format_page = ((int)$page - 1) * $page_size;
            
            $sql = "SELECT * FROM category LIMIT ?, ?";
            $sql_item = "SELECT COUNT(*) AS total FROM category";

            $stmt_item = $conn->query($sql_item);
            $result_item = $stmt_item->fetch_assoc();
            
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $format_page , $page_size);
            
            if($stmt->execute()) {
                $result = $stmt->get_result();
                $categories = [];
                while($row = $result->fetch_assoc()) {
                    $categories[] = $row;
                }
                return [
                    'data' => $categories,
                    'total' => $result_item['total'],
                    'message' => 'Lấy danh mục sản phẩm thành công'
                ];
            } else {
                return [
                    'data' => null,
                    'message' => 'Lấy danh mục sản phẩm không thành công'
                ];
            }
        }

        static function get_all_categories($conn) {
            $sql = "SELECT * FROM category WHERE is_show = 1";
            $stmt = $conn->prepare($sql);
            
            if($stmt->execute()) {
                $result = $stmt->get_result();
                $categories = [];
                while($row = $result->fetch_assoc()) {
                    $categories[] = $row;
                }
                return [
                    'data' => $categories,
                    'message' => 'Lấy danh mục sản phẩm thành công'
                ];
            } else {
                return [
                    'data' => [],
                    'message' => 'Lấy danh mục sản phẩm không thành công'
                ];
            }
        }

        static function get_category_by_id($conn, $category_id, $is_show) {
            if($is_show) {
                $sql = "SELECT * FROM category WHERE category_id = ? AND is_show = 1";
            } else {
                $sql = "SELECT * FROM category WHERE category_id = ?";
            }
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $category_id);
            if($stmt->execute()) {
                $result = $stmt->get_result();
                $category = $result->fetch_assoc();
                
                return [
                    'data' => $category,
                    'message' => 'Lấy chi tiết danh mục thành công'
                ];
            } else {
                return [
                    'data' => null,
                    'message' => 'Lấy chi tiết danh mục thành công'
                ];
            }
        }

        static function update_category($conn, $category) {
            $sql = "UPDATE category SET category_name=?, description=?, is_show=? WHERE category_id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssii", $category['category_name'], $category['description'], $category['is_show'], $category['category_id']);
            if($stmt->execute()) {
                return [
                    'data' => true,
                    'message' => 'Chỉnh sửa danh mục thành công'
                ];
            } else {
                return [
                    'data' => false,
                    'message' => 'Chỉnh sửa danh mục thất bại'
                ];
            }
        }

        static function delete_category($conn, $category_id) {
            try {
                $sql = "DELETE FROM category WHERE category_id=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('i', $category_id);
                if($stmt->execute()) {
                    return [
                        'data' => true,
                        'message' => 'Xóa danh mục thành công'
                    ];
                } else {
                    return [
                        'data' => false,
                        'message' => 'Xóa danh mục không thành công'
                    ];
                }
            } catch (mysqli_sql_exception $e) {
                return [
                    'data' => false,
                    'message' => 'Không thể xóa danh mục do đã có sản phẩm trong danh mục'
                ];
            }

        }
    }
?>