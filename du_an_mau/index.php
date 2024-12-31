<?php 
    session_start();
    ob_start();
    
    include_once 'controllers/SiteController.php';
    $controller = new SiteController();

    if(isset($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page = '';
    }

    if($page === '') {
        $controller->index();
    } else {
        $controller->$page();
    }

?>