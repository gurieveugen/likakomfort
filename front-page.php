<? get_header(); ?>
			<aside class="content-wrap">				
				<?php 				
				if(is_active_sidebar('sidebar_right'))
				{
					dynamic_sidebar('sidebar_right');
				}		
				?>
				<?php echo get_carousel(); ?>		
				<?php while ( have_posts() ) : the_post(); ?>
					<article>
						<?php the_content(); ?>
					</article>					
				<?php endwhile; // end of the loop. ?>						
				<?php echo get_special_offers_html(); ?>
				<?php echo get_most_products_html(); ?>		
				<?php echo get_watched_html(); ?>		
			</aside><!-- content-wrap end -->	
<? get_footer(); ?>	