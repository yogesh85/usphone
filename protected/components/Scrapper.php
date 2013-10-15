<?php

class Scrapper extends CComponent{
    //put your code here
        
        protected $proxy;
        protected $commentArray = array();
        protected $manageTables;

        public function Scrapper(){
            $this->proxy = new Proxy();
            $this->manageTables = new ManageTables();
        }

		public function scrapHelloMoonrock($date=null) {
            if(is_null($date)) $date = date('Y-m-d', strtotime("-2 day", strtotime(date('Y-m-d'))));
            echo $date ." => <br>";
            /*
            $content = $this->proxy->get_result(Constants::HELLOMOONROCK_AREA_CODE_URL."date/$date", false);
            $content_array = json_decode($content);   
            foreach($content_array as $val) {
                $db = AreaCodes::model()->find("area_code = :area_code", array(':area_code' => $val->area_code));
                if(count($db) == 0) {
                    $db = new AreaCode();
                    $db -> area_code = $val->area_code;
                    $db -> state_code = $val->state_code;
                   
                    $db -> save();
                }
            }
            unset($content);unset($content_array);   
           
            $content = $this->get_result(Constants::HELLOMOONROCK_AREA_INTERCHANGE_URL."date/$date", false);
            $content_array = json_decode($content);   
            foreach($content_array as $val) {
                $db = AreaInterchanges::model()->find("area_code = :area_code AND area_interchange = :area_interchange", array(':area_code' => $val->area_code, ':area_interchange' => $val->area_interchange));
                if(count($db) == 0) {
                    $db = new AreaInterchange();
                    $db -> area_code = $val->area_code;
                    $db -> area_interchange = $val->area_interchange;
                    $db -> longitude = $val->longitude;
                    $db -> latitude = $val->latitude;
                    $db -> carrier = $val->carrier;
                    $db -> county = $val->county;
                    $db -> population = $val->population;
                    $db -> city = $val->city;
                    $db -> wireless = $val->wireless;
                    $db -> state = $val->state;
                    $db -> processed = $val->processed;
                    $db -> content_id = 1;
                   
                    $db -> save();
                }
            }*/
            unset($content);unset($content_array);   
           
            $content = $this->get_result(Constants::HELLOMOONROCK_COMMENT_URL."date/$date", false);
            file_put_contents("comment_json", $content."\n", FILE_APPEND);
            $content_array = json_decode($content);   
            foreach($content_array as $val) {
                $this->addCommentToArray($val->comment_text, $val->phone_number);
            }
            if(count($this->commentArray) > 0) $this->saveComments();
            unset($content);unset($content_array);   
           
           
            /*
            foreach($comment_array as $val) {
                $this->addCommentToArray($val->comment_text, $val->phone_number);
            }
            if(count($this->commentArray) > 0) $this->saveComments();
            $this->commentArray = array();
            */
        }
                
        public function scrapCallerComplaints(){
            $content = $this->get_result(Constants::CALLERCOMPLAINTS_SEED_URL);
            if(Constants::SAVE_FILES)
                FileHandler::write(Constants::getCallerComplaintsFileSavePath(), Constants::CALLERCOMPLAINTS_FILE_NAME_PREFIX . date("Ymd-H-i-s") . ".html", $content);
            
            $dom = new DOMDocument();
            @$dom->loadHTML($content);
            // grab all the links on the page
            $xpath = new DOMXPath($dom);
            
            $elements = $xpath->query("//div[@class='tbl report_listing']");
            
            $length = $elements->length;
            for($x = 0; $x < $length; $x++){
                $element = $elements->item($x);
                $number = $element->getElementsByTagName('a')->item(0)->nodeValue;
                
                $rawComment = trim(preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-:]/s', '', $element->getElementsByTagName('p')->item(0)->nodeValue));
                
                
                if(strpos($rawComment, "Phone Number Owner:") > 0){
                    $callerTypeEndIndex = strpos($rawComment, 'Phone Number Owner:');
                    $callerOwnerStartIndex = strpos($rawComment, 'Phone Number Owner:') + 19;
                    $callerOwnerEndIndex = strpos($rawComment, 'Phone Number Report:');
                }
                else{
                    $callerTypeEndIndex = strpos($rawComment, 'Phone Number Report:');
                    $callerOwnerStartIndex = -1;
                    $callerOwner = 'Unknown';
                    $callerType = 'Unknown';
                }
                
                $commentText = substr($rawComment, strpos($rawComment, 'Phone Number Report:')+ 20);
                $callerType = substr($rawComment,12, $callerTypeEndIndex-12);
                if($callerOwnerStartIndex > 0){
                    $callerOwner = substr($rawComment, $callerOwnerStartIndex, $callerOwnerEndIndex - $callerOwnerStartIndex);
                }
                
                $this->addCommentToArray($commentText, $number, $callerOwner, $callerType);
                
            }
            
            $this->saveComments();
            
        }
        
