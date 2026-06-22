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

    <h1><?php single_cat_title('Category: '); ?></h1>
    <?php if (have_posts()) : ?>
      <section class="grid grid-cols-2 md:grid-cols-3 gap-5">
        <?php while (have_posts()) : the_post(); ?>
          <article class="article-box">
            <a href="<?php the_permalink(); ?>">
              <?php the_post_thumbnail('medium', array('alt' => the_title_attribute(array('echo' => false)))); ?>
              <h2 class="article-title"><?php the_title(); ?></h2>
            </a>
          </article>
        <?php endwhile; ?>
      </section>
      <?php the_posts_pagination(array(
        'mid_size'  => 2,
        'prev_text' => __('&laquo; Previous', 'lorem'),
        'next_text' => __('Next &raquo;', 'lorem'),
      )); ?>
    <?php else : ?>
      <p>Sorry, no posts matched your criteria.</p>
    <?php endif; ?>
  </section>
  <aside class="main-aside">
    <?php dynamic_sidebar('primary'); ?>
  </aside>
</section>
<?php get_footer(); ?>