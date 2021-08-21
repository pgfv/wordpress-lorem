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
            <section class="grid grid-cols-2 md:grid-cols-3 gap-5">
				<?php while ( have_posts() ): the_post(); ?>
                    <article class="article-box">
                        <a href="<?php the_permalink(); ?>">
							<?php the_post_thumbnail(); ?>
							<?php the_title(); ?>
                        </a>
                    </article>
				<?php endwhile; ?>
            </section>
		<?php else: ?>
            <p>Sorry, no posts matched your criteria.</p>
		<?php endif; ?>
    </section>
    <aside class="main-aside">
		<?php dynamic_sidebar( 'primary' ); ?>
    </aside>
</section>
<?php get_footer(); ?>
