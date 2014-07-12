<div>
<?php
echo getNews(2);
echo "<section class='news-cta col-sm-4'>\n";
echo getAds();
echo "</section>\n";
?>
<a href="/news/" class="morenews col-sm-8">View more news</a>
</div>




<?php
while (have_posts()) : the_post(); 
// the_content();
endwhile;
?>

