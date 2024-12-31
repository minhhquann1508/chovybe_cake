<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include_once 'helper.php';

require 'vendor/autoload.php';

function send_mail_order($user, $order_list,$total_price) {
    $content = '
        <div style="border: 1px solid #ddd; border-radius: 8px; padding: 20px; max-width: 800px; margin: 20px auto; background-color: #fff;">
            <h2 style="text-align: center; margin-bottom: 20px; font-weight: bold;">Hóa Đơn Mua Hàng</h2>
            <div style="margin-bottom: 20px;">
                <h4 style="margin-bottom: 10px;">Thông tin khách hàng</h4>
                <p style="margin: 0;">Họ và tên: <strong>'.$user['name'].'</strong></p>
                <p style="margin: 0;">Email: <strong>'.$user['email'].'</strong></p>
                <p style="margin: 0;">Số điện thoại: <strong>'.$user['phone'].'</strong></p>
                <p style="margin: 0;">Địa chỉ: <strong>'.$user['address'].'</strong></p>
                <p style="margin: 0;">Ghi chú: <strong>'.$user['note'].'</strong></p>
            </div>
        <div>
            <h4 style="margin-bottom: 15px;">Chi tiết đơn hàng</h4>
            <table style="width: 100%; border-collapse: collapse; border: 1px solid #ddd;">
                <thead style="background-color: #f9f9f9;">
                    <tr style="text-align: center; border: 1px solid #ddd;">
                        <th style="border: 1px solid #ddd; padding: 8px;">#</th>
                        <th style="border: 1px solid #ddd; padding: 8px;">Sản phẩm</th>
                        <th style="border: 1px solid #ddd; padding: 8px;">Hình ảnh</th>
                        <th style="border: 1px solid #ddd; padding: 8px;">Giá</th>
                        <th style="border: 1px solid #ddd; padding: 8px;">Số lượng</th>
                        <th style="border: 1px solid #ddd; padding: 8px;">Tổng tiền</th>
                    </tr>
                </thead>
                <tbody>
    ';
    foreach($order_list as $key => $order) {
        echo $order;
        $content .= '
            <tr style="text-align: center; border: 1px solid #ddd;">
                <td style="border: 1px solid #ddd; padding: 8px;">'.($key + 1).'</td>
                <td style="border: 1px solid #ddd; text-align: left; padding: 8px;">'.$order['title'].'</td>
                <td style="border: 1px solid #ddd; padding: 8px;">
                    <img src="'.$order['thumbnail'].'" alt="" style="width: 50px; height: auto;">
                </td>
                <td style="border: 1px solid #ddd; padding: 8px;">'.format_price($order['price']).' VNĐ</td>
                <td style="border: 1px solid #ddd; padding: 8px;">'.$order['quantity'].'</td>
                <td style="border: 1px solid #ddd; padding: 8px;">'.format_price($order['price'] * $order['quantity']).' VNĐ</td>
            </tr>';
    }

    $content .= '</tbody>
        </table>
    </div>
    <div style="text-align: right; margin-top: 20px; font-size: 18px;">
        <p style="margin: 0;">Tổng cộng: <strong>'.format_price($total_price).' VNĐ</strong></p>
    </div>
    ';

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();                                           
        $mail->Host       = 'smtp.gmail.com';                    
        $mail->SMTPAuth   = true;                                   
        $mail->Username   = 'minhhquann1508@gmail.com';                     
        $mail->Password   = 'ardr lvqj qbdf lmiu';  
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;                            
        $mail->Port       = 587;                                   

        //Thông tin người gửi
        $mail->setFrom('minhhquann1508@gmail.com', 'choVybe');
        //Thông tin người nhân
        $mail->addAddress(''.$user['email'].'', ''.$user['name'].'');     

        //Content
        $mail->CharSet = 'UTF-8';
        $mail->isHTML(true);                                  
        $mail->Subject = 'Hóa đơn điện tử';
        $mail->Body    = $content;
        $mail->AltBody = 'Nội dung đơn hàng';

        $mail->send();
        echo 'Gửi mail thành công';
    } catch (Exception $e) {
        echo $e;
    }
}

function send_mail_forgot_password($email,$token) {
    $content = '
        <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; background-color: #f9f9f9;">
            <h2 style="text-align: center; color: #333;">Đặt lại mật khẩu</h2>
            <p style="color: #555; line-height: 1.6;">Chào bạn,</p>
            <p style="color: #555; line-height: 1.6;">
                Bạn đã yêu cầu đặt lại mật khẩu. Nhấp vào nút bên dưới để đặt lại mật khẩu của bạn:
            </p>
            <div style="text-align: center; margin: 20px 0;">
                <a href="http://localhost/du_an_mau/index.php?page=auth_change_password&email='.$email.'&token='.$token.'" target="_blank" style="display: inline-block; padding: 12px 20px; color: #fff; background-color: #007BFF; text-decoration: none; border-radius: 5px;">Đặt lại mật khẩu</a>
            </div>
            <p style="color: #555; line-height: 1.6;">
                Nếu bạn không yêu cầu thao tác này, vui lòng bỏ qua email này. Mật khẩu của bạn sẽ không thay đổi.
            </p>
            <p style="color: #555; line-height: 1.6;">Trân trọng,<br />Đội ngũ hỗ trợ</p>
        </div>
    ';
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();                                           
        $mail->Host       = 'smtp.gmail.com';                    
        $mail->SMTPAuth   = true;                                   
        $mail->Username   = 'minhhquann1508@gmail.com';                     
        $mail->Password   = 'ardr lvqj qbdf lmiu';  
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;                            
        $mail->Port       = 587;                                   

        //Thông tin người gửi
        $mail->setFrom('minhhquann1508@gmail.com', 'choVybe');
        //Thông tin người nhân
        $mail->addAddress(''.$email.'');     

        //Content
        $mail->CharSet = 'UTF-8';
        $mail->isHTML(true);                                  
        $mail->Subject = 'Mật khẩu mới';
        $mail->Body    = $content;
        $mail->AltBody = 'Cung cấp mật khẩu mới';

        $mail->send();
        echo '<script>
            showToast("Gửi mail thành công. Hãy kiểm tra mail của bạn nhé");
        </script>';
        $_SESSION['token'] = $token;
    } catch (Exception $e) {
        echo $e;
    }
}