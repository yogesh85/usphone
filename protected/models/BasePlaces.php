<?php

/**
 * This is the model base class for the table "places".
 *
 * Columns in table "places" available as properties of the model:
 * @property integer $id
 * @property string $name
 * @property string $status
 * @property string $county
 * @property string $pop_1990
 * @property string $pop_2000
 * @property string $pop_2010
 * @property string $pop_2012
 * @property string $population
 * @property string $state
 *
 * There are no model relations.
 */
abstract class BasePlaces extends CActiveRecord{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'places';
	}

	public function rules()
	{
		return array(
			array('name', 'unique'),
			array('name', 'identificationColumnValidator'),
			array('name, status, county, pop_1990, pop_2000, pop_2010, pop_2012, population, state', 'required'),
			array('name, county', 'length', 'max'=>55),
			array('status, state', 'length', 'max'=>22),
			array('pop_1990, pop_2000, pop_2010, pop_2012', 'length', 'max'=>11),
			array('id, name, status, county, pop_1990, pop_2000, pop_2010, pop_2012, population, state', 'safe', 'on'=>'search'),
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
			'name' => Yii::t('app', 'Name'),
			'status' => Yii::t('app', 'Status'),
			'county' => Yii::t('app', 'County'),
			'pop_1990' => Yii::t('app', 'Pop 1990'),
			'pop_2000' => Yii::t('app', 'Pop 2000'),
			'pop_2010' => Yii::t('app', 'Pop 2010'),
			'pop_2012' => Yii::t('app', 'Pop 2012'),
			'population' => Yii::t('app', 'Population'),
			'state' => Yii::t('app', 'State'),
		);
	}


	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('status', $this->status, true);
		$criteria->compare('county', $this->county, true);
		$criteria->compare('pop_1990', $this->pop_1990, true);
		$criteria->compare('pop_2000', $this->pop_2000, true);
		$criteria->compare('pop_2010', $this->pop_2010, true);
		$criteria->compare('pop_2012', $this->pop_2012, true);
		$criteria->compare('population', $this->population, true);
		$criteria->compare('state', $this->state, true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
	
	public function get_label()
	{
		return '#'.$this->id;		
		
			}
	
}
