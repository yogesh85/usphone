<?php

/**
 * This is the model base class for the table "zip".
 *
 * Columns in table "zip" available as properties of the model:
 * @property integer $id
 * @property string $zip_code
 * @property string $location
 * @property string $area_code
 * @property string $population
 * @property string $avg_home_value
 * @property string $avg_people_per_house_hold
 * @property string $time_zone
 * @property string $county
 * @property string $establishment_count
 * @property string $employees_count
 * @property string $lat
 * @property string $long
 *
 * There are no model relations.
 */
abstract class BaseZip extends CActiveRecord{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'zip';
	}

	public function rules()
	{
		return array(
			array('zip_code', 'unique'),
			array('zip_code', 'identificationColumnValidator'),
			array('id, lat, long', 'required'),
			array('zip_code, location, area_code, population, avg_home_value, avg_people_per_house_hold, time_zone, county, establishment_count, employees_count', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id', 'numerical', 'integerOnly'=>true),
			array('zip_code, location, area_code, population, avg_home_value, avg_people_per_house_hold, time_zone, county, establishment_count, employees_count', 'length', 'max'=>100),
			array('lat, long', 'length', 'max'=>11),
			array('id, zip_code, location, area_code, population, avg_home_value, avg_people_per_house_hold, time_zone, county, establishment_count, employees_count, lat, long', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('app', 'ID'),
			'zip_code' => Yii::t('app', 'Zip Code'),
			'location' => Yii::t('app', 'Location'),
			'area_code' => Yii::t('app', 'Area Code'),
			'population' => Yii::t('app', 'Population'),
			'avg_home_value' => Yii::t('app', 'Avg Home Value'),
			'avg_people_per_house_hold' => Yii::t('app', 'Avg People Per House Hold'),
			'time_zone' => Yii::t('app', 'Time Zone'),
			'county' => Yii::t('app', 'County'),
			'establishment_count' => Yii::t('app', 'Establishment Count'),
			'employees_count' => Yii::t('app', 'Employees Count'),
			'lat' => Yii::t('app', 'Lat'),
			'long' => Yii::t('app', 'Long'),
		);
	}


	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('zip_code', $this->zip_code, true);
		$criteria->compare('location', $this->location, true);
		$criteria->compare('area_code', $this->area_code, true);
		$criteria->compare('population', $this->population, true);
		$criteria->compare('avg_home_value', $this->avg_home_value, true);
		$criteria->compare('avg_people_per_house_hold', $this->avg_people_per_house_hold, true);
		$criteria->compare('time_zone', $this->time_zone, true);
		$criteria->compare('county', $this->county, true);
		$criteria->compare('establishment_count', $this->establishment_count, true);
		$criteria->compare('employees_count', $this->employees_count, true);
		$criteria->compare('lat', $this->lat, true);
		$criteria->compare('long', $this->long, true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
	
	public function get_label()
	{
		return '#'.$this->id;		
		
			}
	
}
