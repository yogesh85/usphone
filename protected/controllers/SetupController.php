<?php

class SetupController extends Controller
{
        public function actionCreateAreaCodesTables(){
            
            set_time_limit(0);
            ini_set('memory_limit', -1);
            
            $manageTables = new ManageTables();
            
            $criteria = new CDbCriteria();
            $criteria->distinct = TRUE;
            $criteria->select = 'area_code';
            
            $areaCodesComments = Comment::model()->findAll($criteria);
            
            var_dump(count($areaCodesComments));
            
            foreach ($areaCodesComments as $areaCodesComment){
                $manageTables->createAreaCodeTable($areaCodesComment->area_code);
                $manageTables->insertAreaCodesComments($areaCodesComment->area_code);
            }
            
            
            $areaCodes = AreaCode::model()->findAll();
            
            foreach ($areaCodes as $areaCode){
                $manageTables->createAreaCodeTable($areaCode->area_code);
            }
            
            
            
        }
        
        public function actionFlushCommentTable (){
			set_time_limit(0);
            ini_set('memory_limit', -1);
            
			$manageTables = new ManageTables();
			$manageTables->flushComments(4000);
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
