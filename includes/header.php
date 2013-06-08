<?php

if ( !function_exists( 'tangerine_header' ) ) {

	function tangerine_header() { ?>

		<?php if ( get_theme_mod( 'show_header' ) == '1' ): ?>
			<div id="header">

				<div class="header-bar">

					<?php if ( get_theme_mod( 'show_header_image' ) == '1' && get_theme_mod( 'set_header_image' ) != '' ): ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo">
							<img src="<?php echo get_theme_mod( 'set_header_image' ); ?>" alt="<?php bloginfo( 'name' ); ?>" />
						</a>
					<?php endif; ?>

					<?php if ( get_theme_mod( 'show_header_title' ) == '1' ): ?>
						<h1 class="name">
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
						</h1>
					<?php endif; ?>

					<?php if ( get_theme_mod( 'show_header_tagline' ) == '1' ): ?>
						<h2 class="description"><small> <?php bloginfo( 'description' ); ?></small></h2>
					<?php endif; ?>

				</div>

			</div>
		<?php endif; ?>

	<?php }

}

if ( !function_exists( 'get_tangerine_header' ) ) {

	function get_tangerine_header() {
		$header_mode = get_theme_mod( 'set_header_mode' );
		$mm_pos = get_theme_mod( 'set_main_menu_pos' );

		get_top_menu();
		if ( $header_mode == 'contained-header' ) { echo '<div class="header-container">'; }
		tangerine_header();
		if ( $header_mode == 'auto-header' ) { echo '<div id="main-area">'; }
		if ( $mm_pos == 'above-slider' ) { get_main_menu(); }
		if ( is_front_page() || get_theme_mod( 'show_slider_always' ) == '1' || is_home() ) { tangerine_home_slider(); }
		if ( $mm_pos == 'below-slider' ) { get_main_menu(); }
		if ( $header_mode == 'contained-header' ) { echo '</div><div id="main-area">'; }
	}

}

?>
