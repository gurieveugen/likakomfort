<?php 
/**
 * Template name: Tips
 */
?>
<? get_header(); ?>
			<aside class="content-wrap">				
				<?php 
				if(is_active_sidebar('sidebar_right'))
				{
					dynamic_sidebar('sidebar_right');
				}	
				?>

				<article >
					<?php echo get_all_tips(); ?>
					<?php the_content(); ?>
				</article>
			</aside><!-- content-wrap end -->	
<? get_footer(); ?>	