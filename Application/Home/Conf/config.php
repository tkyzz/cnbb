<?php
return array(
	'SHOW_ERROR_MSG' =>    false,
	'HTML_CACHE_ON'     =>    true, // 开启静态缓存
	'HTML_CACHE_TIME'   =>    60,   // 全局静态缓存有效期（秒）
	// 'HTML_CACHE_RULES'=> array( 
 //    'Student:'=>array('{:My_Notice}_{id}',1), 
 //      ), 
	'HTML_FILE_SUFFIX'  =>    '.shtml', // 设置静态缓存文件后缀
	'TMPL_STRIP_SPACE' => 	true,//开启去除模板HTML空格
	// //'ERROR_PAGE' =>		MODULE_PATH.'View/Public/error.html',
	// 'TMPL_ACTION_ERROR'     =>  '/Public/error.html', // 默认错误跳转对应的模板文件
	// 'TMPL_ACTION_SUCCESS'   =>  MODULE_PATH.'View/Public/success.html', // 默认成功跳转对应的模板文件
	// //'TMPL_EXCEPTION_FILE'   =>  MODULE_PATH.'View/Public/exception.html',// 异常页面的模板文件
	// 'TMPL_EXCEPTION_FILE' =>  '/Public/error.html', // 默认错误跳转对应的模板文件
);