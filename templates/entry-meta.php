<p class="byline author vcard"><?php echo __('Posted By', 'roots'); ?> <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" rel="author" class="fn"><?php echo get_the_author(); ?></a>

<?php
	$cats = get_the_category();
	$output = "";
	echo __('Category: ', 'roots'); 
	if($cats){
		foreach($cats as $cat){
			$output .= "<a href='" . get_category_link($cat->term_id) . "'>";
			$output .= $cat->cat_name . "</a> \n";
		}
	}
	echo $output;

?>

</p>
