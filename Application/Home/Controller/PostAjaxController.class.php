<?php
//author zhuyi
namespace Home\Controller;
use Think\Controller;
class PostAjaxController extends Controller {

 /**
 * @desc 构造
 * @author zhuyi
 * @date 2016-07-02
 */
public function __construct(){
    parent::__construct();
}

 /**
 * @desc 搜索预选
 * @author zhuyi
 * @date 2016-11-18
 */
public function Search_Hint(){
	$param['keyword'] = urlencode(I('get.keyword'));
	$param['keyword_by'] = I('get.keyword_by');
	if( empty( $param['keyword'] ) ){
		$this->ajaxReturn(array('msg' => '关键词为空！','status'=> 0),'json');
	}
	$url = get_api_info('post','search_hint'.$param['id']); //获取路由地址
	$res = request_api($url,$param,'get'); //获取结果集
	//print_r($res);
	if( empty( $res ) ){
		$this->ajaxReturn(array('msg' => '没有结果','status'=> 0),'json');
	}
	$param['keyword'] = urldecode($param['keyword']);
	$param['keyword'] = str_replace(' ', '', $param['keyword']);//去除关键字里的空格
	foreach($res as $k => $v){

		//var_dump(mb_strpos($res[$k]['name'], trim(urldecode($param['keyword']))));
		
		if(mb_strpos($res[$k]['name'], trim($param['keyword'])) !== false){
			$str = '<span class="same">'.trim($param['keyword']).'</span>';
			$res[$k]['t_name'] = str_replace(trim($param['keyword']),$str,$res[$k]['name']);
		}else{
			$res[$k]['t_name'] = $res[$k]['name'];
		}
		// if($res[$k]['type'] == 1){//职位是1
		// 	$job[] = $res[$k];
		// }elseif($res[$k]['type'] ==0){//公司为0
		// 	$company[] = $res[$k];
		// }
	}
	//print_r($res);
	$this->assign('job',$res);//职位
	//$this->assign('company',$company);//公司
    $html = $this->fetch("ajax_post_searchHint");//得到内存数据
	$this->ajaxReturn(array('msg' => 'success','info' => $html, 'count'=> count($res) ,'status' => 1),'json');
}








}