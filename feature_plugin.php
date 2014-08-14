<?php
   /*
   Plugin Name: Featured Posts
   Plugin URI: http://my-awesomeness-emporium.com
   Description: a plugin to create awesomeness and spread joy
   Version: 1.2
   Author: Mr. Awesome
   Author URI: http://mrtotallyawesome.com
   License: GPL2
   */
?>
<?php
function add_my_stylesheets(){
        wp_register_style('plugin-style',plugins_url('style.css',__FILE__));
        wp_enqueue_style('plugin-style');
        
        $fonts_url='http://fonts.googleapis.com/css?family=Oxygen:400,300,700';
	if ( !empty($fonts_url)){
		wp_enqueue_style('font-name',esc_url_raw($fonts_url),array(),null);
	}
    }
    
    add_action('wp_enqueue_scripts','add_my_stylesheets');
    
    function mp_add_view() {
        if(is_single()) {
        global $post;
        $current_views = get_post_meta($post->ID, "mp_views", true);
        if(!isset($current_views) OR empty($current_views) OR !is_numeric($current_views) ) {
            $current_views = 0;
        }
        $new_views = $current_views + 1;
        update_post_meta($post->ID, "mp_views", $new_views);
        return $new_views;
        }
    }
    
    function mp_get_view_count() {
        global $post;
        $current_views = get_post_meta($post->ID, "mp_views", true);
        if(!isset($current_views) OR empty($current_views) OR !is_numeric($current_views) ) {
            $current_views = 0;
        }
        return $current_views;
    } 
    function mp_show_views($singular = "", $plural = "", $before = "No. of views: ") {
        global $post;
        $current_views = mp_get_view_count();
        $views_text = $before . $current_views . " ";
        if ($current_views == 1) {
            $views_text .= $singular;
        }
        else {
            $views_text .= $plural;
        }
        echo $views_text;
    }
    
    function catch_the_image() {
  		global $post, $posts;
  		$first_img = '';
  		ob_start();
  		ob_end_clean();
  		if($output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches))
  		$first_img = $matches [1] [0];

  		if(empty($first_img)){ //Defines a default image
  			//$first_img = bloginfo('template_directory');
    		$first_img = "http://images.nationalgeographic.com/wpf/media-live/photos/000/820/cache/red-umbrella-walking-night_82057_990x742.jpg";
  		}
  		return $first_img;
	}   
    
    function display_image(){
    
    global $post;
    $post_id = $post->ID;
    if ( has_post_thumbnail($post_id) ) {
            the_post_thumbnail(array(70,70));
        }
        else {
            echo '<img src="';
            echo catch_the_image();
            echo '" alt="Unable to load" width="70px" height="70px" class="featuredImage" />';
        }
    }

    function display_date(){
        echo "Date:";
        echo the_date('','','',TRUE);
    }
    
    function display_author(){
        global $post;
        echo " Author:";
        $author_id= $post->post_author;
        echo get_the_author_meta('first_name',$author_id);
        echo " ";
        echo get_the_author_meta('last_name',$author_id);
    }
    
    function display_category(){
        echo'<p>';
        echo "Category:";
        echo get_the_category_list();
        echo'</p>';
    }
    
    function display_comment_number() {
        global $count;
        $count = comments_number();
        echo "$count";
    }
    
    function display_views_number() {
        global $count;
        mp_show_views();
    }
    
    function display_excerpt(){
        echo " Excerpt:";
        
        the_excerpt();
    } 
    
    function custom_excerpt_length( $length ) {
	return 15;
    }
    
    add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

    function new_excerpt_more($more) {
        global $post;
	return '<a class="moretag" href="'. get_permalink($post->ID) . '"> Read more...</a>';
    }
   
    add_filter('excerpt_more', 'new_excerpt_more');
    
    
    
    
    
    include 'feature_posts.php';
?>

    

    
    
    
    
    
    
    
    
    
    

    