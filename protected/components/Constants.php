<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Constants
 *
 * @author kunalroy
 */
class Constants {
    //put your code here
    
    public static $NUMBERS_PER_PAGE = 1000;
    public static $COMMENTS_HOME = 30;
    public static $COMMENTS_AREA_CODE = 10;
    public static $COMMENTS_AREA_INTERCHANGE = 20;
    public static $COMMENTS_TRACE = 10;
    public static $tollFreeNumbers = array (800, 888, 877, 866, 855);
    
    const HOME_SEARCHED_NUMBER_COUNT = 28;
	const MOSTLY_SEARCHED_NUMBER = 28;
    
    const NOTES_SEED_URL = "http://800notes.com/";
    const NOTES_FILE_SAVE_PATH = "/runtime/800NotesFiles/";
    const NOTES_FILE_NAME_PREFIX = "800notes_";
    
    const CALLERCENTER_SEED_URL = "http://www.callercenter.com/";
    const CALLERCENTER_FILE_SAVE_PATH = "/runtime/CallerCenterFiles/";
    const CALLERCENTER_FILE_NAME_PREFIX = "CallerCenter_";
    
    const WHOCALLED_SEED_URL = "http://whocalled.us/";
    const WHOCALLED_FILE_SAVE_PATH = "/runtime/WhoCalledFiles/";
    const WHOCALLED_FILE_NAME_PREFIX = "WhoCalled_";
    
    
    const CALLERCOMPLAINTS_SEED_URL = "http://www.callercomplaints.com/Default.aspx";
    const CALLERCOMPLAINTS_FILE_SAVE_PATH = "/runtime/CallerComplaintsFiles/";
    const CALLERCOMPLAINTS_FILE_NAME_PREFIX = "CallerComplaints_";
    
    const WHYCALLME_SEED_URL = "http://www.whycall.me/";
    const WHYCALLME_FILE_SAVE_PATH = "/runtime/WhyCallMeFiles/";
    const WHYCALLME_FILE_NAME_PREFIX = "WhyCallMe_";
    
    const VERIFYPHONE_SEED_URL = "http://www.verifyphone.com/";
    const VERIFYPHONE_FILE_SAVE_PATH = "/runtime/VerifyPhone/";
    const VERIFYPHONE_FILE_NAME_PREFIX = "VerifyPhone_";

	const HELLOMOONROCK_AREA_CODE_URL = "http://www.hellomoonrock.com/scrapper/JsonAreaCode/";
	const HELLOMOONROCK_AREA_INTERCHANGE_URL = "http://www.hellomoonrock.com/scrapper/JsonAreaInterchange/";
	const HELLOMOONROCK_COMMENT_URL = "http://www.hellomoonrock.com/scrapper/JsonComments/";
    
    const PEOPLESMART_SITE_REFERENCE = "phoneinfo";
    const PEOPLESMART_SITE_AFF = "273";
    
    const USEPROXY = false;

	static function getPeoplesmartLink () {
		return "http://www.peoplesmart.com/psp.aspx?_act=loadingphone&search=phone&aff=".Constants:: PEOPLESMART_SITE_AFF. "&tid=".Constants::PEOPLESMART_SITE_REFERENCE."&utm_source=".Constants::PEOPLESMART_SITE_REFERENCE."&utm_medium=affiliate"."&id=".Constants::PEOPLESMART_SITE_REFERENCE."&siteName=".Constants::PEOPLESMART_SITE_REFERENCE."&phone=";
	}
    static function getNotesFileSavePath(){
        return Yii::getPathOfAlias('application') . Constants::NOTES_FILE_SAVE_PATH;
    }
    
    static function getCallerCenterFileSavePath(){
        return Yii::getPathOfAlias('application') . Constants::CALLERCENTER_FILE_SAVE_PATH;
    }
    
    static function getWhoCalledFileSavePath(){
        return Yii::getPathOfAlias('application') . Constants::WHOCALLED_FILE_SAVE_PATH;
    }
    
    static function getCallerComplaintsFileSavePath(){
        return Yii::getPathOfAlias('application') . Constants::CALLERCOMPLAINTS_FILE_SAVE_PATH;
    }
    
    static function getWhyCallMeFileSavePath(){
        return Yii::getPathOfAlias('application') . Constants::WHYCALLME_FILE_SAVE_PATH;
    }
    
    static function getVerifyPhoneFileSavePath(){
        return Yii::getPathOfAlias('application') . Constants::VERIFYPHONE_FILE_SAVE_PATH;
    }
    //end of scapper constants
}

?>
