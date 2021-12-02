<?php get_header(); ?>
<section class="content-container" role="main">
  <section class="main-content">
    <?php if (function_exists('aioseo_breadcrumbs')) : ?>
      <section class="mb-10">
        <?php aioseo_breadcrumbs(); ?>
      </section>
    <?php endif; ?>

    <?php the_content(); ?>

    <address class="flex flex-col space-y-3 mt-5 text-sm uppercase">
      <div>Published: <time><?php echo get_the_date('F j, Y'); ?></time> By <?php the_author_meta('display_name', 1); ?></div>
      <?php
      $u_time = get_the_time( 'U' );
      $u_modified_time = get_the_modified_time( 'U' );
      
      if ( $u_modified_time >= $u_time + 86400 ) : ?>
      <div>Last modified on <time><?php the_modified_time( 'F j, Y' ); ?></time></div>
      <?php endif; ?>
    </address>

    <nav class="flex flex-row justify-between mt-5">
      <div><?php previous_post_link('&laquo; %link'); ?></div>
      <div><?php next_post_link('%link &raquo;'); ?></div>
    </nav>
    <?php edit_post_link(); ?>
  </section>
  <aside class="main-aside">
    <?php dynamic_sidebar('primary'); ?>
  </aside>
</section>
<?php get_footer(); ?>