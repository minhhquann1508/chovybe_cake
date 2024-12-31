<?php 
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'chovybe';

    $conn = new mysqli($servername, $username, $password, $database);

    if($conn->connect_error) {
        die("Kết nối database không thành công". $conn->connect_error);
    }

    $conn->set_charset("utf8");
?>