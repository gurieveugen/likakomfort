			<div class="clearfix"></div>
			<footer>
				<a href="/"><h1 class="logo2">Lika</h1></a>
				<span>		
					<div class="row-fluid">© Інтернет-магазин "Ліка комфорт" 2007-2014</div>
					<div class="row-fluid">
						<div class="span4">
							<a href="#">График работи Call-центра</a>
							Пн-Пт: з 8:00 до 18:00 <br>
							Суббота: с 9:00 до 15:00 <br>
							Воскресенье с 10:00 до 15:00 
						</div>
						<div class="span4"></div>
						<div class="span4"></div>
					</div>			
					<?php echo get_bloginfo("description").' '.get_option('l_address').'<br> тел.:'.get_option('l_phone').' моб.:'.get_option('l_mob'). ', email:'.get_bloginfo('admin_email'); ?>							
				</span>
			</footer>
		</section><!-- main-content end -->

		<!-- Modal dialogs START -->
		<div id="modal_add_product" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3 id="myModalLabel">Товар додано в кошик!</h3>
			</div>
			<div class="modal-body">
				<p>Товар додано в кошик! Перейти в неї?</p>
			</div>
			<div class="modal-footer">
				<button class="" data-dismiss="modal" aria-hidden="true">Закрити</button>
				<button class="" onclick="window.open('/cart');">Перейти в кошик</button>
			</div>
		</div>
		<div id="modal_compare" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3 id="myModalLabel">Порівняти товари</h3>
			</div>
			<div class="modal-body">
				<p>Хочете порівняти товари?</p>
			</div>
			<div class="modal-footer">
				<button class="" data-dismiss="modal" aria-hidden="true">Закрити</button>
				<button class="" href="" id="compare-button">Порівняти товари</button>
			</div>
		</div>
		<!-- Modal dialogs END -->
		<!-- BEGIN JIVOSITE CODE {literal} -->
		<script type='text/javascript'>
		(function(){ var widget_id = '99132';
		var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);})();</script>
		<!-- {/literal} END JIVOSITE CODE --> 
	</body>
</html>