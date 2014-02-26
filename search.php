<? get_header(); ?>
<aside class="content-wrap">				
	<?php 
	if(is_active_sidebar('sidebar_right'))
	{
		dynamic_sidebar('sidebar_right');
	}	
	?>
	<article >
	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : the_post(); ?>
			
				<h4><?php the_title() ?></h4>
				<?php echo get_the_post_thumbnail(get_the_ID(), 'thumb', array('class' => 'pull-left')) ?>
				<?php the_content(); ?>	
				<div class="clearfix"></div>					
				<hr>
			
		<?php endwhile; // end of the loop. ?>		
	<?php else : ?>

		<article id="post-0" class="post no-results not-found">
			<header class="entry-header">
				<h1 class="entry-title"><?php _e( 'Нічого не знайдено'); ?></h1>
			</header>

			<div class="entry-content">
				<p><?php _e( 'Вибачте, але нічого не відповідають критеріям пошуку. Будь ласка, спробуйте ще раз з деякими інші ключові слова.'); ?></p>
				<?php get_search_form(); ?>
			</div><!-- .entry-content -->
		</article><!-- #post-0 -->

	<?php endif; ?>	
	</article>
</aside><!-- content-wrap end -->	
<? get_footer(); ?>	
