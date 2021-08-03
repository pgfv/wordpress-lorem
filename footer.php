</main>
<footer class="footer-content mt-5 pt-5 pb-20 md:pb-5"
        style="background-color:<?php echo get_theme_mod( 'footer_color_setting' ) ?>;">
    <section class="flex flex-col md:flex-row md:space-x-10 mb-5 main-container">
        <div class="md:w-1/3 xl:w-1/4 mb-5 md:mb-0">
			<?php the_custom_logo(); ?>
        </div>
        <div class="md:w-1/3 xl:w-2/4">
            <h3 class="text-3xl mb-5"><?php echo get_theme_mod( 'footer_head_setting' ); ?></h3>
            <p><?php echo get_theme_mod( 'footer_content_setting' ); ?></p>
        </div>
        <div class="md:w-1/3 xl:w-1/4">
			<?php dynamic_sidebar( 'footer' ); ?>
        </div>
    </section>

    <p class="text-center text-xs pt-3 md:text-sm"><?php echo get_theme_mod( 'copyright_text_setting' ) ?></p>

    <section class="mobile-menu fixed bottom-0 py-5 container md:hidden"
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