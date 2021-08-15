<?php get_header(); ?>
<section class="flex flex-col md:flex-row divide-x divide-gray-300">
    <section class="md:w-3/4 prose max-w-none md:pr-5">
		<?php
		if ( function_exists( 'aioseo_breadcrumbs' ) ) {
			aioseo_breadcrumbs();
		} ?>

		<?php the_content(); ?>
		<?php edit_post_link(); ?>
    </section>
    <aside class="md:w-1/4 mt-10 md:mt-0 md:pl-5">
		<?php dynamic_sidebar( 'primary' ); ?>
    </aside>
</section>
<?php get_footer(); ?>
