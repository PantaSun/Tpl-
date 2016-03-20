<?php
//设置编码
header('Content-Type:text/html; charset=utf-8');
//网站根目录
define('ROOT_PATH', dirname(__FILE__));
//存放模板目录
define('TPL_DIR', ROOT_PATH.'/templates/');
//编译文件夹
define('TPL_C_DIR', ROOT_PATH.'/templates_c/');
//缓存文件夹
define('CACHE_DIR', ROOT_PATH.'/cache/');
define('IS_CACHE',true);
//是否开启缓存区
IS_CACHE ? ob_start() : null;
require ROOT_PATH.'/includes/Templates.class.php';

 ?>
