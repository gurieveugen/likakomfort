<?php
//  d888b  db    db d8888b. d888888b d88888b db    db  .o88b. d8888b. d88888b  .d8b.  d888888b d888888b db    db d88888b     .o88b.  .d88b.  .88b  d88. 
// 88' Y8b 88    88 88  `8D   `88'   88'     88    88 d8P  Y8 88  `8D 88'     d8' `8b `~~88~~'   `88'   88    88 88'        d8P  Y8 .8P  Y8. 88'YbdP`88 
// 88      88    88 88oobY'    88    88ooooo Y8    8P 8P      88oobY' 88ooooo 88ooo88    88       88    Y8    8P 88ooooo    8P      88    88 88  88  88 
// 88  ooo 88    88 88`8b      88    88~~~~~ `8b  d8' 8b      88`8b   88~~~~~ 88~~~88    88       88    `8b  d8' 88~~~~~    8b      88    88 88  88  88 
// 88. ~8~ 88b  d88 88 `88.   .88.   88.      `8bd8'  Y8b  d8 88 `88. 88.     88   88    88      .88.    `8bd8'  88.     db Y8b  d8 `8b  d8' 88  88  88 
//  Y888P  ~Y8888P' 88   YD Y888888P Y88888P    YP     `Y88P' 88   YD Y88888P YP   YP    YP    Y888888P    YP    Y88888P VP  `Y88P'  `Y88P'  YP  YP  YP 

add_theme_support( 'post-thumbnails' );
add_action( 'init', 'create_post_type' );
add_action('do_meta_boxes', 'meta_boxes');
add_action('save_post', 'url_update', 0);

/**
 * Add meta boxes
 */
function meta_boxes() {
	add_meta_box('url', 'URL', 'url_box_func', 'carousel_item', 'normal', 'high');
}

/**
 * Create new post type
 */
function create_post_type() 
{
	register_post_type('carousel_item', array(
		'labels' => array(
			'name'          => __( 'Слайдер' ),
			'singular_name' => __( 'carousel_item' )
			),
		'public'      => true,
		'has_archive' => true,
		'supports'    => array( 'title', 'thumbnail'),
		'rewrite'     => array( 'slug' => 'carousel_item' )
		)
	);
}

/**
 * Show URL meta Box
 */
function url_box_func($post)
{
?>
	<p>
		<label for="url" style="width: 10%; display: inline-block;">URL:</label>		
		<input style="width: 40%" type="text" name="url" value="<?php echo get_post_meta($post->ID, 'url', 1)?>">
	</p>	

	<input type="hidden" name="url_nonce" value="<?php echo wp_create_nonce(__FILE__); ?>" />
<?php
}

/**
 * Update URL Meta box
 */
function url_update($post_id)
{
	if ( !wp_verify_nonce($_POST['url_nonce'], __FILE__) ) return false; 
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE  ) return false; 
	if ( !current_user_can('edit_post', $post_id) ) return false; 

	if( !isset($_POST['url']) ) return false;	
	
	$value = trim($_POST['url']);
	if( empty($value) )
	{
		delete_post_meta($post_id, 'url');
	}
	update_post_meta($post_id, 'url', $value);

	return $post_id;
}

/**
 * Get carousel HTML
 */
function get_carousel($id = "myCarousel", $class = "carousel slide")
{
	$args = array(		
		'post_type'     => 'carousel_item',
		'post_status'   => 'publish',
		'orderby'       => 'post_date',  
		'order'         => 'DESC'	
   	);

	$posts               = get_posts($args);
	$x                   = 0;
	$carousel            = "";
	$carousel_items      = "";
	$carousel_indicators = "";

	if($posts)
	{
		
		$carousel_indicators .= '<ol class="carousel-indicators">';
		$carousel_items      .= '<div class="carousel-inner">';
		foreach ($posts as $key => $value) 
		{
			// ========================================================
			// If this is the first item to note its active
			// ========================================================
			if($x == 0) 
			{ 
				$carousel_indicators.= '<li data-target="#'.$id.'" data-slide-to="'.$x.'" class="active"></li>'; 

				$carousel_items.= '<div class="item active">';	
				$carousel_items.= '<a href="'.get_post_meta($value->ID, 'url', TRUE).'">';		 
				$carousel_items.= get_the_post_thumbnail($value->ID);
				$carousel_items.= '</a>';
				$carousel_items.= "</div>";
			}
			else 
			{ 
				$carousel_indicators.= '<li data-target="#'.$id.'" data-slide-to="'.$x.'"></li>'; 

				$carousel_items.= '<div class="item">';	
				$carousel_items.= '<a href="'.get_post_meta($value->ID, 'url', TRUE).'">';		 
				$carousel_items.= get_the_post_thumbnail($value->ID);
				$carousel_items.= '</a>';
				$carousel_items.= "</div>";
			}

			$x++;
		}
		$carousel_indicators .= '</ol>';
		$carousel_items      .= '</div>';

		$carousel.= '<div id="'.$id.'" class="'.$class.'">';
		$carousel.= $carousel_indicators.$carousel_items;
		$carousel.= "</div>";
	}
	return $carousel;
	
}

