<?php get_header(); ?>
<section class="main-content flex flex-col md:flex-row md:divide-x md:divide-gray-300">
    <section class="md:w-3/4 prose max-w-none md:pr-5">
		<?php if ( function_exists( 'aioseo_breadcrumbs' ) ) : ?>
            <section class="mb-10">
				<?php aioseo_breadcrumbs(); ?>
            </section>
		<?php endif; ?>

		<?php the_content(); ?>
		<?php edit_post_link(); ?>
    </section>
    <aside class="md:w-1/4 mt-10 md:mt-0 md:pl-5">
		<?php dynamic_sidebar( 'primary' ); ?>
    </aside>
</section>
<?php get_footer(); ?>
