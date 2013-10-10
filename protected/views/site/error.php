<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Error',
);
?>

<div class="BPcoreContainer" style="width:100%">

<h1>Error <?php echo $code; ?></h1>

<div class="tb1 error" style="color:red;padding:0;">
<?php echo CHtml::encode($message); ?>
</div>
</div>
