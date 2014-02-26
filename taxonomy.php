<? get_header(); ?>
<aside class="content-wrap">				
	<?php 
	if(is_active_sidebar('sidebar_right'))
	{
		dynamic_sidebar('sidebar_right');
	}	
	?>
	<article >
		<?php while ( have_posts() ) : the_post(); ?>
			
				<h4><a href="<?php echo get_permalink(); ?>"><?php the_title() ?></a></h4>
				<a href="<?php echo get_permalink(); ?>"><?php echo get_the_post_thumbnail(get_the_ID(), 'thumb', array('class' => 'pull-left')) ?></a>
				<div class="article-content">
					<?php the_content(); ?>		
				</div>
				<div class="clearfix"></div>					
				<hr>
			
		<?php endwhile; // end of the loop. ?>			
	</article>
</aside><!-- content-wrap end -->	
<? get_footer(); ?>	