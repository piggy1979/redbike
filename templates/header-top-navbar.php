
<script type="text/javascript">
$(function(){
  $(".maps").fancybox({
    fitToView: true,
    maxWidth:1000,
    maxHeight: 700,
    openEffect: 'none',
    closeEffect: 'none',
    autoSize: false
  });
});
</script>

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
    <div class="addpadding">
    <a href="<?php echo home_url(); ?>" class="logo hide"><img src="/img/logo-pop.png" alt="<?php bloginfo('name'); ?>"></a>

    <nav class="collapse navbar-collapse" role="navigation">
      <?php
        if (has_nav_menu('primary_navigation')) :
          wp_nav_menu(array('theme_location' => 'primary_navigation', 'menu_class' => 'nav navbar-nav'));
        endif;
      ?>
    </nav>

    


    </div>
</header>

<?php endif; ?>


<?php if(is_front_page() ) get_template_part('templates/slideshow'); ?>


