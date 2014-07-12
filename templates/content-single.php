<?php while (have_posts()) : the_post(); ?>
  <article <?php post_class(); ?>>
    <header>



    <div class="featuredimage">
    <time class="published" datetime="<?php echo get_the_time('c'); ?>"><?php echo get_the_date('d') . "<br>" . get_the_date('M'); ?></time>
       <?php echo get_the_post_thumbnail($post->ID, 'large'); ?>
    </div>

    <h2 class="entry-title"><?php the_title(); ?></h2>
      <?php get_template_part('templates/entry-meta'); ?>
    </header>
    <div class="entry-content">
      <?php the_content(); ?>
    </div>
    <div class="navitems">
      <?php wp_link_pages(array('before' => '<nav class="page-nav"><p>' . __('Pages:', 'roots'), 'after' => '</p></nav>')); ?>
    </div>
    <?php // comments_template('/templates/comments.php'); ?>
  </article>
<?php endwhile; ?>
