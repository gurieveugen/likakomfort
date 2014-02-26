<?php 
/**
 * Template name: Сравнить
 */
?>
<? get_header(); ?>
			<aside class="content-wrap">				
				<?php 
				if(is_active_sidebar('sidebar_right'))
				{
					dynamic_sidebar('sidebar_right');
				}
				the_post();	
				?>
				<?php 				
				if(isset($_GET['c1']) && isset($_GET['c2']))
				{
					$first  = intval($_GET['c1']);
					$second = intval($_GET['c2']);
					$back_path = (isset($_GET['p'])) ? $_GET['p'] : "/";
					if($first > 0 && $second > 0)
					{
				?>
					<div class="compare">
						<div class="row-fluid"><a href="<?php echo $back_path; ?>" class="btn-back" style="float: left; margin-bottom: 30px;">Повернутися</a></div>
						<h4><?php the_title(); ?></h4>
						<div class="row-fluid" style="margin-bottom: 20px;">
							<div class="span6">
								<?php echo get_the_post_thumbnail($first); ?>															
							</div>
							<div class="span6">
								<?php echo get_the_post_thumbnail($second); ?>															
							</div>
						</div>
						<div class="row-fluid">
							<div class="span6"><a href="<?php echo get_permalink($first); ?>"><?php echo get_the_title($first); ?></a></div>
							<div class="span6"><a href="<?php echo get_permalink($second); ?>"><?php echo get_the_title($second); ?></a></div>
						</div>
						<div class="row-fluid">
							<div class="shadow-bottom"></div>
						</div>
						<div class="row-fluid" style="margin-bottom: 60px;">
							
							<?php get_two_specifications($first, $second); ?>
						</div>						
						<div class="row-fluid" style="margin-bottom: 60px;">
							<div class="span2 text-left">Вартість</div>
							<div class="span10">
								<div class="span6"><b class="base-color-text"><?php echo get_post_meta($first, 'price', 1); ?></b></div>
								<div class="span6"><b class="base-color-text"><?php echo get_post_meta($second, 'price', 1); ?></b></div>
							</div>
						</div>		
						<div class="row-fluid" >
							<div class="span2 text-left"></div>
							<div class="span10">
								<div class="span6"><button onclick="buy(<?php echo $first; ?>)">Придбати</button></div>
								<div class="span6"><button onclick="buy(<?php echo $second; ?>)">Придбати</button></div>
							</div>
						</div>						
					</div>					
				<?php
					}
				}
				?>
			</aside><!-- content-wrap end -->	
<? get_footer(); ?>	