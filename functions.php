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
require_once(TEMPLATEPATH . '/functions/post_type_factory.php');
require_once(TEMPLATEPATH . '/functions/walker.php');

// =========================================================
// POST TYPES
// =========================================================
$GLOBALS['pt_product'] = new PostTypeFactory('product');
$GLOBALS['pt_product']->addMetaBox('Additional info', array(
	'Product type' => array('table', array('title', 'items'))
		));

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

function get_short_string($symbols, $str)
{
	return preg_match("/^(.{".$symbols.",}?)\s+/s", $str, $m) ? $m[1] . '...' : $str; 
}


/**
 * Display breadcrumbx
 */
function the_breadcrumb() 
{
	global $post, $term;
	$all_cats = array();
	if($term)
	{
		$all_cats = getAllParents($term->term_id);
	}
	else
	{
		$cats     = wp_get_post_categories($post->ID);
		if($cats)
		{
			foreach ($cats as $cat) 
			{
				$temp     = getAllParents($cat);
				$all_cats = $all_cats + $temp;
			}
		}
	}
	unset($term);
	
	

	$all_cats = array_reverse($all_cats);

	$out[] = sprintf('<a href="%s">Головна</a>', get_option('home'));
	foreach ($all_cats as $term) 
	{
		$term = get_term_by_id_only($term);
		
		$out[] = sprintf('<a href="%s">%s</a>', get_term_link( $term->slug, $term->taxonomy), $term->name);		
	}
	

	if($out)
	{
		echo '<ul class="breadcrumbs">';
		foreach ($out as &$el) 
		{
			printf('<li>%s</li>', $el);
		}	
		echo '</ul>';
	}
}

function getAllParents($term_id, $parents = array())
{
	$term = get_term_by_id_only($term_id);
	array_push($parents, $term->term_id);
	if($term->parent != 0) return getAllParents($term->parent, $parents);		
	return $parents;
}


/**
 * Get term just by id only
 */
function get_term_by_id_only($term, $output = OBJECT, $filter = 'raw') 
{
    global $wpdb;
    $null = null;

    if(empty($term)) 
    {
        $error = new WP_Error('invalid_term', __('Empty Term'));
        return $error;
    }

    if (is_object($term) && empty($term->filter)) 
    {
        wp_cache_add($term->term_id, $term, 'my_custom_queries');
        $_term = $term;
    } 
    else 
    {
        if (is_object($term)) $term = $term->term_id;
        $term = (int) $term;
        if (!$_term = wp_cache_get($term, 'my_custom_queries')) 
        {
            $_term = $wpdb->get_row( $wpdb->prepare( "SELECT t.*, tt.* FROM $wpdb->terms AS t INNER JOIN $wpdb->term_taxonomy AS tt ON t.term_id = tt.term_id WHERE t.term_id = %s LIMIT 1", $term) );
            if(!$_term) return $null;
            wp_cache_add($term, $_term, 'my_custom_queries');
        }
    }

    if ( $output == OBJECT ) 
    {
        return $_term;
    } 
    else if ($output == ARRAY_A) 
	{
        $__term = get_object_vars($_term);
        return $__term;
    } 
    else if ( $output == ARRAY_N ) 
    {
        $__term = array_values(get_object_vars($_term));
        return $__term;
    } 
    else 
    {
        return $_term;
    }
}