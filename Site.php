<?php
/* 
 * 菜鸟教程 RESTful 演示实例
 * RESTful 服务类
 */

require_once("db.php");

Class Site{
    
    private $sites = array(
        1 => 'TaoBao',  
        2 => 'Google',  
        3 => 'Runoob',              
        4 => 'Baidu',              
        5 => 'Weibo',  
        6 => 'Sina'
            
    );
        
    
    public function getAllSite(){
        $db = new DbHandle();
        $sites = $db->getAll();
        return $sites;
    }
    
    public function getSite($id){
        $db = new DbHandle();
        $site = $db->getSingle($id);
        // $site = array($id => ($this->sites[$id]) ? $this->sites[$id] : $this->sites[1]);
        return $site;
    } 

    public function postSite($title,$content){
        $db = new DbHandle();
        $site = $db->postSingle($title,$content);
        return $site;
    }

    public function putSite($id,$title,$content){
        $db = new DbHandle();
        $site = $db->putSingle($id,$title,$content);
        return $site;
    }

    public function deleteSite($id){
        $db = new DbHandle();
        $site = $db->deleteSingle($id);
        return $site; 
    }

}
?>