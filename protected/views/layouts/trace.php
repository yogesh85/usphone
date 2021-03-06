<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::t("custom", "site.url"); ?>/css/bundle.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::t("custom", "site.url"); ?>/css/profile.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::t("custom", "site.url"); ?>/css/checkout.css" />
	<style>#idneededforprint { background:none; } </style>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<meta name="keywords" content="<?php echo CHtml::encode($this->description); ?>">
	<meta name="description" content="<?php echo CHtml::encode($this->keyword); ?>">
</head>

<body id="idneededforprint">
	<div class="master" id="page0">
		<div id="city_image" class="masthead noprint">		
			<div class="tabheader ">
				<?php $this->renderPartial("//include/header");?>
			</div>
		</div><!--end masthead-->
		<div style="clear:both;font-size:5px;height:7px">&nbsp;</div>
		
		<div id="BPtopbar">
			<div style="display: block;" class="BPrail"></div>
		</div>
		<div id="BPcontainer">
			<div class="brdcrumb">		
		<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
		<?php endif?>
		</div>
			<table border="0" cellpadding="0" cellspacing="0" width="950">
				<tr>
					<td id="leftsd" valign="top">
						<?php //$this->renderPartial("//include/social_header");?>
					</td>
					<td valign="top">
						<div id="BPcolMain" style="width:100%">
							<?php echo $content; ?>
						</div>
					</td>
				</tr>
			</table>

			<div id="bannerbottom" style="height:12px;">
				<div class="toprint" style="padding-top:20px;" align="center">
					<div id="banadiframe" class="bacenterd" style="margin:5px 0 5px 15px;z-index:1000;"></div>
				</div>
			</div>
		</div>
		<?php echo $this->renderPartial("//include/footer");?>
	</div>
</body>
</html>
