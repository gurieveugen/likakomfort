<?php
// db   db  .d88b.   .d88b.  db   dD .d8888. 
// 88   88 .8P  Y8. .8P  Y8. 88 ,8P' 88'  YP 
// 88ooo88 88    88 88    88 88,8P   `8bo.   
// 88~~~88 88    88 88    88 88`8b     `Y8b. 
// 88   88 `8b  d8' `8b  d8' 88 `88. db   8D 
// YP   YP  `Y88P'   `Y88P'  YP   YD `8888Y' 
add_action( 'init', 'create_ow_post_type' );
add_action( 'owscat_add_form_fields', 'ow_form_custom_field_add', 10 );
add_action( 'owscat_edit_form_fields', 'ow_form_custom_field_edit', 10, 2 );
add_action( 'created_owscat', 'ow_form_custom_field_save', 10, 2 );	
add_action( 'edited_owscat', 'ow_form_custom_field_save', 10, 2 );

// .88b  d88. d88888b d888888b db   db  .d88b.  d8888b. .d8888. 
// 88'YbdP`88 88'     `~~88~~' 88   88 .8P  Y8. 88  `8D 88'  YP 
// 88  88  88 88ooooo    88    88ooo88 88    88 88   88 `8bo.   
// 88  88  88 88~~~~~    88    88~~~88 88    88 88   88   `Y8b. 
// 88  88  88 88.        88    88   88 `8b  d8' 88  .8D db   8D 
// YP  YP  YP Y88888P    YP    YP   YP  `Y88P'  Y8888D' `8888Y' 
/**
 * Create new post type
 */
function create_ow_post_type() 
{
	register_taxonomy(
		'owscat',
		array('ow'),
		array(
			'label' => __( 'Рубрики' ),
			'hierarchical' => true, 			
			'query_var' => true, 
			'rewrite' => array( 'slug' => 'owscat' )
		)
	);

	register_post_type('ow', array(
		'labels' => array(
			'name'          => __( 'Наші роботи' ),
			'singular_name' => __( 'ow' )

			),
		'public'      => true,
		'has_archive' => true,
		'supports'    => array( 'title', 'thumbnail', 'editor', 'author', 'custom-fields', 'comments'),
		'rewrite'     => array( 'slug' => 'ow' ),
		'taxonomies'  => array('owscat')
		)
	);

}

function ow_form_custom_field_add( $taxonomy ) 
{
?>
<div class="form-field">
  <label for="ow_image_file"><?php _e('Изображение'); ?></label>
  <input name="ow_image_file" id="ow_image_file" type="text" value="" size="40" aria-required="true" />
  <p class="description"><?php _e('Путь к изображению'); ?></p>
</div>
<?php
}

function ow_form_custom_field_edit( $tag, $taxonomy ) 
{

	$option_name = 'ow_image_file_' . $tag->term_id;
	$ow_image_file = get_option( $option_name );

?>
<tr class="form-field">
  <th scope="row" valign="top"><label for="ow_image_file"><?php _e('Изображение'); ?></label></th>
  <td>
    <input type="text" name="ow_image_file" id="ow_image_file" value="<?php echo esc_attr( $ow_image_file ) ? esc_attr( $ow_image_file ) : ''; ?>" size="40" aria-required="true" />
    <p class="description"><?php _e('Путь к изображению'); ?></p>
  </td>
</tr>
<?php
}

function ow_form_custom_field_save( $term_id, $tt_id ) 
{
	if ( isset( $_POST['ow_image_file'] ) ) {			
		$option_name = 'ow_image_file_' . $term_id;
		update_option( $option_name, $_POST['ow_image_file'] );
	}
}


/**
 * Get all ows html code
 */
function get_all_ows()
{
	$res  = "";
	$args = array(
		'type'         => 'ow',
		'child_of'     => 0,
		'parent'       => '',
		'orderby'      => 'name',
		'order'        => 'ASC',
		'hide_empty'   => 0,
		'hierarchical' => 1,
		'exclude'      => '',
		'include'      => '',
		'number'       => '',
		'taxonomy'     => 'owscat',
		'pad_counts'   => false 
	); 
	$ows = get_categories( $args );

	if($ows)
	{
		foreach ($ows as $key => $value) 
		{
			$link   =  get_term_link($value, 'owscat');
			$res   .= '<div class="tip">';
			$res   .= '<a href="'.$link.'"><img src="'.get_option('ow_image_file_'.$value->term_id).'" width="278" height="181" alt="'.$value->name.'" /></a>';
			$res   .= '<a href="'.$link.'"><b>'.$value->name.'</b></a>';
			$res   .= '<hr></div>';
		}
	}
	return $res;
}