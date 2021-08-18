<?php get_header(); ?>
<section class="content-container" role="main">
    <section class="main-content">
		<?php if ( function_exists( 'aioseo_breadcrumbs' ) ) : ?>
            <section class="mb-10">
				<?php aioseo_breadcrumbs(); ?>
            </section>
		<?php endif; ?>

        <h1><?php single_cat_title( 'Category: ' ); ?></h1>
		<?php if ( have_posts() ): ?>
            <ul>
				<?php while ( have_posts() ): the_post(); ?>
                    <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
				<?php endwhile; ?>
            </ul>
		<?php else: ?>
            <p>Sorry, no posts matched your criteria.</p>
		<?php endif; ?>
    </section>
    <aside class="main-aside">
		<?php dynamic_sidebar( 'primary' ); ?>
    </aside>
</section>
<?php get_footer(); ?>
