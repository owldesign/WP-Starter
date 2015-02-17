<!DOCTYPE html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" />
<link rel="shortcut icon" type="image/png" href="<?php bloginfo('template_url'); ?>/favicon.png" />
<title>
	<?php bloginfo('name'); ?> | 
	<?php is_front_page() ? bloginfo('description') : wp_title(''); ?>
</title>

<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<header id="masthead" class="site-header" role="banner">
		<div class="container center">
		
			<nav role="navigation" class="site-navigation main-navigation">
				<?php wp_nav_menu(array('theme_location' => 'primary')); ?>
			</nav>
		</div>
		<div class="center">

			<div id="brand">
				<h1 class="site-title">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo('name', 'display')); ?>" rel="home"><?php bloginfo('name'); ?></a>
				</h1>
				<h4 class="site-description">
					<?php bloginfo( 'description' ); ?>
				</h4>
			</div>
			
		</div>
	</header>

