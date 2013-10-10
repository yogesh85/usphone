
<div class="BPcoreContainer" style="width:100%">

	<h1><?php echo Yii::t("custom", "area_code_list.title")?></i></h1>
	
	<?php
	$areaCodeArray = array();
	foreach($area_code as $val) {
		$key = substr($val->area_code, 0, 1);
		$areaCodeArray[$key][] = array(
			'area_code' => $val['area_code'],
			'url' => (new Clicky)->areaCodeUrl($val['area_code']),
			'state_name' => $val->state0->name,
			'state_code' => $val->state,
		);
	}
	foreach($areaCodeArray as $key=>$areaCode1) { 
	?>
	<div class="th1"><?php echo Yii::t("custom", "homepage.header4", array('{digit}' => $key))?></div>
	<div class="tb1">
		<?php foreach($areaCode1 as $areaCode) { ?>
		<div class='trc'>
			<a title='' class='b' href='<?php echo $areaCode['url']?>'>
				<?php echo $areaCode['area_code'] ?>
			</a> 
			<?php echo $areaCode['state_name']." (<b>".$areaCode['state_code']."</b>)"?>
		</div>
		<?php } ?>
	</div>
	<?php } ?>
	
	<div id="BPcore_nonad">
		<div id="listingdiv0" class="bpListingInfo">
			<div id="coreBizName_nonad">
			</div>
		</div>									
	</div>
</div>

