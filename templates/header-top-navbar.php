<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-PJFGJP"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-PJFGJP');</script>
<!-- End Google Tag Manager -->
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
      <h1><a href="<?php echo site_url(); ?>">Collide Halifax</a></h1>

    </div>

    <nav role="navigation">
      <?php
        if (has_nav_menu('primary_navigation')) :
          wp_nav_menu(array('theme_location' => 'primary_navigation', 'menu_id' => 'mobile_main',  'menu_class' => 'mobile-main'));
        endif;
        
        if (has_nav_menu('primary_navigation')) :
          wp_nav_menu(array('theme_location' => 'secondary_nav', 'menu_id' => 'mobile_secondary', 'menu_class' => 'mobile-secondary'));
        endif;
      ?>
    </nav>
    <a href="#" class='mobile buy btn'>Buy Tickets</a>

</header>
<div id="mobilecontainer">
<?php  endif; ?>



<header class="banner" role="banner">
    <div class="col-lg-12 sites">   
      <ul>
        <li><a href="http://halifaxpopexplosion.com">Pop Explosion</a></li>
        <li><a class="active" href="http://collidehalifax.com">Collide</a></li>
        
        <li><span class="date">October 22-24, 2014 <em>&bull; Halifax, NS</em></span></li>
        <li class="shopcart"><?php echo shoppingCart(); ?></li>
        <li class="searchbtn"><a href="/search">Search</a></li>
      </ul>
    </div>

    <form action="<?php echo site_url(); ?>" id="searchform" method="get">
      <label>Search:</label><input type="text" name="s" autocomplete="off">
    </form>

</header>
<?php

if( is_search() || is_404() ){
  $post = new stdClass();
  $post->post_name = "";
}

?>

<?php if( wpmd_is_notphone() ) : ?>
<?php if($post->post_name == "lineup"){
  echo "<div class='lineupbackground'>\n";
}
?>
<header id="mainnav">
    <div class="addpadding">
    <a href="<?php echo home_url(); ?>" class="logo hide"><img src="/img/logo-pop.png" alt="<?php bloginfo('name'); ?>"></a>

    <nav class="collapse navbar-collapse" role="navigation">
      <?php
        if (has_nav_menu('primary_navigation')) :
          wp_nav_menu(array('theme_location' => 'primary_navigation', 'menu_class' => 'nav navbar-nav'));
        endif;
        
        if (has_nav_menu('primary_navigation')) :
          wp_nav_menu(
            array(
              'theme_location' => 'secondary_nav', 
              'menu_class' => 'secnav navbar-nav'
            ));
        endif;
      ?>
    </nav>

    <a href="#" class='buy btn'>Buy Tickets</a>

    </div>
</header>

<?php endif; ?>


<?php if(is_front_page() ) get_template_part('templates/slideshow'); ?>


