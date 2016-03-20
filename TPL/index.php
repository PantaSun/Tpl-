<?php
	require dirname(__FILE__).'/template.inc.php';
	//实例化
	$_tpl = new Templates();
	//注入变量
	$_array = array(1,2,3,4,5,6,7);
	$_tpl->assign('array',$_array);
	$_tpl->assign('name','23333');
	$_tpl->assign('content','我就是喜欢：');
	$_tpl->assign('a',0);
	//载入模板
	$_tpl->display('index.tpl');

?>
