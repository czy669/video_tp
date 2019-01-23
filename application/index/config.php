<?php

use think\Env;
//配置文件
return [
	// 应用调试模式
	'app_debug'              => Env::get('app.debug', true),
	//分页配置
	'paginate'               => [
		'type'      => 'bootstrap1',
		'var_page'  => 'page',
		'list_rows' => 15,
	],
];
