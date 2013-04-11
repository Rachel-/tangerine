			</div>
			<!-- END #main -->

		</div>
		<!-- END #main-area -->

		<!-- BEGIN #footer-area -->
		<div id="footer-area">

			<div id="footer-widgets">
				<ul class="widgets small-block-grid-2 large-<?php echo get_theme_mod('tangerine_footer_widgets'); ?>">
					<?php if ( is_active_sidebar( 'footer-area' ) ) dynamic_sidebar( 'footer-area' ); ?>
				</ul>
			</div>

			<?php get_template_part( 'includes/nav/footer', 'menu' ); ?>

			<div id="credits">
				<div class="credits-inner">
					<span id="copyright" class="left">&copy; <?php the_date( 'Y' ); ?> <?php bloginfo( 'name' ); ?>. <?php _e( 'All rights reserved.', TANGERINE_TEXTDOMAIN ); ?></span>

					<?php if( get_theme_mod( 'design_by' ) == '' ): ?>
						<span id="design-by"class="right"><?php _e( 'Powered by', TANGERINE_TEXTDOMAIN ); ?> <a href="<?php echo wp_get_theme()->get( 'ThemeURI' ); ?>" target="_blank"><?php echo wp_get_theme()->Name; ?></a></span>
					<?php else: ?>
						<span id="design-by"class="right"><?php echo get_theme_mod( 'design_by' ); ?></span>
					<?php endif; ?>
				</div>
			</div>

		</div>
		<!-- END #footer-area -->

	</div>
	<!-- END #wrapper -->

	<!-- BEGIN wp_footer -->
	<?php wp_footer(); ?>
	<!-- END wp_footer -->

</body>
</html>
