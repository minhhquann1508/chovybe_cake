<?php 
    function format_date($date) {
        return (new DateTime($date))->format("d/m/Y");
    }

    function format_json($info) {
        return htmlspecialchars(json_encode($info), ENT_QUOTES, 'UTF-8');
    }

    function format_price($price) {
        return number_format($price, 0, ',', '.');
    }

    function count_cart($cart) {
        return array_sum(array_column($_SESSION['cart'], 'quantity'));
    }

    function randomString($length = 10) {
        return substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, $length);
    }

?>