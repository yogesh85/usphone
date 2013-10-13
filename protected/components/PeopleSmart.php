<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PeopleSmart
 *
 * @author kunalroy
 */
class PeopleSmart extends CComponent{
    //put your code here
    public $_number;
    public $_API_URL = "http://api.peoplesearchaffiliates.com/cgi-bin/rpd-api.cgi?phone=";
    public $_state;
    public $_city;
    public $_county;
    public $_country;
    public $_latitude;
    public $_longitude;
    public $_wireless;
    public $_carrier;
    
    public function fetchData(){
        $url = $this->_API_URL . $this->_number;
        $jsonObj = json_decode($this->get_result($url));
        //var_dump($url);
        //var_dump($jsonObj);
        $this->_longitude = $jsonObj->Longitude;
        $this->_carrier = $this->remove_quotes($jsonObj->Carrier);
        $this->_county = $this->remove_quotes($jsonObj->County);
        $this->_city = $this->remove_quotes($jsonObj->City);
        $this->_wireless = $jsonObj->Wireless ? 1 : 0;
        $this->_state = $this->remove_quotes($jsonObj->State);
        $this->_latitude = $jsonObj->Latitude;
        
        
    }
    
    public function get_result($url){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
	curl_setopt($ch, CURLOPT_USERAGENT, "My server");
	if (!($contents = trim(@curl_exec($ch)))) {
		echo "curl_exec failed";
	}
	return $contents;
        }

    public function remove_quotes($str){
	$str = str_replace ("'", "\'", $str);
  	$str = str_replace ("\"", "\\\"", $str);
  	return $str;
        }        
        
}

?>
