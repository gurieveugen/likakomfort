<?php
//  d888b  db    db d8888b. d888888b d88888b db    db  .o88b. d8888b. d88888b  .d8b.  d888888b d888888b db    db d88888b     .o88b.  .d88b.  .88b  d88. 
// 88' Y8b 88    88 88  `8D   `88'   88'     88    88 d8P  Y8 88  `8D 88'     d8' `8b `~~88~~'   `88'   88    88 88'        d8P  Y8 .8P  Y8. 88'YbdP`88 
// 88      88    88 88oobY'    88    88ooooo Y8    8P 8P      88oobY' 88ooooo 88ooo88    88       88    Y8    8P 88ooooo    8P      88    88 88  88  88 
// 88  ooo 88    88 88`8b      88    88~~~~~ `8b  d8' 8b      88`8b   88~~~~~ 88~~~88    88       88    `8b  d8' 88~~~~~    8b      88    88 88  88  88 
// 88. ~8~ 88b  d88 88 `88.   .88.   88.      `8bd8'  Y8b  d8 88 `88. 88.     88   88    88      .88.    `8bd8'  88.     db Y8b  d8 `8b  d8' 88  88  88 
//  Y888P  ~Y8888P' 88   YD Y888888P Y88888P    YP     `Y88P' 88   YD Y88888P YP   YP    YP    Y888888P    YP    Y88888P VP  `Y88P'  `Y88P'  YP  YP  YP 

// ========================================================
// Constants
// ========================================================
const BANK_NOTES = " грн";

// db   db  .d88b.   .d88b.  db   dD .d8888. 
// 88   88 .8P  Y8. .8P  Y8. 88 ,8P' 88'  YP 
// 88ooo88 88    88 88    88 88,8P   `8bo.   
// 88~~~88 88    88 88    88 88`8b     `Y8b. 
// 88   88 `8b  d8' `8b  d8' 88 `88. db   8D 
// YP   YP  `Y88P'   `Y88P'  YP   YD `8888Y' 
add_action( 'init', 'create_produc_post_type' );
add_action('do_meta_boxes', 'product_meta_box');
add_action('save_post', 'product_update', 0);
add_action('wp_ajax_buy', 'buy_ajax');
add_action('wp_ajax_nopriv_buy', 'buy_ajax');
add_action('wp_ajax_buy_cancel', 'buy_cancel_ajax');
add_action('wp_ajax_nopriv_buy_cancel', 'buy_cancel_ajax');
add_action('wp_ajax_cancel_all_buys', 'cancel_all_buys_ajax');
add_action('wp_ajax_nopriv_cancel_all_buys', 'cancel_all_buys_ajax');
add_action('wp_ajax_send_order', 'send_order_ajax');
add_action('wp_ajax_nopriv_send_order', 'send_order_ajax');
add_action('wp_ajax_numeric_sort', 'numeric_sort_ajax');
add_action('wp_ajax_nopriv_numeric_sort', 'numeric_sort_ajax');
add_action('wp_ajax_unset_numeric_sort', 'unset_numeric_sort_ajax');
add_action('wp_ajax_nopriv_unset_numeric_sort', 'unset_numeric_sort_ajax');
add_action('wp_ajax_search_by_price', 'search_by_price_ajax');
add_action('wp_ajax_nopriv_search_by_price', 'search_by_price_ajax');
add_action('admin_head', 'customStylesAndScript');

/**
 * Add meta boxes
 */
function product_meta_box() 
{
	add_meta_box('product_meta_box', 'Опції', 'product_box_func', 'product', 'side', 'high');
	add_meta_box('specifications', 'Характеристики', 'box_specifications', 'product', 'normal', 'high');
}

/**
 * Booking suppliers box
 * @param  object $post
 */
function box_specifications($post)
{
	$specifications = get_post_meta($post->ID, 'specifications', 0);		
	$specifications = $specifications[0];		
	$count          = count($specifications['fields']);
	$str_start      = '<table class="specifications_table" id="specifications"><thead><tr><th>#</th><th>Ячейки</th><th>Значения</th></tr></thead><tbody>';
	$str_end        = '</tbody></table><button type="button" onclick="addSpecificationsItem(\'specifications\');" class="button button-large">Добавить характеристику</button>';
	
	for ($i=0; $i <= $count-1; $i++) 
	{ 

		$field = (isset($specifications['fields'][$i])) ? $specifications['fields'][$i] : "";
		$value = (isset($specifications['values'][$i])) ? $specifications['values'][$i] : "";		
		if($field != "")
		{
			$str  .= '<tr>';
			$str  .= '<td>'.$i.'</td>';
			$str  .= '<td><input type="text" name="specifications[fields][]" value="'.$field.'"></td>';
			$str  .= '<td><input type="text" name="specifications[values][]" value="'.$value.'"></td>';
			$str  .= '</tr>';			
		}		
	}	

	echo $str_start.$str.$str_end;
}

