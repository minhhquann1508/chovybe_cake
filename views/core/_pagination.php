<?php 
    function render_pagination($page, $total, $page_size, $url) {
        $nums_page = ceil($total / $page_size);
        $content = '<div id="pagination" class="text-center">
        <ul class="d-flex justify-content-center align-items-center gap-3">';
        for($i = 1; $i <= $nums_page; $i++) {
            if($page == $i) {
                $content .= '<li class="pagination-item pagination-active"><a href="'.$url.'&page_index='.$i.'">'.$i.'</a></li>';
            } else {
                $content .= '<li class="pagination-item"><a href="'.$url.'&page_index='.$i.'">'.$i.'</a></li>';
            }
        }
        $content .= '</ul>
            </div>';
        echo $content;
    }
?>