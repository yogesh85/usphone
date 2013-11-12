
<div class="BPcoreContainer" style="width:100%">
	<?php	
	$this->widget('zii.widgets.CBreadcrumbs', array(
		'homeLink'=>CHtml::link('Home', Yii::t("custom", "site.url")),
		'links'=>array( Yii::t("custom", "areaCode.breadcrumb", $params)),
	));
	?>
	
	
	<div id="BPcore_nonad">
		<div id="listingdiv0" class="bpListingInfo">
			<div id="coreBizName_nonad">
			</div>
		</div>									
	</div>
</div>
