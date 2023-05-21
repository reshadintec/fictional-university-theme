<?php 


//adding fonts, styles and js files
function university_files(){
   wp_enqueue_script('main-university-js', get_theme_file_uri('/build/index.js'), array('jquery'), '1.0', true);

   wp_enqueue_style('custom-google-fonts','//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
   
   wp_enqueue_style('font-awsome','//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
   wp_enqueue_style('university_main_styles', get_theme_file_uri('/build/style-index.css'));
   
   wp_enqueue_style('university_extra_styles', get_theme_file_uri('/build/index.css'));
   
}

add_action('wp_enqueue_scripts', 'university_files');
//End of adding styles and etc 
////////////////////////////////


//adding menu locations and admin bar
function university_features() {
   register_nav_menu( 'heade rMenuLocation', 'Header Menu Location');
   register_nav_menu( 'footerLocationOne', 'Footer Location One');
   register_nav_menu( 'footerLocationTwo', 'Footer Location Two');
   add_theme_support('title-tag');
   add_theme_support('post-thumbnails');
   add_image_size('professorLandscape',400, 260, true);
   add_image_size('professorPortrait', 480, 650, true);
   add_image_size( 'pageBanner',1500, 350, true);
}

add_action('after_setup_theme', 'university_features');
// End of Menu locations
/////////////////////////////////////////


//custom query for setting up events page 

function university_adjust_queries($query){ 
   if(!is_admin() && is_post_type_archive('program') && is_main_query()){
      $query -> set('orderby' , 'title');
      $query -> set('order' , 'ASC');
      $query -> set('posts_per_page' ,-1);
   }

   if(!is_admin() && is_post_type_archive('event') && $query->is_main_query()){
      $today = date('Ymd');
      $query -> set('meta_key', 'event_date');
      $query -> set('orderby', 'meta_value_num');
      $query -> set('order', 'ASC');
      $query -> set('meta_query', array(
         array(
           'key' => 'event_date',
           'compare' => '>=', 
           'value' => $today,
           'type' => 'numeric'
         ),
       ));

   }
}
add_action('pre_get_posts','university_adjust_queries');

//End of custom query for events page
///////////////////////////////////////