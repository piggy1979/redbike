

<header class="banner container" role="banner">
  <div class="row">
    <div class="col-lg-12 sites">
        
      <ul>
        <li><a href="http://hpxdigital.com">HPX Digital</a></li>
        <li><a class="active" href="http://halifaxpopexplosion.com">Pop Explosion</a></li>
      </ul>

    </div>
    <div class="col-lg-12">
      <a class="brand" href="<?php echo home_url('/') ?>"><?php bloginfo('name'); ?></a>
      <nav class="nav-main" role="navigation">
        <?php
          if (has_nav_menu('primary_navigation')) :
            wp_nav_menu(array('theme_location' => 'primary_navigation', 'menu_class' => 'nav nav-pills'));
          endif;
        ?>
        <?php
          if (has_nav_menu('secondary_nav')) :
            wp_nav_menu(array('theme_location' => 'secondary_nav', 'menu_class' => 'sec-nav nav-pills'));
          endif;
        ?>
      </nav>
    </div>
  </div>
</header>
