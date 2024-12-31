<?php 
    include_once './models/database.php';
    include_once './models/Category.php';
    include_once './config/helper.php';

    $category_data = Category::get_all_categories($conn);
?>

<section class="position-fixed w-100" style="z-index: 99;">
    <div class="bg-black text-white text-center p-2" style="font-size: 15px;">
        ĐẶT HÀNG NGAY - MIỄN PHÍ SHIP TRONG THÁNG 11
    </div>
    <header class="text-center border-bottom bg-white">
        <div class="container">
            <div class="row align-items-center py-4">
                <div class="col-5">
                    <button class="btn d-block d-lg-none rounded-circle"
                        style="width: 35px; height: 35px; border: 2px solid black"><i
                            class="fa-solid fa-bars"></i></button>
                    <ul class="nav nav-pills d-none d-lg-flex">
                        <li class="nav-item">
                            <a class="nav-link ps-0 fw-medium" href="index.php">TRANG CHỦ</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle fw-medium" data-bs-toggle="dropdown" href="#"
                                role="button" aria-expanded="false">DANH MỤC</a>
                            <ul class="dropdown-menu">
                                <?php 
                                    foreach ($category_data['data'] as $key => $category) {
                                        echo '<li><a class="dropdown-item text-uppercase" href="index.php?page=category&category_id='.$category['category_id'].'">'.$category['category_name'].'</a></li>';
                                    }
                                ?>
                            </ul>
                        </li>
                    </ul>
                </div>

                <div class="col-2 text-center">
                    <h1 class="fw-bold">choVybe</h1>
                </div>

                <div class="col-5 d-flex justify-content-end">
                    <ul class="nav nav-pills gap-2 align-items-center">
                        <li class="nav-item dropdown d-none d-lg-block">
                            <a class="nav-link dropdown-toggle fw-medium" data-bs-toggle="dropdown" href="#"
                                role="button" aria-expanded="false">VỀ CHÚNG TÔI</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="index.php?page=about">Thông tin về choVybe</a></li>
                                <li><a class="dropdown-item" href="index.php?page=contact">Liên hệ</a></li>
                            </ul>
                        </li>
                        <li>
                            <button class="btn"></button>
                        </li>
                        <li class="nav-item rounded-circle d-none d-lg-flex justify-content-center align-items-center"
                            style="width: 35px; height: 35px; border: 2px solid black" data-bs-toggle="modal"
                            data-bs-target="#searchModal">
                            <a class="nav-link" href="#"><i class="fa-solid fa-magnifying-glass"></i></a>
                        </li>
                        <li class="nav-item rounded-circle d-flex justify-content-center align-items-center position-relative"
                            style="width: 35px; height: 35px; border: 2px solid black">
                            <!-- Tag số lượng -->
                            <?php 
                                $content = '';
                                if(isset($_SESSION['cart'])) {
                                    $totalQuantity = count_cart($_SESSION['cart']);
                                    $content = '
                                        <span id="cart-count" class="position-absolute bg-black text-white rounded-circle"
                                            style="width: 18px; height: 18px; font-size: 12px; top: -10px; left: 20px">'.$totalQuantity.'</span>
                                    ';
                                } 
                                echo $content;
                            ?>
                            <a class="nav-link" href="index.php?page=cart"><i class="fa-solid fa-cart-shopping"></i></a>
                        </li>
                        <?php 
                            if(isset($_SESSION['user'])) {
                                if($_SESSION['user']['role'] == 1) {
                                    echo '
                                        <li class="nav-item dropdown rounded-circle d-none d-lg-flex justify-content-center align-items-center">
                                            <a class="nav-link dropdown-toggle fw-medium" data-bs-toggle="dropdown" href="#"
                                                role="button" aria-expanded="false"><i class="fa-regular fa-user"></i></a>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="index.php?page=user_info">Hồ sơ</a></li>
                                                <li><a class="dropdown-item" href="admin.php">Trang quản trị</a></li>
                                                <li><a class="dropdown-item" href="index.php?page=logout">Đăng xuất</a></li>
                                            </ul>
                                        </li>
                                    ';
                                } else {
                                    echo '
                                        <li class="nav-item dropdown rounded-circle d-none d-lg-flex justify-content-center align-items-center">
                                            <a class="nav-link dropdown-toggle fw-medium" data-bs-toggle="dropdown" href="#"
                                                role="button" aria-expanded="false"><i class="fa-regular fa-user"></i></a>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="index.php?page=user_info">Hồ sơ</a></li>
                                                <li><a class="dropdown-item" href="index.php?page=logout">Đăng xuất</a></li>
                                            </ul>
                                        </li>
                                    ';
                                }
                            } else {
                                echo '
                                    <li class="nav-item rounded-circle d-none d-lg-flex justify-content-center align-items-center"
                                        style="width: 35px; height: 35px; border: 2px solid black">
                                        <a class="nav-link" href="index.php?page=login"><i class="fa-regular fa-user"></i></a>
                                    </li>
                                ';
                            }
                        ?>

                    </ul>
                </div>
            </div>
        </div>
    </header>
</section>

<div class="modal" tabindex="-1" id="searchModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Tìm kiếm theo sản phẩm</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="search-form" class="search-box py-2" style="width: 100%; border: 1px solid #ccc;">
                    <input id="" style="font-size: 16px;" type="text" class="w-100" placeholder="Nhập tên sản phẩm">
                    <i class="fa-solid fa-magnifying-glass fs-4"></i>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('search-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const inputValue = this.getElementsByTagName('input')[0].value;
    window.location.href = `index.php?page=search&keyword=${inputValue}`;
})
</script>