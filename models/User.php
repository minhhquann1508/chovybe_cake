<?php 
    class User {
        static function register($conn, $user) {
            $sql = "INSERT INTO user(name, email, password)
                    VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $hashed_password = password_hash($user['password'], PASSWORD_ARGON2ID);
            $stmt->bind_param("sss", $user['name'], $user['email'], $hashed_password);
            if($stmt->execute()) {
                return [
                    'data' => [],
                    'message' => 'Đăng ký thành công'
                ];
            } else {
                return [
                    'data' => null,
                    'message' => 'Đăng ký thất bại'
                ];
            }
        }

        static function login($conn, $user) {
            $sql = "SELECT * FROM user where email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $user['email']);
            if($stmt->execute()) {
                $result = $stmt->get_result();
                $user_info = $result->fetch_assoc();
                if(password_verify($user['password'], $user_info['password'])) {
                    $_SESSION['message'] = 'Đăng nhập thành công';
                    $_SESSION['user'] = $user_info;
                    return [
                        'data' => $user,
                        'message' => 'Đăng nhập thành công'
                    ];
                } else {
                    return [
                        'data' => null,
                        'message' => 'Tài khoản hoặc mật khẩu không đúng'
                    ];
                }
            } else {
                return [
                    'data' => null,
                    'message' => 'Đăng nhập không thành công'
                ];
            }
        }

        static function get_user_info($conn, $user_id) {
            $sql = "SELECT * FROM user WHERE user_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $user_id);
            if($stmt->execute()) {
                $result = $stmt->get_result();
                $user_info = $result->fetch_assoc();
                return [
                    'data' => $user_info,
                    'message' => 'Lấy thông tin người dùng thành công'
                ];
            } else {
                return [
                    'data' => null,
                    'message' => 'Lấy thông tin người dùng thất bại'
                ];
            }
        }

        static function update_user_info($conn, $user_info) {
            $sql = "UPDATE user SET name=? , address=?, phone=?, avatar=?
                    WHERE user_id=?";

            $sql_user = "SELECT * FROM user WHERE user_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssi", $user_info['name'], $user_info['address'], 
                                    $user_info['phone'],$user_info['avatar'], $user_info['user_id']);
            if($stmt->execute()) {
                $stmt_1 = $conn->prepare($sql_user);
                $stmt_1->bind_param("i", $user_info['user_id']);
                $stmt_1->execute();
                $result = $stmt_1->get_result();
                $user_info_update = $result->fetch_assoc();
                return [
                    'data' => $user_info_update,
                    'message' => 'Cập nhật thông tin người dùng thành công'
                ];
            } else {
                return [
                    'data' => null,
                    'message' => 'Cập nhật thông tin người dùng thất bại'
                ];
            }
        }

        static function change_password($conn,$user_id,$old_password, $new_password) {
            $hashed_password = password_hash($new_password, PASSWORD_ARGON2ID);
            $sql = "SELECT * FROM user WHERE user_id =?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $user_id);
            if($stmt->execute()) {
                $result = $stmt->get_result();
                $user_info = $result->fetch_assoc();
                if(password_verify($old_password, $user_info['password'])) {
                    $sql_1 = "UPDATE user SET password = ? WHERE user_id = ?";
                    $stmt_1 = $conn->prepare($sql_1);
                    $stmt_1->bind_param("si", $hashed_password, $user_id);
                    if($stmt_1->execute()) {
                        return [
                            'data' => true,
                            'message' => 'Đổi mật khẩu thành công'
                        ];
                    } else {
                        return [
                            'data' => false,
                            'message' => 'Đổi mật khẩu không thành công'
                        ];
                    }
                } else {
                    return [
                        'data' => false,
                        'message' => 'Mật khẩu cũ không đúng'
                    ];
                }
            } else {
                return [
                    'data' => false,
                    'message' => 'Đổi mật khẩu không thành công'
                ];
            }
        }

        static function get_all_users($conn, $page_size = 10, $page = 1) {
            $format_page = ((int)$page - 1) * $page_size;
            $sql = "SELECT * FROM user LIMIT ?, ?";
            $sql_item = "SELECT COUNT(*) AS total FROM user";
            $stmt_item = $conn->query($sql_item);
            $result_item = $stmt_item->fetch_assoc();

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $format_page, $page_size);
            if($stmt->execute()) {
                $result = $stmt->get_result();
                $users = [];
                while($row = $result->fetch_assoc()) {
                    $users[] = $row;
                }
                return [
                    'data' => $users,
                    'total' => $result_item['total'],
                    'message' => 'Lấy danh sách người dùng thành công'
                ];
            } else {
                return [
                    'data' => [],
                    'message' => 'Lấy danh sách người dùng thất bại'
                ];
            }
        }

        static function delete_user($conn, $user_id) {
            try {
                $sql = "DELETE FROM user WHERE user_id =?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $user_id);
                if($stmt->execute()) {
                    return [
                        'data' => true,
                        'message' => 'Xóa người dùng thành công'
                    ];
                } else {
                    return [
                        'data' => false,
                        'message' => 'Xóa người dùng không thành công'
                    ];
                }
            } catch (mysqli_sql_exception $e) {
                return [
                    'data' => false,
                    'message' => 'Xóa người dùng không thành công'
                ];
            }
        }

        static function add_user_by_admin($conn, $user) {
            $sql = "INSERT INTO user(name, email, password, phone, address, role)
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $hashed_password = password_hash($user['password'], PASSWORD_ARGON2ID);   
            $stmt->bind_param("sssssi", $user['name'], $user['email'], $hashed_password,
                            $user['phone'], $user['address'], $user['role']);       
            if($stmt->execute()) {
                return [
                    'data' => true,
                    'message' => 'Đăng ký thành công'
                ];
            } else {
                return [
                    'data' => false,
                    'message' => 'Đăng ký thất bại'
                ];
            }
        }

        static function change_password_forgot($conn, $email, $password) {
            $hashed_password = password_hash($password, PASSWORD_ARGON2ID);
            $sql = "UPDATE user SET password = ? WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $hashed_password, $email);
            if($stmt->execute()) {
                unset($_SESSION['token']);
                return [
                    'data' => true,
                    'message' => 'Đổi mật khẩu thành công'
                ];
            } else {
                return [
                    'data' => false,
                    'message' => 'Đổi mật khẩu không thành công'
                ];
            }
        }
    }
?>