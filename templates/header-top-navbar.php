
<?php if(wpmd_is_device()) : ?>
<script type="text/javascript">
$(function(){
$("#searchform input").on('focus', function(){
  $("header.banner").css({position: 'absolute'});
});
$("#searchform input").on('blur', function(){
  $("header.banner").css({position: 'fixed'});
});
});
</script>
<?php endif; ?>

<?php  if(wpmd_is_phone()) : ?>


<header id="mainnavmobile">
    <div class="mainnavholder">
      <div id="mobile-icon">
       <span></span><span></span><span></span>

      </div>
      <h1><a href="<?php echo site_url(); ?>"><?php bloginfo('name'); ?></a></h1>

    </div>

    <nav role="navigation">
      <?php
        if (has_nav_menu('primary_navigation')) :
          wp_nav_menu(array('theme_location' => 'primary_navigation', 'menu_id' => 'mobile_main',  'menu_class' => 'mobile-main'));
        endif;
      ?>
    </nav>
</header>
<div id="mobilecontainer">
<?php  endif; ?>

<?php

if( is_search() || is_404() ){
  $post = new stdClass();
  $post->post_name = "";
}

?>

<?php if( wpmd_is_notphone() ) : ?>

<header id="mainnav">
    <div class="inner">
    <a href="<?php echo home_url(); ?>" class="logo hide"><img src="<?php echo home_url(); ?>/wp-content/themes/redbike/assets/img/red-logo.png" alt="<?php bloginfo('name'); ?>"></a>

    <nav class="collapse navbar-collapse" role="navigation">
      <?php
        if (has_nav_menu('primary_navigation')) :
          wp_nav_menu(array('theme_location' => 'primary_navigation', 'menu_class' => 'nav navbar-nav', 'walker'=> new Add_Data));
        endif;
      ?>
    </nav>
      <div id="contactdetails">
      <?php echo stripslashes(get_option('default_contact')); ?>
      </div>
    </div>
</header>

<?php endif; ?>


<?php if(is_front_page() ) get_template_part('templates/slideshow'); ?>


