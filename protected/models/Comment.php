<?php

// auto-loading fix
Yii::setPathOfAlias('Comment', dirname(__FILE__));
Yii::import('Comment.*');

class Comment extends BaseComment
{
	// Add your model-specific methods here. This file will not be overriden by gtc except you force it.
	public static function model($className=__CLASS__)
	{
		
		$className = (is_null($className)) ? __CLASS__ : $className;
		$params = func_get_args(); 
		$new_table_id = (is_array($params) && isset($params[1])) ? $params[1] : NULL;
		$model = new $className(null, $new_table_id);
		$model->_md=new CActiveRecordMetaData($model);
		$model->attachBehaviors($model->behaviors());
		return $model;
	}

	public function init()
	{
		return parent::init();
	}

	public function __toString() {
		return (string) $this->comment;

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
