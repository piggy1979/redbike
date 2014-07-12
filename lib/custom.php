<?php
/**
 * Custom functions
 */

// new image Sizes

add_image_size( 'featured', 1600, 600, true);
add_image_size( 'profilepic', 220, 180 );
add_image_size( 'newsitem', 760, 544, true);
add_image_size( 'ads', 300, 250, true );


register_nav_menus(array(
	'secondary_nav' => __('Secondary Navigation', 'roots')
));

/** 
/* RESGISTER POST TYPES
**/

function create_post_types(){

/*
register_post_type('news', 
	array(
		'labels'	=> array(
			'name' 			=> __('News'),
			'singular_name'	=> __('News')
			),
		'public'		=> true,
		'has_archive'	=> true,
		'menu_position'	=> 5,
		'publicly_queryable' => true,
		'supports' => array('title', 'excerpt', 'editor', 'thumbnail', 'revisions')
	)
);
*/

register_post_type('advertisement',
	array(
		'labels'	=> array(
			'name' 			=> __('Advertisements'),
			'singular_name'	=> __('Advertisement')
			),
		'public'		=> true,
		'has_archive'	=> true,
		'menu_position'	=> 5,
		'publicly_queryable' => true,
		'supports' => array('title', 'thumbnail', 'revisions')
	)
);

register_post_type('featured',
	array(
		'labels'	=> array(
			'name' 			=> __('Featured Slides'),
			'singular_name'	=> __('Featured Slide')
			),
		'public'		=> true,
		'has_archive'	=> false,
		'menu_position'	=> 5,
		'publicly_queryable' => true,
		'supports' => array('title', 'thumbnail', 'revisions')
	)
);


}



/**
Clean up functions
**/

function remove_thumbnail_dimensions( $html ) {
    $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
    return $html;
}
add_filter( 'post_thumbnail_html', 'remove_thumbnail_dimensions', 10 );
add_action('init', 'create_post_types');


// pass hashtag to function it searches for a hashtag and if none exists it adds one otherwise it will return 
// the original text including the hash.
function check_hash($n){
	if(!$n) return;
	$hashpos = strpos($n, "#");

	if($hashpos === false){
		$output = "#" . $n;
	}else if($hashpos == 0){
		$output = $n;
	}
	return $output;
}

/**
CONNECTION TYPES
* These connection types require the use of the posts 2 posts plugin.
**/

function my_connection_types() {
    p2p_register_connection_type( array(
        'name' => 'posts_to_pages',
        'from' => 'marcato_show',
        'to' => 'marcato_artist'
    ) );
}
add_action( 'p2p_init', 'my_connection_types' );


/**
Pull Functions
**/

/*
# $n = posts on current page
# $paged = current page number.
*/

function getNews($n, $paged=null, $list = null){

	$output= "";

	$args = array(
		'post_type' 		=> 'post',
		'posts_per_page'	=> $n,
		'paged'				=> $paged,
		'order'				=> 'DESC'
		);

	$query = new WP_Query($args);

	foreach($query->posts as $post){

		if($list){


			$authorname = get_the_author_meta( 'display_name', $post->post_author ); 
			$authorlink = get_the_author_meta( 'user_email', $post->post_author ); 

			$cats = get_the_category($post->ID);
			$categories = "";
			foreach($cats as $cat){
				$categories .= $cat->name . " "; 
			}


		//	print_r($cats);

			$output .= "<article class='post category-music type-post'>\n";
			$output .= "<header><h2 class='entry-title'>\n";
			$output .= "<a href=\"".get_permalink($post->ID)."\">".$post->post_title . "</a></h2>\n";

			$output .= "<p class='byline author vcard'>\n";
			$output .= "Posted By <a class='fn' rel='author' href='".$authorlink."'>".$authorname."</a>\n";
			$output .= " Category: " . $categories . "</p>\n";
			$output .= "</header>\n";
			$output .= "<div class='entry-summary'><p>" . limit_words($post->post_content, 60) . "</p></div>\n";

			$output .= "</article>\n";
		}else{
	
			$imageID = get_post_thumbnail_id($post->ID);
			$image = wp_get_attachment_image_src($imageID, 'newsitem');
	
			$output .= "<section class='news-cta col-sm-4'>\n";
			$output .= "<time class=\"published\" datetime=\"" . processDate($post->post_date, 'c') . "\">" . processDate($post->post_date, 'M') . "<br>" . processDate($post->post_date, 'd') . "</time>\n";
			$output .= "<img src=\"".$image[0]."\">\n";
			$output .= "<h2><a href='".get_permalink($post->ID)."'>". $post->post_title . "</a></h2>\n";
			$output .=  "<p>" . limit_words($post->post_content, 30) . "</p>\n";
			$output .= "</section>\n";
		}
	}

	return $output;
}

