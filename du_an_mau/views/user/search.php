<?php 
    include_once './models/database.php';
    include_once './models/Product.php';
    include_once './utils/constant.php';
    include_once '_product_item.php';
    include_once '_breadcrumb.php';
    include_once './views/core/_pagination.php';

    $bread_crumb = [
        ['title' => 'Trang chủ', 'url' => 'index.php'],
        ['title' => 'Sản phẩm', 'url' => 'index.php?page=product'],
    ];

    if(isset($_GET['keyword'])) {
        $keyword = $_GET['keyword'];
    } else {
        $keyword = '';
    };

    $page = isset($_GET['page_index']) ? $_GET['page_index'] : 1;
    $url = 'index.php?page=search&keyword='.$keyword.'';

    $search_data = Product::get_products_by_keyword($conn, $keyword,$PAGE_SIZE,$page);
?>

<section style="background-color: #bae8d4;">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 pt-4">
                <?php 
                    render_breadcrumbs($bread_crumb);
                ?>
                <h1 class="lg-mb-5">Tìm kiếm theo từ khóa "<?php echo $keyword ?>"</h1>
                <h5 class="ps-1">Tổng cộng <?php echo count($search_data['data']) ?> kết quả phù hợp</h5>
            </div>
            <div class="col-lg-6">
                <img class="w-100" src="https://www.magnoliabakery.com/cdn/shop/files/Same_Day__1.png?v=1633628407"
                    alt="">
            </div>
        </div>
    </div>
</section>

<section class="py-5"">
    <div class=" container">
    <?php 
            if(count($search_data['data']) <= 0) {
                echo '<div class="d-flex justify-content-center align-items-center" style="min-height: 200px;">
                         <h5 class="text-center">Hãy thử tìm với từ khóa khác nhé</h5>
                    </div>';
            } else {
                echo '<h1 class="text-center mb-5">Danh sách sản phẩm</h1>';
                echo '<div class="row">';
                foreach($search_data['data'] as $product) {
                    echo '<div class="col-sm-6 col-lg-4 col-xl-3">';
                    product_item($product);
                    echo '</div>';
                }
                echo '</div>';
            }
        ?>
    </div>
    <div class="mt-3">
        <?php render_pagination($page, $search_data['total'], $PAGE_SIZE, $url); ?>
    </div>
</section>

<?php include_once '_contact.php' ?>