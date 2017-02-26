<?php 

$dbms='mysql';     //数据库类型
$host='localhost:8889'; //数据库主机名
$dbName='test';    //使用的数据库
$user='root';      //数据库连接用户名
$pass='root';          //对应的密码
$dsn="$dbms:host=$host;dbname=$dbName;charset=utf8";


class DbHandle{
    // 获取所有数据
    public function getAll(){
        global $dsn,$user,$pass,$row;
        try {
            $conn = new PDO($dsn, $user, $pass); //初始化一个PDO对象
             // 设置 PDO 错误模式，用于抛出异常
               $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
               $stmt = $conn->prepare("SELECT id,title,content FROM article_list");
               $stmt->execute();
               $row = $stmt->fetchAll();
            $conn = null;
            return $row;
        } catch (PDOException $e) {
            die ("Error!: " . $e->getMessage() . "<br/>");
        }
    }

    // get 获取单条数据
    public function getSingle($id){
        global $dsn,$user,$pass,$row;
        try {
            $conn = new PDO($dsn, $user, $pass); //初始化一个PDO对象
             // 设置 PDO 错误模式，用于抛出异常
               $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
               $stmt = $conn->prepare("SELECT * FROM article_list where id = ?");
               if ($stmt->execute([$id])) {
                $row = $stmt->fetch();
               }
            $conn = null;
            return $row;
        } catch (PDOException $e) {
            die ("Error!: " . $e->getMessage() . "<br/>");
        }
    }
    
    // post
    public function postSingle($title,$content){
        global $dsn,$user,$pass;
        try {
            $conn = new PDO($dsn, $user, $pass); //初始化一个PDO对象
             // 设置 PDO 错误模式，用于抛出异常
               $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
               $stmt = $conn->prepare("INSERT INTO article_list (title, content) VALUES (?,?)");
               // $stmt->bindParam(1, $title);
               // $stmt->bindParam(2, $content);
               $stmt->execute([$title,$content]);
            $conn = null;
            return array('code' => '添加成功');
        } catch (PDOException $e) {
            die ("Error!: " . $e->getMessage() . "<br/>");
        }
    }
    // put 更新单条数据
    public function putSingle($id,$title,$content){
      global $dsn,$user,$pass;
      try {
          $conn = new PDO($dsn, $user, $pass); //初始化一个PDO对象
           // 设置 PDO 错误模式，用于抛出异常
             $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
             $stmt = $conn->prepare("UPDATE article_list SET title=?,content=? WHERE id=?");
             $stmt->execute([$title,$content,$id]);
          $conn = null;
          return array('code' => '修改成功');
      } catch (PDOException $e) {
          die ("Error!: " . $e->getMessage() . "<br/>");
      }
    }
    // delete 单条数据
    public function deleteSingle($id){
      global $dsn,$user,$pass;
      try {
          $conn = new PDO($dsn, $user, $pass); //初始化一个PDO对象
           // 设置 PDO 错误模式，用于抛出异常
             $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
             $stmt = $conn->prepare("DELETE FROM article_list WHERE id=?");
             $stmt->execute([$id]);
          $conn = null;
          return array('code' => '删除成功');
      } catch (PDOException $e) {
          die ("Error!: " . $e->getMessage() . "<br/>");
      }
    }
}

// $db = new DbHandle();
// $db->getSingle(14);
 ?>