function getAds($n = null){
	
	$args = array(
		'post_type'			=> 'advertisement',
		'posts_per_page'	=> 1,
		'orderby'			=> 'rand'
	);

	if($n !== null){
		//we have a possible id listed. Display ad that matches the id number.
		$args['p'] = $n;
	}

	$query = new WP_Query($args);
	$output = '';

	foreach($query->posts as $post){
		$imageID = get_post_thumbnail_id($post->ID);
		$image = wp_get_attachment_image_src($imageID, 'ads');
		$output .= "<a class='advertlink' href='". get_field('url', $post->ID ) ."'>\n";
		$output .= "<img src=\"".$image[0]."\">\n";
		$output .= "</a>\n";
	}
	return $output;
}



function featuredSlides($n){
	$args = array(
		'post_type'			=> 'featured',
		'posts_per_page'	=> $n
	);

	$query = new WP_Query($args);
	$output = "";
	foreach($query->posts as $post){
		$imageID = get_post_thumbnail_id($post->ID);
		$image = wp_get_attachment_image_src($imageID, 'featured');


		$background = " style='background-image: url(".$image[0].")' ";
		$output .= "<div class='slide' ".$background.">\n";
		$output .= "<div class='slidecontent'><div class='addpadding'>\n";
		$output .= "<h2>".$post->post_title."</h2>\n";
		if(get_post_meta($post->ID, 'url')[0] && get_post_meta($post->ID, 'link_title')[0] ){
		$output .= "<a href='". get_post_meta($post->ID, 'url')[0] ."' class='btn bko'>". get_post_meta($post->ID, 'link_title')[0] ."</a>\n";
		}
		$output .= "</div></div>\n";
		$output .= "</div>\n";
	}

	return $output;
}

/* GET LINUP LISTING */

function fetchLineup(){
	$args = array(
		'post_type'			=> 'marcato_artist',
		'posts_per_page'	=> -1,
		'orderby'			=> 'title',
		'order'				=> 'ASC'
	);

	$query = new WP_Query($args);
	$output = "<ul id=\"lineuplist\">";
	$currentAlpha = '-';

	foreach($query->posts as $key=>$post){

		// get categories for current page.
		$cats = get_the_terms($post->ID, 'artist_tag');
		$classlist = "";
		if($cats){
			foreach($cats as $cat){
				$classlist .= " " . $cat->slug;
			}
		}

		// case insesitive match. If it does not = 0 then it does not match.
		if(strcasecmp($post->post_title[0],$currentAlpha) != 0 ){

			if($key != 0) $output .= "</ul></li>\n"; 
			$currentAlpha = $post->post_title[0];

			$output .= "<li><strong>". $currentAlpha . "</strong>\n<ul>";
		}
		$output .= "<li class='act ".$classlist."'><a href='" . get_permalink($post->ID) . "'>".$post->post_title."</a></li>\n"; 
	}
	$output .= "</ul></li></ul>\n";
	return $output;

}

