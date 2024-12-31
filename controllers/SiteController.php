<?php
    class SiteController {
        public function index() {
            $main_view = 'views/user/home.php';
            include_once 'views/user/layout.php';
        }
        public function login() {
            $main_view = 'views/auth/login.php';
            include_once 'views/auth/layout.php';
        }

        public function forgot_password() {
            $main_view = 'views/auth/forgot_password.php';
            include_once 'views/auth/layout.php';
        }

        public function auth_change_password() {
            $main_view = 'views/auth/auth_change_password.php';
            include_once 'views/auth/layout.php';
        }

        public function register() {
            $main_view = 'views/auth/register.php';
            include_once 'views/auth/layout.php';
        }
        public function logout() {
            $main_view = 'views/auth/logout.php';
            include_once 'views/auth/layout.php';
        }
        public function product_detail() {
            $main_view = 'views/user/product_detail.php';
            include_once 'views/user/layout.php';
        }
        public function product() {
            $main_view = 'views/user/product.php';
            include_once 'views/user/layout.php';
        }
        public function category() {
            $main_view = 'views/user/category.php';
            include_once 'views/user/layout.php';
        }
        public function cart() {
            $main_view = 'views/user/cart.php';
            include_once 'views/user/layout.php';
        }
        public function search() {
            $main_view = 'views/user/search.php';
            include_once 'views/user/layout.php';
        }
        public function order() {
            $main_view = 'views/user/order.php';
            include_once 'views/user/layout.php';
        }

        public function checkout() {
            $main_view = 'views/user/checkout.php';
            include_once 'views/user/layout.php';
        }

        public function thank_you() {
            $main_view = 'views/user/thank_you.php';
            include_once 'views/user/layout.php';
        }

        public function user_info() {
            $main_view = 'views/user/user_info.php';
            include_once 'views/user/layout.php';
        }

        public function change_password() {
            $main_view = 'views/user/change_password.php';
            include_once 'views/user/layout.php';
        }
        
        public function about() {
            $main_view = 'views/user/about.php';
            include_once 'views/user/layout.php';
        }
        public function contact() {
            $main_view = 'views/user/contact.php';
            include_once 'views/user/layout.php';
        }
    }
?>