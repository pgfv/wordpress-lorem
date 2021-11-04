<?php get_header(); ?>
<section class="content-container" role="main">
    <section class="main-content">
		<?php if ( function_exists( 'aioseo_breadcrumbs' ) ) : ?>
            <section class="mb-10">
				<?php aioseo_breadcrumbs(); ?>
            </section>
		<?php endif; ?>

		<?php the_content(); ?>

        <address class="flex flex-row space-x-3 mt-5">
            <div>Author: <?php the_author_meta( 'display_name', 1 ); ?></div>
            <div>Date: <?php echo get_the_date(); ?></div>
        </address>

        <nav class="flex flex-row justify-between mt-5">
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
