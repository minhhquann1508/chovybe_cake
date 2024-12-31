<?php 
    function render_option($title, $url) {
        $content = '
            <div class="row px-2 py-3 align-items-center">
                <div class="col">
                    <h5>'.$title.'</h5>
                </div>
                <div class="col text-end">
                    <button type="button" class="btn btn-primary">
                        <a href="'.$url.'" class="text-decoration-none text-white">Thêm mới</a>
                    </button>
                    <button class="btn btn-secondary ms-2"><i class="fa-solid fa-border-all"></i></button>
                </div>
            </div>
        ';
        echo $content;
    }
?>