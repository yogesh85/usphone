<?php

// auto-loading fix
Yii::setPathOfAlias('AreaCode', dirname(__FILE__));
Yii::import('AreaCode.*');

class AreaCode extends BaseAreaCode
{
	public $min_area_interchange;
	public $max_area_interchange;
	// Add your model-specific methods here. This file will not be overriden by gtc except you force it.
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function init()
	{
		return parent::init();
	}

	public function __toString() {
		return (string) $this->area_code;

	}

	public function behaviors() 
	{
		return array_merge(parent::behaviors(),array(
));
	}




	public function rules() 
	{
		return array_merge(
				/*array('column1, column2', 'rule'),*/
				parent::rules()
				);
	}

}
