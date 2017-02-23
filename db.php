<?php 

$dbms='mysql';     //数据库类型
$host='localhost:8889'; //数据库主机名
$dbName='test';    //使用的数据库
$user='root';      //数据库连接用户名
$pass='root';          //对应的密码
$dsn="$dbms:host=$host;dbname=$dbName;charset=utf8";


class DbHandle{
    public function postSingle(){
        global $dsn,$user,$pass;
        try {
            $conn = new PDO($dsn, $user, $pass); //初始化一个PDO对象
             // 设置 PDO 错误模式，用于抛出异常
               $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
               $stmt = $conn->prepare("INSERT INTO article_list (title, content) VALUES (?,?)");
               $stmt->bindParam(1, $name);
               $stmt->bindParam(2, $value);
               $name='标题';
               $value='内容';
               echo "新记录插入成功";
               $stmt->execute();
            $conn = null;
        } catch (PDOException $e) {
            die ("Error!: " . $e->getMessage() . "<br/>");
        }
    }

    public function getSingle($id){
        global $dsn,$user,$pass,$row;
        
        try {
            $conn = new PDO($dsn, $user, $pass); //初始化一个PDO对象
             // 设置 PDO 错误模式，用于抛出异常
               $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
               $stmt = $conn->prepare("SELECT * FROM article_list where id = ?");
               if ($stmt->execute(array($id))) {
                $row = $stmt->fetch();
               }
            $conn = null;
            return $row;
        } catch (PDOException $e) {
            die ("Error!: " . $e->getMessage() . "<br/>");
        }
    }
}

$db = new DbHandle();
$db->getSingle(14);
 ?>