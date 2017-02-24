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
            // 处理 REST Url /site/show/<id>/
            $siteRestHandler = new SiteRestHandler();
            $siteRestHandler->getSite($_GET["id"]);
            break;

        case "" :
            //404 - not found;
            break;
    }
        break;
        
    case 'POST':
        // 处理 REST Url /site/postlist/
        $siteRestHandler = new SiteRestHandler();
        $siteRestHandler->postSite($_GET["title"],$_GET["content"]);
        break;

    case "" :
        //404 - not found;
        break;
}
?>