function fetchShows(){

	$args = array(
		'post_type'			=> 'marcato_show',
		'posts_per_page'	=> -1,
		'orderby'			=> 'meta_value_num',
		'meta_key'			=> 'marcato_show_start_time_unix'
	);

	$query = new WP_Query($args);

	$output = "";

	// build opening of the section.
	foreach($query->posts as $post){
		$type = strtolower(getCat($post->ID));
		$date = "date" . date( 'd', get_post_meta($post->ID, 'marcato_show_start_time_unix')[0] );
		$output .= "<section class=\"mix " . $type . " " . $date . "\">\n";
		$output .= "<div class='eventdescription'>\n";
		$output .= "<h3>" . $post->post_title . "</h3>\n";
		$output .= "<strong>" . get_post_meta($post->ID, 'marcato_show_price')[0] . "</strong>\n";
		$output .= "<div class='eventextra'>\n";

		$output .= getTimes($post->ID);

		$output .= "<div class='articlesocial'>\n";

		if($type) $output .= "<span class='tag'>" . $type . "</span>\n";

		$shareurl = site_url() . "/shows/" . $post->post_name; 
		$output .= "<ul class=\"rrssb-buttons\">\n";

		$twithash = get_post_meta($post->ID, 'twitter_hash_tag')[0];
		if($twithash) $output .= "<li class='twitter'><a target='_blank'href='http://twitter.com/hashtag/".$twithash."'>#" . $twithash . "</a></li>\n";

		//$output .= ""
		$output .= "<li class='facebook'>" . "<a href=\"https://www.facebook.com/sharer/sharer.php?u=" . $shareurl ."\">Facebook</a></li>\n";
		$output .= "</ul>\n";
		$output .= "</div><!-- end of article social -->\n";
		$output .= "</div><!-- end of event extra -->\n";
		$output .= "</div><!-- end of event description -->\n";

		// event details 

		$output .= "<div class=\"eventdetails\">\n";
		$output .= "<div class=\"eventtime\">\n";
		$output .= "<strong>".date( 'l, F n', get_post_meta($post->ID, 'marcato_show_start_time_unix')[0] )."</strong>\n";
		$output .= "</div>\n";

		$output .= "<div class=\"directions\">";
		$output .= "<strong>" . get_post_meta($post->ID, 'marcato_show_venue_name')[0] . "</strong><br>\n";

		$googlemaps = rawurlencode(get_post_meta($post->ID, 'marcato_show_venue_name')[0] . ",Halifax NS");

		$output .= "<a class='maps fancybox.iframe' href=\"https://www.google.com/maps/embed/v1/place?key=AIzaSyApi6sfP5n-DEVKtPHJt8Lfbc4R1_r4Z8U&q=".$googlemaps."\">Directions</a>\n";
		$output .= "</div>\n";

		$output .= "</div><!-- end of event details -->\n";

		$output .= "</section>\n";
	}
	return $output;
}

function getTimes($n){
	$connected = new WP_Query( array(
        'connected_type'  	=> 'posts_to_pages',
    	'connected_items'	=> $n,
        'nopaging'        	=> true
      ));

	$output = "";

      if($connected->have_posts()){
        foreach($connected->posts as $post){
        //	print_r( get_post_meta($post->ID, 'marcato_show_start_time_unix')[0] );
        	$output .= "<p><a href='".get_permalink($post->ID). "'>" . $post->post_title . "</a></p>";
		}
	}
	return $output;
}

function getCat($id){
	$cats = get_the_category($id);
	$total = "";
	//print_r($cats);
	foreach($cats as $cat){
		$total .= $cat->name . " ";
	}
	return trim($total);

}

//marcato_show_start_time_unix

function getSimilar($id){
	// grab similar categories inside the genre category group.
//	echo $id;
	$n = currentTax($id);

	// build query;
	$args = array(
		'post_type' 	=> 'marcato_artist',
		'orderby'		=> 'rand',
		'post__not_in'	=> array($id),
		'posts_per_page'=> 3,
		'tax_query' 	=> array(
			array(
				'taxonomy' => 'marcato_genre',
				'terms'	=> $n
			)
		)
	);
	$query = new WP_Query($args);
	$output = "<div class='row similar'>\n";
	foreach($query->posts as $post){

		$imageID = get_post_thumbnail_id($post->ID);
		$image = wp_get_attachment_image_src($imageID, 'ads');

		if(isset($image[0])){
			$newimage = "<a href='".get_permalink($post->ID)."'><img src='".$image[0]."' width='100%' title='".$post->post_title."' ></a>\n";
		}else{
			$newimage = "<a href='".get_permalink($post->ID)."'><img src='/img/placeholder.png' width='100%' ></a>\n";
		}

		$output .= "<div class='col-xs-4'>\n";
		$output .= $newimage;
		$output .= "<a href='".get_permalink($post->ID)."'>" . $post->post_title . "</a>\n";
		$output .= "</div>\n";
	}
	$output .= "</div>\n";
	return $output;

}

function currentTax($id){
	$term_id = get_the_terms($id, 'marcato_genre');
	foreach($term_id as $genre){
		$terms[] = $genre->term_id;
	}

	return $terms;
}


/* fetch websites that fit a certain string from the Marcato xml feed. */

