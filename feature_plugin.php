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
        echo "<strong>Date:  </strong>";
        echo the_date('','','',TRUE);
    }
    
    function display_author(){
        global $post;
        echo "<strong>Author:  </strong>";
        $author_id= $post->post_author;
        echo get_the_author_meta('first_name',$author_id);
        echo " ";
        echo get_the_author_meta('last_name',$author_id);
    }
    
    function display_category(){
        echo "<strong>Category:</strong>";
        echo "<br>";
        echo get_the_category_list();
    }
    
    function display_comment_number() {
        global $count;
        $count = comments_number();
        echo "$count";
    }
    
    function display_excerpt(){
        echo "<strong>Excerpt:</strong>";
        echo "<br>";
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
    
    function show_category(){
        $args = array(
            'show_option_all'    => '',
            'show_option_none'   => '',
            'orderby'            => 'ID', 
            'order'              => 'ASC',
            'show_count'         => 0,
            'hide_empty'         => 1, 
            'child_of'           => 0,
            'exclude'            => '',
            'echo'               => 1,
            'selected'           => 0,
            'hierarchical'       => 0, 
            'name'               => 'cat',
            'id'                 => '',
            'class'              => 'postform',
            'depth'              => 0,
            'tab_index'          => 0,
            'taxonomy'           => 'category',
            'hide_if_empty'      => false,
    );
        
        wp_dropdown_categories( $args );
    }
    
    
    
    include 'feature_posts.php';
?>

    

    
    
    
    
    
    
    
    
    
    

    