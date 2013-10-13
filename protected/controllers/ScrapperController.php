<?php

class ScrapperController extends Controller
{
	protected $scrapper;
    
    public function init() {
        $this->scrapper = new Scrapper();
        set_time_limit(0);
        ini_set('memory_limit', -1);
    }
    
	public function actionAreaCode()
	{
		
	}

	public function actionComment()
	{
		//$this->scrapper->scrapHelloMoonrock();
		for($i=4;$i<74;$i++) {
			$this->scrapper->scrapHelloMoonrock(date("Y-m-d", strtotime("-$i days")));
			echo date("Y-m-d", strtotime("-$i days"))."<br>";
		}
	}

	public function actionCommentAll()
	{
		try {
            $this->scrapper->scrap800Notes();
            $this->scrapper->scrapCallerCenter();
            $this->scrapper->scrapWhoCalled();
            $this->scrapper->scrapCallerComplaints();
            $this->scrapper->scrapWhyCallMe();
            $this->scrapper->scrapVerifyPhone();
        } catch (Exception $e) {
            $this->scrapper->alerts->alert(print_r($e, true));
        }
	}

	public function actionInterchange()
	{
		
	}

	public function actionNewsFeed()
	{
		
	}

	public function actionWeatherInfo()
	{
		
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
