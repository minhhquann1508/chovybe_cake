<?php 
    $list = [
        [
            'key' => 'dashboard',
            'icon' => 'fa-solid fa-chart-simple',
            'label' => 'Thống kê',
            'href' => 'admin.php?page=dashboard'
        ],
        [
            'key' => 'categories',
            'icon' => 'fa-solid fa-list',
            'label' => 'Danh mục',
            'href' => 'admin.php?page=categories'
        ],
        [
            'key' => 'products',
            'icon' => 'fa-solid fa-box-archive',
            'label' => 'Sản phẩm',
            'href' => 'admin.php?page=products'
        ],
        [
            'key' => 'users',
            'icon' => 'fa-solid fa-users',
            'label' => 'Người dùng',
            'href' => 'admin.php?page=users'
        ],
        [
            'key' => 'comments',
            'icon' => 'fa-regular fa-comment-dots',
            'label' => 'Bình luận',
            'href' => 'admin.php?page=comments'
        ],
        [
            'key' => 'orders',
            'icon' => 'fa-regular fa-clipboard',
            'label' => 'Đơn hàng',
            'href' => 'admin.php?page=orders'
        ],
    ];

    function render_list($list) {
        $page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
        $content = '';
        foreach ($list as $item) {
            echo '
                <li class="d-flex align-items-center '.($page == $item['key'] ? 'active' : '').'">
                    <i class="'.$item['icon'].'"></i> <a class="ps-3 text-decoration-none" href="'.$item['href'].'">'.$item['label'].'</a>
                </li>
            ';
        }

        echo $content;
    } 
?>

<article style="height: 100vh;">
    <div class="text-center">
        <a href="index.php">
            <img width="70" height="70" src="./img/logo.png" alt="">
        </a>
    </div>
    <ul class="sidebar-list">
        <?php 
            render_list($list);
        ?>
    </ul>
</article>