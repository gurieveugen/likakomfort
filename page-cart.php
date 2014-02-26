<?php 
/**
 * Template name: Cart
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
				<span class="cart-title"><?php the_title() ?></span>
					<div class="cart-table">
						<?php echo get_all_products_cart() ?>
					</div>
					
					<a class="btn-remove-all" href="#" onclick="cancel_all_buys()">Видалити все</a>
					<form class="form-order" onsubmit="send_order(); return false;">
						<b>Замовити</b>
						<input type="text" placeholder="Ваше ім'я" name="fullname" required>
						<input type="email" placeholder="Ваше емейл" name="email" class="pull-right" required>
						<textarea placeholder="Контакти" rows="10" cols="60" id="contacts" name="contacts"></textarea>
						<button type="submit">Надіслати</button>
					</form>
				</article>
			</aside><!-- content-wrap end -->	
<? get_footer(); ?>	asdfasdf