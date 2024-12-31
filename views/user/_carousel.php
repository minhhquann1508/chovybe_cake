<div class="swiper d-none d-xl-block" id="main-carousel">
    <div class="swiper-wrapper" style="height: 1000px;">
        <div class="swiper-slide position-relative">
            <div class="position-absolute border p-5 rounded"
                style="background-color: rgba(254,228,162,0.5);border: none !important; color: #451f13; width: 600px; top: 25%; left: 10%">
                <h1 class="text-center fw-bold mb-4" style="font-size: 52px">Giáng sinh sắp đến rồi!</h1>
                <p class="text-center fs-4 mb-4">Hãy đặt những chiếc bánh xinh đẹp và thơm ngon nhất dành cho những
                    người thân của bạn nhé !</p>
                <div class="text-center">
                    <button class="btn fw-bold fs-5 rounded-pill px-5 py-3 align-items-center"
                        style="background-color: #451f13;color: white">Đặt hàng ngay</button>
                </div>
                <div class="d-flex justify-content-center">
                    <div class="position-relative mt-5" style="width: 110px;">
                        <div class="swiper-button-prev fw-bold"><i class="fa-solid fa-angle-left"></i></div>
                        <div class="swiper-button-next ms-3 fw-bold"><i class="fa-solid fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <img class="w-100 h-100" src="./img/carousel-1.png" alt="1">
        </div>
        <div class="swiper-slide position-relative">
            <div class="position-absolute border p-5 rounded"
                style="background-color: rgba(198,234,219,0.7);color: #00211a;border: none !important; width: 600px; top: 25%; left: 10%">
                <h1 class="text-center fw-bold mb-4" style="font-size: 52px">Sản phẩm mới được ra mắt!</h1>
                <p class="text-center fs-4 mb-4">Bánh quy với các vụn chocolate nóng hổi. Sản phẩm mới được ra mắt đầy
                    thơm ngon và hấp dẫn!</p>
                <div class="text-center">
                    <button class="btn fw-bold fs-5 rounded-pill px-5 py-3 align-items-center"
                        style="background-color: #00211a;color: white">Thử ngay</button>
                </div>
                <div class="d-flex justify-content-center">
                    <div class="position-relative mt-5" style="width: 110px;">
                        <div class="swiper-button-prev fw-bold"><i class="fa-solid fa-angle-left"></i></div>
                        <div class="swiper-button-next ms-3 fw-bold"><i class="fa-solid fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <img class="w-100 h-100" src="./img/carousel-3.jpg" alt="2">
        </div>
    </div>
</div>


<script type="module">
import Swiper from 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.mjs'
const settings = {
    loop: true,

    speed: 700,

    pagination: {
        el: ".swiper-pagination",
        type: "bullets"
    },

    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev"
    }
};

const swiper = new Swiper('#main-carousel', settings);
</script>