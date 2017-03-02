<?php
require_once("Response.Class.php");
        
/*
 * RESTful service 控制器
 * URL 映射
*/
$view = "";
if(isset($_GET["view"]))
    $view = $_GET["view"];
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
    switch($view){
        case "all":
            // 处理 REST Url /api/list/
            
            $res = new Response();
            $res->getAll();
            break;
            
        case "single":
            // 处理 REST Url  GET /api/id/
            $res = new Response();
            $res->getOne($_GET["id"]);
            break;

        case "" :
            //404 - not found;
            break;
    }
        break;

    // POST 请求
        
    case 'POST':
            // 处理 REST URL  PUT /api/list/id/  以post方式更新单条数据
            $res = new Response();
            if ($view == "single") {
                var_dump(2);
                $res->putOne($_GET["id"],$_GET["title"],$_GET["content"],$_GET["complete"]);
            }else{
                // 处理 REST Url  POST /api/list/ 增加一条数据
                $res->postOne($_GET["title"],$_GET["content"]);
            }
        break;

    case "PUT":
         // 处理 REST URL  PUT /api/list/id/
        if ($view == "single") {
            $json = file_get_contents('php://input');
            $data = json_decode($json,true);

            $res = new Response();
            // var_dump($data["complete"]);
            $res->putOne($data["id"],$data["title"],$data["content"],$data["complete"]);
        }
        break;
    
    case "DELETE":
        // 处理 REST URL  DELETE /api/list/id/
        if ($view == "single") {
            $json = file_get_contents('php://input');
            $data = json_decode($json,true);
            $res = new Response();
            $res->deleteOne($data["id"]);
        }
        break;
        
    case "" :
        //404 - not found;
        break;
}
?>