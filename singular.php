<?php get_header(); ?>
<section class="content-container" role="main">
  <section class="main-content">
    <?php if (function_exists('yoast_breadcrumb')) : ?>
      <section class="mb-10">
        <?php yoast_breadcrumb('<nav class="breadcrumb">', '</nav>'); ?>
      </section>
    <?php elseif (function_exists('aioseo_breadcrumbs')) : ?>
      <section class="mb-10">
        <?php aioseo_breadcrumbs(); ?>
      </section>
    <?php endif; ?>

    <h1 class="entry-title"><?php the_title(); ?></h1>

    <?php the_content(); ?>

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