<?php get_header(); ?>
<?php 
global $query_string; 
if(isset($_SESSION["numeric"])) query_posts($query_string."&post_type=product&meta_key=price&orderby=meta_value_num&order=ASC");
else query_posts($query_string."&post_type=product&order=ASC");

$term = get_queried_object();
$compare_visible = array(7, 8, 11);
$children = get_terms( $term->taxonomy, array(
'parent'     => $term->term_id,
'hide_empty' => false
) );

if(!$children)
{
	$children = get_terms( $term->taxonomy, array(
	'parent'     => $term->parent,
	'hide_empty' => false
	) );
}

if($children && !is_parent_menu_item($term->name)) 
{ 
	$cats = '<ul class="block-categories">';
	foreach ($children as $key => $value) 
	{
		if($term->term_id == $value->term_id)
		{
			$cats.= '<li class="block-categories-active"><a href="'.get_category_link($value->term_id).'">'.$value->name.'</a></li>';
		}
		else
		{
			$cats.= '<li><a href="'.get_category_link($value->term_id).'">'.$value->name.'</a></li>';
		}		
	}
	$cats.= '</ul>';
}
?>
<aside class="content-wrap">
	<?php the_breadcrumb(); ?>
		<?php if ( have_posts() ) : ?>
	<article>	
		<?php echo $cats; ?>
		<?php if ( category_description() ) : // Show an optional category description ?>
			<div class="archive-meta"><?php echo category_description(); ?></div>
		<?php endif; ?>

		<?php
		$items = array();
		while ( have_posts() ) : the_post();

		if(isset($_GET["start_price"]) && isset($_GET["end_price"]))
		{

			$check_price = get_post_meta(get_the_ID(), 'price', TRUE);
			if($check_price >= intval($_GET["start_price"]) && $check_price <= intval($_GET["end_price"]))
			{
				$items[] = array(
					'title'   => get_the_title(),
					'content' => get_the_excerpt(),
					'thumb'   => get_the_post_thumbnail(get_the_ID(), 'thumbnail'),
					'id'      => get_the_ID()
					);	
			}
		}
		else
		{
			$items[] = array(
					'title'   => get_the_title(),
					'content' => get_the_excerpt(),
					'thumb'   => get_the_post_thumbnail(get_the_ID(), 'thumbnail'),
					'id'      => get_the_ID()
					);	
		}
		endwhile;		

		echo '<article class="product">';
		$end = intval(count($items)/3)+1;		
		for ($i=0; $i < $end; $i++) 
		{ 			
			echo '<div class="row-fluid">';
			for ($y=0; $y < 3; $y++) 
			{ 
				if(isset($items[$i*3+$y]))
				{
					echo '<div class="span4">';
					echo '<div class="opjat_peredeluvajem_block">';
					echo '<figure>';
					echo '<a href="'.get_permalink($items[$i*3+$y]['id']).'" class="cat-image">';
					echo $items[$i*3+$y]['thumb'];
					echo '</a>';
					echo '<figcaption><a href="'.get_permalink($items[$i*3+$y]['id']).'">'.$items[$i*3+$y]['title'].'</a></figcaption>';
					echo '</figure><hr>';
					echo '<span>'.get_short_string(50, $items[$i*3+$y]['content']).'</span>';
					if(in_array(intval($term->term_id), $compare_visible))
					{
						echo '<input name="compare'.$items[$i*3+$y]['id'].'" id="compare'.$items[$i*3+$y]['id'].'" data-id="'.$items[$i*3+$y]['id'].'" type="checkbox"><label for="compare'.$items[$i*3+$y]['id'].'">Порівняти</label>';	
					}
					echo '</div><!-- opjat_peredeluvajem_block -->';
					echo '<div class="row-fluid">';
					echo '<div class="span6">';
					$price = trim(get_post_meta($items[$i*3+$y]['id'], 'price', TRUE));
					if(empty($price))
					{
						echo '<p class="price-text">Уточніть</p>';
					}
					else
					{
						echo '<p class="price-text">'.$price.' грн.</p>';
					}
					echo '</div>';
					echo '<div class="span6">';
					echo '<button class="btn-product-button" onclick="buy('.$items[$i*3+$y]['id'].')">Придбати</button>';
					echo '</div>';
					echo '</div>';
					
					
					echo '</div>';
				}								
			}
			echo '</div>';
		}
		echo '</article>';
		
		?>

		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>

	</article>
</aside>	
<?php get_footer(); ?>