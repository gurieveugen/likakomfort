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
add_action('widgets_init', create_function('', 'register_widget( "social_buttons" );'));

/**
 * social_buttons Class
 */
class social_buttons extends WP_Widget 
{ 
	public function __construct() 
	{
	    parent::__construct(
	        'social_buttons', 
	        'Social Buttons', 
	        array( 'description' => 'This widget shows the Social buttons' )
	    );
	}
 
    public function widget( $args, $instance )
    {
        extract($args);        
		
		$facebook  = isset( $instance[ 'facebook' ] )  ? $instance[ 'facebook' ] : '';
		$vkontakte = isset( $instance[ 'vkontakte' ] )  ? $instance[ 'vkontakte' ] : '';
		$rss       = isset( $instance[ 'rss' ] )  ? $instance[ 'rss' ] : '';

		echo '<ul class="block-social">';
		if(!empty($facebook)) echo '<li><a class="facebook" href="'.$facebook.'"></a></li>';
		if(!empty($vkontakte)) echo '<li><a class="vkontakte" href="'.$vkontakte.'"></a></li>';
		if(!empty($rss)) echo '<li><a class="rss" href="'.$rss.'"></a></li>';			
		echo '</ul>';
    }

    /**
     * Update data
     */
    public function update( $new_instance, $old_instance )
    {
		$instance              = array();
		$instance['facebook']  = $new_instance['facebook'];        
		$instance['vkontakte'] = $new_instance['vkontakte'];  
		$instance['rss']       = $new_instance['rss'];          
        return $instance;
    }

    /**
     * Create widget form on the admin panel
     */
    public function form( $instance )
    {
		$facebook  = isset( $instance[ 'facebook' ] )  ? $instance[ 'facebook' ] : '';		
		$vkontakte = isset( $instance[ 'vkontakte' ] )  ? $instance[ 'vkontakte' ] : '';		
		$rss       = isset( $instance[ 'rss' ] )  ? $instance[ 'rss' ] : '';		
		?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'facebook' ); ?>"><?php _e( 'facebook:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'facebook' ); ?>" name="<?php echo $this->get_field_name( 'facebook' ); ?>" type="text" value="<?php echo esc_attr( $facebook ); ?>" />
		</p>	

		<p>
			<label for="<?php echo $this->get_field_id( 'vkontakte' ); ?>"><?php _e( 'vkontakte:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'vkontakte' ); ?>" name="<?php echo $this->get_field_name( 'vkontakte' ); ?>" type="text" value="<?php echo esc_attr( $vkontakte ); ?>" />
		</p>	

		<p>
			<label for="<?php echo $this->get_field_id( 'rss' ); ?>"><?php _e( 'rss:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'rss' ); ?>" name="<?php echo $this->get_field_name( 'rss' ); ?>" type="text" value="<?php echo esc_attr( $rss ); ?>" />
		</p>	
		<?php
    }
}