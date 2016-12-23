<?php 	
namespace Components;
use Think\Controller;
class BaseController extends Controller{
    public function __construct() {
        parent::__construct();
        $this->checkLogin();
    }
    private function checkLogin(){
        $res = session('user');
        $member = session('member');
        $token=cookie('xscnbb_token');
        if(empty($token)){
            redirect('/login.html');
            exit;
        }
        elseif(isset($res['un_events']) && $res['un_events'][0] == 'unverified_mail' && $member['type'] ==1){
        //激活邮箱才能使用某些功能
            $this->redirect('/registerActive');
        }
        // elseif($member['type'] ==2){
        //     $url = get_api_info('org','verify_state'); //获取登录路由地址GET /org/
        //     $res = request_api($url,array('access_token'=>$res['access_token']),'get'); //验证机构状态
            //print_r($res);
            // if($res['result'] == 1){
            //     $this->redirect('/company/create');
            // }elseif($res['result'] == 2){
            //      $this->redirect(C('EE_URL'));
            // }elseif($res['result'] == 3){
            //      $this->redirect('/company/resub');
            // }
        //}
        // }elseif($member['type']==2){
        //     $this->redirect('/index');
        // }
        //消息数量
        session('message_num',_get_notice());
    }


    
    // 图片上传
    public function upload($img,$key){
        $upload = new \Think\Upload();
        $upload->maxSize   =     5242880;
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');
        $upload->autoSub   =     false;
        $upload->rootPath  =     './uploads/';
        $upload->savePath  =     '';

        $info  =  $upload->upload($img);
        //print_r($info);
        if(!$info){
            return false;
        }else{
            return $info[$key];
        }
    }


    // 图片裁剪
    public function cropper($img,$url,$x,$y,$w,$h){
        $image = new \Think\Image(); 
        $image->open($img);
        $image->crop($w,$h,$x,$y)->save($url);
        return $url;
    }


    // 图片固定大小压缩
    public function gdzoom($img,$url,$w,$h){
        $image = new \Think\Image();
        $image->open($img);
        $image->thumb($w, $h,\Think\Image::IMAGE_THUMB_FIXED)->save($url);
        return basename($url);
    }

}
