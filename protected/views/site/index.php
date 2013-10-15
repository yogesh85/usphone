
<div class="BPcoreContainer" style="width:100%">

	<h1><?php echo Yii::t("custom", "homepage.title")?></i></h1>
	<div class="th1"><?php echo Yii::t("custom", "homepage.header1")?></div>
	<div class="tb1">
	<?php foreach($this->comments as $comment) { ?>
		<div><a class='b' title='<?php echo $comment['phone_number']; ?>' href='<?php echo (new Clicky)->areaInterchangeUrl($comment['area_code'], $comment['area_interchange_code'])?>'>(<?php echo $comment['area_code']?>) <?php echo $comment['area_interchange_code']."-".substr($comment['phone_number'], -3)?></a><span class='rt date'><?php echo date("j'S F Y \a\\t g:i a", strtotime($comment['timestamp']))?></span></div>
		<div class='text'><?php echo $comment['comment']; ?></div>
	<?php } ?>
	</div>
	<div class="th1"><?php echo Yii::t("custom", "homepage.header2")?></div>
	<div class="tb1">
	<?php foreach($this->recently_searched_number as $number) { ?>
		<?php
		$temp = explode("-", $number); 
		?>
		<div class="trc1"><a class="b" href="<?php echo (new Clicky)->areaInterchangeUrl($temp[0], $temp[1])?>">(<?php echo $temp[0]?>) <?php echo $temp[1]."-".$temp[2]?></a></div>
	<?php } ?>
	</div>
	
	<?php if(isset($this->mostly_searched_number)) { ?>
	<div class="th1"><?php echo Yii::t("custom", "homepage.header6")?></div>
	<div class="tb1">
	<?php if(count($this->mostly_searched_number) == 0) echo "No One searched any number today! Be the First One to search number. Thanks!!!" ?>
	<?php foreach($this->mostly_searched_number as $number) { ?>
		<?php $temp = explode("-", $number); ?>
		<div class="trc1"><a class="b" href="<?php echo (new Clicky)->areaInterchangeUrl($temp[0], $temp[1])?>">(<?php echo $temp[0]?>) <?php echo $temp[1]."-".$temp[2]?></a></div>
	<?php } ?>
	</div>
	<?php } ?>
	
	<?php
	$areaCodeArray = array();
	foreach($this->areaCodeList as $areaCode) {
		//echo "<div class='trc'><a title='' class='b' href='".$this->areaCodeUrl($areaCode['area_code'])."'>".$areaCode['area_code']."</a> ".$areaCode->state0->name." (".$areaCode->state.")</div>";
		$key = substr($areaCode->area_code, 0, 1);
		$areaCodeArray[$key][] = array(
			'area_code' => $areaCode['area_code'],
			'url' => (new Clicky)->areaCodeUrl($areaCode['area_code']),
			'state_name' => $areaCode->state0->name,
			'state_code' => $areaCode->state,
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
