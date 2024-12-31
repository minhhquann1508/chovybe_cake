<?php 
    session_start();
    ob_start();

    include_once 'controllers/AdminController.php';
    $controller = new AdminController();

    if(isset($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page = '';
    }

    if($page === '') {
        $controller->dashboard();
    } else {
        $controller->$page();
    }

?>