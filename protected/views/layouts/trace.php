<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bundle.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/profile.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/checkout.css" />
	<style>#idneededforprint { background:none; } </style>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<meta name="keywords" content="<?php echo CHtml::encode($this->description); ?>">
	<meta name="description" content="<?php echo CHtml::encode($this->keyword); ?>">
</head>

<body id="idneededforprint">
	<div class="master" id="page0">
		<div id="city_image" class="masthead noprint">		
			<div class="tabheader ">
				<ul class="nav spclear">
					<li class="current ot_header_businesses"><a href="<?php echo Yii::app()->request->baseUrl; ?>"><span>Home</span></a></li>
					<li class="ot_header_people"><a href="<?php echo (new Clicky)->areaCodeDirectoryUrl() ?>"><span>List Of Area Codes</span></a></li>
				</ul>
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
				<tbody><tr>
					<td id="leftsd" valign="top">
						<?php //$this->renderPartial("//include/social_header");?>
					</td>
					<td valign="top">
						<div id="BPcolMain" style="width:100%">
							<?php echo $content; ?>
						</div>
					</td>
				</tr>
			</tbody></table>

			<div id="bannerbottom" style="height:12px;">
				<div class="toprint" style="padding-top:20px;" align="center">
					<div id="banadiframe" class="bacenterd" style="margin:5px 0 5px 15px;z-index:1000;"></div>
				</div>
			</div>
		</div>
		<div class="footer">
			<div class="ftrancd">
				<a href="<?php echo Yii::app()->request->baseUrl; ?>"><span class="footer_anc">Home</span></a>
				<a href="<?php echo (new Clicky)->areaCodeDirectoryUrl() ?>"><span class="footer_anc">List Of Area Codes</span></a>
			</div>
			<div class="copy-wrapper">				
				<p class="data"><?php echo Yii::t("custom", "site.domain"); ?></p>
				<p class="copyright">Copyright &copy; <?php echo date("Y")?> <a href="<?php echo Yii::t("custom", "site.domain"); ?>"><?php echo Yii::t("custom", "site.domain"); ?></a> All rights reserved. * Restrictions apply.</p>
			</div>
		</div>
	</div>
</body>
</html>
