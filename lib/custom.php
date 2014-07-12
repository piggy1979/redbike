<?php
/**
 * Custom functions
 */

// new image Sizes

add_image_size( 'featured', 1600, 600, true);
add_image_size( 'sponsor', 280, 175, true );

/** 
/* RESGISTER POST TYPES
**/

function create_post_types(){

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

register_post_type('sponsor',
	array(
		'labels'	=> array(
			'name' 			=> __('Sponsors'),
			'singular_name'	=> __('Sponsor')
			),
		'public'		=> true,
		'has_archive'	=> true,
		'menu_position'	=> 5,
		'publicly_queryable' => true,
		'supports' => array('title', 'thumbnail', 'revisions')
	)
);

register_post_type('Careers',
	array(
		'labels'	=> array(
			'name' 			=> __('Careers'),
			'singular_name'	=> __('Career')
			),
		'public'		=> true,
		'has_archive'	=> true,
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

/**
Pull Functions
**/

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


function getCat($id){
	$cats = get_the_category($id);
	$total = "";
	//print_r($cats);
	foreach($cats as $cat){
		$total .= $cat->name . " ";
	}
	return trim($total);

}


function currentTax($id){
	$term_id = get_the_terms($id, 'marcato_genre');
	foreach($term_id as $genre){
		$terms[] = $genre->term_id;
	}

	return $terms;
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


################################
###		DASHBOARD TRIAL      ###
################################

function add_default_contact(){
	global $wp_meta_boxes;
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
	add_meta_box( 'default_contact', 'Default Contact Details', 'show_default_contact', 'dashboard', 'side', 'high' );

}

function show_default_contact()
{
	echo "Set the contact details";
	echo "<form method=\"post\">";
	echo "<textarea style='width:100%;' name='contactdeet'>".get_option('default_contact')."</textarea>";
	wp_nonce_field('save_default_contact', 'default_contact_nonce');
	submit_button();
	echo "</form>";
}
// verify post data and save.
if(isset($_POST['contactdeet'])){
	if(!isset($_POST['default_contact_nonce']) || !wp_verify_nonce($_POST['default_contact_nonce'], 'save_default_contact')  )
	{
		echo "invalid request. The system thinks this was a remote request which is not allowed. If this persists contact the webmaster";
		exit;
	}
	save_default_contact();
}

function save_default_contact()
{
	dashboard_save_option( array('default_contact' => $_POST['contactdeet']) );
}

// takes an associative array eg:  array('wp_option_name' => 'wp_option_value');
function dashboard_save_option($request)
{
	if( current_user_can('manage_options') ) {

		foreach($request as $key=>$value)
		{
			update_option($key, $value);
		}

	}else{
		echo 'you currently do not have permission to make this change';
		return false;
	}
}

add_action('wp_dashboard_setup', 'add_default_contact');



