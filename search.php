<?php get_header(); ?>
<section class="content-container" role="main">
  <section class="main-content">
    <h1><?php printf( esc_html__( 'Search results for: %s', 'lorem' ), '<span>' . get_search_query() . '</span>' ); ?></h1>

    <?php if ( have_posts() ) : ?>
      <section class="grid grid-cols-2 md:grid-cols-3 gap-5 mt-5">
        <?php while ( have_posts() ) : the_post(); ?>
          <article class="article-box">
            <a href="<?php the_permalink(); ?>">
              <?php the_post_thumbnail( 'medium', array( 'alt' => the_title_attribute( array( 'echo' => false ) ) ) ); ?>
              <h2 class="article-title"><?php the_title(); ?></h2>
            </a>
          </article>
        <?php endwhile; ?>
      </section>
      <?php the_posts_pagination( array(
        'mid_size'  => 2,
        'prev_text' => __( '&laquo; Previous', 'lorem' ),
        'next_text' => __( 'Next &raquo;', 'lorem' ),
      ) ); ?>
    <?php else : ?>
      <p><?php esc_html_e( 'Sorry, no results matched your search.', 'lorem' ); ?></p>
    <?php endif; ?>
  </section>
  <aside class="main-aside">
    <?php dynamic_sidebar( 'primary' ); ?>
  </aside>
</section>
<?php get_footer(); ?>
