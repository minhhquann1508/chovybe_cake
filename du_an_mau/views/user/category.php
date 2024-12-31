<?php 
    include_once './utils/constant.php';
    include_once './models/database.php';
    include_once './models/Product.php';
    include_once './models/Category.php';
    include_once '_product_item.php';
    include_once './utils/constant.php';
    include_once './views/core/_pagination.php';
    include_once '_breadcrumb.php';
    
    if(isset($_GET['category_id'])) {
        $page = isset($_GET['page_index']) ? $_GET['page_index'] : 1;
        $category_id = $_GET['category_id'];
        $url = 'index.php?page=category&category_id='.$category_id.'';
        
        $sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : '-price';
        $category_data = Category::get_category_by_id($conn, $category_id, true);
        $product_data = Product::get_product_by_category($conn, $category_id, $PAGE_SIZE, $page, $sort_by);
    
        $bread_crumb = [
            ['title' => 'Trang chủ', 'url' => 'index.php'],
            ['title' => ''.$category_data['data']['category_name'].'', 'url' => 'index.php?page=category&category_id='.$category_id],
        ];
    } else {
        header('Location: index.php?page=category&category_id=2');
    }
?>

<section class="py-5 pt-4" style="background-color: #bae8d4;">
    <div class="container">
        <?php render_breadcrumbs($bread_crumb) ?>
        <div class="text-center category-head mx-auto">
            <h1 class="font-bold"><?php echo $category_data['data']['category_name'] ?></h1>
            <p class="fs-5"><?php echo $category_data['data']['description'] ?></p>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row mb-5 align-items-center">
            <div class="col-6">
                <h4 class="fw-bold">Danh sách sản phẩm</h4>
            </div>
            <div class="col-6 d-flex justify-content-end">
                <?php
                    $sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : '';
                ?>
                <select id="sort-select" onchange="handleChangeSort(this)" class="form-select" style="width: 200px;">
                    <option value="-price" <?php echo $sort_by == '-price' ? 'selected' : ''; ?>>Từ giá thấp đến cao
                    </option>
                    <option value="price" <?php echo $sort_by == 'price' ? 'selected' : ''; ?>>Giá từ cao xuống thấp
                    </option>
                    <option value="top_views" <?php echo $sort_by == 'top_views' ? 'selected' : ''; ?>>Lượt xem cao nhất
                    </option>
                    <option value="top_sold" <?php echo $sort_by == 'top_sold' ? 'selected' : ''; ?>>Lượt bán cao nhất
                    </option>
                </select>
            </div>
        </div>
        <div class="row">
            <?php 
                if($product_data['data']) {
                    foreach ($product_data['data'] as $key => $product) {
                        echo '<div class="col-sm-6 col-lg-4 col-xl-3">';
                        product_item($product);
                        echo '</div>';
                    }
                } else {
                    echo '<div>Chưa có sản phẩm</div>';
                }
            ?>
        </div>
    </div>
</section>

<section class="mb-5">
    <?php  render_pagination($page, $product_data['total'], $PAGE_SIZE, $url); ?>
</section>

<?php include_once '_interesting.php' ?>


<?php include_once '_contact.php' ?>

<script>
function handleChangeSort(e) {
    const sortValue = e.value;

    if (sortValue !== "") {
        const params = new URLSearchParams(window.location.search);
        params.set('sort_by', sortValue);

        const newUrl = `${window.location.pathname}?${params.toString()}`;
        window.location.href = newUrl;
    }
}
</script>