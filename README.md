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
    # http://localhost/项目名/site/list/  跳转至  http://localhost/项目名/RestController.php?view=all
    RewriteRule ^site/list/$   RestController.php?view=all [nc,qsa]
    # http://localhost/项目名/site/list/1/  跳转至  http://localhost/项目名/RestController.php?view=single&id=1
    RewriteRule ^site/list/([0-9]+)/$   RestController.php?view=single&id=$1 [nc,qsa]


  ```

* 增加PDO查询单条数据和增加单条数据的接口 