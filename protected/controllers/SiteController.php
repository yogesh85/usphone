<?php

class SiteController extends Controller
{
	public $description;
	public $keyword;
	public $_commentReader;
	public $comments;
	public $areaCodeList;
	public $recently_searched_number;
	public $mostly_searched_number;
	
	public $areaCode;
	public $areaInterchange;
	public $time_zone;
	public $lat;
	public $long;
	public $state;
	public $county;
	public $city;
	public $stateCode;
	public $isTollFree = false;
	public $interchangeObj;

	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}
	
	public function SiteController() {
		$this->layout = "main";
		$this->_commentReader = new CommentReader();
	}


	public function actionIndex()
	{
		$this->pageTitle = Yii::t("custom", "homepage.titletag");
		$this->description = Yii::t("custom", "homepage.descriptiontag");
		$this->keyword = Yii::t("custom", "homepage.keyword");
		
		Clicky::trace();
		$this->comments = $this->_commentReader->getRecentComments(Constants::$COMMENTS_HOME);
		$this->areaCodeList = AreaCode::model()->findAll();
		
		
		$phone = array();
		while(true) {
			$criteria = new CDbCriteria();
			$criteria -> select = "phone_number";
			$criteria -> order = "timestamp DESC";
			$criteria -> limit = Constants::HOME_SEARCHED_NUMBER_COUNT - count($phone);
			if(count($phone) > 0) {
				$criteria -> condition = "phone_number NOT IN ('".implode("', '", $phone)."') AND action = 'detail' AND site = '".Yii::t('custom', 'site.domain')."'";
			} else {
				$criteria -> condition = "action = 'detail' AND site = '".Yii::t('custom', 'site.domain')."'";
			}
			$analytics = Analytics::model()->findAll($criteria);
			unset($criteria);
			if(count($analytics) == 0) break;
			foreach($analytics as $val) {
				if(!in_array($val['phone_number'], $phone)) $phone[] = $val['phone_number'];
				if(count($phone) >= Constants::HOME_SEARCHED_NUMBER_COUNT) break;
			}
			unset($analytics);
			if(count($phone) >= Constants::HOME_SEARCHED_NUMBER_COUNT) break;
			
		}
		$this->recently_searched_number = $phone;
		unset($phone);
		
			
		$analytics = Yii::app()->db->createCommand()->select("phone_number, count(*) as total")->from("analytics a")
			->where("site = '".Yii::t("custom", "site.domain")."' AND length(phone_number) >= 10")
			->group("phone_number")->order('total DESC')->limit(Constants::MOSTLY_SEARCHED_NUMBER)->queryAll();
		$this->mostly_searched_number = array();
		foreach($analytics as $val) array_push($this->mostly_searched_number, $val['phone_number']);
		
		$this->render('//site/index');
	}

	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('//site/error', $error);
		}
	}
	
	public function actionAreaCode($number) {
		
		$this->areaCode = $number;
		Clicky::trace($this->areaCode);
		if(in_array($number, Constants::$tollFreeNumbers)) {
			$this -> isTollFree = true;
			$this->render('//site/areaCodeTollFree', array('stateInfo' => $model->state0, 'params' => $params));
		} else {
			
			$model = AreaCode::model()->find("area_code = {$this->areaCode}");
			
			if(!isset($model->state)) throw new CHttpException(404,"OOps !! This area code $this->areaCode does not exist in our database !!!!!!!!");
			
			$this->stateCode = $model->state;
			$this->state = @$model->state0->name;
			
			$time_zone_arr = explode(",", $model->state0->time_zone);
			if(isset($time_zone_arr[1])) { 
				if(strtotime("now") >= strtotime("10 March 2013") AND strtotime("now") <= strtotime("3 November 2013")) {
					if(strpos($time_zone_arr[count($time_zone_arr) - 1], "*") > 0) {
						@$this->time_zone = "UTC".(intval(str_replace(array("UTC", "*", " "), "", $time_zone_arr[0])) +1);
						@$this->time_zone .= ",UTC".(intval(str_replace(array("UTC", "*", " "), "", $time_zone_arr[1])) +1);
					} else {
						$this->time_zone = @$time_zone_arr[1];
					}
				} else {
					$this->time_zone = @$time_zone_arr[0];
				}
			} else {
				$this->time_zone = @$time_zone_arr[0];
			}	
						
			$criteria = new CDbCriteria();
			$criteria->select = "lat, `long`";
			$criteria->condition = "`area_code` = '{$this->areaCode}' AND length(`lat`) > 1 AND length(`long`) > 1";
			$criteria->limit = 1;
			$zip = Zip::model()->find($criteria);			
			$this->lat = @$zip->lat;
			$this->long = @$zip->long;
						
			$params = array(
				"{area_code}" => $this->areaCode,
				"{state}" => $this->state,
				"{state_code}" => $this->stateCode,
				"{lat}" => $this->lat,
				"{long}" => $this->long,
			);			
			
			$this->pageTitle = Yii::t("custom", "areaCode.titletag", $params);
			$this->description = Yii::t("custom", "areaCode.descriptiontag", $params);
			$this->keyword = Yii::t("custom", "areaCode.keyword", $params);
		
			$this->comments = $this->_commentReader->getRecentComments(Constants::$COMMENTS_AREA_CODE, null, $this->areaCode);
			
			$this->interchangeObj = AreaInterchange::model()->findAll("area_code = {$this->areaCode}");
			
			$criteria = new CDbCriteria();
			$criteria->select = "area_code";
			$criteria->condition = "state = '$this->stateCode'";
			$area_code_obj = AreaCode::model()->findAll($criteria);
			foreach($area_code_obj as $val) {
				$other_area_codes[] = $val->area_code;
			}
			$other_area_codes = AreaCode::model()->findAll($criteria);
			$this->render('//site/areaCode', array('stateInfo' => $model->state0, 'params' => $params, 'other_area_codes' => $other_area_codes));
		}
		
		
	}
	
	public function actionInterchange($areaCode, $areaInterchange) {
		$this->areaCode = $areaCode;
		$this->areaInterchange = $areaInterchange;
		Clicky::trace($this->areaCode, $this->areaInterchange);
		
		$interchange_model = AreaInterchange::model()->find("area_code = {$this->areaCode} AND area_interchange = {$this->areaInterchange}");
		if(!isset($interchange_model->area_code)) throw new CHttpException(404,"OOps !! This area interchange $this->areaCode-$this->areaInterchange does not exist in our database !!!!!!!!");
		$this->interchangeObj = $interchange_model;
		
		$area_code_obj = AreaCode::model()->find("area_code = {$this->areaCode}");
		$this->stateCode = $area_code_obj->state;
		$this->state = $area_code_obj->state0->name;
		
		$time_zone_arr = explode(",", $area_code_obj->state0->time_zone);
		if(isset($time_zone_arr[1])) { 
			if(strtotime("now") >= strtotime("10 March 2013") AND strtotime("now") <= strtotime("3 November 2013")) {
				if(strpos($time_zone_arr[count($time_zone_arr) - 1], "*") > 0) {
					@$this->time_zone = "UTC".(intval(str_replace(array("UTC", "*", " "), "", $time_zone_arr[0])) +1);
					@$this->time_zone .= ",UTC".(intval(str_replace(array("UTC", "*", " "), "", $time_zone_arr[1])) +1);
				} else {
					$this->time_zone = @$time_zone_arr[1];
				}
			} else {
				$this->time_zone = @$time_zone_arr[0];
			}
		} else {
			$this->time_zone = @$time_zone_arr[0];
		}
		
		$criteria = new CDbCriteria();
		$criteria->select = "lat, `long`, lcase(location) as location, zip_code";
		$criteria ->condition = "county = '{$interchange_model->county}' AND length(lat) > 0 ORDER BY population DESC";
		$obj1 = Zip::model()->findAll($criteria);
				
		$zip = "";
		$cities = array();
		$map = array();
		foreach($obj1 as $val) {
			if(count($cities) >= 10) break;
			if(!in_array($val->location, $cities)) {
				$cities[] = $val->location;
				$map[] = array('lat' => $val->lat, 'long' => $val->long, 'name' => $val->location, 'zip' => $val->zip_code);
			}
		}
		if(!empty($interchange_model->latitude) AND $interchange_model->latitude > 0) {
			$this->lat = $interchange_model->latitude; 
			$this->long = $interchange_model->longitude;
		} else {
			$this->lat = @$map[0]['lat'];
			$this->long = @$map[0]['long']; 
		}
		
		$criteria = new CDbCriteria();
		$criteria->select = "*, (((acos(sin(({$this->lat}*pi()/180)) * sin((`lat`*pi()/180))+cos(({$this->lat}*pi()/180)) * cos((`lat`*pi()/180)) * cos((({$this->long}- `long`)* pi()/180))))*180/pi())*60*1.1515	) as distance";
		if(!empty($interchange_model->county)) $criteria->condition = "state = '{$this->stateCode}' AND county IN(\"".implode('", "', explode("/", str_replace(array(" / ", " /", "/ "), "/", $interchange_model->county)))."\")";
		else $criteria->condition = "state = '{$this->stateCode}'";
		$criteria->order = "distance";
		$criteria->limit = 10;
		$obj2 = Zip::model()->findAll($criteria);
		//$obj2 = Zip::model()->findAll("county = '{$interchange_model->county}' AND replace(location, ' ', '') like '".str_replace(" ", "", $interchange_model->region)."%' ");							
		$zip_code_arr = array();
		foreach($obj2 as $val) {
			$zip_code_arr[] = $val->zip_code;
		}

		/*take min distance from zip and get zip code*/
		$zip = @$zip_code_arr[0];
		
		$criteria = new CDbCriteria();
		$criteria->select = "population";
		$criteria->condition = "county = '{$interchange_model->county}' AND replace(name, ' ', '') like '".str_replace(" ", "", $interchange_model->region)."%' ";
		$obj3 = Places::model()->find($criteria);
		$pop = array();
		if(isset($obj3->population) AND !empty($obj3->population)) {
			$pop = unserialize($obj3->population);
			ksort($pop);
		}

		$params = array(
			"{area_code}" => $this->areaCode,
			"{area_interchange}" => $this->areaInterchange,
			"{state_code}" => $area_code_obj->state,
			"{state}" => $area_code_obj->state0->name,
			"{county}" => $interchange_model->county,
			"{city}" => $interchange_model->region,
			"{lat}" => $this->lat,
			"{long}" => $this->long,
			"{zip}" => $zip,
		);
				
		$this->pageTitle = Yii::t("custom", "areaInterchange.titletag", $params);
		$this->description = Yii::t("custom", "areaInterchange.descriptiontag", $params);
		$this->keyword = Yii::t("custom", "areaInterchange.keyword", $params);
		
		$places = Places::model()->findAll("county = '{$params['{county}']}'");
		
		$this->comments = $this->_commentReader->getRecentComments(Constants::$COMMENTS_AREA_INTERCHANGE, null, $this->areaCode, $this->areaInterchange);
	
	
		$phone = array();
		while(true) { 
			$criteria = new CDbCriteria();
			$criteria -> select = "phone_number";
			$criteria -> order = "timestamp DESC";
			$criteria -> limit = Constants::HOME_SEARCHED_NUMBER_COUNT - count($phone);
			if(count($phone) > 0) {
				$criteria -> condition = "site = '".Yii::t('custom', 'site.domain')."' AND phone_number NOT IN ('".implode("', '", $phone)."') AND action = 'detail'";
			} else {
				$criteria -> condition = "site = '".Yii::t('custom', 'site.domain')."' AND action = 'detail'";
			}
			$analytics = Analytics::model()->findAll($criteria);
			unset($criteria);
			if(count($analytics) == 0) break;
			foreach($analytics as $val) {
				if(!in_array($val['phone_number'], $phone)) $phone[] = $val['phone_number'];
				if(count($phone) >= Constants::HOME_SEARCHED_NUMBER_COUNT) break;
			}
			unset($analytics);
			if(count($phone) >= Constants::HOME_SEARCHED_NUMBER_COUNT) break;
		}
		$this->recently_searched_number = $phone;
		unset($phone);
		
		$analytics = Yii::app()->db->createCommand()->select("phone_number, count(*) as total")->from("analytics a")
			->where("area_code = '{$this->areaCode}' AND area_interchange = '{$this->areaInterchange}' AND site = '".Yii::t("custom", "site.domain")."' AND length(phone_number) >= 10")
			->group("phone_number")->order('total DESC')->limit(Constants::MOSTLY_SEARCHED_NUMBER)->queryAll();
		$arr = array();
		$this->mostly_searched_number = array();
		foreach($analytics as $val) array_push($this->mostly_searched_number, $val['phone_number']);
		
		$this->render('//site/areaInterchange', array(
			'zip_codes' => $zip_code_arr, 
			'places' => $places, 
			'params' => $params, 
			'other_cities' => $cities, 
			'map' => $map,
			'allCityObj' => $obj2,
			'placePopulation' => $pop,
		));
	}
	
	public function actionAreaCodeDirectory() {
		$this->render('//site/areaCodeDirectory', array('area_code'=>AreaCode::model()->findAll()));
	}
	
	public function SEOshuffle(&$items, $seed=false) {
		$original = md5(serialize($items));
		mt_srand(crc32(($seed) ? $seed : $items[0]));
		for ($i = count($items) - 1; $i > 0; $i--){
			$j = @mt_rand(0, $i);
			list($items[$i], $items[$j]) = array($items[$j], $items[$i]);
		}
		if ($original == md5(serialize($items))) {
			list($items[count($items) - 1], $items[0]) = array($items[0], $items[count($items) - 1]);
		}
	}
}