function get_two_specifications($id1, $id2)
{	
	$first  = get_post_meta($id1, 'specifications', 0);
	$first  = $first[0];
	$first  = transform_spec_array($first);
	$second = get_post_meta($id2, 'specifications', 0);
	$second = $second[0];
	$second = transform_spec_array($second);
	
	$output = '<table class="compare-table"><tbody>';
	if($first)
	{
		foreach ($first as $key => $value) 
		{
			$output.= '<tr>';
			$output.= '<td style="width: 20%; border-right: 1px solid black;">'.$key.'</td>';
			$output.= '<td style="width: 40%;">'.$value.'</td>';
			$output.= '<td style="width: 40%;">'.$second[$key].'</td>';
			$output.= '</tr>';
		}	
	}
	$output.= '</tbody></table>';
	echo $output;
}

function transform_spec_array($arr)
{
	$res = array();
	if(isset($arr['fields']))
	{
		foreach ($arr['fields'] as $key => $value) 
		{
			if(isset($arr['values'][$key]))
			{
				$res[$value] = $arr['values'][$key];
			}
		}	
	}
	return $res;
}

/**
 * Custom CSS and Script for admin backend
 */
function customStylesAndScript() 
{
	?>
	<style type="text/css">
	.specifications_table{
		width: 100%;
		text-align: left;
		border-collapse: collapse;
		border-spacing: 0;
		margin-bottom: 30px;
	}

	.specifications_table thead th{
		border-bottom: 2px solid #DDDDDD;
	}

	.specifications_table tbody tr:nth-child(odd) td,
	.specifications_table tbody tr:nth-child(odd) th {
	  background-color: #f9f9f9;
	}

	.specifications_table tbody tr:hover td,
	.specifications_table tbody tr:hover th {
	  background-color: #f5f5f5;
	}

	.specifications_table tbody tr{
		border-top: 1px solid #DDDDDD;
	}
	
	.specifications_table thead tr th,
	.specifications_table tbody tr td{
		padding: 10px 5px;
	}

	.specifications_table tbody tr td input{
		width: 100%;
	}
	</style>
	<script type='text/javascript'>
		function addSpecificationsItem(id)
		{			
			jQuery('#' + id + ' tbody').append('<tr><td></td><td><input type="text" name="specifications[fields][]" value=""></td><td><input type="text" name="specifications[values][]" value=""></td></tr>');
		}
	</script>
	<?php
  
}

/**
 * Create new post type
 */
function create_produc_post_type() 
{
	register_post_type('product', array(
		'labels' => array(
			'name'          => __( 'Магазин' ),
			'singular_name' => __( 'product' )
			),
		'public'      => true,
		'has_archive' => true,
		'supports'    => array( 'title', 'thumbnail', 'editor', 'author', 'custom-fields', 'excerpt'),
		'rewrite'     => array( 'slug' => 'product' ),
		'taxonomies'  => array('category'),
		'menu_icon'   => get_bloginfo('template_url')."/img/products.png"
		)
	);
}

/**
 * Show Price meta Box
 */
function product_box_func($post)
{
?>
	<p>		
		<label for="price">Ціна:</label>
		<input style="width: 95%;" type="text" name="price" value="<?php echo get_post_meta($post->ID, 'price', 1)?>">
	</p>	
	<p>		
		<label for="discount">Дисконт знижка:</label>
		<input style="width: 95%;" type="text" name="discount" value="<?php echo get_post_meta($post->ID, 'discount', 1)?>">
	</p>		
	<p>
		<label for="special_offer" style="width: 60%; display: inline-block">Спецпропозиція</label>
		<?php
		if(get_post_meta($post->ID, 'special_offer', 1) == "on")
		{
			echo '<input type="checkbox" name="special_offer" checked>';
		}
		else
		{
			echo '<input type="checkbox" name="special_offer">';
		}
		?>
		
	</p>
	<p>
		<label for="most_products" style="width: 60%; display: inline-block">Найпопулярніші товари</label>
		<?php
		if(get_post_meta($post->ID, 'most_products', 1) == "on")
		{
			echo '<input type="checkbox" name="most_products" checked>';
		}
		else
		{
			echo '<input type="checkbox" name="most_products">';
		}
		?>		
	</p>

	<input type="hidden" name="product_nonce" value="<?php echo wp_create_nonce(__FILE__); ?>" />
<?php
}

