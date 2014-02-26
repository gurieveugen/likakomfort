<?php 

$script = "";

$title = get_bloginfo('name'); 
if(is_front_page())
{
	$title.= " | ".get_bloginfo('description');
	$script = "<script>jQuery( document ).ready(function(){ jQuery('#menu-item-77').addClass('current-menu-item')});</script>";
}
else
{
	$title.= wp_title(' | ', false);
}

$term = get_queried_object();


if(isset($_SESSION["style_url"]))
{
	if(get_father_category($term->term_id) == 3  && $term->taxonomy == "category")
	{
		$_SESSION["style_url"] = get_bloginfo('template_url')."/blue.css";
	}
	else if(get_father_category($term->term_id) == 4  && $term->taxonomy == "category")
	{
		$_SESSION["style_url"] = get_bloginfo('template_url')."/brown.css";
	}
}
else
{
	$_SESSION["style_url"] = get_bloginfo('template_url')."/brown.css";
}


?> 
<!DOCTYPE html>
	<html>
	<head>
			<meta charset="utf-8">
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<title><?php echo $title; ?></title>

			<link rel="stylesheet" href="<?php echo $_SESSION["style_url"]; ?>">
			<link rel="stylesheet" href="<?php echo get_bloginfo('stylesheet_url'); ?>">
			<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/skins/tango/skin.css">
			<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" type="text/css" media="screen" />
			<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" type="text/css" media="screen" />
			<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
			<? wp_enqueue_script('jquery'); ?>
			<? wp_head(); ?>
			<script src="<?php bloginfo('template_url'); ?>/js/bootstrap.min.js"></script>
			<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
			<script src="<?php bloginfo('template_url'); ?>/js/lika.js"></script>
			<script src="<?php bloginfo('template_url'); ?>/js/jquery.jcarousel.min.js"></script>
			<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>
			<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
			<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>
			<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>
			<script>
				var map;
				function initialize() 
				{
				  var mapOptions = 
				  {
				    zoom: 18,
				    center: new google.maps.LatLng(<?php echo get_option('l_lat').', '.get_option('l_lng'); ?>),
				    disableDefaultUI: true,
				    mapTypeId: google.maps.MapTypeId.ROADMAP
				  };
				  map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

				  var image = '<?php bloginfo('template_url'); ?>/img/pointer.png';
				  var myLatLng = new google.maps.LatLng(<?php echo get_option('l_lat').', '.get_option('l_lng'); ?>);
				  var beachMarker = new google.maps.Marker({
				  position: myLatLng,
				  map: map,
				  icon: image
				  }); 
				}
			</script>
			<?php echo $script; ?>

	</head>
	<body>
		<section class="main-content">
			<a href="/cart">
			<div class="block-cart">				
				<span>В кошику</span>
				<b class="total-sum"><?php echo get_total_sum() ?> грн</b>
			</div><!-- block-cart end -->
			</a>
			<header>
				<a href="/"><h1 class="logo">Lika</h1></a>	
				<nav class="nav-line">
				<?php 
				wp_nav_menu(array(
				  'menu'            => 'main',
				  'container'       => 'ul',
				  'menu_class' => 'main-menu'
				  )); 
				?>
				</nav>			
			</header>
			<aside class="sidebar-left">
				<?php 
				wp_nav_menu(array(
					'menu'       => 'LeftMenu',
					'container'  => 'ul',
					'menu_class' => 'left-menu'
				  )); 
				?>
				
				<?php 
				if(is_active_sidebar('sidebar_left'))
				{
					dynamic_sidebar('sidebar_left');
				}		
				?>									
			</aside><!-- sidebar-left end -->	