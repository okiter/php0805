<?php
//>>1.对比当前PHP运行的环境
version_compare(PHP_VERSION,'5.3.0','>=')  or exit('版本太低');
//>>2.定义项目的运行根目录
define('ROOT_PATH',dirname($_SERVER['SCRIPT_FILENAME']).'/');
//>>3.将ThinkPHP的框架目录定义为常量
define('THINK_PATH',dirname(ROOT_PATH).'/ThinkPHP'.'/');
//>>4.定义APP_PATH,指定应用目录
define('APP_PATH',ROOT_PATH.'Application'.'/');
//>>5.定义RUNTIME_PATH,指定运行目录
define('RUNTIME_PATH',ROOT_PATH.'Runtime'.'/');
//>>6.定义是否在调试模式下
define('APP_DEBUG',true);
//>>7.绑定模型
define('BIND_MODULE','Home');

//define('HTML_PATH',ROOT_PATH.'Html/');  定义静态缓存文件存放的目录, 默认请求下 APP_PATH 的Html文件中

//>>2.加载框架代码
require THINK_PATH.'ThinkPHP.php';