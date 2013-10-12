<?php

class Proxy{

    protected $list;
    
    public function Proxy(){
        $this->loadProxies();
    }
    
    
    function parser($content,$regex){
            $keywords = array();        
            if ($content !== FALSE) {
                if (preg_match_all($regex, $content, $matches)) {
                    for ($i = 0; $i < count($matches[1]); $i++) {
                        $keywords[$i] = $matches[1][$i];
                    }            
                }
            }
            return $keywords;
    }
    
    function getParsedResult($url,$regex,$proxy=USEPROXY){
        return $this->parser($this->get_result($url,$proxy), $regex);
    }

    function loadProxies(){
        $this->list = file(dirname(__FILE__).'/../config/proxy_list.txt', FILE_IGNORE_NEW_LINES);
    }
    function getProxy(){
        return $this->list[ceil((rand(0, count($this->list)-1)))];
    }
    function get_result($url,$useProxy = Constants::USEPROXY,$cookie='PREF=;'){
         $proxy = $this->getProxy();
         $ch = curl_init();
         curl_setopt($ch, CURLOPT_URL, $url);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
         curl_setopt($ch, CURLOPT_COOKIE, $cookie);
         if($useProxy) curl_setopt($ch, CURLOPT_PROXY,$proxy);
         if (!($contents = trim(@curl_exec($ch)))) {
                $contents =  "curl_exec failed";
                return false;
         }
         return $contents;
    }
    
}

?>
