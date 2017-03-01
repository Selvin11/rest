<?php 
    // require_once("db.config");
    /**
    * restful api 类
    */
    class Site
    {
        public  $dbms='mysql',            //数据库类型
                $host='localhost:8889',  //数据库主机名
                $dbName='test',         //使用的数据库
                $user='root',          //数据库连接用户名
                $pass='root';         //对应的密码


        private $pdo;

        public function __construct()
        {
            
            $dsn = $this->dbms.":host=".$this->host.";dbname=".$this->dbName.";charset=utf8";
            // echo $dsn;
            try {
                $this->pdo = new PDO($dsn, $this->user, $this->pass); //初始化一个PDO对象
                 // 设置 PDO 错误模式，用于抛出异常
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die ("Error!: " . $e->getMessage() . "<br/>");
            }
        }

        public function getAll()
        {
           try {
                //对于需要发出多次的sql语句，用 PDO::prepare() 来准备一个 PDOStatement 对象并用 PDOStatement::execute() 发出语句。 
               $stmt = $this->pdo->prepare("SELECT id,title,content FROM article_list");
               $stmt->execute();
               $row = $stmt->fetchAll();
               var_dump($row);
               echo "<br/>";
           } catch (PDOException $e) {
               die ("Error!: " . $e->getMessage() . "<br/>");
           }
           
        }

        public function __destruct()
        {
            $this->pdo = null;
            var_dump($this->pdo);
            echo "结束时自己调用"."<br/>";
        }
    }


    $site = new Site();
    $site->getAll();
 ?>