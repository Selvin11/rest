<?php 
require_once("SimpleRest.php");
require_once("Site.php");
 
class SiteRestHandler extends SimpleRest {
 
    function getAllSites() {    
 
        $site = new Site();
        $rawData = $site->getAllSite();
 
        if(empty($rawData)) {
            $statusCode = 404;
            $rawData = array('error' => 'No sites found!');        
        } else {
            $statusCode = 200;
        }
 
        $requestContentType = $_SERVER['HTTP_ACCEPT'];
        $this ->setHttpHeaders($requestContentType, $statusCode);
                
        if(strpos($requestContentType,'application/json') !== false){
            $response = $this->encodeJson($rawData);
            echo $response;
        } else if(strpos($requestContentType,'text/html') !== false){
            $response = $this->encodeHtml($rawData);
            echo $response;
        } else if(strpos($requestContentType,'application/xml') !== false){
            $response = $this->encodeXml($rawData);
            echo $response;
        }
    }
    
    public function encodeHtml($responseData) {
    
        $htmlResponse = "<table border='1'>";
        foreach($responseData as $key=>$value) {
            if(is_array($value)){
                foreach ($value as $k => $val) {
                    if (!is_int($k)) {
                        $htmlResponse .= "<tr><td>". $k. "</td><td>". $val. "</td></tr>";
                    }
                    
                }
            }else if (!is_int($key)) {
                 $htmlResponse .= "<tr><td>". $key. "</td><td>". $value. "</td></tr>";
            }
        }
        $htmlResponse .= "</table>";
        return $htmlResponse;        
    }
    
    public function encodeJson($responseData) {
        $jsonResponse = json_encode($responseData);
        return $jsonResponse;        
    }
    
    public function encodeXml($responseData) {
        // 创建 SimpleXMLElement 对象
        $xml = new SimpleXMLElement('<?xml version="1.0"?><site></site>');
        foreach($responseData as $key=>$value) {
            $xml->addChild($key, $value);
        }
        return $xml->asXML();
    }
    
    public function getSite($id) {
        $site = new Site();
        $rawData = $site->getSite($id);
        if(empty($rawData)) {
            $statusCode = 404;
            $rawData = array('error' => 'No sites found!');        
        } else {
            $statusCode = 200;
        }
 
        $requestContentType = $_SERVER['HTTP_ACCEPT'];
        $this ->setHttpHeaders($requestContentType, $statusCode);
                
        if(strpos($requestContentType,'application/json') !== false){
            $response = $this->encodeJson($rawData);
            echo $response;
        } else if(strpos($requestContentType,'text/html') !== false){
            $response = $this->encodeHtml($rawData);
            echo $response;
        } else if(strpos($requestContentType,'application/xml') !== false){
            $response = $this->encodeXml($rawData);
            echo $response;
        }
    }

    public function postSite($title,$content){
        $site = new Site();
        $rawData = $site->postSite($title,$content);

        if(empty($rawData)) {
            $statusCode = 404;
            $rawData = array('error' => 'No sites found!');        
        } else {
            $statusCode = 200;
        }
        
        $requestContentType = $_SERVER['HTTP_ACCEPT'];
        $this ->setHttpHeaders($requestContentType, $statusCode);
                
        if(strpos($requestContentType,'application/json') !== false){
            $response = $this->encodeJson($rawData);
            echo $response;
        } else if(strpos($requestContentType,'text/html') !== false){
            $response = $this->encodeHtml($rawData);
            echo $response;
        } else if(strpos($requestContentType,'application/xml') !== false){
            $response = $this->encodeXml($rawData);
            echo $response;
        }
    }

    public function putSite($id,$title,$content){
        $site = new Site();
        $rawData = $site->putSite($id,$title,$content);

        if(empty($rawData)) {
            $statusCode = 404;
            $rawData = array('error' => 'No sites found!');        
        } else {
            $statusCode = 200;
        }
        
        $requestContentType = $_SERVER['HTTP_ACCEPT'];
        $this ->setHttpHeaders($requestContentType, $statusCode);
                
        if(strpos($requestContentType,'application/json') !== false){
            $response = $this->encodeJson($rawData);

            echo $response;
        } else if(strpos($requestContentType,'text/html') !== false){
            $response = $this->encodeHtml($rawData);
            echo $response;
        } else if(strpos($requestContentType,'application/xml') !== false){
            $response = $this->encodeXml($rawData);
            echo $response;
        }
    } 

    public function deleteSite($id){
        $site = new Site();
        $rawData = $site->deleteSite($id);

        if(empty($rawData)) {
            $statusCode = 404;
            $rawData = array('error' => 'No sites found!');        
        } else {
            $statusCode = 200;
        }
        
        $requestContentType = $_SERVER['HTTP_ACCEPT'];
        $this ->setHttpHeaders($requestContentType, $statusCode);
                
        if(strpos($requestContentType,'application/json') !== false){
            $response = $this->encodeJson($rawData);

            echo $response;
        } else if(strpos($requestContentType,'text/html') !== false){
            $response = $this->encodeHtml($rawData);
            echo $response;
        } else if(strpos($requestContentType,'application/xml') !== false){
            $response = $this->encodeXml($rawData);
            echo $response;
        }
    }  
}
?>