function getMarWebsite($id, $str)
{
	// loop through all post types of marcato artists websites. Exit when string is
	// found and return the proper details.
	for($i=0; $i<=10; $i++)
	{
		$url = "marcato_artist_website_".$i."_url";
		$result = get_post_meta($id, $url);
		
		//end as soon as no results are pulled.
		if(!isset($result[0])) return false;

		//compare result with our passed string. It can be 0 but not false.
		if( strstr($result[0], $str) !== false ){
			return $result[0];
		}
	}
}
// $n is the filters. Pass an array;
function siteLoop($id, $n = null){
	// loop through all post types of marcato artists websites. Exit when string is
	// found and return the proper details.\
	$output = '';
	for($i=0; $i<=10; $i++)
	{
		$url = "marcato_artist_website_".$i."_url";
		$result = get_post_meta($id, $url);	
		$name = "marcato_artist_website_".$i."_name";
		$sitename = get_post_meta($id, $name);

		if(!isset($result[0])) return false;
		if($n){
			$site_url = URLinArray($result[0], $n);
			if($site_url){
				echo "<p class=\"artistlink\">" . $sitename[0] . ": <a href=\"".$site_url."\" target=\"_blank\">".$site_url."</a></p>\n";
				//$output .= "<p class=\"artistlink\">" . $sitename[0] . ": <a href=\"".$site_url."\" target=\"_blank\">".$site_url."</a></p>\n";
			}
		}
	}

	return $output;
}

function connectedItems($n, $show=true){
	$connected = new WP_Query( array(
        'connected_type'  => 'posts_to_pages',
    	'connected_items'	=> $n,
        'nopaging'        => true
      ));

	$output = "";

      if($connected->have_posts()){
        $output .= "<h2>Current Shows</h2>\n";
        foreach($connected->posts as $post){
        	
        	if($show){
        		$time = get_post_meta($post->ID, 'marcato_show_start_time_unix')[0];
        		$formattedtime = date("F jS, g:i A", $time);
			}
        	$output .= "<p class='artistlink'><a href='".get_permalink($post->ID)."'>" . $post->post_title . "</a>";
			if($show) $output .= " &bull; " . $formattedtime . "</p>\n";
        }
      }
      return $output;
}


function URLinArray($url, $array){
	if($url == null) return false;
	foreach($array as $value){
		if( strstr($url, $value) == true ){
			return false;
		}
	}
	return $url;
}

function shoppingCart(){
	global $woocommerce;

	$cart_url = $woocommerce->cart->get_cart_url();
	$shop_page_url = get_permalink( woocommerce_get_page_id( 'shop' ) );
	$cart_contents_count = $woocommerce->cart->cart_contents_count;

	if($cart_contents_count >0){
		return "<span>Cart" . "<strong><a href='/cart'>" . $cart_contents_count . "</a></strong></span>\n";
	}else{
		return false;
	}


//	return "test";
}


function getTwitterName($n){
	$segments = explode("/", $n);
	$length = count($segments);
	return '@' . $segments[$length-1];
}

function limit_words($string, $word_limit){
	$newstring = strip_tags($string);
    $words = explode(" ",$newstring);
    return implode(" ",array_splice($words,0,$word_limit));
}

function processDate($t, $format){
	$date = strtotime($t);
	return date($format, $date);
}

add_filter('nav_menu_css_class', 'my_css_attributes_filter', 100, 1);
add_filter('nav_menu_item_id', 'my_css_attributes_filter', 100, 1);
add_filter('page_css_class', 'my_css_attributes_filter', 100, 1);

function my_css_attributes_filter($var) {
  return is_array($var) ? array_intersect($var, array('current-menu-item', 'active', 'current-page-item')) : '';
}

class Page_List_Walker extends Walker_page {
  function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
  {
  //	print_r($item);
    $output .= sprintf( "\n<li class='cat-item'><a href='%s'%s>%s</a></li>\n",
            get_permalink($item->ID),
            ( $item->ID === get_the_ID() ) ? ' class="current"' : '',
            $item->post_title );
  }

}


class Page_Options_Walker extends Walker_page{
  function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
  {
  //	print_r($item);
    $output .= sprintf( "\n<option value='%s' %s>%s</option>\n", get_permalink($item->ID), ( $item->ID === get_the_ID() ) ? ' selected' : '', $item->post_title );
  }	
}


/* register shop sidebar */

