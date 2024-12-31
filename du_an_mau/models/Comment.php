<?php 
    class Comment {
        static function add_comment($conn, $comment) {
            $sql = "INSERT INTO comments(content,product_id,user_id)
                    VALUES (?,?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sii", $comment['content'], $comment['product_id'], $comment['user_id']);
            $result = $stmt->execute();

            if($result) {
                return [
                    'data' => true,
                    'message' => 'Bình luận thành công',
                ];
            } else {
                return [
                    'data' => false,
                    'message' => 'Bình luận không thành công',
                ];
            }
        }

        static function get_all_comments($conn, $product_id) {
            $sql = "SELECT * FROM comments 
                    INNER JOIN user ON comments.user_id = user.user_id
                    WHERE product_id = ? 
                    ORDER BY comment_id DESC";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $product_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $comments = [];
            while($row = $result->fetch_assoc()) {
                $comments[] = $row;
            }
            return [
                'data' => $comments,
                'message' => 'Lấy danh sách bình luận thành công',
            ];
        }
    }
?>