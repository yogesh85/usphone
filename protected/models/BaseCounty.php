<?php

/**
 * This is the model base class for the table "county".
 *
 * Columns in table "county" available as properties of the model:
 * @property integer $id
 * @property string $county
 * @property string $status
 * @property string $county_fips_code
 * @property string $state
 * @property string $population
 * @property string $OMB_CBSA_code
 * @property string $OMB_CSA_code
 * @property string $BEA_EA_code
 * @property string $BEA_CEA_code
 * @property string $OMB_CBSA_title
 * @property string $OMB_CBSA_type
 * @property string $OMB_CSA_title
 * @property string $BEA_EA_name
 * @property string $BEA_CEA_name
 *
 * Relations of table "county" available as properties of the model:
 * @property State $state0
 */
abstract class BaseCounty extends CActiveRecord{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'county';
	}

	public function rules()
	{
		return array(
			array('county', 'unique'),
			array('county', 'identificationColumnValidator'),
			array('county, status, county_fips_code, state, population, OMB_CBSA_code, OMB_CSA_code, BEA_EA_code, BEA_CEA_code, OMB_CBSA_title, OMB_CBSA_type, OMB_CSA_title, BEA_EA_name, BEA_CEA_name', 'required'),
			array('county, county_fips_code, OMB_CBSA_code, OMB_CSA_code, BEA_EA_code, BEA_CEA_code, OMB_CBSA_title, OMB_CBSA_type, OMB_CSA_title, BEA_EA_name, BEA_CEA_name', 'length', 'max'=>100),
			array('status', 'length', 'max'=>22),
			array('state', 'length', 'max'=>5),
			array('id, county, status, county_fips_code, state, population, OMB_CBSA_code, OMB_CSA_code, BEA_EA_code, BEA_CEA_code, OMB_CBSA_title, OMB_CBSA_type, OMB_CSA_title, BEA_EA_name, BEA_CEA_name', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'state0' => array(self::BELONGS_TO, 'State', 'state'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('app', 'ID'),
			'county' => Yii::t('app', 'County'),
			'status' => Yii::t('app', 'Status'),
			'county_fips_code' => Yii::t('app', 'County Fips Code'),
			'state' => Yii::t('app', 'State'),
			'population' => Yii::t('app', 'Population'),
			'OMB_CBSA_code' => Yii::t('app', 'Omb Cbsa Code'),
			'OMB_CSA_code' => Yii::t('app', 'Omb Csa Code'),
			'BEA_EA_code' => Yii::t('app', 'Bea Ea Code'),
			'BEA_CEA_code' => Yii::t('app', 'Bea Cea Code'),
			'OMB_CBSA_title' => Yii::t('app', 'Omb Cbsa Title'),
			'OMB_CBSA_type' => Yii::t('app', 'Omb Cbsa Type'),
			'OMB_CSA_title' => Yii::t('app', 'Omb Csa Title'),
			'BEA_EA_name' => Yii::t('app', 'Bea Ea Name'),
			'BEA_CEA_name' => Yii::t('app', 'Bea Cea Name'),
		);
	}


	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('county', $this->county, true);
		$criteria->compare('status', $this->status, true);
		$criteria->compare('county_fips_code', $this->county_fips_code, true);
		$criteria->compare('state', $this->state);
		$criteria->compare('population', $this->population, true);
		$criteria->compare('OMB_CBSA_code', $this->OMB_CBSA_code, true);
		$criteria->compare('OMB_CSA_code', $this->OMB_CSA_code, true);
		$criteria->compare('BEA_EA_code', $this->BEA_EA_code, true);
		$criteria->compare('BEA_CEA_code', $this->BEA_CEA_code, true);
		$criteria->compare('OMB_CBSA_title', $this->OMB_CBSA_title, true);
		$criteria->compare('OMB_CBSA_type', $this->OMB_CBSA_type, true);
		$criteria->compare('OMB_CSA_title', $this->OMB_CSA_title, true);
		$criteria->compare('BEA_EA_name', $this->BEA_EA_name, true);
		$criteria->compare('BEA_CEA_name', $this->BEA_CEA_name, true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
	
	public function get_label()
	{
		return '#'.$this->id;		
		
			}
	
}
