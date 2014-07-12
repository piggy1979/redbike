<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-PJFGJP"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-PJFGJP');</script>
<!-- End Google Tag Manager -->


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