        public function scrapWhoCalled(){
            $content = $this->get_result(Constants::WHOCALLED_SEED_URL);
            
            if(Constants::SAVE_FILES)
                FileHandler::write(Constants::getWhoCalledFileSavePath(), Constants::WHOCALLED_FILE_NAME_PREFIX . date("Ymd-H-i-s") . ".html", $content);
            
            $dom = new DOMDocument();
            @$dom->loadHTML($content);
            // grab all the links on the page
            $xpath = new DOMXPath($dom);
            
            $elements = $xpath->query("//div[@class='comment']");
            
            $length = $elements->length;
            for($x = 0; $x < $length; $x++){
                $element = $elements->item($x);
                
                $number = $element->getElementsByTagName('a')->item(0)->nodeValue;
                //var_dump($anchorList->item(0)->nodeValue);
                
                $element->removeChild($element->getElementsByTagName('h3')->item(0));
                $this->addCommentToArray($element->nodeValue, $number);
            }
            $this->saveComments();
        }

        public function scrapCallerCenter(){
            $content = $this->get_result(Constants::CALLERCENTER_SEED_URL);
            
            if(Constants::SAVE_FILES)
                FileHandler::write(Constants::getCallerCenterFileSavePath(), Constants::CALLERCENTER_FILE_NAME_PREFIX . date("Ymd-H-i-s") . ".html", $content);
            
            $dom = new DOMDocument();
            @$dom->loadHTML($content);
            // grab all the links on the page
            $xpath = new DOMXPath($dom);
            
            $elements = $xpath->query("//div[@id='complaint']");
            
            foreach($elements as $element){
                
                $anchorList = $element->getElementsByTagName('a');
                $commentList = $element->getElementsByTagName('p');
                
                $number = $anchorList->item(0)->nodeValue;
                $number = str_replace(":", "", $number);
                
                $this->addCommentToArray($commentList->item(0)->nodeValue, $number);
            }
            
            $this->saveComments();
        }

        public function scrapWhyCallMe(){
            $content = $this->get_result(Constants::WHYCALLME_SEED_URL);
            
            if(Constants::SAVE_FILES)
                FileHandler::write(Constants::getWhyCallMeFileSavePath(), Constants::WHYCALLME_FILE_NAME_PREFIX . date("Ymd-H-i-s") . ".html", $content);
            
            $dom = new DOMDocument();
            @$dom->loadHTML($content);
            // grab all the links on the page
            $xpath = new DOMXPath($dom);
            
            $elements = $xpath->query("//div[@id='complaint']");
            
            foreach($elements as $element){
                
                $anchorList = $element->getElementsByTagName('a');
                $commentList = $element->getElementsByTagName('p');
                $number = $anchorList->item(0)->nodeValue;
                
                $number = str_replace(":", "", $number);
                
                $this->addCommentToArray($commentList->item(0)->nodeValue, $number);
            }
            
            $this->saveComments();
        }

