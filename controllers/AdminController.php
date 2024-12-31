<?php
    class AdminController {
        public function dashboard() {
            $main_view = 'views/admin/dashboard.php';
            include_once 'views/admin/layout.php';
        }
        public function products() {
            $main_view = 'views/admin/products.php';
            include_once 'views/admin/layout.php';
        }
        public function categories() {
            $main_view = 'views/admin/categories.php';
            include_once 'views/admin/layout.php';
        }
        public function orders() {
            $main_view = 'views/admin/orders.php';
            include_once 'views/admin/layout.php';
        }

        public function detail_order() {
            $main_view = 'views/admin/detail_order.php';
            include_once 'views/admin/layout.php';
        }

        public function delete_order() {
            $main_view = 'views/admin/delete_order.php';
            include_once 'views/admin/layout.php';
        }

        public function brands() {
            $main_view = 'views/admin/brands.php';
            include_once 'views/admin/layout.php';
        }
        public function users() {
            $main_view = 'views/admin/users.php';
            include_once 'views/admin/layout.php';
        }
        public function add_user() {
            $main_view = 'views/admin/add_user.php';
            include_once 'views/admin/layout.php';
        }

        public function delete_user() {
            $main_view = 'views/admin/delete_user.php';
            include_once 'views/admin/layout.php';
        }
        public function add_product() {
            $main_view = 'views/admin/add_product.php';
            include_once 'views/admin/layout.php';
        }
        public function update_product() {
            $main_view = 'views/admin/update_product.php';
            include_once 'views/admin/layout.php';
        }

        public function delete_product() {
            $main_view = 'views/admin/delete_product.php';
            include_once 'views/admin/layout.php';
        }

        public function add_category() {
            $main_view = 'views/admin/add_category.php';
            include_once 'views/admin/layout.php';
        }

        public function update_category() {
            $main_view = 'views/admin/update_category.php';
            include_once 'views/admin/layout.php';
        }

        public function delete_category() {
            $main_view = 'views/admin/delete_category.php';
            include_once 'views/admin/layout.php';
        }

        public function comments() {
            $main_view = 'views/admin/comments.php';
            include_once 'views/admin/layout.php';
        }
        
    }
?>