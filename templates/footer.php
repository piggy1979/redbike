<footer class="content-info" role="contentinfo" data-scroll-index='14'>
  <div>
		<div class="col-sm-6">    
        <?php 
        gravity_form(1, false, false, false, '', true); 
        ?>
		</div>
		<div class="col-sm-6">
		<?php
        echo getFooter(72);
        ?>
		</div>
    <section id="copyright">

    	
    <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?></p>
	</section>
  </div>
</footer>
<?php  if(wpmd_is_phone()) : ?>
</div><!-- end of mobile holder -->
<?php endif; ?>
<?php wp_footer(); ?>
