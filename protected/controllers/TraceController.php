<?php

class TraceController extends Controller
{
	public $title;
	public $pageTitle;
	public $description;
	public $keyword;
	public function actionCheckout($areaCode, $areaInterchange, $digit4)
	{
		
		Clicky::trace($areaCode, $areaInterchange, $digit4);
		
		$params = array(
			'{area_code}' => $areaCode,
			'{area_interchange}' => $areaInterchange,
			'{digit4}' => $digit4,
		);
		$this->pageTitle = Yii::t("custom", "checkout.titletag", $params);
		$this->description = Yii::t("custom", "checkout.descriptiontag", $params);
		$this->keyword = Yii::t("custom", "checkout.keyword", $params);
		$this->title = Yii::t("custom", "checkout.title", $params);
		$this->render('checkout', array('area_code' => $areaCode, 'area_interchange' => $areaInterchange,'digit4'=>$digit4));
	}

	public function actionDetail($areaCode, $areaInterchange, $digit4)
	{
		Clicky::trace($areaCode, $areaInterchange, $digit4);
		
		$criteria = new CDbCriteria();
		$criteria->select = "`area_code`, `region`, `company_number`, `company`, `status`, `usage`, `introduced`, `region`, `county`";
		$criteria->condition = "area_code = $areaCode AND area_interchange = $areaInterchange";
		$interchangeObj = AreaInterchange::model()->find($criteria);
		
		$params = array(
			'{area_code}' => $areaCode,
			'{area_interchange}' => $areaInterchange,
			'{digit4}' => $digit4,
			'{city}' => $digit4,
			'{state}' => @$interchangeObj->areaCode->state0->name,
			'{state_code}' => @$interchangeObj->areaCode->state,
		);
		$this->pageTitle = Yii::t("custom", "detail.titletag", $params);
		$this->description = Yii::t("custom", "detail.descriptiontag", $params);
		$this->keyword = Yii::t("custom", "detail.keyword", $params);
		$this->title = Yii::t("custom", "detail.title", $params);
		
		
		if(!empty($interchangeObj->region)) {
			$crit = new CDbCriteria();
			$crit->select="`lat`, `long`";
			if(!empty($interchangeObj->county))
				$crit->condition = "lat > 0 AND county = '{$interchangeObj->county}' AND replace(location, ' ', '') like '".str_replace(" ", "", $interchangeObj->region)."%' ";
			else
				$crit->condition = "lat > 0 AND county = '{$interchangeObj->county}' AND replace(location, ' ', '') like '".str_replace(" ", "", $interchangeObj->region)."%' ";
			$latobj = Zip::model()->find($crit);
			$lat = @$latobj->lat;
			$long = @$latobj->long;

		}
		
		$cr = new CommentReader;
		$comments = $cr->getNumberComments($areaCode."-".$areaInterchange."-".$digit4, Constants::$COMMENTS_TRACE);
		
		$this->render('detail', array(
			'state' => @$interchangeObj->areaCode->state0->name,
			'state_code' => @$interchangeObj->areaCode->state,
			'area_code' => $areaCode,
			'area_interchange' => $areaInterchange,
			'digit4' => $digit4,
			'region' => @$interchangeObj->region,
			'company_number' => @$interchangeObj->company_number,
			'company' => @$interchangeObj->company,
			'status' => @$interchangeObj->status,
			'usage' => @$interchangeObj->usage,
			'introduced' => @$interchangeObj->introduced,
			'county' => @$interchangeObj->county,
			'latitude' => @$lat,
			'longitude' => @$long,
			'comments' => $comments,
		));
	}
	
	public function actionAddComment($areaCode, $areaInterchange, $digit4) {
		$result = array("result" => "", "message" => "");
		$comment = new Comment();
		$comment -> area_code = $areaCode;
		$comment -> area_interchange_code = $areaInterchange;
		$comment -> phone_number = $areaCode."-".$areaInterchange."-".$digit4;
		$_POST['user_name'] = trim($_POST['user_name']);
		$_POST['comment'] = trim($_POST['comment']);
		
		if(isset($_POST['user_name']) AND !empty($_POST['user_name'])) $comment -> user_name = $_POST['user_name'];
		if(isset($_POST['comment']) AND !empty($_POST['comment'])) {
			if(strlen($_POST['comment']) > 20) {
				$comment -> comment = strip_tags(stripslashes(trim($_POST['comment'])));
				if(!$comment -> save()) {
					$result['result'] = "error";
					$result['message'] = "There is some technical issue in adding comment.";
				} else {
					$result['result'] = "success";
					$result['message'] = "Your review added to our database.";
				}
			} else {
				$result['result'] = "error";
				$result['message'] = "Comment should have at least 20 charactes.";
			}
		} else {
			$result['result'] = "error";
			$result['message'] = "Please add Comment";
		}
		echo json_encode($result);
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}
