<?php
/**
 * NewFeed  class file.
 *
 */

/**
 * NewFeed is a class for...
 *
 *
 */

/**
 * This is the model class for table "new_feed".
 *
 * The followings are the available columns in table 'new_feed':
 * @property integer $id
 * @property string $title
 * @property string $url
 * @property string $timestamp
 * @property string $content
 * @property string $state
 */
class NewFeed extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return NewFeed the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'new_feed';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, url, timestamp, content, state', 'required'),
			array('state', 'length', 'max'=>5),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, url, timestamp, content, state', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'url' => 'Url',
			'timestamp' => 'Timestamp',
			'content' => 'Content',
			'state' => 'State',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);

		$criteria->compare('title',$this->title,true);

		$criteria->compare('url',$this->url,true);

		$criteria->compare('timestamp',$this->timestamp,true);

		$criteria->compare('content',$this->content,true);

		$criteria->compare('state',$this->state,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}