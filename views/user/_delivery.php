<?php 
    $list = [
        ['title' => 'Giao hàng nhanh chóng','img' => 'https://www.magnoliabakery.com/cdn/shop/files/website01_1_900x.png?v=1651012445'],
        ['title' => 'Sẵn sàng 24/7', 'img' => 'https://www.magnoliabakery.com/cdn/shop/files/website02_2_900x.png?v=1651012468'],
        ['title' => 'Chăm sóc tận tình', 'img' => 'https://www.magnoliabakery.com/cdn/shop/files/website03_900x.png?v=1651004898']
    ];
?>

<section class="py-5">
    <div class="container">
        <div class="text-center">
            <h1 class="fw-bold mb-4">Đóng gói và giao hàng</h1>
            <p class="m-auto fw-medium mb-4 w-100 lg-w-75" style="line-height: 1.6; font-size: 17.5px;">Lorem ipsum
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
        <div class="mt-5">
            <div class="row justify-content-center">
                <?php 
                    foreach($list as $item) {
                        echo '
                            <div class="col-12 col-sm-6 col-lg-4 p-1">
                                <div>
                                    <div class="shadow" style="border-radius: 10px; overflow: hidden;"><img class="w-100 h-100" style="object-fit: center;" src="'.$item['img'].'" alt=""></div>
                                    <h4 class="fw-bold mt-3 text-center">'.$item['title'].'</h4>
                                </div>
                            </div>
                        ';
                    }
                ?>
            </div>
        </div>
    </div>
</section>