add_action('widgets_init', 'imp_register_sidebars');
function imp_register_sidebars(){
	register_sidebar(array(
		'name' 			=> __('Store'),
		'id'			=> 'woo-shop',
		'before_title' 	=> '<h3>',
		'after_title'	=> '</h3>',
		'before_widget'	=> '<section class="widget_categories">',
		'after_widget'	=> '</section>'
	));
}



add_filter( 'comments_template' , 'block_disqus', 1 );
function block_disqus($file) {
if ( 'product' == get_post_type() )
remove_filter('comments_template', 'dsq_comments_template');
return $file;

}

function custom_mobile_widget(){
//	echo "test test";
	unregister_widget('WP_Widget_Categories');
	register_widget('IMP_Widget_Categories');
}
add_action('widgets_init', 'custom_mobile_widget');

/* EXTEND Widget */

class IMP_Widget_Categories extends WP_Widget_Categories {

	function __construct() {
		$widget_ops = array( 'classname' => 'widget_categories', 'description' => __( "A list or dropdown of categories." ) );
		parent::__construct('categories', __('Categories'), $widget_ops);
	}

	function widget( $args, $instance ) {
		extract( $args );

		/** This filter is documented in wp-includes/default-widgets.php */
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( 'Categories' ) : $instance['title'], $instance, $this->id_base );

		$c = ! empty( $instance['count'] ) ? '1' : '0';
		$h = ! empty( $instance['hierarchical'] ) ? '1' : '0';
		$d = ! empty( $instance['dropdown'] ) ? '1' : '0';

		if(wpmd_is_phone()){
		$d = 1;

		}

		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;

		$cat_args = array('orderby' => 'name', 'show_count' => $c, 'hierarchical' => $h);

		if ( $d ) {
			$cat_args['show_option_none'] = __('Select Category');

			/**
			 * Filter the arguments for the Categories widget drop-down.
			 *
			 * @since 2.8.0
			 *
			 * @see wp_dropdown_categories()
			 *
			 * @param array $cat_args An array of Categories widget drop-down arguments.
			 */
			wp_dropdown_categories( apply_filters( 'widget_categories_dropdown_args', $cat_args ) );
?>

<script type='text/javascript'>
/* <![CDATA[ */
	var dropdown = document.getElementById("cat");
	function onCatChange() {
		if ( dropdown.options[dropdown.selectedIndex].value > 0 ) {
			location.href = "<?php echo home_url(); ?>/?cat="+dropdown.options[dropdown.selectedIndex].value;
		}
	}
	dropdown.onchange = onCatChange;
/* ]]> */
</script>

<?php
		} else {
?>
		<ul>
<?php
		$cat_args['title_li'] = '';

		/**
		 * Filter the arguments for the Categories widget.
		 *
		 * @since 2.8.0
		 *
		 * @param array $cat_args An array of Categories widget options.
		 */
		wp_list_categories( apply_filters( 'widget_categories_args', $cat_args ) );
?>
		</ul>
<?php
		}

		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['count'] = !empty($new_instance['count']) ? 1 : 0;
		$instance['hierarchical'] = !empty($new_instance['hierarchical']) ? 1 : 0;
		$instance['dropdown'] = !empty($new_instance['dropdown']) ? 1 : 0;

		return $instance;
	}

	function form( $instance ) {
		//Defaults
		$instance = wp_parse_args( (array) $instance, array( 'title' => '') );
		$title = esc_attr( $instance['title'] );
		$count = isset($instance['count']) ? (bool) $instance['count'] :false;
		$hierarchical = isset( $instance['hierarchical'] ) ? (bool) $instance['hierarchical'] : false;
		$dropdown = isset( $instance['dropdown'] ) ? (bool) $instance['dropdown'] : false;
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('dropdown'); ?>" name="<?php echo $this->get_field_name('dropdown'); ?>"<?php checked( $dropdown ); ?> />
		<label for="<?php echo $this->get_field_id('dropdown'); ?>"><?php _e( 'Display as dropdown' ); ?></label><br />

		<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>"<?php checked( $count ); ?> />
		<label for="<?php echo $this->get_field_id('count'); ?>"><?php _e( 'Show post counts' ); ?></label><br />

		<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('hierarchical'); ?>" name="<?php echo $this->get_field_name('hierarchical'); ?>"<?php checked( $hierarchical ); ?> />
		<label for="<?php echo $this->get_field_id('hierarchical'); ?>"><?php _e( 'Show hierarchy' ); ?></label></p>
<?php
	}

}








