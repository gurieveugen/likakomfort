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
						<?php
						if($post->post_parent > 0)
						{
							echo '<a class="btn-back" href="'.get_permalink($post->post_parent).'">Повернутися</a>';
						}
						?>
						<h2><?php the_title(); ?></h2>						
						<?php the_content(); ?>	
						<aside class="comments">
							
							<?php comments_template( '', true ); ?>	
						</aside>	
										
					</article>				

					

				<?php endwhile; // end of the loop. ?>										

			</aside><!-- content-wrap end -->	
<? get_footer(); ?>