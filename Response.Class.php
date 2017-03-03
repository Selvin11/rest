<?php 
require_once("Rest.Class.php");
/**
*  获取请求头类型，传入数据库访问返回的数据，对其转码输出给请求方
*/
class Response
{
    private $httpVersion = "HTTP/1.1";
    

    // GET 返回所有数据
    public function getAll()
    {
        $rest = new Rest();
        $rowData = $rest->getAll();
        $this->encodeData($rowData);
    }
    // GET 返回对应ID的单条数据
    public function getOne($id)
    {
        $rest = new Rest();
        $rowData = $rest->getOne($id);
        $this->encodeData($rowData);
    }

    // POST 增加单条数据
    public function postOne($title,$content)
    {
        $rest = new Rest();
        $rowData = $rest->postOne($title,$content);
        $this->encodeData($rowData);
    }
    // PUT 更新单条数据
    public function putOne($id,$title,$content,$complete)
    {
        $rest = new Rest();
        $rowData = $rest->putOne($id,$title,$content,$complete);
        $this->encodeData($rowData);
    }
    // DELETE 删除单条数据
    public function deleteOne($id)
    {
        $rest = new Rest();
        $rowData = $rest->deleteOne($id);
        $this->encodeData($rowData);
    }
    /**
     * 对数据库查询返回的数据进行类型转化，将数组转为html、json、xml等
     * @param [type] $contentType [text/html application/json]
     * @param [type] $statusCode  [100 - 500]
     * @param [type] $rawData  [传入数据库返回数据]
     */
    public function encodeData($rawData){

        if(empty($rawData)) {
            $statusCode = 404;
            $rawData = array('error' => 'No sites found!');        
        } else {
            $statusCode = 200;
        }
        // 获取请求接受类型 Accept
        $requestContentType = $_SERVER['HTTP_ACCEPT'];
        

        $statusMessage = $this->getHttpStatusMessage($statusCode);
        
        // 根据请求的头部类型设置返回数据头部信息 http协议版本，状态码及对应的信息，返回的content-Type类型
        header("Content-Type:". $requestContentType);
        header($this->httpVersion. " ". $statusCode ." ". $statusMessage);        
        // 跨域设置 测试用
        header("Access-Control-Allow-Origin:*");

        // 对数据转化 $response 返回的数据
        // strpos函数 查找字符串首次出现的位置，找到返回 0，未找到返回false

        if(strpos($requestContentType,'application/json') !== false){
            $response = json_encode($rawData);
            echo $response;
        } else if(strpos($requestContentType,'text/html') !== false){
            $response = $this->encodeHtml($rawData);
            echo $response;
        } else if(strpos($requestContentType,'application/xml') !== false){
            $response = $this->encodeXml($rawData);
            echo $response;
        }
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
        $htmlResponse = "<table border='1' style='border-collapse:collapse;'>";
        foreach($responseData as $key=>$value) {
            if(is_array($value)){
                foreach ($value as $k => $val) {
                    $htmlResponse .= "<tr><td>". $k. "</td><td>". $val. "</td></tr>";
                }
            }else {
                 $htmlResponse .= "<tr><td>". $key. "</td><td>". $value. "</td></tr>";
            }
        }
        $htmlResponse .= "</table>";
        return $htmlResponse;        
    }
    
    // public function encodeJson($responseData) {
    //     $jsonResponse = json_encode($responseData);
    //     return $jsonResponse;        
    // }
    
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