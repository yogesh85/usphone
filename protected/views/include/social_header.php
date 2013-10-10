

<div style="margin-top: 0px;" class="social-bar" id="box">
	<div id="fb-root"></div>
	
<script>(function(d, s, id) {
var js, fjs = d.getElementsByTagName(s)[0];
if (d.getElementById(id)) return;
js = d.createElement(s); js.id = id;
js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=219600251432958";
fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
	<ul class="social-count">
		<li class="social facebook-share">
			<div class="fb-like" data-href="<?php echo Yii::t('custom', 'site.url');?>" data-send="false" data-layout="box_count" data-width="450"></div>
		</li>
		<li class="social twitter-tweet">
			<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo Yii::t('custom', 'site.url');?>" data-count="vertical">Tweet</a>
			<script type="text/javascript" src="//platform.twitter.com/widgets.js"></script>
		</li>
		<li>
			<g:plusone size="tall"></g:plusone>
<script type="text/javascript">
(function() {
var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
po.src = 'https://apis.google.com/js/plusone.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
})();
</script>
		</li>	
	</ul>
</div>
