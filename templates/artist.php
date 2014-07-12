<?php while (have_posts()) : the_post(); ?>
  <article <?php post_class(); ?>>
    
    <?php

    $website    = get_post_meta($post->ID, "marcato_artist_website_0_url");
    $homebase   = get_post_meta($post->ID, "marcato_artist_homebase");
    $artistID   = get_post_meta($post->ID, "marcato_artist_id");


    $twitterhandle    = getMarWebsite($post->ID,"twitter.com");
    $youtubehandle    = getMarWebsite($post->ID,"youtube.com");
    $soundcloudhandle = getMarWebsite($post->ID,"soundcloud.com");

    $twittername = getTwitterName($twitterhandle);

    ?>
    <div class="featuredimage col-sm-5">
       <?php 
        if(get_the_post_thumbnail($post->ID, 'large')){
           echo get_the_post_thumbnail($post->ID, 'large'); 
        }else{
          echo "<img src='/img/placeholder.png'>";
        }
       ?>
    </div>
    <div class="col-sm-7">
    <header>

      <h1 class="entry-title"><?php the_title(); ?></h1>

      <?php 
      if(isset($homebase[0]) || $twitterhandle){
          
          echo "<h5>\n";
          if($twitterhandle){
          echo "<a href='".$twitterhandle."' target='_blank'>".$twittername."</a>\n";
          if($homebase[0]) echo " &bull; ";
          }
          if($homebase[0]){
          echo $homebase[0];
          }
          echo "</h5>\n";
      }

      ?>
    </header>

   
      <?php 
      //BIO
      echo "<p>" . get_post_meta($post->ID, 'marcato_artist_bio_public', true) . "</p>"; 

      //WEBSITES TO VIEW MUSIC
      if($youtubehandle){
        echo "<a class='btn bko' target='_blank' href='".$youtubehandle."'>Watch Videos</a>\n";
      }
      if($soundcloudhandle){
        echo "<a class='btn bko' target='_blank' href='".$soundcloudhandle."'>Listen</a>\n";
      }
      /*
      if(isset($website[0])) 
      {
        $website = get_post_meta($post->ID, "marcato_artist_website_0_url");
        echo "<p class='artistlink'>Visit: <a target='_blank' href='".$website[0]."'>" . $website[0] . "</a></p>\n"; 
      }
      */

      // loop through all websites.
      echo siteLoop($post->ID, array("youtube","soundcloud"));


      echo connectedItems($post->ID);
      



      ?>
    



    </div><!-- boostrap -->
  
    <div class='clear'>
      <div class="related">

        <!-- cta -->
        <div class="col-sm-5">
          <h2>Call to Action to Buy Tickets</h2>
           <p>Lorem ipsum dolor sit amet, consectetur esentium, expedita quia eveniet molestias et alias minima consectetur dolorum nesciunt unde, voluptatum doloribus saepe! Quibusdam officia, eius optio natus voluptatum nesciunt est quo deleniti animi rerum dolore beatae, quia tempore maiores saepe, magnam quasi cumque provident dicta doloremque sequi asperiores soluta. Nulla, blanditiis!</p>
          <p><a class='btn buy' href='#'>Buy Tickets</a>
        </div>

        <!-- similar artists -->
        <div class="col-sm-7">
          <h2>Similar Artists</h2>
          <?php
            echo getSimilar($post->ID);
          ?>
        </div>


      </div>
    </div>



  </article>
<?php endwhile; ?>
