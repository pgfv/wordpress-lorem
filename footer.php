</main>
<footer class="mt-5 pt-5 pb-20 md:pb-5"
        style="<?php echo footer_background(); ?>">
    <section class="footer-content flex flex-col md:flex-row md:space-x-10 mb-5 main-container">
		<?php $widget_style = footer_widget_style(); ?>

        <div class="<?php echo $widget_style[1]; ?>">
			<?php dynamic_sidebar( 'footer' ); ?>
        </div>
        <div class="<?php echo $widget_style[2]; ?>">
			<?php dynamic_sidebar( 'footer_2' ); ?>
        </div>

		<?php if ( $widget_style[0] >= 3 ) : ?>
            <div class="<?php echo $widget_style[3]; ?>">
				<?php dynamic_sidebar( 'footer_3' ); ?>
            </div>
		<?php endif; ?>

		<?php if ( $widget_style[0] == 4 ) : ?>
            <div class="md:w-1/4">
				<?php dynamic_sidebar( 'footer_4' ); ?>
            </div>
		<?php endif; ?>
    </section>

	<?php if ( get_theme_mod( 'footer_logo_setting', false ) && function_exists( 'has_custom_logo' ) && has_custom_logo() ) :
		$logo_align_classes = array(
			'left'   => 'mr-auto',
			'center' => 'mx-auto',
			'right'  => 'ml-auto',
		);
		$logo_align = get_theme_mod( 'footer_logo_align_setting', 'center' );
		$logo_align = isset( $logo_align_classes[ $logo_align ] ) ? $logo_align_classes[ $logo_align ] : 'mx-auto';
		$logo_width = get_theme_mod( 'footer_logo_width_setting', '160px' );
		?>
        <div class="footer-logo <?php echo $logo_align; ?> mb-4"
             style="width:<?php echo esc_attr( $logo_width ); ?>;">
			<?php the_custom_logo(); ?>
        </div>
	<?php endif; ?>

    <div class="text-center text-xs pt-3 copyright"><?php echo get_theme_mod( 'copyright_text_setting' ) ?></div>

	<?php if ( get_theme_mod( 'footer_mobile_menu_enable_setting', true ) ) : ?>
        <section class="mobile-menu fixed bottom-0 py-5 w-full md:hidden"
                 style="background-color: <?php echo get_theme_mod( 'footer_mobile_color_setting' ); ?>;">
			<?php $mobile_menu = mobile_menu(); ?>
            <nav class="flex flex-row justify-evenly text-gray-300 text-sm px-3">
				<?php echo $mobile_menu[0] ?>
            </nav>
        </section>
	<?php endif ?>
</footer>
</section>
<!-- /wrapper -->

<?php wp_footer(); ?>
</body>
</html>