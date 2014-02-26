<? get_header(); ?>
<?php 

global $post;
$terms = wp_get_post_terms($post->ID, 'owscat');
$link  = get_term_link($terms[0]->name, 'owscat'); 

?>
<aside class="content-wrap">	
<article>

<a class="btn-back" href="<?php echo $link; ?>">Повернутися</a>
<?php 
if(is_active_sidebar('sidebar_right'))
{
	dynamic_sidebar('sidebar_right');
}		
?>				
<?php while ( have_posts() ) : the_post(); ?>	
<h2><?php the_title(); ?></h2>
<small><?php the_date(); ?></small>
<div class="image-center">
	<?php echo get_the_post_thumbnail(get_the_ID(), 'full') ?>
</div>
<div class="row-fluid">
	<nav class="thumbs">
		<?php echo get_carousel_arr(get_all_images_from_post(get_the_ID())); ?>
		<div class="thumbs-controls">
			<a class="prev-image" href="#" onclick="jQuery('#mycarousel').jcarousel('prev'); return false;"></a>
			<a class="next-image" href="#" onclick="jQuery('#mycarousel').jcarousel('next'); return false;"></a>
		</div>
	</nav>
	
</div>	
<?php the_content(); ?>	
			<aside class="comments">
				
				<?php comments_template( '', true ); ?>	
			</aside>	
							
		</article>				

		

	<?php endwhile; // end of the loop. ?>										

</aside><!-- content-wrap end -->	
<? get_footer(); ?>