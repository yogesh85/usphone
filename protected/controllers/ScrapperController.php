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
		$this->scrapper->scrapHelloMoonrock();		
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

	public function actionNewsFeed() {
		
		
		$dom = new DOMDocument();
		@$dom->loadHTML(@file_get_contents("http://localhost/test/t.html"));
		$xpath = new DOMXPath($dom);
		$elements = $xpath->query("//div[@class='headline']");
		//var_dump($elements);
		if(!is_null($elements)) {
			foreach($elements as $element) {
				foreach($element->childNodes as $el1) {
//					echo $el1->getAttribute("class")."!!!!!".$el1->nodeName."----".$el1->nodeValue;
					if($el1->hasAttributes() AND $el1->getAttribute("class") == "article-content") {
						
						if(!is_null($el1->childNodes)) {
							
							$temp_arr = array();
							foreach($el1->childNodes as $el2) {
								echo $el2->nodeValue."<br><br><br><br><br><br>";
								continue;
								if($el2->hasAttributes() AND !is_null($el2->getAttribute("class")) AND $el2->getAttribute("class") == "title") {
									$temp_arr['title'] = str_replace(array("\n", "\t", "  "), " ", trim($el2->nodeValue));
									foreach($el2->childNodes as $el3) {
										//echo $el3->nodeName;
										if($el3->hasAttributes() AND !is_null($el3->getAttribute("href"))) $temp_arr['link'] = $el3->getAttribute("href");
										if($el3->hasAttributes() AND !is_null($el3->getAttribute("href"))) { 
											if($el3->hasAttributes() AND !is_null($el3->getAttribute("href"))) echo $el3->getAttribute("href")."<br>";
											foreach($el3->childNodes as $el4) {
												if($el4->hasAttributes() AND !is_null($el4->getAttribute("href"))) echo "fffffff<br>";
											}
										}
									}
								}
								if($el2->hasAttributes() AND !is_null($el2->getAttribute("class")) AND $el2->getAttribute("class") == "date") {								
									$temp_arr['date'] = date(date("Y-m-d G:i:s"), strtotime(substr(trim($el2->nodeValue), -24)));
								}
								if($el2->nodeName == "p") {
									$temp_arr['content'] = trim($el2->nodeValue);
								}
								
							}
							//print_r($temp_arr);
						}
						echo "----------------------------------------<br>";
					}
				}
			}
		}
		die();
		
		$crit = new CDbCriteria();
		$crit->select = "abbreviation";
		$crit->condition = "country = 'CA'";
		$state_obj = State::model()->findAll($crit);
		$state_arr = array();
		foreach($state_obj as $val) {
			$state_arr[] = $val['abbreviation'];
		}
		
		$crit = new CDbCriteria();
		if(count($state_arr) > 0) $crit -> condition = "state not in ('".implode("', '", $state_arr)."')";
		$detail = NewsRssUrl::model()->findAll($crit);
		$news_rss = array();
		$news_content = array();
		foreach($detail as $link){ 
			$dom = new DOMDocument();
			@$dom->loadHTML(@file_get_contents($link['feed_url']));
			$xpath = new DOMXPath($dom);
			$elements = $xpath->query("//div[@class='headline']");
			if(!is_null($elements)) {
				foreach($elements as $element) {
					foreach($element->childNodes as $el1) {
						var_dump($el1);
						die();
					}
				}
			}
		}
		
		
		die();
		
		
		
		$crit = new CDbCriteria();
		if(count($state_arr) > 0) $crit -> condition = "state in ('".implode("', '", $state_arr)."')";
		
		$detail = NewsRssUrl::model()->findAll($crit);
		$news_rss = array();
		$news_content = array();
		foreach($detail as $link){ 
			$xml = @simplexml_load_file($link['feed_url']);
			
			if($xml){
				$news_feed = $xml->xpath("/rss/channel/item");				
				for($i=0;$i<count($news_feed);$i++){
					if(count($news_feed[$i]) > 0) {	
						$news_temp = array();
						$news_temp['state'] = $link['state'];
						foreach($news_feed[$i] as $key=>$val){
							if($key=="title") $news_temp['title'] = "$val";
							if($key=="link") $news_temp['link'] = "$val";
							if($key=="pubDate") $news_temp['pubDate'] = "$val";
							if($key=="description") $news_temp['description'] = "$val";
							if($key=="guid") $news_temp['guid'] = "$val";
						}
						array_push($news_content, $news_temp);
						if(count($news_content) == 10) break;
					}
				}				
			}		
		}
		foreach($news_content as $content) {
			$news_feed = new NewsFeed();
			$news_feed -> title = strip_tags(stripslashes($content['title']));
			$news_feed -> url = $content['link'];
			$news_feed -> timestamp = date("Y-m-d G:i:s", strtotime($content['pubDate']));
			$news_feed -> content = strip_tags(stripslashes($content['description']));
			$news_feed -> state = $content['state'];
			$news_feed->save();
		}
				
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