        public function scrapVerifyPhone(){
            
            $content = $this->get_result(Constants::VERIFYPHONE_SEED_URL);
            
            if(Constants::SAVE_FILES)
                FileHandler::write(Constants::getVerifyPhoneFileSavePath(), Constants::VERIFYPHONE_FILE_NAME_PREFIX . date("Ymd-H-i-s") . ".html", $content);
            
            $dom = new DOMDocument();
            @$dom->loadHTML($content);
            $xpath = new DOMXPath($dom);
            
            //$elements = $xpath->query("//div[class='recentcomments']");
            $elements = $xpath->query("//table/tr/td");
            
            $length = $elements->length;
            
            for($x = 0; $x < $length; $x++){
                
                if(strpos($elements->item($x)->nodeValue, 'This review was create') > 0){
                    
                    $element = $elements->item($x);
                    $anchorList = $element->getElementsByTagName('a');
                    $number = $anchorList->item(0)->nodeValue;
                    $divList = $element->getElementsByTagName('div');
                    
                    $commentText = trim(preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-:]/s', '', $divList->item(0)->nodeValue));
                    //var_dump($commentText);
                    
                    $this->addCommentToArray($commentText, $number);
                }
            }
            
            $this->saveComments();
        }
        
        public function scrap800Notes(){
            
            $content = $this->get_result(Constants::NOTES_SEED_URL);
            
            if(Constants::SAVE_FILES)
                FileHandler::write(Constants::getNotesFileSavePath(), Constants::NOTES_FILE_NAME_PREFIX . date("Ymd-H-i-s") . ".html", $content);
            
            $dom = new DOMDocument();
		@$dom->loadHTML($content);
		// grab all the links on the page
		$xpath = new DOMXPath($dom);

		$elements = $xpath->query("//li[@class='oos_l1']");
                
                //$commentArray = Array();
                
                foreach($elements as $element) {
                    //outer li for each comment
                    $numberPosition = 1;
                    $commentPosition = 2;
                    
                    foreach ($element->childNodes as $oos_l1_node) {
                       $count = 0;
                       foreach ($oos_l1_node->childNodes as $innerUl){
                           
                           if($count == $numberPosition){
                               $number = $innerUl->childNodes->item(0)->nodeValue;
                           }
                           else if($count == $commentPosition){
                               $comment = $innerUl->childNodes->item(0)->nodeValue;
                           }
                           
                           $count++;
                       }
                       $this->addCommentToArray($comment, $number);
                       //$this->commentArray[] = array('comment' => $comment, 'number' => $number);
                    }
                }
                
                $this->saveComments();
        }
        
        protected function addCommentToArray($comment, $number, $owner = 'Unknown', $callerType = 'Unknown'){
            
            $number = preg_replace('/[^0-9]/Uis', "", $number);
            $comment = trim(preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-:]/s', '', $comment));
            $owner = trim(preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-:]/s', '', $owner));
            $callerType = trim(preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-:]/s', '', $callerType));
            
            //$number = str_replace($regex, $replace, $subject);
            $this->commentArray[] = array(
                'comment' => trim($comment),
                'number' => trim($number),
                'owner' => trim($owner),
                'callerType' => trim($callerType));
        }
        
        protected function saveComments(){
            //write the code to save the comments to the database
            //check if the comment is already existing
            
            $insertedCount = 0;
            $this->validateComments();
            foreach ($this->commentArray as $commentItem){              
                
                if(strlen(trim($commentItem['number'])) != 10){
                    Yii::log('number length is not valid: ' . $commentItem['number'] . " Length: ". strlen(trim($commentItem['number'])));
                    continue;
                }
                
                if(strlen($commentItem['comment']) == 0){
                    Yii::log('Comment is empty: ' . $commentItem['number'] );
                    continue;
                }
                
                $number = preg_replace("/^(\d{3})(\d{3})(\d{4})$/", "$1-$2-$3", $commentItem['number']);                
                $numberSplits = explode('-', $number);
                
                $exists = Comment::model()->findAll('phone_number=:phone_number AND comment=:comment_text', array('phone_number' => $number, 'comment_text' => $commentItem['comment']));
                
                //if(!$this->validateAreaInterchange($numberSplits[0], $numberSplits[1], $number))	continue;
				//if(!$this->validateAreaCode($numberSplits[0]))	continue;                
                
                if(!$exists) {
					$insertedCount++;
					echo "Adding.." . $number . "<BR>";
                
                    $comment = new Comment();
                    $comment->comment = $commentItem['comment'];
                    $comment->phone_number = $number;
                    $comment->area_code = $numberSplits[0];
                    $comment->area_interchange_code = $numberSplits[1];
                    $comment->date = date('Y-m-d');
                
                    if(!$comment->save()){
                        Yii::log($comments->getErrors());
                    }
                }
                else{
                    echo "Skipping.." . $number . "<BR>";
                }
              }  
                
            Yii::log($_SERVER['REQUEST_URI'] . ". Total Comments Read: " . count($this->commentArray) . ", Total Inserted: " . $insertedCount);
            echo "Success ";
            Yii::log("Endig saveComments() function. ");
            
            $this->commentArray = array();
            
        }
        
