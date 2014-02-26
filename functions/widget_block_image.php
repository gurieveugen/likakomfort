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
add_action('widgets_init', create_function('', 'register_widget( "block_image" );'));

/**
 * block_image Class
 */
class block_image extends WP_Widget 
{ 
	public function __construct() 
	{
	    parent::__construct(
	        'block_image', 
	        'Image block', 
	        array( 'description' => 'This widget shows the Image block' )
	    );
	}
 
    public function widget( $args, $instance )
    {
        extract($args);        
		
		$url   = isset( $instance[ 'url' ] )  ? $instance[ 'url' ] : '';	
		$image = isset( $instance[ 'image' ] )  ? $instance[ 'image' ] : '';	

		echo '<a href="'.$url.'"><img src="'.$image.'" alt="" /></a>';
    }

    /**
     * Update data
     */
    public function update( $new_instance, $old_instance )
    {
		$instance          = array();
		$instance['url']   = $new_instance['url']; 
		$instance['image'] = $new_instance['image']; 
        return $instance;
    }

    /**
     * Create widget form on the admin panel
     */
    public function form( $instance )
    {
		$url   = isset( $instance[ 'url' ] )  ? $instance[ 'url' ] : '';
		$image = isset( $instance[ 'image' ] )  ? $instance[ 'image' ] : '';
		?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'url' ); ?>"><?php _e( 'url:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'url' ); ?>" name="<?php echo $this->get_field_name( 'url' ); ?>" type="text" value="<?php echo esc_attr( $url ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'image' ); ?>"><?php _e( 'image:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'image' ); ?>" name="<?php echo $this->get_field_name( 'image' ); ?>" type="text" value="<?php echo esc_attr( $image ); ?>" />
		</p>
		<?php
    }
}