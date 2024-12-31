<?php 
    $list = [
        ['title' => 'Best seller', 'src' => 'https://www.magnoliabakery.com/cdn/shop/files/Classic_Banana_Pudding_1_500x600_crop_center.jpg?v=1669741856', 'href' => ''],
        ['title' => 'Bánh sinh nhật', 'src' => 'https://www.magnoliabakery.com/cdn/shop/collections/Birthday__10_500x600_crop_center.jpg?v=1632803139', 'href' => ''],
        ['title' => 'Sản phẩm xem nhiều', 'src' => 'https://www.magnoliabakery.com/cdn/shop/collections/Mini_Van_Van_6PK_500x600_crop_center.jpg?v=1632994630', 'href' => ''],
        ['title' => 'Bánh giá rẻ', 'src' => 'https://www.magnoliabakery.com/cdn/shop/collections/Grop_Shot_25335_1_500x600_crop_center.jpg?v=1632994722', 'href' => ''],
    ];
?>

<section class="py-5" style="background-color: #bae8d4;">
    <div class="container">
        <div class="text-center mb-5">
            <h1 class="fw-bold mb-4">Có thể bạn quan tâm</h1>
            <p class="m-auto w-100 lg-w-75 fw-medium mb-4" style="line-height: 1.6; font-size: 17.5px;">Lorem ipsum
                dolor
                sit amet, consectetur adipisicing
                elit. Nulla,
                aliquid
                aliquam
                accusamus voluptates
                eveniet
                architecto culpa laboriosam atque illo! Nam rem sunt sapiente fugiat suscipit eos adipisci amet nulla
                deserunt?
            </p>
            <a href="" class="fs-5 text-uppercase fw-bold text-decoration-underline">Xem thêm</a>
        </div>
        <div class="row">
            <?php 
                foreach ($list as $key => $item) {
                    echo '<div class="col-6 col-lg-3">
                        <div class="mb-3">
                            <div class="shadow item-hover" style="border-radius: 10px; overflow: hidden;"><img class="w-100 h-100"
                                    style="object-fit: center;"
                                    src="'.$item['src'].'"
                                    alt=""></div>
                            <h4 class="fw-bold mt-3">'.$item['title'].'</h4>
                        </div>
                    </div>';
                }
            ?>
        </div>
    </div>
</section>