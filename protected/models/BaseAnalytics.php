<?php

/**
 * This is the model base class for the table "analytics".
 *
 * Columns in table "analytics" available as properties of the model:
 * @property integer $id
 * @property string $area_code
 * @property string $area_interchange
 * @property string $phone_number
 * @property string $action
 * @property string $client_ip
 * @property string $site
 * @property string $timestamp
 *
 * There are no model relations.
 */
abstract class BaseAnalytics extends CActiveRecord{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'analytics';
	}

	public function rules()
	{
		return array(			
			array('action', 'required'),
			array('area_code, area_interchange', 'length', 'max'=>3),
			array('phone_number', 'length', 'max'=>12),
			array('action', 'length', 'max'=>16),
			array('client_ip', 'length', 'max'=>15),
			array('site', 'length', 'max'=>22),
			array('id, area_code, area_interchange, phone_number, action, client_ip, site, timestamp', 'safe', 'on'=>'search'),
			
			array('site', 'default', 'value'=> Yii::t('custom', 'site.domain'), 'setOnEmpty'=>false,'on'=>'insert'),
			array('client_ip', 'default', 'value'=>(isset($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR'] : '', 'setOnEmpty'=>false,'on'=>'insert'),
			array('timestamp', 'default', 'value'=>new CDbExpression('NOW()'), 'setOnEmpty'=>false,'on'=>'insert'),
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
			'area_code' => Yii::t('app', 'Area Code'),
			'area_interchange' => Yii::t('app', 'Area Interchange'),
			'phone_number' => Yii::t('app', 'Phone Number'),
			'action' => Yii::t('app', 'Action'),
			'client_ip' => Yii::t('app', 'Client Ip'),
			'site' => Yii::t('app', 'Site'),
			'timestamp' => Yii::t('app', 'Timestamp'),
		);
	}


	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('area_code', $this->area_code, true);
		$criteria->compare('area_interchange', $this->area_interchange, true);
		$criteria->compare('phone_number', $this->phone_number, true);
		$criteria->compare('action', $this->action, true);
		$criteria->compare('client_ip', $this->client_ip, true);
		$criteria->compare('site', $this->site, true);
		$criteria->compare('timestamp', $this->timestamp, true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
	
	public function get_label()
	{
		return '#'.$this->id;		
		
			}
	
}
