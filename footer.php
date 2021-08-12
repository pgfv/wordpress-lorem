</main>
<footer class="footer-content mt-5 pt-5 pb-20 md:pb-5"
        style="background-color:<?php echo get_theme_mod( 'footer_color_setting' ) ?>;">
    <section class="flex flex-col md:flex-row md:space-x-10 mb-5 main-container">
		<?php
		$column   = get_theme_mod( 'footer_column_setting' );
		$column_1 = 'md:w-1/3';
		$column_2 = 'md:w-1/3';
		$column_3 = 'md:w-1/3';

		if ( $column == 3 ) {
			// check layout
			$layout = get_theme_mod( 'footer_3_columns_layout_setting' );
			switch ( $layout ) {
				case '1|1|2':
					$column_1 = 'md:w-1/4';
					$column_2 = 'md:w-1/4';
					$column_3 = 'md:w-2/4';
					break;
				case '1|2|1':
					$column_1 = 'md:w-1/4';
					$column_2 = 'md:w-2/4';
					$column_3 = 'md:w-1/4';
					break;
				case '2|1|1':
					$column_1 = 'md:w-2/4';
					$column_2 = 'md:w-1/4';
					$column_3 = 'md:w-1/4';
					break;
			}
		}
		?>

        <div class="<?php echo $column_1; ?>">
			<?php dynamic_sidebar( 'footer' ); ?>
        </div>
        <div class="<?php echo $column_2; ?>">
			<?php dynamic_sidebar( 'footer_2' ); ?>
        </div>

		<?php if ( $column >= 3 ) : ?>
            <div class="<?php echo $column_3; ?>">
				<?php dynamic_sidebar( 'footer_3' ); ?>
            </div>
		<?php endif; ?>

		<?php if ( $column == 4 ) : ?>
            <div class="md:w-1/4">
				<?php dynamic_sidebar( 'footer_4' ); ?>
            </div>
		<?php endif; ?>
    </section>

    <div class="text-center text-xs pt-3"><?php echo get_theme_mod( 'copyright_text_setting' ) ?></div>

    <section class="mobile-menu fixed bottom-0 py-5 w-full md:hidden"
             style="background-color: <?php echo get_theme_mod( 'footer_mobile_color_setting' ); ?>;">
		<?php $mobile_menu = mobile_menu(); ?>
        <nav class="flex flex-row justify-evenly text-gray-300 text-sm px-3">
			<?php echo $mobile_menu[0] ?>
        </nav>
    </section>
</footer>
</section>
<!-- /wrapper -->

<?php wp_footer(); ?>
</body>
</html>