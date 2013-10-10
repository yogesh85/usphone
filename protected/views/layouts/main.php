<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bundle.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/profile.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/checkout.css" />

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
					<li class="ot_header_people"><a href="<?php echo Yii::app()->request->baseUrl; ?>"><span>States</span></a></li>
					<li class="ot_header_people"><a href="<?php echo Yii::app()->request->baseUrl; ?>"><span>List Of Area Codes</span></a></li>
				</ul>
			</div>
			<div class="search-bar spclear;">
				<a title="Yellow Pages" class="logo ot_header_logo" href=""></a>
				<script type="text/javascript">
					function verifyNumber() {
						var number = document.getElementById("what_number").value;
						var numArr = new Array();
						for(var i=0;i<number.length;i++) {
							var dig = number.substring(i, i+1);
							var RE = /^-{0,1}\d*\.{0,1}\d+$/;
							if(RE.test(dig)) numArr.push(dig);
						}
						if(numArr.length==10) {
							var url = numArr.join("");
							url = "<?php echo Yii::app()->request->baseUrl;?>/trace/" + url.substring(0, 3) + "-" + url.substring(3, 6) + "-" + url.substring(6, 11);
							document.location = url;
						} else {
							var t = numArr.join("");
							var numbr = "";
							if(t.length >= 3) numbr += "("+ t.substring(0, 3) +") "
							if(t.length >= 6) numbr += t.substring(3, 6) + "-";
							if(t.length >= 10) numbr += t.substring(6, 10);
							document.getElementById("what_number").value = numbr;
						}
						return false;
					}
				</script>
				<form action="" method="POST" id="phone_search_form" onsubmit="return verifyNumber();">
					<input id="what_number" name="C" class="search-box sfield_OF" autocomplete="off" size="25" maxlength="13" type="text" placeholder="Search Phone Number">
					<div style="width:103px; height:72px; float:left;">
						<input class="submit" name="submit" value="Search" type="submit">
					</div>
				</form>
			</div><!--end search-bar-->
		</div><!--end masthead-->
		<div style="clear:both;font-size:5px;height:7px">&nbsp;</div>
		<div class="brdcrumb">
		
		<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
		<?php endif?>
		</div>
		<div id="BPtopbar">
			<div style="display: block;" class="BPrail"></div>
		</div>
		<div id="BPcontainer">
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
			<div class="copy-wrapper">
				<p class="data"><?php echo Yii::t("custom", "site.domain"); ?></p>
				<p class="copyright">Copyright &copy; <?php echo date("Y")?> <a href="<?php echo Yii::t("custom", "site.domain"); ?>"><?php echo Yii::t("custom", "site.domain"); ?></a> All rights reserved. * Restrictions apply.</p>
			</div>
		</div>
	</div>
</body>
</html>
