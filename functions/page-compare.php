<?php 
/**
 * Template name: Compare
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
				<?php 
				var_dump($_GET);
				if(isset($_GET['first']) && isset($_GET['second']))
				{
					$first  = intval($_GET['first']);
					$second = intval($_GET['second']);
					if($first > 0 && $second > 0)
					{
				?>
					<div class="row-fluid">
						<div class="span6">
							<?php echo get_the_post_thumbnail($first); ?>
						</div>
						<div class="span6">
							<?php echo get_the_post_thumbnail($second); ?>
						</div>
					</div>
				<?php
					}
				}
				?>
			</aside><!-- content-wrap end -->	
<? get_footer(); ?>	