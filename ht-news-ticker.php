<?php 
/*
Plugin Name: HT News Ticker
Plugin URI: http://happythemez.com/
Description: A Breaking news ticker based on JQuery ,Displays a sliding list of post titles. you can use it with a simple shortcode.
Author: Md Fahim Reza
Version: 1.1
Author URI: http://fahimrb.com/
*/


//Call WordPress Latest jQuery
function ht_wp_latest_jQuery() {
	wp_enqueue_script('jquery');
}
add_action('init', 'ht_wp_latest_jQuery');

//Call News ticker js file and css file
function  ht_news_ticker_js() {
    wp_enqueue_script( 'ht-news-ticker-js', plugins_url( '/assets/js/newsTicker.min.js', __FILE__ ), array('jquery'), 1.0, false);
    wp_enqueue_style( 'ht-news-ticker-css', plugins_url( '/assets/css/style.css', __FILE__ ));
}

add_action('init','ht_news_ticker_js');

// Shortcode function
function ht_ticker_shortcode($atts){
    extract( shortcode_atts( array(
        'id' => '1',
        'bgcolor' => '#dfdfdf',
        'linkcolor'=> '#343434',
        'title' => 'Latest News',
        'tbgcolor' => '#343434',
        'tcolor' => '#fff',
        'rowheight' => '30',
        'maxrows' => '1',
        'speed' => '800',
        'duration' => '5000',
        'numberposts' => '10',
    ), $atts, 'newsticker' ) );

$ht_query = new Wp_Query (array(
        'post_type' => 'post',
        'posts_per_page' => $numberposts,
        $category_slug => $category
    ));

$news='<div class="ht_ticker">';

$news.= '<ul id="ht_news'.$id.'" style="background-color:'.$bgcolor.'">';
$news.= '<span class="title" style="background-color:'.$tbgcolor.'; color:'.$tcolor.';" >'.$title.'</span>';

while($ht_query->have_posts()) : $ht_query->the_post();
    $tid = get_the_ID();
    $news.= '<li>
               <a href="'.get_permalink($tid->get_the_ID).'" style="color:'.$linkcolor.'">'.get_the_title().'</a>
    </li>';
endwhile;
    $news.= '</ul></div>

<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery("#ht_news'.$id.'").newsTicker({
        row_height: '.$rowheight.',
        max_rows: '.$maxrows.',
        speed: '.$speed.',
        duration: '.$duration.',
        autostart: 1,
        pauseOnHover: 0,
    });
});
</script>';

return $news;

}

add_shortcode('ht_ticker', 'ht_ticker_shortcode');
?>