/**
 * Update Price Meta box
 */
function product_update($post_id)
{
	if ( !wp_verify_nonce($_POST['product_nonce'], __FILE__) ) return false; 
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE  ) return false; 
	if ( !current_user_can('edit_post', $post_id) ) return false; 

	if(isset($_POST['price']))
	{
		$value = trim($_POST['price']);
		if( empty($value) )
		{
			delete_post_meta($post_id, 'price');
		}
		update_post_meta($post_id, 'price', $value);
	}

	if(isset($_POST['discount']))
	{
		$discount = trim($_POST['discount']);
		if( empty($discount) )
		{
			delete_post_meta($post_id, 'discount');
		}
		update_post_meta($post_id, 'discount', $discount);
	}

	if(isset($_POST['discount']))
	{
		$discount = trim($_POST['discount']);
		if( empty($discount) )
		{
			delete_post_meta($post_id, 'discount');
		}
		update_post_meta($post_id, 'discount', $discount);
	}
	
	if(isset($_POST['special_offer']))
	{

		update_post_meta($post_id, 'special_offer', $_POST['special_offer']);
	}
	else
	{
		delete_post_meta($post_id, 'special_offer');
	}

	if(isset($_POST['most_products']))
	{
		update_post_meta($post_id, 'most_products', $_POST['most_products']);
	}
	else
	{
		delete_post_meta($post_id, 'most_products');
	}	

	if(isset($_POST['specifications']))
	{		
		update_post_meta($post_id, 'specifications', $_POST['specifications']);
	}
	else
	{
		delete_post_meta($post_id, 'specifications');
	}	

	return $post_id;
}

/**
 * FUNCTION FOR DEBUG.
 * REMOVE ME LATER
 */
function log_it( $message ) 
{
	if( is_array( $message ) || is_object( $message ) )
	{
		mail('tatarinfamily@gmail.com', 'My Subject', print_r( $message, true ));	
	} 
	else 
	{
		mail('tatarinfamily@gmail.com', 'My Subject', $message);	
	}
 }

/**
 * Get product by checkbox oprion
 */
function get_by_checkbox_option($option)
{
	$args = array(		
		'posts_per_page' => '-1',
		'post_type'     => 'product',
		'post_status'   => 'publish',
		'orderby'       => 'post_date',  
		'order'         => 'DESC'	
   	);

	$posts  = get_posts($args);
	$result = array();

	if($posts)
	{
		foreach ($posts as $key => $value) 
		{			
			if(get_post_meta($value->ID, $option, 1) == "on")
			{
				$result[] = $value;
			}
		}
	}
	return $result;
}

/**
 * Get Most Products
 */
function get_most_products()
{
	return get_by_checkbox_option('most_products');
}

/**
 * Get Special offer Products
 */
function get_special_offers()
{
	return get_by_checkbox_option('special_offer');
}

/**
 * Get special offers blocks html
 */
function get_special_offers_html($max_items = 3)
{
	$x              = 0;
	$str            = "";
	$special_offers = get_special_offers();
	if($special_offers)
	{
		$str.= '<article class="product"><header><b>Спецпропозиції</b></header><div class="row-fluid">';
		foreach ($special_offers as $key => $value) 
		{
			if($x < 3)
			{
				$x++;
				$str.= '<div class="span4 bordered">';
				$str.= '<figure>';
				$str.= '<a href="'.get_permalink($value->ID).'" class="cat-image">';
				$str.= get_the_post_thumbnail($value->ID, 'thumbnail');
				$str.= '</a>';
				$str.= '<figcaption><a href="'.get_permalink($value->ID).'">'.$value->post_title.'</a></figcaption>';
				$str.= '</figure><hr>';
				$str.= '<span>'.$value->post_excerpt.'</span>';
				$str.= '<input name="compare'.$value->ID.'" id="compare'.$value->ID.'" data-id="'.$value->ID.'" type="checkbox"><label for="compare'.$value->ID.'">Порівняти</label>';
				$price = trim(get_post_meta($value->ID, 'price', TRUE));
				if(empty($price))
				{
					$str.= '<p class="price">Уточніть</p>';
				}
				else
				{
					$str.= '<p class="price">'.$price.' грн.</p>';
				}
				$str.= '<button onclick="buy('.$value->ID.')">Придбати</button>';
				$str.= '</div>';
			}			
		}
		$str.= '</div></article><!-- product (Special Offers) end -->';
	}
	return $str;
}

