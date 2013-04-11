<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width" />

	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); ?>

	<title><?php tangerine_title(); ?></title>

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<!-- BEGIN #wrapper -->
	<div id="wrapper" class="row <?php echo get_theme_mod('tangerine_page_width'); ?> <?php echo get_theme_mod('tangerine_sidebar'); ?> <?php echo get_theme_mod( 'tangerine_slider_mode' ); ?>">

		<?php top_menu(); ?>

		<?php if( is_front_page() && get_theme_mod( 'tangerine_slider_mode' ) == 'full-slider' ) { tangerine_header(); home_slider(); } ?>

		<?php if( !is_front_page() && get_theme_mod( 'tangerine_slider_mode' ) == 'full-slider' ) { tangerine_header(); } ?>

		<!-- BEGIN #main-area -->
		<div id="main-area">

			<?php if( !is_front_page() && get_theme_mod( 'tangerine_slider_mode' ) == 'auto-slider' ) { tangerine_header(); } ?>

			<?php if( !is_front_page() ) { main_menu(); } ?>

			<?php if( is_front_page() && get_theme_mod( 'tangerine_slider_mode' ) == 'full-slider' ) { main_menu(); } ?>

			<?php if( is_front_page() && get_theme_mod( 'tangerine_slider_mode' ) == 'auto-slider' ) { tangerine_header(); main_menu(); home_slider(); } ?>

			<!-- BEGIN #main -->
			<div id="main">
