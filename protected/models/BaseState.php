<?php

/**
 * This is the model base class for the table "state".
 *
 * Columns in table "state" available as properties of the model:
 * @property integer $id
 * @property string $name
 * @property string $abbreviation
 * @property string $status
 * @property string $capital
 * @property string $population
 * @property string $area_total
 * @property string $area_land
 * @property string $area_water
 * @property string $country
 *
 * Relations of table "state" available as properties of the model:
 * @property AreaCode[] $areaCodes
 * @property County[] $counties
 */
abstract class BaseState extends CActiveRecord{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'state';
	}

	public function rules()
	{
		return array(
			array('name', 'unique'),
			array('name', 'identificationColumnValidator'),
			array('name, abbreviation, status, capital, population, area_total, area_land, area_water, country', 'required'),
			array('name, capital', 'length', 'max'=>55),
			array('abbreviation, country', 'length', 'max'=>5),
			array('status', 'length', 'max'=>11),
			array('area_total, area_land, area_water', 'length', 'max'=>22),
			array('id, name, abbreviation, status, capital, population, area_total, area_land, area_water, country', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'areaCodes' => array(self::HAS_MANY, 'AreaCode', 'state'),
			'counties' => array(self::HAS_MANY, 'County', 'state'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('app', 'ID'),
			'name' => Yii::t('app', 'Name'),
			'abbreviation' => Yii::t('app', 'Abbreviation'),
			'status' => Yii::t('app', 'Status'),
			'capital' => Yii::t('app', 'Capital'),
			'population' => Yii::t('app', 'Population'),
			'area_total' => Yii::t('app', 'Area Total'),
			'area_land' => Yii::t('app', 'Area Land'),
			'area_water' => Yii::t('app', 'Area Water'),
			'country' => Yii::t('app', 'Country'),
		);
	}


	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('abbreviation', $this->abbreviation, true);
		$criteria->compare('status', $this->status, true);
		$criteria->compare('capital', $this->capital, true);
		$criteria->compare('population', $this->population, true);
		$criteria->compare('area_total', $this->area_total, true);
		$criteria->compare('area_land', $this->area_land, true);
		$criteria->compare('area_water', $this->area_water, true);
		$criteria->compare('country', $this->country, true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
	
	public function get_label()
	{
		return '#'.$this->id;		
		
			}
	
}
