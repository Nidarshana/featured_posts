<?php

class Featured_Posts extends WP_Widget {
	// Controller
	function __construct() {
	$widget_ops = array('classname' => 'post_plugin', 'description' => __('Widget to display post details', 'wp_widget_plugin'));
	$control_ops = array('width' => 300, 'height' => 300);
	parent::WP_Widget(false, $name = __('Featured_Posts', 'wp_widget_plugin'), $widget_ops, $control_ops );

}

public function form($instance) { 
	$defaults = array(
            'title' => __('Popular Posts'), 
            'post_count' => __(5) ,
            'check_image'=>__(0),
            'check_date'=> __(0),
            'check_author'=>  __(0),
            'check_category'=> __(0),
            'check_comments'=> __(0),
            'check_views'=> __(0),
            'post_excerpt'=> __(0),
            );
	$instance = wp_parse_args( (array) $instance, $defaults );
	if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
            $post_count=$instance['post_count'];
	}
	else {
            $title =$defaults['title'];
            $post_count=$defaults['post_count'];
	}?>
	<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'wp_post_plugin'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
	</p>
        
	<p>
		<label for="<?php echo $this->get_field_id('post_count'); ?>"><?php _e('Top Posts:', 'wp_post_plugin'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('post_count'); ?>" name="<?php echo $this->get_field_name('post_count'); ?>" type="number" value="<?php echo $post_count;?>" />
	</p>
        
        <p> 
                <input class="img_check" type="checkbox" <?php checked($instance['check_image'], 'on'); ?> id="<?php echo $this->get_field_id('check_image'); ?>" name="<?php echo $this->get_field_name('check_image'); ?>" /> 
                <label for="<?php echo $this->get_field_id('check_image'); ?>">Check to display post thumbnail</label>
        </p>
     
        <p>
                <input class="checkbox" type="checkbox" <?php checked($instance['check_date'], 'on'); ?> id="<?php echo $this->get_field_id('check_date'); ?>" name="<?php echo $this->get_field_name('check_date'); ?>" /> 
                <label for="<?php echo $this->get_field_id('check_date'); ?>">Check to display Post Date</label>
        </p>
        <p>
                <input class="checkbox" type="checkbox" <?php checked($instance['check_author'], 'on'); ?> id="<?php echo $this->get_field_id('check_author'); ?>" name="<?php echo $this->get_field_name('check_author'); ?>" /> 
                <label for="<?php echo $this->get_field_id('check_author'); ?>">Check to display Post Author</label>
        </p>
        <p>
                <input class="checkbox" type="checkbox" <?php checked($instance['check_category'], 'on'); ?> id="<?php echo $this->get_field_id('check_category'); ?>" name="<?php echo $this->get_field_name('check_category'); ?>" /> 
                <label for="<?php echo $this->get_field_id('check_category'); ?>">Check to display Post Category</label>
        </p>
        <p>
                <input class="checkbox" type="checkbox" <?php checked($instance['check_comments'], 'on'); ?> id="<?php echo $this->get_field_id('check_comments'); ?>" name="<?php echo $this->get_field_name('check_comments'); ?>" /> 
                <label for="<?php echo $this->get_field_id('check_comments'); ?>">Check to display Number of Comments</label>
        </p>
         
        <p>
                <input class="checkbox" type="checkbox" <?php checked($instance['post_excerpt'], 'on'); ?> id="<?php echo $this->get_field_id('post_excerpt'); ?>" name="<?php echo $this->get_field_name('post_excerpt'); ?>" /> 
                <label for="<?php echo $this->get_field_id('post_excerpt'); ?>">Check to display Post Excerpt with Read More link</label>
        </p>
        
       <p>
                <input class="checkbox" type="checkbox" <?php checked($instance['check_views'], 'on'); ?> id="<?php echo $this->get_field_id('post_excerpt'); ?>" name="<?php echo $this->get_field_name('check_views'); ?>" /> 
                <label for="<?php echo $this->get_field_id('check_views'); ?>">Check to display number of views</label>
        </p>
        
        
            
<?php }
public function update($new_instance,$old_instance){
    $instance = $old_instance;
    $instance['title'] = strip_tags( $new_instance['title'] );  
    $instance['post_count'] = strip_tags( $new_instance['post_count'] );
    $instance['check_image'] =strip_tags($new_instance['check_image']);
    $instance['check_date'] =strip_tags($new_instance['check_date']);
    $instance['check_author'] =strip_tags($new_instance['check_author']);
    $instance['check_category'] =strip_tags($new_instance['check_category']);
    $instance['check_comments'] =strip_tags($new_instance['check_comments']);
    $instance['post_excerpt'] =strip_tags($new_instance['post_excerpt']);
    $instance['check_views'] =strip_tags($new_instance['check_views']);
    
    return $instance;
}       

public function widget($args, $instance) {
            
	    $post_count = $instance['post_count'];
            $title = apply_filters('widget_title', $instance['title']);
		// Display the widget title
            echo '<div class="recent-posts">';
            if ( $title )                
                    echo "<h3>$title</h3>";
	//Display the name
                    $args = new WP_Query(
                        array(
                            "posts_per_page" => $post_count,
                            "post_type" => "post",
                            "post_status" => "publish",
                            "order" => "DESC"
                        )
                    );
                    global $post;
                    echo'<div class="feat-posts">'; 
                    if($args->have_posts()) { echo "<ul>"; }
                    while ( $args->have_posts() ) : $args->the_post();
                    echo'<li class="widget-list">';
                    echo'<div class="post-data">';
                    echo'<div class="post-img">';
                    if($instance['check_image']){                          
                       display_image();
                    }   
                    echo'</div>';
                    echo'<div class="post-details">';
                    echo'<div class="post-title">';
                    echo '<a href="'.get_permalink($post->ID).'">'.the_title('', '', false).'</a>';
                    echo'<p>';
                    echo'</div>';
                    if($instance['check_date']){
                        display_date();
                    }
                    echo'</p>';
                    echo'<p>';
                    if($instance['check_author']){
                        display_author();
                    }
                    echo'</p>';
                    
                    if($instance['check_category']){
                        display_category();
                    }
                    
                    echo'</div>';
                    echo'</div>';
                    echo'<div class="post_stats">';
                    echo'<p>';
                    if($instance['check_comments']){
                        display_comment_number();
                    }
                    echo'</p>';
                    echo'<p>';
                    if(isset($instance['check_views'])){
                        display_views_number();
                    }
                    echo'</p>';
                    echo'</div>';
                    echo'<div class="post_excerpt">';
                    echo'<p>';
                    if($instance['post_excerpt']){
                        display_excerpt();
                    }
                    echo'</p>';
                    echo'</div>';
                    
         
            echo'</li>';
            endwhile;
            if($args->have_posts()) { echo "</ul>"; }
            echo'</div>';
            echo'</div>';

    }
}

add_action('widgets_init', create_function('', 'return register_widget("Featured_Posts");'));
?>

