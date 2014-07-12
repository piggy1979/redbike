<?php while (have_posts()) : the_post(); ?>
  <article <?php post_class(); ?>>
    
    <?php

/*
    $website    = get_post_meta($post->ID, "marcato_artist_website_0_url");
    $homebase   = get_post_meta($post->ID, "marcato_artist_homebase");
    $artistID   = get_post_meta($post->ID, "marcato_artist_id");


    $twitterhandle    = getMarWebsite($post->ID,"twitter.com");
    $youtubehandle    = getMarWebsite($post->ID,"youtube.com");
    $soundcloudhandle = getMarWebsite($post->ID,"soundcloud.com");

    $twittername = getTwitterName($twitterhandle);
*/
    ?>
    <div class="featuredimage col-sm-5">
	<?php
//https://www.google.com/maps/embed/v1/place?key=AIzaSyA5I8Q4uvg4UCgiPZgBQ_rLC7aBuTT0eFw&q=The+Nook,Halifax+NS

	// setup google maps.
	$place = get_post_meta($post->ID, 'marcato_show_venue_name' )[0] . " " . get_post_meta($post->ID, 'marcato_show_venue_street')[0] . ",Halifax NS" ;
	$placeencode = rawurlencode( $place );
	//echo $place;
	?>

	<iframe 
		src="https://www.google.com/maps/embed/v1/place?key=AIzaSyA5I8Q4uvg4UCgiPZgBQ_rLC7aBuTT0eFw&q=<?php echo $place; ?>"
		width="100%"
		height="400"
		frameborder="0" ></iframe>

    </div>
    <div class="col-sm-7">
    <header>

      <h1 class="entry-title"><?php the_title(); ?></h1>

<?php
  	$time = get_post_meta($post->ID, 'marcato_show_start_time_unix')[0];
  	$formattedtime = date("F jS, g:i A", $time);
	echo "<h4>" . $formattedtime . "</h4>\n";
?>


    </header>

   
      <?php 
      echo connectedItems($post->ID, false);
      ?>
    



    </div><!-- boostrap -->
  </article>
<?php endwhile; ?>
