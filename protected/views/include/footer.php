<div class="footer">
	<div class="ftrancd">
		<a href="<?php echo Yii::app()->request->baseUrl; ?>"><span class="footer_anc">Home</span></a>
		<a href="<?php echo (new Clicky)->areaCodeDirectoryUrl() ?>"><span class="footer_anc">Area Codes</span></a>
		<a href="<?php echo Yii::app()->baseUrl."/privacy-policy"; ?>"><span class="footer_anc">Privacy Policy</span></a>
	</div>
	<div class="copy-wrapper">				
		<p class="copyright">Copyright &copy; <?php echo date("Y")?> <strong><?php echo Yii::t("custom", "site.domain"); ?></strong> All rights reserved.</p>
	</div>
</div>