/**
 * Get most products blocks html
 */
function get_most_products_html($max_items = 3)
{
	$x              = 0;
	$str            = "";
	$most_products = get_most_products();
	if($most_products)
	{
		$str.= '<article class="product"><header><b>Найпопулярніші товари</b></header><div class="row-fluid">';
		foreach ($most_products as $key => $value) 
		{
			if($x < 3)
			{
				$x++;
				$str.= '<div class="span4 bordered">';
				$str.= '<figure>';
				$str.= '<a href="'.get_permalink($value->ID).'" class="cat-image">';
				$str.= get_the_post_thumbnail($value->ID, 'thumbnail');
				$str.= '</a>';
				$str.= '<figcaption><a href="'.get_permalink($value->ID).'">'.$value->post_title.'</a></figcaption>';
				$str.= '</figure><hr>';
				$str.= '<span>'.$value->post_excerpt.'</span>';
				$str.= '<input name="compare'.$value->ID.'" id="compare'.$value->ID.'" data-id="'.$value->ID.'" type="checkbox"><label for="compare'.$value->ID.'">Порівняти</label>';
				$price = trim(get_post_meta($value->ID, 'price', TRUE));
				if(empty($price))
				{
					$str.= '<p class="price">Уточніть</p>';
				}
				else
				{
					$str.= '<p class="price">'.$price.' грн.</p>';
				}
				$str.= '<button onclick="buy('.$value->ID.')">Придбати</button>';
				$str.= '</div>';
			}			
		}
		$str.= '</div></article><!-- product (Most Products) end -->';
	}
	return $str;
}


function get_watched_html($max = 3)
{
	$arr = getLatestWatched($max);
	$str = '';
	if($arr)
	{
		$str.= '<article class="product"><header><b>Останні переглянуті</b></header><div class="row-fluid jcarousel">';
		foreach ($arr as $key => $value) 
		{
			$value = get_post($value);
			$str.= '<div class="span4">';
			$str.= '<div class="opjat_peredeluvajem_block">';
			$str.= '<figure>';
			$str.= '<a href="'.get_permalink($value->ID).'" class="cat-image">';
			$str.= get_the_post_thumbnail($value->ID, 'thumbnail');
			$str.= '</a>';
			$str.= '<figcaption><a href="'.get_permalink($value->ID).'">'.$value->post_title.'</a></figcaption>';
			$str.= '</figure><hr>';
			$str.= '<span>'.get_short_string(50, $value->post_excerpt).'</span>';
			$str.= '<input name="compare'.$value->ID.'" id="compare'.$value->ID.'" data-id="'.$value->ID.'" type="checkbox"><label for="compare'.$value->ID.'">Порівняти</label>';
			$str.= '</div><!-- opjat_peredeluvajem_block -->';
			$str.= '<div class="row-fluid">';
			$str.= '<div class="span6">';
			$price = trim(get_post_meta($value->ID, 'price', TRUE));
			if(empty($price))
			{
				$str.= '<p class="price-text">Уточніть</p>';
			}
			else
			{
				$str.= '<p class="price-text">'.$price.' грн.</p>';
			}
			$str.= '</div>';
			$str.= '<div class="span6">';
			$str.= '<button class="btn-product-button" onclick="buy('.$value->ID.')">Придбати</button>';
			$str.= '</div>';
			$str.= '</div>';
			$str.= '</div>';
		}	
		$str.= '</div></article><!-- product (Most Products) end -->';
	}
	return $str;
}

/**
 * Get most products blocks html
 */
