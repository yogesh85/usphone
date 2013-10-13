<?php

class CommentReader extends CComponent {
    
    /**
     * This function returns the latest comments in the whole site
     * @param type $limit
     * @param type $offset
     * @return Comments 
     */
    public function getRecentComments($limit = null, $offset = null, $areaCode = null, $areaInterchange = null){
        $criteria = new CDbCriteria();
        
        if($limit)
            $criteria->limit = $limit;
        if($offset)
            $criteria->offset = $offset;
        $criteria->order = "timestamp DESC";
        
        if(!is_null($areaCode) AND is_null($areaInterchange)) $criteria->condition = "area_code = $areaCode";
        if(!is_null($areaCode) AND !is_null($areaInterchange)) $criteria->condition = "area_code = $areaCode AND area_interchange_code = $areaInterchange";
        if(is_null($areaCode) AND !is_null($areaInterchange)) $criteria->condition = "area_interchange_code = $areaInterchange";
        
        $criteria->select = "area_code, area_interchange_code, comment, phone_number, timestamp";
        if(!is_null($areaCode))        
			return Comment::model(null, $areaCode)->findAll($criteria);
		else
			return Comment::model()->findAll($criteria);
        
    }
    
    public function getNumberComments($number = null, $limit = null, $offset = null){
        $criteria = new CDbCriteria();
        
        if($limit)
            $criteria->limit = $limit;
        if($offset)
            $criteria->offset = $offset;
        $criteria->order = "timestamp DESC";
        
        $criteria->condition = "phone_number = '$number'";
        
        $criteria->select = "area_code, area_interchange_code, comment, phone_number, timestamp";
        return Comment::model()->findAll($criteria);
        
    }
}
?>
