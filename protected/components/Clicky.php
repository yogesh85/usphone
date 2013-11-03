<?php

class Clicky extends CComponent {
    
    /**
     * This function returns the latest comments in the whole site
     * @param type $limit
     * @param type $offset
     * @return Comments 
     */

	public static function trace($areaCode=null, $areaInterchange = null, $digit4 = null, $action = null) {
		$analytics = new Analytics;
		
		if(!is_null($areaCode)) $analytics->area_code = $areaCode;
		if(!is_null($areaInterchange)) $analytics->area_interchange = $areaInterchange;
		if(!is_null($digit4)) $analytics->phone_number = $areaCode."-".$areaInterchange."-".$digit4;
		if(!is_null($action)) $analytics->action = $action;
		else $analytics->action = Yii::app()->getController()->action->id;
		//$analytics->client_ip = $_SERVER['REMOTE_ADDR'];
		if(!$analytics->save()){
			Yii::log($analytics->getErrors()); 
		}
	}
	
	public static function traceUrl($areaCode, $areaInterchange, $digit4) {
		return Yii::app()->request->baseUrl."/trace/$areaCode-$areaInterchange-$digit4";
	}
	public static function checkoutUrl($areaCode, $areaInterchange, $digit4) {
		return Yii::app()->request->baseUrl."/checkout/$areaCode-$areaInterchange-$digit4";
	}
	
	public function areaCodeUrl($areaCode) {
		return Yii::app()->baseUrl."/1-$areaCode/$areaCode";
	}
	public function areaInterchangeUrl($areaCode, $areaInterchange) {
		return Yii::app()->baseUrl."/1-$areaCode/$areaCode-$areaInterchange";
	}
	
	public function nextAreaCodeUrl($area_code) {
		$criteria = new CDbCriteria();
		$criteria -> select = "area_code";
		$criteria->limit = 1;
		$criteria->order = "area_code ASC";
		$criteria->condition = "area_code > $area_code";
		$temp_obj = AreaCode::model()->find($criteria);
		if(isset($temp_obj->area_code)) return array(
			"area_code" => $temp_obj->area_code, 
			"url" => $this->areaCodeUrl($temp_obj->area_code)
		);
		else return array("area_code" => "", "url" => "#");
	}
	public function previousAreaCodeUrl($area_code) {
		$criteria = new CDbCriteria();
		$criteria -> select = "area_code";
		$criteria->limit = 1;
		$criteria->order = "area_code DESC";
		$criteria->condition = "area_code < $area_code";
		$temp_obj = AreaCode::model()->find($criteria);
		if(isset($temp_obj->area_code)) return array(
			"area_code" => $temp_obj->area_code, 
			"url" => $this->areaCodeUrl($temp_obj->area_code)
		);
		else return array("area_code" => "", "url" => "#");
	}
	public function nextInterchangeUrl($area_code, $interchange) {
		$criteria = new CDbCriteria();
		$criteria -> select = "area_interchange";
		$criteria->limit = 1;
		$criteria->order = "area_interchange ASC";
		$criteria->condition = "area_interchange > $interchange";
		
		$temp_obj = AreaInterchange::model()->find($criteria);
		if(isset($temp_obj->area_interchange)) return array(
			"interchange" => $temp_obj->area_interchange, 
			"url" => $this->areaInterchangeUrl($area_code, $temp_obj->area_interchange)
		);
		else return array("interchange" => "", "url" => "#");
	}
	public function previousInterchangeUrl($area_code, $interchange) {
		$criteria = new CDbCriteria();
		$criteria -> select = "area_interchange";
		$criteria->limit = 1;
		$criteria->order = "area_interchange DESC";
		$criteria->condition = "area_interchange < $interchange";
		
		$temp_obj = AreaInterchange::model()->find($criteria);
		if(isset($temp_obj->area_interchange)) return array(
			"interchange" => $temp_obj->area_interchange, 
			"url" => $this->areaInterchangeUrl($area_code, $temp_obj->area_interchange)
		);
		else return array("interchange" => "", "url" => "#");
	}
	
	public function areaCodeDirectoryUrl() {
		return Yii::app()->baseUrl."/area-code-list";
	}
	
}
?>
