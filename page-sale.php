<?php 
/**
 * Template name: Sale
 */
?>
<? get_header(); ?>
<?php
$get_type      = (!isset($_GET['get_type'])) || empty($_GET['get_type']) ? 'special_offer' : $_GET['get_type'];
$x             = 0;
$str           = "";
$most_products = get_by_checkbox_option($get_type);

$most_products_active = '';
$special_offer_active = '';

if($get_type == 'most_products') $most_products_active = 'active';
else $special_offer_active = 'active';

if($most_products)
{

	for ($i=0; $i < count($most_products); $i+=3) 
	{ 	
		$str .= "<div class='row-fluid'>";
		for ($y=0; $y < 3; $y++) 
		{ 
			$x = $i + $y;
			if(isset($most_products[$x]))
			{
				$discount      = intval(get_post_meta($most_products[$x]->ID, 'discount', TRUE));
				$discount      = ($discount > 0) ? '<div class="circle"><span>'.$discount.'</span></div>' : '';
				$str.= '<div class="span4 bordered">';
				$str.= '<figure>';
				$str.= $discount;
				$str.= '<a href="'.get_permalink($most_products[$x]->ID).'" class="cat-image">';
				$str.= get_the_post_thumbnail($most_products[$x]->ID, 'thumbnail');
				$str.= '</a>';
				$str.= '<figcaption><a href="'.get_permalink($most_products[$x]->ID).'">'.$most_products[$x]->post_title.'</a></figcaption>';
				$str.= '</figure><hr>';
				$str.= '<span>'.$most_products[$x]->post_excerpt.'</span>';
				$str.= '<input name="compare'.$most_products[$x]->ID.'" id="compare'.$most_products[$x]->ID.'" data-id="'.$most_products[$x]->ID.'" type="checkbox"><label for="compare'.$most_products[$x]->ID.'">Порівняти</label>';
				$price = trim(get_post_meta($most_products[$x]->ID, 'price', TRUE));
				if(empty($price))
				{
					$str.= '<p class="price">Уточніть</p>';
				}
				else
				{
					$str.= '<p class="price">'.$price.' грн.</p>';
				}
				$str.= '<button onclick="buy('.$most_products[$x]->ID.')">Придбати</button>';
				$str.= '</div>';
			}			
		}
		$str .= '</div>';
	}
}

?>
			<aside class="content-wrap">				
				<?php 
				if(is_active_sidebar('sidebar_right'))
				{
					dynamic_sidebar('sidebar_right');
				}	
				?>
				<article class="product sale-wrap">
					<header class="sale">
						<nav>
							<a href="?get_type=special_offer" class="<?php echo $special_offer_active; ?>">Спецпропозиції</a>
							<div class="separator"></div>
							<a href="?get_type=most_products"  class="<?php echo $most_products_active; ?>">Розпродаж</a>
						</nav>	
					</header>
					
					<?php echo $str; ?>
				</article>
			</aside><!-- content-wrap end -->	
<? get_footer(); ?>	