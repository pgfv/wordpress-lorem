<?php get_header(); ?>
<section class="content-container" role="main">
    <section class="main-content">
		<?php if ( function_exists( 'aioseo_breadcrumbs' ) ) : ?>
            <section class="mb-10">
				<?php aioseo_breadcrumbs(); ?>
            </section>
		<?php endif; ?>

		<?php the_content(); ?>

        <nav class="flex flex-row justify-between">
            <div><?php previous_post_link( '&laquo; %link' ); ?></div>
            <div><?php next_post_link( '%link &raquo;' ); ?></div>
        </nav>
		<?php edit_post_link(); ?>
    </section>
    <aside class="main-aside">
		<?php dynamic_sidebar( 'primary' ); ?>
    </aside>
</section>
<?php get_footer(); ?>
