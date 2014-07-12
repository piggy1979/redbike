<div id="socialbar">
<div class="wrap container">
<div class="socialcontainer col-sm-12">
	<div class="socialicons col-sm-7">
		<ul>
			<li><a class="facebook" href="https://www.facebook.com/halifaxpopexplosion"><img src="/img/btn-facebook.jpg" alt="Facebook"></a></li>
			<li><a class="twitter" href="https://twitter.com/HalifaxPopX"><img src="/img/btn-twitter.jpg" alt="Twitter"></a></li>
			<li><a class="youtube" href="https://www.youtube.com/user/HPXHFX"><img src="/img/btn-youtube.jpg" alt="Youtube"></a></li>
			<li><a class="tumblr" href="http://halifaxpopexplosion.tumblr.com/"><img src="/img/btn-tumblr.jpg" alt="Tumblr"></a></li>
			<li><a class="flickr" href="https://www.flickr.com/search/?q=halifax+pop+explosion&f=hp"><img src="/img/btn-flickr.jpg" alt="Flickr"></a></li>
		</ul>

	</div>


<?php 

$emailform = new Impact_Get_Response();

$emailform->creategetresponseMiniForm();

?>


<!--
	<form id="emailform" class="col-sm-5">
		<h3>Get Email Updates</h3>
		<input type="text" placeholder="Your Email" name="email">
		<input type="submit" value="GO">
	</form>
-->

</div>
</div><!-- socialcontainer -->
</div><!-- end of social bar -->

<div id="sponsorbar">
	<div class="wrap container">
		<div class="col-sm-offset-2 col-sm-8">
			<ul>
				<li><img src="/img/sponsor-1.jpg"></li>
				<li><img src="/img/sponsor-1.jpg"></li>
				<li><img src="/img/sponsor-1.jpg"></li>
				<li><img src="/img/sponsor-1.jpg"></li>
				<li><img src="/img/sponsor-1.jpg"></li>
			</ul>
		</div>
	</div>
</div><!-- end of sponsorbar -->


<footer class="content-info" role="contentinfo">
  <div class="container">
    <?php dynamic_sidebar('sidebar-footer'); ?>
    <section id="copyright">
    <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?></p>
    <ul>
    	<li><a href="http://collidehalifax.com">Collide</a></li>
		<li class="hide">/</li>
		<li><a href="http://halifaxpopexplosion.com">Halifax Pop Explosion</a></li>

    </ul>
	</section>
  </div>
</footer>
<?php  if(wpmd_is_phone()) : ?>
</div><!-- end of mobile holder -->
<?php endif; ?>
<?php wp_footer(); ?>
