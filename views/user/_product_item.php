<?php 
    include_once './config/helper.php';

    function product_item($product) {
        if($product['quantity'] > 0) {
            echo '
                <div onclick="navigate(\'index.php?page=product_detail&product_id='.$product['product_id'].'\')" class="product-item shadow bg-white p-2 border product-item mb-3 w-100" style="border-radius: 10px">
                    <div class="mb-4 rounded" style="width: 100%; height: 290px; overflow: hidden">
                        <img class="w-100 h-100" style="object-fit: center" src="'.$product['thumbnail'].'"
                            alt="">
                    </div>
                    <div class="px-2">
                        <h5 class="fw-bold text-uppercase">'.$product['title'].'</h5>
                        <p class="mb-2">'.$product['sub_desc'].'</p>
                        <p class="mb-2">Giá: '.format_price($product['price']).' VNĐ</p>
                    </div>
                    <div class="px-2 d-flex justify-content-between align-items-center">
                        <p class="mb-0"><span>Lượt bán:</span> <span>'.$product['sold'].'</span></p>
                        <p class="mb-0"><span>Lượt xem:</span> <span>'.$product['views'].'</span></p>
                    </div>
                </div>
            ';
        } else {
            echo '
                <div onclick="navigate(\'index.php?page=product_detail&product_id='.$product['product_id'].'\')" class="product-item shadow bg-white p-2 border product-item mb-3 w-100" style="border-radius: 10px; position: relative">
                    <span class="sold-out-tag">Hết hàng</span>
                    <div class="mb-4 rounded" style="width: 100%; height: 290px; overflow: hidden">
                        <img class="w-100 h-100" style="object-fit: center" src="'.$product['thumbnail'].'"
                            alt="">
                    </div>
                    <div class="px-2">
                        <h5 class="fw-bold text-uppercase">'.$product['title'].'</h5>
                        <p class="mb-2">'.$product['sub_desc'].'</p>
                        <p class="mb-2">Giá: '.format_price($product['price']).' VNĐ</p>
                    </div>
                    <div class="px-2 d-flex justify-content-between align-items-center">
                        <p class="mb-0"><span>Lượt bán:</span> <span>'.$product['sold'].'</span></p>
                        <p class="mb-0"><span>Lượt xem:</span> <span>'.$product['views'].'</span></p>
                    </div>
                </div>
            ';
        }
        
    }
?>