function get_also_products_html($cat_id, $exclude = 0, $max_items = 3)
{
	$x              = 0;
	$str            = "";
	$args = array(		
		'posts_per_page' => '-1',
		'category'		=> $cat_id,
		'exclude'		=> $exclude,
		'post_type'     => 'product',
		'post_status'   => 'publish',
		'orderby'       => 'post_date',  
		'order'         => 'DESC'	
   	);

	$posts  = get_posts($args);	
	$result = array();

	if($posts)
	{
		foreach ($posts as $key => $value) 
		{			
			$result[] = $value;			
		}
	}
	$most_products = $result;
	
	if($most_products)
	{
		$str.= '<article class="product"><header><b>Дивіться також</b></header><div class="row-fluid">';
		foreach ($most_products as $key => $value) 
		{
			if($x < 3)
			{
				$x++;
				$str.= '<div class="span4">';
				$str.= '<div class="opjat_peredeluvajem_block">';
				$str.= '<figure>';
				$str.= '<a href="'.get_permalink($value->ID).'" class="cat-image">';
				$str.= get_the_post_thumbnail($value->ID, 'thumbnail');
				$str.= '</a>';
				$str.= '<figcaption><a href="'.get_permalink($value->ID).'">'.$value->post_title.'</a></figcaption>';
				$str.= '</figure><hr>';
				$str.= '<span>'.get_short_string(50, $value->post_excerpt).'</span>';
				$str.= '<input name="compare'.$value->ID.'" id="compare'.$value->ID.'" data-id="'.$value->ID.'" type="checkbox"><label for="compare'.$value->ID.'">Порівняти</label>';
				$str.= '</div><!-- opjat_peredeluvajem_block -->';
				$str.= '<div class="row-fluid">';
				$str.= '<div class="span6">';
				$price = trim(get_post_meta($value->ID, 'price', TRUE));
				if(empty($price))
				{
					$str.= '<p class="price-text">Уточніть</p>';
				}
				else
				{
					$str.= '<p class="price-text">'.$price.' грн.</p>';
				}
				$str.= '</div>';
				$str.= '<div class="span6">';
				$str.= '<button class="btn-product-button" onclick="buy('.$value->ID.')">Придбати</button>';
				$str.= '</div>';
				$str.= '</div>';
				$str.= '</div>';
			}			
		}
		$str.= '</div></article><!-- product (Most Products) end -->';
	}
	return $str;
}

/**
 * Get all products cart
 */
function get_all_products_cart($visible_buttons = true)
{	
	if(isset($_SESSION["products"]))
	{

		foreach ($_SESSION["products"] as $key => $value) 
		{
			$price = get_post_meta($key, 'price', TRUE);
			$sum = $price*$value;
			$products.= '<tr>';
			$products.= '<td>'.get_the_title($key).'</td>';
			$products.= '<td>'.$price.'</td>';
			$products.= '<td>'.$value.'</td>';
			$products.= '<td>'.$sum.'</td>';
			if($visible_buttons) $products.= '<td>'.'<button class="btn-remove" onclick="buy_cancel('.$key.')"></button>'.'</td>';
			$products.= '</tr>';
		}
	}		
	$str = '<table class="cart-table">';
	if($visible_buttons) $str.= '<thead> <tr> <th>Товар</th> <th>Ціна,грн</th> <th>Кількість</th> <th>Сума, грн.</th> <th>Видалити</th> </tr> </thead> <tbody>';
	else $str.= '<thead> <tr> <th>Товар</th> <th>Ціна,грн</th> <th>Кількість</th> <th>Сума, грн.</th> </tr> </thead> <tbody>';
	$str.= $products;
	$str.= '</tbody>';
	$str.= '</table><!-- cart-table end -->';	

	return $str;	
}

/**
 * Buy product
 */
function buy_product($id)
{
	if(isset($_SESSION["products"][$id]))
	{
		$_SESSION["products"][$id]++;
	}
	else
	{
		$_SESSION["products"][$id] = 1;
	}

	$res["status"] = "OK";
	$res["msg"]    = "Goods ($id) purchased";
	$res["sum"]    = get_total_sum() + BANK_NOTES;
	return json_encode($res);
}

/**
 * Remove product
 */
function remove_product($id)
{
	if(isset($_SESSION["products"][$id]))
	{		
		if($_SESSION["products"][$id] > 1)
		{
			$_SESSION["products"][$id]--;			
		}
		else
		{
			unset($_SESSION["products"][$id]);
		}

		$res["msg"]   = 'Remove product ('.$id.')';
		$res["table"] = get_all_products_cart();
		$res["sum"]   = get_total_sum().BANK_NOTES;
		return json_encode($res);
	}
	else
	{
		$res["msg"]   = 'NULL';		
		$res["sum"]   = get_total_sum().BANK_NOTES;
	}
	return json_encode($res);
}

/**
 * Remove all products
 */
function remove_all_products()
{
	if(isset($_SESSION["products"]))
	{
		unset($_SESSION["products"]);
	}
	$res["msg"]   = "Remove all products";
	$res["table"] = get_all_products_cart();
	$res["sum"]   = get_total_sum().BANK_NOTES;
	return json_encode($res);
}

/**
 * Get the sum of all goods
 */
