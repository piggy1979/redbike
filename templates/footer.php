<footer class="content-info" role="contentinfo">
  <div class="container">
    <?php dynamic_sidebar('sidebar-footer'); ?>
    <section id="copyright">
    <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?></p>
	</section>
  </div>
</footer>
<?php  if(wpmd_is_phone()) : ?>
</div><!-- end of mobile holder -->
<?php endif; ?>
<?php wp_footer(); ?>
