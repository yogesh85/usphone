<?php

class ManageTables extends CDbMigration {

    public $commentTableStructure = array(
        'id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
        'comment' => 'text',
        'phone_number' => 'varchar(13) DEFAULT NULL',
        'area_code' => 'int(11) DEFAULT NULL',
        'area_interchange_code' => 'int(11) DEFAULT NULL',
        'date' => 'date NOT NULL DEFAULT \'0000-00-00\'',
        'timestamp' => 'timestamp NOT NULL DEFAULT \'0000-00-00 00:00:00\' ON UPDATE CURRENT_TIMESTAMP',
        'user_name' => 'varchar(48) DEFAULT NULL',
        'is_spam' => 'varchar(5) NOT NULL',
    );

    /**
     * This function  creates the comment table for the area code
     * @param type $areaCode 
     */
    public function createAreaCodeTable($areaCode) {

        $tableName = 'comment_' . str_pad($areaCode, 3, "0", STR_PAD_LEFT);

        if (Yii::app()->db->schema->getTable($tableName) == null) {
            $this->createTable($tableName, $this->commentTableStructure);
        }
    }
    /**
     * This function  copies the comments from tha master comments table
     * to the respective comment table for each area code
     * @param type $areaCode 
     */
    public function insertAreaCodesComments($areaCode){
        
        //check if there is already data in the comments table.
        if(Comment::model(null, $areaCode)->exists()) return false;
        
        $tableName = 'comment_' . str_pad($areaCode, 3, "0", STR_PAD_LEFT);
        
        $sql = "INSERT INTO $tableName SELECT * FROM comment WHERE area_code = " . $areaCode;
        
        $connection = Yii::app() -> db;
        $command = $connection -> createCommand($sql);
        $command -> execute();
        
    }
    
    public function insertCommentToChildTable($comment){
        
        $this->createAreaCodeTable($comment->area_code);
        
        $tableName = 'comment_' . $comment->area_code;
        
        $areaCode = $comment->area_code;
        $areaInterchangeCode = $comment->area_interchange_code;
        $phoneNumber = $comment->phone_number;
        $commentText = addslashes($comment->comment);
        $userName = stripslashes($comment->user_name);
        $isSpam = $comment->is_spam;
        
        $sql = "INSERT INTO " . $tableName . "(comment, phone_number, area_code, area_interchange_code, date, timestamp, user_name, is_spam )" 
                . "VALUES('$commentText', '$phoneNumber', $areaCode, $areaInterchangeCode, NOW(), NOW(), '$userName', '$isSpam')";
        
        $connection = Yii::app() -> db;
        $command = $connection -> createCommand($sql);
        $command -> execute();
    }
    /*
     * This function flush the comments table.
     * It will keep latest 40000 comments.
     * 
     * */
    public function flushComments($rowTOKeep){
		
        $tableName = 'comments';
        
        $sql = "select count(*) as total from comments";
        $connection = Yii::app() -> db;
        $command = $connection -> createCommand($sql);
        $command = $command -> queryRow();
        $limit = $command['total'] - $rowTOKeep;
        
        $sql = "delete from $tableName order by timestamp ASC limit $limit";
        $connection = Yii::app() -> db;
        $command = $connection -> createCommand($sql);
        $command -> execute();
    }
}

?>
