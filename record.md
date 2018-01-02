#GITHUB创建项目

##安装yii2框架
一、在写代码的地方按住Shift打开命令窗口，输入命令：composercreate-project yiisoft/yii2-app-advanced yiishop -vvv    
 安装之后 在命令窗口出现Generating autoload files，则表示安装成功   
二、初始化    
三、找到入口文件，设置虚拟主机   
四、配置    
1、配置语言和时区：common\config\main.php（前后都需要）
    'language'=>'zh-CN',//语言    
    'timeZone'=>'zh-CN',//时区   
2、配置数据库：common\config\main-local.php
(遇到的小问题：phpstudy的数据库是默认是没有innodb引擎的)    
解决方案：找到my.ini这个文件把default-storage-engine=MYISAM 换成 default-storage-engine=INNODB
支持 INNODB 引擎模式。修改为　default-storage-engine=INNODB　即可。如果 INNODB 模式如果不能启动，删除data目录下ib开头的日志文件重新启动。

## 品牌模块
一、建表（用数据迁移）