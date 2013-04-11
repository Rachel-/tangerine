<?php

	function top_menu() { ?>

		<?php if( get_theme_mod( 'show_top_menu' ) == '1' || get_theme_mod( 'show_main_menu' ) == '1' ): ?>
			<div id="top-area" <?php if ( get_theme_mod('show_top_menu') == '') { echo 'class="show-for-small"'; } ?>>
				<nav id="top-menu" class="top-bar">
					<ul class="title-area">
						<!-- Title Area -->
						<li class="name">
							<?php if( get_theme_mod('top_bar_title') == '1' ): ?>
								<h1 id="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
							<?php endif; ?>
						</li>
						<!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
						<li class="toggle-topbar menu-icon">
							<a href="#"><span><?php _e( 'Menu', TANGERINE_TEXTDOMAIN ); ?></span></a>
						</li>
					</ul>

					<?php if( get_theme_mod( 'show_top_menu' ) == '1' ): ?>
						<section class="top-bar-section">
							<?php tangerine_top_menu_bar(); ?>
						</section>
					<?php endif; ?>

					<?php if( get_theme_mod( 'show_main_menu' ) == '1' ): ?>
						<section class="main-bar-section show-for-small">
							<?php tangerine_main_menu_bar(); ?>
						</section>
					<?php endif; ?>

				</nav>
			</div>
		<?php endif; ?>

	<?php }

	function main_menu() { ?>

		<?php if( get_theme_mod( 'show_main_menu' ) == '1' ): ?>
			<div id="main-menu" class="hide-for-small">
				<nav class="main-bar" data-hide="<?php if( get_theme_mod('show_main_menu') == '1' ) { echo 'false'; } else { echo 'true'; } ?>">
					<section class="main-bar-section">
						<?php tangerine_main_menu_bar(); ?>
					</section>
				</nav>
			</div>
		<?php endif ?>

	<?php }

	function footer_menu() { ?>

		<?php if( get_theme_mod( 'show_footer_menu' ) == '1' ): ?>
			<div id="footer-menu">
				<div class="footer-menu-inner">
					<nav class="footer-bar">
						<section class="footer-bar-section">
							<?php tangerine_footer_menu_bar(); ?>
						</section>
					</nav>
				</div>
			</div>
		<?php endif; ?>

	<?php }

?>