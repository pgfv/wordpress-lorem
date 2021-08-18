<?php get_header(); ?>
<section class="content-container">
    <section class="main-content">
		<?php the_content(); ?>
		<?php edit_post_link(); ?>
    </section>
    <aside class="main-aside">
		<?php dynamic_sidebar( 'primary' ); ?>
    </aside>
</section>
<?php get_footer(); ?>
