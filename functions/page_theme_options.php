<?php

/**
 * Create new sub menu on Appearance page
 */
add_action('admin_menu', 'omr_create_menu');
function omr_create_menu() 
{	
	add_submenu_page( 'themes.php', 'Опції', 'Опції', 'administrator', __FILE__, 'omr_settings_page', 'favicon.ico' );
	add_action( 'admin_init', 'register_mysettings' );
}

/**
 * Register our settings
 */
function register_mysettings() 
{
	register_setting('lika_group', 'l_phone');	
	register_setting('lika_group', 'l_mob');
	register_setting('lika_group', 'l_address');
	register_setting('lika_group', 'l_lat');
	register_setting('lika_group', 'l_lng');

}
/**
 * Show Theme options page on WP Admin
 */
function omr_settings_page() 
{
?>
	<div class="wrap">		
		<form method="post" action="options.php">
			<h2><?php _e('Основні налаштування'); ?></h2>
			<?php settings_fields('lika_group'); ?>			
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php _e('Телефон:'); ?></th>
					<td><input type="text" name="l_phone" value="<?php echo get_option('l_phone')?>"></td>	
				</tr>		
				<tr valign="top">
					<th scope="row"><?php _e('Мобильный:'); ?></th>
					<td><input type="text" name="l_mob" value="<?php echo get_option('l_mob')?>"></td>	
				</tr>	
				<tr valign="top">
					<th scope="row"><?php _e('Адреса:'); ?></th>					
					<td><textarea name="l_address" id="l_address" cols="18" rows="5"><?php echo get_option('l_address')?></textarea></td>
				</tr>	
			</table>			
			<h2><?php _e('Google Налаштування'); ?></h2>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php _e('Lat:'); ?></th>
					<td><input type="text" name="l_lat" value="<?php echo get_option('l_lat')?>"></td>	
				</tr>		
				<tr valign="top">
					<th scope="row"><?php _e('Lng:'); ?></th>
					<td><input type="text" name="l_lng" value="<?php echo get_option('l_lng')?>"></td>	
				</tr>
				
			</table>	

			<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
			</p>
		</form>
	</div>	
<? 
}  