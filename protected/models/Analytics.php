<?php

// auto-loading fix
Yii::setPathOfAlias('Analytics', dirname(__FILE__));
Yii::import('Analytics.*');

class Analytics extends BaseAnalytics
{
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
		'CTimestampBehavior' => array(
				'class' => 'zii.behaviors.CTimestampBehavior',
				'createAttribute' => 'timestamp',
				'updateAttribute' => null,
					),

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
