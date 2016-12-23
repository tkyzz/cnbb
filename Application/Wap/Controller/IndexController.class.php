<?php
namespace Wap\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
    	if ( empty(session('user.access_token'))){
			echo '请登录';
    	}else{
    		echo '当前token : '.session('user.access_token');
    	}
    	
        //$this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;font-size:24px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px } a,a:hover{color:blue;}</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>WAP欢迎使用 <b>ThinkPHP</b>！</p><br/>版本 V{$Think.version}</div>','utf-8');
    }
}