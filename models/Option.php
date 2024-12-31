<?php 
    class Option {
        static function get_all_options($conn) {
            $sql = "SELECT * FROM `options`";
            $stmt = $conn->query($sql);
            $options = [];
            while($row = $stmt->fetch_assoc()) {
                $options[] = $row;
            }
            return [
                'data' => $options,
                'message' => 'Lấy danh sách lựa chọn thành công'
            ];
        }
    }
?>