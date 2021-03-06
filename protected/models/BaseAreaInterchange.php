<?php

/**
 * This is the model base class for the table "area_interchange".
 *
 * Columns in table "area_interchange" available as properties of the model:
 * @property integer $id
 * @property string $area_code
 * @property string $area_interchange
 * @property string $state
 * @property string $company_number
 * @property string $company
 * @property string $status
 * @property string $usage
 * @property string $introduced
 * @property string $region
 * @property string $county
 * @property string $latitude
 * @property string $longitude
 * @property string $population
 *
 * Relations of table "area_interchange" available as properties of the model:
 * @property AreaCode $areaCode
 */
abstract class BaseAreaInterchange extends CActiveRecord{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'area_interchange';
	}

	public function rules()
	{
		return array(
			array('area_code, area_interchange, state, company_number, company, status, usage, introduced, region, county, latitude, longitude, population', 'required'),
			array('area_code, area_interchange, state', 'length', 'max'=>5),
			array('company_number', 'length', 'max'=>9),
			array('company', 'length', 'max'=>55),
			array('status, usage, latitude, longitude', 'length', 'max'=>15),
			array('region, county', 'length', 'max'=>35),
			array('population', 'length', 'max'=>11),
			array('id, area_code, area_interchange, state, company_number, company, status, usage, introduced, region, county, latitude, longitude, population', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'areaCode' => array(self::BELONGS_TO, 'AreaCode', 'area_code'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('app', 'ID'),
			'area_code' => Yii::t('app', 'Area Code'),
			'area_interchange' => Yii::t('app', 'Area Interchange'),
			'state' => Yii::t('app', 'State'),
			'company_number' => Yii::t('app', 'Company Number'),
			'company' => Yii::t('app', 'Company'),
			'status' => Yii::t('app', 'Status'),
			'usage' => Yii::t('app', 'Usage'),
			'introduced' => Yii::t('app', 'Introduced'),
			'region' => Yii::t('app', 'Region'),
			'county' => Yii::t('app', 'County'),
			'latitude' => Yii::t('app', 'Latitude'),
			'longitude' => Yii::t('app', 'Longitude'),
			'population' => Yii::t('app', 'Population'),
		);
	}


	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('area_code', $this->area_code);
		$criteria->compare('area_interchange', $this->area_interchange, true);
		$criteria->compare('state', $this->state, true);
		$criteria->compare('company_number', $this->company_number, true);
		$criteria->compare('company', $this->company, true);
		$criteria->compare('status', $this->status, true);
		$criteria->compare('usage', $this->usage, true);
		$criteria->compare('introduced', $this->introduced, true);
		$criteria->compare('region', $this->region, true);
		$criteria->compare('county', $this->county, true);
		$criteria->compare('latitude', $this->latitude, true);
		$criteria->compare('longitude', $this->longitude, true);
		$criteria->compare('population', $this->population, true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
	
	public function get_label()
	{
		return '#'.$this->id;		
		
			}
	
}
