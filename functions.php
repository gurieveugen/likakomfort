<?php
//  d888b  db    db d8888b. d888888b d88888b db    db  .o88b. d8888b. d88888b  .d8b.  d888888b d888888b db    db d88888b     .o88b.  .d88b.  .88b  d88. 
// 88' Y8b 88    88 88  `8D   `88'   88'     88    88 d8P  Y8 88  `8D 88'     d8' `8b `~~88~~'   `88'   88    88 88'        d8P  Y8 .8P  Y8. 88'YbdP`88 
// 88      88    88 88oobY'    88    88ooooo Y8    8P 8P      88oobY' 88ooooo 88ooo88    88       88    Y8    8P 88ooooo    8P      88    88 88  88  88 
// 88  ooo 88    88 88`8b      88    88~~~~~ `8b  d8' 8b      88`8b   88~~~~~ 88~~~88    88       88    `8b  d8' 88~~~~~    8b      88    88 88  88  88 
// 88. ~8~ 88b  d88 88 `88.   .88.   88.      `8bd8'  Y8b  d8 88 `88. 88.     88   88    88      .88.    `8bd8'  88.     db Y8b  d8 `8b  d8' 88  88  88 
//  Y888P  ~Y8888P' 88   YD Y888888P Y88888P    YP     `Y88P' 88   YD Y88888P YP   YP    YP    Y888888P    YP    Y88888P VP  `Y88P'  `Y88P'  YP  YP  YP 


/**
 * Loadd additional modules
 */
require_once(TEMPLATEPATH . '/functions/page_theme_options.php');
require_once(TEMPLATEPATH . '/functions/post_type_carousel_items.php');
require_once(TEMPLATEPATH . '/functions/post_type_product.php');
require_once(TEMPLATEPATH . '/functions/post_type_tip.php');
require_once(TEMPLATEPATH . '/functions/post_type_services.php');
require_once(TEMPLATEPATH . '/functions/post_type_our_works.php');
require_once(TEMPLATEPATH . '/functions/widget_social_buttons.php');
require_once(TEMPLATEPATH . '/functions/widget_block_address.php');
require_once(TEMPLATEPATH . '/functions/widget_block_search_by_price.php');
require_once(TEMPLATEPATH . '/functions/widget_block_order_by.php');
require_once(TEMPLATEPATH . '/functions/widget_block_image.php');
require_once(TEMPLATEPATH . '/functions/widget_block_latest_news.php');

/**
 * Adding the ability to add menu
 */
if (function_exists('add_theme_support')) 
{ 
	add_theme_support('menus'); 
}

/**
 * Adding the ability to add widgets.
 */
if(function_exists('register_sidebar'))
{
	// ========================================================
	// Sidebar-right
	// ========================================================
	register_sidebar(array(
		'name'          => 'Sidebar Right',
		'id'			=> 'sidebar_right',
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '',
		'after_title'   => ''
	));	

	// ========================================================
	// Sidebar-left
	// ========================================================
	register_sidebar(array(
		'name'          => 'Sidebar Left',
		'id'			=> 'sidebar_left',
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '',
		'after_title'   => ''
	));				
}

/**
 * Check parent item.
 * @param  string  $title 
 * @param  string  $menu_name 
 * @return boolean
 */
function is_parent_menu_item($title, $menu_name = "LeftMenu")
{
	$res   = FALSE;
	$items = wp_get_nav_menu_items($menu_name);
	foreach ($items as $key => $value) 
	{
		if($value->menu_item_parent == 0)
		{
			if($value->title == $title)
			{
				$res = TRUE;
			}
		}
	}
	return $res;
}

/**
 * Get father category
 */
function get_father_category($id)
{
	$term = get_term($id, 'category');	
	if($term->parent > 0) 
	{
		return get_father_category($term->parent);
	}
	return $term->term_id;
}