        private function get_result($url){
            $content = $this->proxy->get_result($url);
            if(!$content){
                $this->alerts->alert("Error occured while accessing url: ". $url);
                return false;
            }
            
            return $content;
        }
        private function validateComments(){
            if(count($this->commentArray) == 0){
                Yii::log("Unable to scrap comments from html code. ");
            }
        }
        
        public function validateAreaInterchange($areaCode, $areaInterchangeText, $number){
            
			if($this->isTollFreeNumber($areaCode)) return true;             
			//check if the area_code or the area interchanges are not present
			$areaInterchange = AreaInterchange::model()->find('area_code=:area_code AND area_interchange=:area_interchange', array('area_code' => $areaCode, 'area_interchange' => $areaInterchangeText));
                
			if($areaInterchange == null){
                    
                    $areaInterchangeInstance = new AreaInterchange();
                    $areaInterchangeInstance->area_interchange = $areaInterchangeText;
                    $areaInterchangeInstance->area_code = $areaCode;
                    
                    $peopleSmart = new PeopleSmart();
                    $peopleSmart->_number = $number;
                    $peopleSmart->fetchData();
                    
                    if(null == $peopleSmart->_city){
                        //var_dump($peopleSmart);
                        Yii::log("$areaCode-$areaInterchangeText does not exist in the Peoplesmart database. Skipping the comment. ");
                        var_dump("$areaCode-$areaInterchangeText does not exist in the Peoplesmart database. Skipping the comment. ");
                        return false;
                    }
                    
                    var_dump("Adding area Interchange for: $areaCode $areaInterchangeText");
                    Yii::log("Adding area Interchange for: $areaCode $areaInterchangeText");
                    
                    $areaInterchangeInstance->longitude = $peopleSmart->_longitude;
                    $areaInterchangeInstance->latitude = $peopleSmart->_latitude;
                    $areaInterchangeInstance->company = $peopleSmart->_carrier;
                    $areaInterchangeInstance->region = $peopleSmart->_city;
                    $areaInterchangeInstance->county = $peopleSmart->_county;
                    $areaInterchangeInstance->state = $peopleSmart->_state;
                    
                    if(!$areaInterchangeInstance->save()){
                        //Yii::log($areaInterchangeInstance->getErrors());
                        var_dump($areaInterchangeInstance->getErrors());
                        return false;
                    }
                    else 
                        return true;
                }
                else {
                    return true;
                }
                
        }
        
        public function validateAreaCode($areaCodeText){
            
            if($this->isTollFreeNumber($areaCodeText)){
               return true; 
            }
            
            $areaCode = AreaCodes::model()->find('area_code=:area_code',array('area_code' => $areaCodeText));
                
                if($areaCode == null){
                    Yii::log("Adding area code for: " . $areaCodeText);
                    var_dump("Adding area code for: " . $areaCodeText);
                    
                    //create area_code table if it does not exist already
                    $this->manageTables->createAreaCodeTable($areaCodeText);
                    
                    $areaCode = new AreaCodes();
                    $areaCode->area_code = $areaCodeText;
                    if(!$areaCode->save()){
                        Yii::log($areaCode->getErrors());
                        var_dump($areaCode->getErrors());
                        return false;
                    }
                    return true;
                }
                else {
                    return true;
                }
        }
        
        public function isTollFreeNumber($areaCodeText){
            
            if(in_array($areaCodeText, Constants::$tollFreeNumbers)){
                echo "$areaCodeText is toll free <BR>";
                return true;
            }
            else {
                return false;
            }
        }

}

?>
