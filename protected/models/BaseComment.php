<?php

/**
 * This is the model base class for the table "comment".
 *
 * Columns in table "comment" available as properties of the model:
 * @property integer $id
 * @property string $comment
 * @property string $phone_number
 * @property integer $area_code
 * @property integer $area_interchange_code
 * @property string $date
 * @property string $timestamp
 * @property string $user_name
 * @property string $is_spam
 *
 * There are no model relations.
 */
abstract class BaseComment extends CActiveRecord{
	
	
    protected $areaCode;
    protected $_md;

	public function __construct($scenario = 'insert', $areaCode = null) {
		if($areaCode != null) $this->areaCode = str_pad($areaCode, 3, "0", STR_PAD_LEFT);
		if($scenario != null) $this->setScenario($scenario);
		$this->setIsNewRecord(true);
		$this->afterConstruct();
		parent::__construct ($scenario);
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function populateRecord($attributes,$callAfterFind=true) {
		if($attributes!==false) {
			$record=$this->instantiate($attributes);
			$record->setScenario('update');
			$record->init();
			$md=$record->getMetaData();

			foreach($attributes as $name=>$value) {
				if(property_exists($record,$name)) $record->$name=$value;
				else if(isset($md->columns[$name])) $record->setAttribute($name, $value);
			}          
			$record->_pk=$record->getPrimaryKey();
			$record->attachBehaviors($record->behaviors());
			if($callAfterFind)	$record->afterFind();
			return $record;
		}
		else return null;
	}

	protected function instantiate($attributes) {            
		$class=get_class($this);
		$model=new $class(null, $this->areaCode);
		$model->_md=new CActiveRecordMetaData($model);
		$model->attachBehaviors($model->behaviors());
		$model->_attributes=$model->getMetaData()->attributeDefaults;
		//try and comment the below line of code and see if it still works
		$model->_attributes = $attributes;
		return $model;
	}
	
	public function tableName()
	{
		if($this->getDbConnection()->getSchema()->getTable('comment_' . $this->areaCode) != null AND $this->areaCode != null)
			return 'comment_' . $this->areaCode;
		else 
			return 'comment';
	}

	public function beforeSave() {

		if ($this->getIsNewRecord()){
			if($this->areaCode === null) {
				$manageTable = new ManageTables();
				$manageTable->insertCommentToChildTable($this);
			}
		}
		return parent::beforeSave();
	}

	public function rules()
	{
		return array(
			array('comment, phone_number, area_code, area_interchange_code, date, timestamp, user_name', 'default', 'setOnEmpty' => true, 'value' => null),
			array('area_code, area_interchange_code', 'numerical', 'integerOnly'=>true),
			array('phone_number', 'length', 'max'=>13),
			array('user_name', 'length', 'max'=>48),
			array('is_spam', 'length', 'max'=>5),
			array('comment, date, timestamp', 'safe'),
			array('id, comment, phone_number, area_code, area_interchange_code, date, timestamp, user_name, is_spam', 'safe', 'on'=>'search'),
			array('date', 'default', 'value'=>new CDbExpression('NOW()'), 'setOnEmpty'=>false,'on'=>'insert'),
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
			'comment' => Yii::t('app', 'Comment'),
			'phone_number' => Yii::t('app', 'Phone Number'),
			'area_code' => Yii::t('app', 'Area Code'),
			'area_interchange_code' => Yii::t('app', 'Area Interchange Code'),
			'date' => Yii::t('app', 'Date'),
			'timestamp' => Yii::t('app', 'Timestamp'),
			'user_name' => Yii::t('app', 'User Name'),
			'is_spam' => Yii::t('app', 'Is Spam'),
		);
	}


	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('comment', $this->comment, true);
		$criteria->compare('phone_number', $this->phone_number, true);
		$criteria->compare('area_code', $this->area_code);
		$criteria->compare('area_interchange_code', $this->area_interchange_code);
		$criteria->compare('date', $this->date, true);
		$criteria->compare('timestamp', $this->timestamp, true);
		$criteria->compare('user_name', $this->user_name, true);
		$criteria->compare('is_spam', $this->is_spam, true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
	
	public function get_label()
	{
		return '#'.$this->id;		
		
			}
	
}