function get_total_sum()
{
	$sum = 0;
	if(isset($_SESSION["products"]))
	{
		foreach ($_SESSION["products"] as $key => $value) 
		{
			$sum = $sum + get_post_meta($key, 'price', TRUE)*$value;
		}
	}
	return $sum;
}

/**
 * Send the order
 */
function send_order($name, $email, $contacts)
{
	$to      = get_bloginfo("admin_email");
	$subject = "Новый заказ";
	$message = "Имя: $name"."<br>";
	$message.= "Электронная почта: $email"."<br>";
	$message.= "Контакты: $contacts"."<br>";
	$message.= get_all_products_cart(false);
	$headers = "Content-type: text/html; charset=utf-8 \r\n";	
	
	return mail($to, $subject, $message, $headers);
}

/**
 * Session Start
 */
function _session_start()
{
	if(!isset($_SESSION["on"]))
	{
		session_start();
		$_SESSION["on"] = true;
	}	
}

/**
 * Add watched product
 * @param integer $ID 
 */
function addWatched($ID)
{
	if(get_post_type($ID) == "product")
	{
		$_SESSION['watched'][] = $ID;	
	}	
}

/**
 * Get latest watched products
 * @param  integer $count
 * @return mixed
 */
function getLatestWatched($count = 10)
{
	if(isset($_SESSION['watched']) && $count > 0)
	{
		$arr = array_unique($_SESSION['watched']);
		for ($i=count($arr)-1; $i >= 0 ; $i--) 
		{ 
			if($count > 0)
			{
				$count--;
				$watched[] = $arr[$i];	
			}
			
		}
		return $watched;
	}
	return false;
}

/**
 * Get the text page to the specific mark
 */
function get_anons($text, $mark = "<!--more-->")
{		
	$anons = explode($mark, $text);
	$anons = $anons[0];

	return $anons;
}

/**
 * Get all images from post
 */
function get_all_images_from_post($id)
{
	$args = array(
		'post_type'   => 'attachment',
		'numberposts' => -1,
		'post_status' => null,
		'post_parent' => $id
	);

	$thumbnail_id = get_post_thumbnail_id($id);
	$images       = null;  
	$attachments  = get_posts($args);
	if ($attachments) 
	{
		foreach($attachments as $attachment) 
		{	
			if($attachment->ID != $thumbnail_id)
			{
				$tmp = wp_get_attachment_image_src($attachment->ID, 'thumbnail');
			   	if($tmp[0])
			   	{
			   		$images[] = array('src' => $tmp[0], 'id' => $attachment->ID);
			   	}      		  		   	
			}
		}
	}
	return $images;
}

/**
 * Get html code for jcarousel plugin
 */
function get_carousel_arr($arr, $id = "mycarousel")
{
	$li       = "";
	$carousel = '<ul id="'.$id.'" class="jcarousel-skin-tango">';
	foreach ($arr as $key => $value) 
	{
		$full_image = wp_get_attachment_image_src($value['id'], 'full');
		$li .= '<li><a href="'.$full_image[0].'" class="fancybox" rel="group"><img src="'.$value['src'].'" alt="" /></a></li>';
	}
	$carousel.= $li.'</ul>';

	return $carousel;
}

// ========================================================
// AJAX
// ========================================================
function buy_ajax()
{
	$id = $_POST["id"];

	echo buy_product($id);
	die();
}
function buy_cancel_ajax()
{
	$id = $_POST["id"];

	echo remove_product($id);
	die();
}

function cancel_all_buys_ajax()
{
	echo remove_all_products();
	die();
}

function send_order_ajax()
{
	$fullname = $_POST["fullname"];
	$email    = $_POST["email"];
	$contacts = $_POST["contacts"];

	if(send_order($fullname, $email, $contacts))
	{	
		remove_all_products();
		$res["msg"] = "Письмо отправлено. Спасибо за покупки!";
	}
	else
	{
		$res["msg"] = "Письмо не может быть отправлено. Свяжитесь с администратором ".get_bloginfo("admin_email")."!";
	}
	echo json_encode($res);
	die();
}

function numeric_sort_ajax()
{
	$_SESSION["numeric"] = true;
	die();
}

function unset_numeric_sort_ajax()
{
	unset($_SESSION["numeric"]);
	die();
}

function search_by_price_ajax()
{
	$_SESSION["start_price"] = $_POST["start_price"];
	$_SESSION["end_price"]   = $_POST["end_price"];
	die();
}

// ========================================================
// PHP Code
// ========================================================

_session_start();