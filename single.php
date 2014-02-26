<? get_header(); ?>
			<aside class="content-wrap">				
				<?php 
				if(is_active_sidebar('sidebar_right'))
				{
					dynamic_sidebar('sidebar_right');
				}		
				?>				
				<?php while ( have_posts() ) : the_post(); ?>
					<article>
						<h4><?php the_title() ?></h4>
						<?php echo get_the_post_thumbnail(get_the_ID(), 'large', array('class' => 'pull-left')) ?>
						<?php the_content(); ?>		
						<aside class="comments">
							
							<?php comments_template( '', true ); ?>	
						</aside>					
					</article>					
				<?php endwhile; // end of the loop. ?>										

			</aside><!-- content-wrap end -->	
<? get_footer(); ?>	asdfasdf