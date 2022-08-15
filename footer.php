</main>
<footer class="mt-5 pt-5 pb-20 md:pb-5 main-footer">
    <section class="footer-content flex flex-col md:flex-row md:space-x-10 mb-5 main-container">
		<?php $widget_style = LoremTheme::footer_widget_style(); ?>

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

    <div class="text-center text-xs pt-3 copyright"><?php echo get_theme_mod( 'copyright_text_setting' ) ?></div>

	<?php if ( get_theme_mod( 'footer_mobile_menu_enable_setting', true ) ) : ?>
        <section class="mobile-menu fixed bottom-0 py-5 w-full md:hidden"
                 style="background-color: <?php echo get_theme_mod( 'footer_mobile_color_setting' ); ?>;">
			<?php $mobile_menu = LoremTheme::menu_with_count( 'mobile_menu' ); ?>
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