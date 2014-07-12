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
      <div class="articlesocial">
        <a class='btn' href="<?php echo site_url(); ?>news">Back</a>

        <ul class="rrssb-buttons">

        <?php if(get_field('twitter_hash_tag')) : ?>
        <li><a class="hash" href="#"><?php echo check_hash(get_field('twitter_hash_tag')); ?></a><li>
        <?php endif; ?>

          <li class="facebook">
           <a class="popup" href="https://www.facebook.com/sharer/sharer.php?u=http://halifaxpopexplosion.com<?php the_permalink(); ?>">Facebook</a></li>
        </ul>
      </div><!-- end of articlesocial -->
    </div>
    <div class="navitems">
      <?php wp_link_pages(array('before' => '<nav class="page-nav"><p>' . __('Pages:', 'roots'), 'after' => '</p></nav>')); ?>
    </div>
    <?php // comments_template('/templates/comments.php'); ?>
  </article>
<?php endwhile; ?>
