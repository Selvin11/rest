<?php 
/**
*  获取请求头类型，传入数据库访问返回的数据，对其转码输出给请求方
*/
class encodeData
{
    private $httpVersion = "HTTP/1.1";
    
    function __construct()
    {
        # code...
    }


    
    public function setHttpHeaders($contentType, $statusCode){
        
        $statusMessage = $this -> getHttpStatusMessage($statusCode);
        
        header($this->httpVersion. " ". $statusCode ." ". $statusMessage);        
        header("Content-Type:". $contentType);
    }
    
    public function getHttpStatusMessage($statusCode){
        $httpStatus = array(
            100 => 'Continue',  
            101 => 'Switching Protocols',  
            200 => 'OK',
            201 => 'Created',  
            202 => 'Accepted',  
            203 => 'Non-Authoritative Information',  
            204 => 'No Content',  
            205 => 'Reset Content',  
            206 => 'Partial Content',  
            300 => 'Multiple Choices',  
            301 => 'Moved Permanently',  
            302 => 'Found',  
            303 => 'See Other',  
            304 => 'Not Modified',  
            305 => 'Use Proxy',  
            306 => '(Unused)',  
            307 => 'Temporary Redirect',  
            400 => 'Bad Request',  
            401 => 'Unauthorized',  
            402 => 'Payment Required',  
            403 => 'Forbidden',  
            404 => 'Not Found',  
            405 => 'Method Not Allowed',  
            406 => 'Not Acceptable',  
            407 => 'Proxy Authentication Required',  
            408 => 'Request Timeout',  
            409 => 'Conflict',  
            410 => 'Gone',  
            411 => 'Length Required',  
            412 => 'Precondition Failed',  
            413 => 'Request Entity Too Large',  
            414 => 'Request-URI Too Long',  
            415 => 'Unsupported Media Type',  
            416 => 'Requested Range Not Satisfiable',  
            417 => 'Expectation Failed',  
            500 => 'Internal Server Error',  
            501 => 'Not Implemented',  
            502 => 'Bad Gateway',  
            503 => 'Service Unavailable',  
            504 => 'Gateway Timeout',  
            505 => 'HTTP Version Not Supported');
        return ($httpStatus[$statusCode]) ? $httpStatus[$statusCode] : $status[500];
    }

    /**
     * 数据转成HTML/JSON/XML
     * @param  [type] $responseData [description]
     * @return [type]               [description]
     */
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
}


 ?>