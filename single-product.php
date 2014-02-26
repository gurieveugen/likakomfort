<? get_header(); ?>
			<aside class="content-wrap">				
				<?php 
				if(is_active_sidebar('sidebar_right'))
				{
					dynamic_sidebar('sidebar_right');
				}		
				?>				
				<?php while ( have_posts() ) : the_post(); 
				addWatched(get_the_ID());
				?>
					<article>
					<?php 
					$cat = get_the_category();
					foreach ($cat as $key => $value) 
					{
						$term_id = $value->term_id;
						if($value->parent == "0")
						{
							$cats[]  = $value->name;							
						}
						
					}

					echo '<a class="btn-back" href="'.get_category_link($term_id).'">Повернутися</a>';
					?>
						<h4><?php the_title() ?></h4>
						<span>
							<?php
							$price = trim(get_post_meta(get_the_ID(), 'price', TRUE));
							if(empty($price))
							{
								$price_text = '<p class="price">Уточніть</p>';
							}
							else
							{
								$price_text = '<p class="price">'.$price.' грн.</p>';
							}
							?>	

							<div class="row-fluid">								
								<div class="span6">
									<?php echo get_the_post_thumbnail(get_the_ID(), "full", array('class' => 'bigger')); ?>
									<div class="row-fluid">
										<div class="span6"><?php echo $price_text; ?></div>
										<div class="span6"><button class="btn-buy" onclick="buy(<?php the_ID() ?>)">Придбати</button></div>
									</div>		
									<?php
									$all_images_from_post = get_all_images_from_post(get_the_ID());
									if($all_images_from_post)
									{
									?>
										<div class="row-fluid">									
											<nav class="thumbs">
												<?php echo get_carousel_arr($all_images_from_post); ?>
												<div class="thumbs-controls">
													<a class="prev-image" href="#" onclick="jQuery('#mycarousel').jcarousel('prev'); return false;"></a>
													<a class="next-image" href="#" onclick="jQuery('#mycarousel').jcarousel('next'); return false;"></a>
												</div>
											</nav>										
										</div>	
									<?php
									}
									?>
								</div>
								<div class="span6">
									<?php the_content(); ?>	
									
								</div>
							</div>
							<div class="row-fluid">								
								<?php echo get_also_products_html($term_id, get_the_ID()) ?>
							</div>
							
						</span>			
						
					</article>					
				<?php endwhile; // end of the loop. ?>										

			</aside><!-- content-wrap end -->	
<?php 
if($cats)
{
?>
<script>	
	var cats = ["<?php echo implode('", "', $cats); ?>"];
</script>		
<?php
}
?>	
<? get_footer(); ?>