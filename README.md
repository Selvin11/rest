# 原生PHP编写REST API

* Apache URL Rewrite 模式开启

  ```
      // apache/httpd.conf
      1. LoadModule rewrite_module modules/mod_rewrite.so  去掉#
      2. 下面两处的None 改为All
        <Directory />
            Options Indexes FollowSymLinks
            AllowOverride None   // None 改为 All
        </Directory>

        <Directory "/Applications/MAMP/htdocs">
            AllowOverride None    // None 改为 All
            Order allow,deny
            Allow from all
        </Directory>
      3. 重启Apache Server，如果是MAMP等集成环境，最好关闭集成环境，重新打开。
      
  ```


* 项目根目录下增加.htaccess文件，填写URL路径规则

  ```
    # 开启 rewrite 功能
    Options +FollowSymlinks
    RewriteEngine on

    # 重写规则
    # http://localhost/项目名/api/list/  跳转至  http://localhost/项目名/RestController.php?view=all
    RewriteRule ^api/list/$   RestController.php?view=all [nc,qsa]
    # http://localhost/项目名/api/list/1/  跳转至  http://localhost/项目名/RestController.php?view=single&id=1
    RewriteRule ^api/list/([0-9]+)/$   RestController.php?view=single&id=$1 [nc,qsa]


  ```

* 增加PDO查询单条数据和增加单条数据的接口 

* 后端接口通过判断请求头中的`Accept`属性，来对查询返回后的数据进行`json`/`html`/`xml`的转换

* 实现RESTFUL中的增删改查的基本接口

* 改进`Rest`和`Response`类，更加直观简洁，能迅速了解`GET`/`POST`/`PUT`/`DELETE`对应的`RestFul`接口

* PDO 查询MySQL返回字段整型（int）变为字符串型（String）解决方法
  ```php
     <?php
     $pdo = new PDO($dsn, $user, $pass, $param);

     // 在创建连接后，加入
     $pdo->setAttribute(PDO::ATTR_STRINGIFY_FETCHES, false);//提取的时候将数值转换为字符串,关闭
     $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);//启用或禁用预处理语句的模拟,禁用
     ?>
  ```