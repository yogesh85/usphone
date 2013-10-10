<?php

/**
 * This is the model base class for the table "area_code".
 *
 * Columns in table "area_code" available as properties of the model:
 * @property integer $id
 * @property string $area_code
 * @property string $state
 *
 * Relations of table "area_code" available as properties of the model:
 * @property State $state0
 * @property AreaInterchange[] $areaInterchanges
 */
abstract class BaseAreaCode extends CActiveRecord{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'area_code';
	}

	public function rules()
	{
		return array(
			array('area_code', 'unique'),
			array('area_code', 'identificationColumnValidator'),
			array('area_code, state', 'required'),
			array('area_code, state', 'length', 'max'=>5),
			array('id, area_code, state', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'state0' => array(self::BELONGS_TO, 'State', 'state'),
			'areaInterchanges' => array(self::HAS_MANY, 'AreaInterchange', 'area_code'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('app', 'ID'),
			'area_code' => Yii::t('app', 'Area Code'),
			'state' => Yii::t('app', 'State'),
		);
	}


	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('area_code', $this->area_code, true);
		$criteria->compare('state', $this->state);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
	
	public function get_label()
	{
		return '#'.$this->id;		
		
			}
	
}
