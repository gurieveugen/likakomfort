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
						<?php the_content(); ?>
						<div id="map-canvas"></div>
						<div class="row-fluid" style="margin-top: 40px;">
							<div class="span3"><a href="/%D0%BC%D0%B0%D0%B3%D0%B0%D0%B7%D0%B8%D0%BD-1/"><img src="/wp-content/uploads/2013/11/our_works_32-150x150.jpg" alt=""></a></div>
							<div class="span3"><a href="/%D0%BC%D0%B0%D0%B3%D0%B0%D0%B7%D0%B8%D0%BD-2/"><img src="/wp-content/uploads/2013/11/our_works_42-150x150.jpg" alt=""></a></div>
							<div class="span3"><a href="/%D0%BC%D0%B0%D0%B3%D0%B0%D0%B7%D0%B8%D0%BD-3/"><img src="/wp-content/uploads/2013/11/our_works_62-150x150.jpg" alt=""></a></div>
							<div class="span3"><a href="/%D0%BC%D0%B0%D0%B3%D0%B0%D0%B7%D0%B8%D0%BD-4/"><img src="/wp-content/uploads/2013/11/our_works_71-150x150.jpg" alt=""></a></div>
						</div>
					</article>					
				<?php endwhile; // end of the loop. ?>										

			</aside><!-- content-wrap end -->	
<? get_footer(); ?>	