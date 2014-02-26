<?php
//  d888b  db    db d8888b. d888888b d88888b db    db  .o88b. d8888b. d88888b  .d8b.  d888888b d888888b db    db d88888b     .o88b.  .d88b.  .88b  d88. 
// 88' Y8b 88    88 88  `8D   `88'   88'     88    88 d8P  Y8 88  `8D 88'     d8' `8b `~~88~~'   `88'   88    88 88'        d8P  Y8 .8P  Y8. 88'YbdP`88 
// 88      88    88 88oobY'    88    88ooooo Y8    8P 8P      88oobY' 88ooooo 88ooo88    88       88    Y8    8P 88ooooo    8P      88    88 88  88  88 
// 88  ooo 88    88 88`8b      88    88~~~~~ `8b  d8' 8b      88`8b   88~~~~~ 88~~~88    88       88    `8b  d8' 88~~~~~    8b      88    88 88  88  88 
// 88. ~8~ 88b  d88 88 `88.   .88.   88.      `8bd8'  Y8b  d8 88 `88. 88.     88   88    88      .88.    `8bd8'  88.     db Y8b  d8 `8b  d8' 88  88  88 
//  Y888P  ~Y8888P' 88   YD Y888888P Y88888P    YP     `Y88P' 88   YD Y88888P YP   YP    YP    Y888888P    YP    Y88888P VP  `Y88P'  `Y88P'  YP  YP  YP 

/**
 * Register new widget
 */
add_action('widgets_init', create_function('', 'register_widget( "latest_news" );'));

/**
 * latest_news Class
 */
class latest_news extends WP_Widget 
{ 
	public function __construct() 
	{
	    parent::__construct(
	        'latest_news', 
	        'Latest news', 
	        array( 'description' => 'This widget shows the Latest news' )
	    );
	}
 
    public function widget( $args, $instance )
    {
        extract($args);        
		
		$str   = "";
		$title = isset( $instance[ 'title' ] )  ? $instance[ 'title' ] : '';	
		$count = isset( $instance[ 'count' ] )  ? $instance[ 'count' ] : '';	
		$args  = array(		
			'posts_per_page' => intval($count),
			'post_type'     => 'post',
			'post_status'   => 'publish',
			'orderby'       => 'post_date',  
			'order'         => 'DESC'	
	   	);

		$posts  = get_posts($args);
		if($posts)
		{
			foreach ($posts as $key => $value) 
			{
				$str.= '<article>';
				$str.= '<small>'.get_sng_date($value->post_date).'</small>';				
				$str.= '<span><a href="'.get_permalink($value->ID).'">'.$value->post_title.'</a></span>';
				$str.= '</article>';
			}
		}

		echo '<div class="block-latest-news">';
		echo '<b>'.$title.'</b><hr>';
		echo $str;
		echo '</div><!-- block-latest-news end -->';
    }

    /**
     * Update data
     */
    public function update( $new_instance, $old_instance )
    {
		$instance          = array();
		$instance['title'] = $new_instance['title']; 		
		$instance['count'] = $new_instance['count']; 		
        return $instance;
    }

    /**
     * Create widget form on the admin panel
     */
    public function form( $instance )
    {
		$title   = isset( $instance[ 'title' ] )  ? $instance[ 'title' ] : '';		
		$count   = isset( $instance[ 'count' ] )  ? $instance[ 'count' ] : '';		
		?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e( 'count:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" type="text" value="<?php echo esc_attr( $count ); ?>" />
		</p>
		<?php
    }
}

/**
 * Get CCCP date format
 */
function get_sng_date($date)
{
	$date = explode(' ', $date);
	$str = explode('-', $date[0]);
	return $str[2].'.'.$str[1].'.'.$str[0];
}