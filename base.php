<?php get_template_part('templates/head'); ?>
<body <?php body_class(); ?>>

  <!--[if lt IE 8]>
    <div class="alert alert-warning">
      <?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'roots'); ?>
    </div>
  <![endif]-->

  <?php
    do_action('get_header');
    // Use Bootstrap's navbar if enabled in config.php
    if (current_theme_supports('bootstrap-top-navbar')) {
      get_template_part('templates/header-top-navbar');
    } else {
      get_template_part('templates/header');
    }

    //setup maincontainer so it does not display on every page

    if($post->post_name == "schedule"){
      $maincontainer = '';
    }else{
      $maincontainer = 'maincontainer';
    }

  ?>

  <div class="wrap container <?php echo $maincontainer; ?>" role="document">
<?php if(is_singular('marcato_artist')) : ?>
    <a class='back' href="<?php echo site_url(); ?>/lineup/">Back</a>
<?php endif; ?>

    <div class="content row">
      <?php if (roots_display_sidebar()) : ?>
        <aside class="sidebar <?php echo roots_sidebar_class(); ?>" role="complementary">
          <?php 
          if(get_post_type($post) == 'post' || $post->post_name == "news" || is_archive() || is_woocommerce()){
            include roots_sidebar_path(); 
          }else{
            
              $parent = null;
              if ($post->post_parent) {
                $ancestors=get_post_ancestors($post->ID);
                $root=count($ancestors)-1;
                $parent = $ancestors[$root];
              } else {
                $parent = $post->ID;
              }

              $args = array(
                'child_of'      => $parent,
                'post_status'   => 'publish',
                'title_li'      => null,
                'walker'        => new Page_List_Walker()
              );
              if(wpmd_is_phone()){
       
              $args = array(
                'child_of'      => $parent,
                'post_status'   => 'publish',
                'title_li'      => null,
                'walker'        => new Page_Options_Walker()
              );

              if(get_pages($args)){
              echo "<section style='margin-bottom:10px;'>\n";
              echo "<select id='navselect'>\n";
              wp_list_pages($args);
              echo "</select>\n";
              echo "</section>\n";
              }
              ?>
              <script>
              $(function(){
                $nav = $("#navselect");
                $nav.on('change', function(){
                  location.href = $(this).val();
                  console.log("testing");
                }); 
              });
              </script>


              <?php
              }else{
              echo "<section class=\"widget categories-2 widget_categories\">\n";
              echo "<h3><a href='".get_permalink($parent)."'>" . get_the_title($parent) . "</a></h3>\n";
              echo "<ul>\n";
              wp_list_pages($args);
              echo "</ul>\n";
              echo "</section>\n";
              }
          }
          ?>
        </aside><!-- /.sidebar -->
      <?php endif; ?>
      <main class="main <?php echo roots_main_class(); ?>" role="main">
        <?php  include roots_template_path(); ?>
      </main><!-- /.main -->

    </div><!-- /.content -->
  </div><!-- /.wrap -->

  <?php get_template_part('templates/footer'); ?>

</body>
</html>
