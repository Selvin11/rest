<?php 
    /**
    * restful api 类
    */
    class Rest
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
                // PDO::ATTR_STRINGIFY_FETCHES 提取的时候将数值转换为字符串。 
                // PDO::ATTR_EMULATE_PREPARES 启用或禁用预处理语句的模拟。
                $this->pdo->setAttribute(PDO::ATTR_STRINGIFY_FETCHES, false);
                $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            } catch (PDOException $e) {
                die ("Error!: " . $e->getMessage() . "<br/>");
            }
        }

        // GET 获取所有数据
        public function getAll()
        {
           try {
                //对于需要发出多次的sql语句，用 PDO::prepare() 来准备一个 PDOStatement 对象并用 PDOStatement::execute() 发出语句。 
               $stmt = $this->pdo->prepare("SELECT * FROM todo");
               $stmt->execute();
               $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
               return $row;
           } catch (PDOException $e) {
               die ("Error!: " . $e->getMessage() . "<br/>");
           }
           
        }


        // GET 获取单条数据
        public function getOne($id){
            try {
                $stmt = $this->pdo->prepare("SELECT * FROM todo where id = ?");
                   if ($stmt->execute([$id])) {
                    // 获取单条数据，只包含键名不含数字PDO::FETCH_ASSOC
                    $row = $stmt->fetch();
                   }
                   var_dump($row);
                return $row;
            } catch (PDOException $e) {
                die ("Error!: " . $e->getMessage() . "<br/>");
            }
        }

        // POST 增加单条数据
        public function postOne($title,$content)
        {
            try {
                $stmt = $this->pdo->prepare("INSERT INTO todo (title, content) VALUES (?,?)");
                $stmt->execute([$title,$content]);
                return array('code' => '添加成功');
            } catch (PDOException $e) {
                die ("Error!: " . $e->getMessage() . "<br/>");
            }
        }

        // PUT 更新单条数据
        function putOne($id,$title,$content,$complete)
        {
            try {
                $stmt = $this->pdo->prepare("UPDATE todo SET title=?,content=?,complete=? WHERE id=?");
                $stmt->execute([$title,$content,$complete,$id]);
                return array('code' => '修改成功');
            } catch (PDOException $e) {
                die ("Error!: " . $e->getMessage() . "<br/>");
            }
        }

        // DELETE 删除单条数据
        public function deleteOne($id)
        {
            try {
                $stmt = $this->pdo->prepare("DELETE FROM todo WHERE id=?");
                $stmt->execute([$id]);
                return array('code' => '删除成功');
            } catch (PDOException $e) {
                die ("Error!: " . $e->getMessage() . "<br/>");
            }
        }


        // 实例调用结束后执行，断开pdo数据库连接
        public function __destruct()
        {
            $this->pdo = null;
        }
    }


    // $site = new Rest();
    // $site->getAll();
 ?>