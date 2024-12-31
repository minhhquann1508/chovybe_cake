<?php 
    function render_breadcrumbs($array) {
        $content = '';
        foreach ($array as $key => $item) {
            if($key + 1 < count($array)) {
                $content .= '<li>
                    <a class="text-decoration-underline fw-medium" style="font-size: 18px;" href="'.$item['url'].'">'.$item['title'].' 
                        <i class=" ms-2 fa-solid fa-angle-right"></i>
                    </a>
                </li>';
            } else {
                $content .= '<li>
                    <a class="text-decoration-underline fw-medium" style="font-size: 18px;" href="'.$item['url'].'">'.$item['title'].'</a>
                </li>';
            }
        }

        echo '<div class="mb-4">
                <ul class="d-flex gap-3">';
        echo $content;
        echo '</ul>
            </div>';
    }
?>