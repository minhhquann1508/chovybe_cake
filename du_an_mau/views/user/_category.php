<?php 
    include_once './models/database.php';
    include_once './models/Category.php';

    $category_data = Category::get_all_categories($conn);
    
    $img = [
        'https://www.magnoliabakery.com/cdn/shop/collections/cupcakes_500x600_crop_center.png?v=1632992496',
        'https://www.magnoliabakery.com/cdn/shop/collections/brownies_500x600_crop_center.png?v=1632993284',
        'https://www.magnoliabakery.com/cdn/shop/collections/cakes_500x600_crop_center.png?v=1632992987',
        'https://www.magnoliabakery.com/cdn/shop/files/220415_CL_Magnolia_02_TableScape_Closeup_134_500x600_crop_center.png?v=1654610313',
        'https://www.magnoliabakery.com/cdn/shop/files/Peanut_Butter_Chocolate_Pudding_1_5c555d39-6289-4289-8dea-340786ae72be_500x600_crop_center.jpg?v=1651002552',
        'https://www.magnoliabakery.com/cdn/shop/files/Peanut_Butter_Chocolate_Pudding_1_5c555d39-6289-4289-8dea-340786ae72be_500x600_crop_center.jpg?v=1651002552'
    ]
?>

<section class="py-5">
    <div class="container">
        <div class="text-center">
            <h1 class="fw-bold mb-4">Danh mục sản phẩm</h1>
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
        <div class="swiper category-slide mt-5">
            <div class="swiper-wrapper">
                <?php 
                    for($i = 0;$i < 6; $i++) {
                        echo '
                            <div class="swiper-slide">
                                <a href="index.php?page=category&category_id='.$category_data['data'][$i]['category_id'].'">
                                    <div class="shadow item-hover" style="border-radius: 10px; overflow: hidden;"><img class="w-100 h-100" style="object-fit: center;" src="'.$img[$i].'" alt=""></div>
                                    <h4 class="fw-bold mt-3">'.$category_data['data'][$i]['category_name'].'</h4>
                                </a>
                            </div>
                        ';
                    }
                ?>
            </div>
        </div>
    </div>
</section>

<script type="module">
import Swiper from 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.mjs'
const settings = {
    slidesPerView: 4,
    speed: 700,
    breakpoints: {
        0: {
            slidesPerView: 1
        },
        567: {
            slidesPerView: 2
        },
        768: {
            slidesPerView: 3
        },
        1024: {
            slidesPerView: 4
        }
    },
    pagination: {
        el: ".swiper-pagination",
        type: "bullets"
    },
    spaceBetween: '20px',
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev"
    }
};

const swiper = new Swiper('.category-slide', settings);
</script>