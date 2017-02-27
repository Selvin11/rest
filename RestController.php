<?php
require_once("SiteRestHandler.php");
        
$view = "";
if(isset($_GET["view"]))
    $view = $_GET["view"];
/*
 * RESTful service 控制器
 * URL 映射
*/

$method = $_SERVER['REQUEST_METHOD'];
switch ($method) {
    
    case 'GET':
    switch($view){
     
        case "all":
            // 处理 REST Url /site/list/
            $siteRestHandler = new SiteRestHandler();
            $siteRestHandler->getAllSites();
            break;
            
        case "single":
            // 处理 REST Url  GET /site/id/
            $siteRestHandler = new SiteRestHandler();
            $siteRestHandler->getSite($_GET["id"]);
            break;

        case "" :
            //404 - not found;
            break;
    }
        break;
        
    case 'POST':
         // 处理 REST URL  PUT /site/list/id/
        if ($view == "single") {
            $json = file_get_contents('php://input');
            $data = json_decode($json,true);
            var_dump($data);

            $siteRestHandler = new SiteRestHandler();
            if ($data == NULL) {
                $siteRestHandler->putSite($_GET["id"],$_GET["title"],$_GET["content"]);
            }else{
                $siteRestHandler->putSite($data["id"],$data["title"],$data["content"]);
            }
        }else{
            // 处理 REST Url  POST /site/list/
            $siteRestHandler = new SiteRestHandler();
            $siteRestHandler->postSite($_GET["title"],$_GET["content"]);
        }
        break;

    
    case "DELETE":
        // 处理 REST URL  DELETE /site/list/id/
        if ($view == "single") {
            $siteRestHandler = new SiteRestHandler();
            $siteRestHandler->deleteSite($_GET["id"]);
        }
        break;
        
    case "" :
        //404 - not found;
        break;
}
?>