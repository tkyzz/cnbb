<?php
//author zhuyi
namespace Home\Controller;
use Think\Controller;
class PublicController extends \Components\BaseController {


	//图片上传
    public function uploads(){
        $filename = I('post.name');
        $type = I('post.type','api');
        $w = I('post.w','240');
        $h = I('post.h','240');
        //print_r($_FILES[$filename]);
        $imginfo = $this->upload($_FILES,$filename);
        //var_dump($imginfo);
        if(!$imginfo){
             $this->ajaxReturn(array("status"=>0,'msg'=>'上传失败'),'json');
        }
        if( $imginfo['savename'] ){
            $imginfo['ext'] = pathinfo($imginfo['name'], PATHINFO_EXTENSION);
            if($type == 'api'){
                $path = "{$_SERVER['DOCUMENT_ROOT']}/Uploads/";
                $pic_path = $path.$this->gdzoom($path.$imginfo['savename'],$path.time()."_".mt_rand().".{$imginfo['ext']}",$w,$h);
                $res = $this->uploadPicApi($pic_path);
                $this->ajaxReturn(array("status"=>1,'msg'=>'上传成功',"file_id"=>$res['file_id'],"path"=>$res['path']),'json');
            }else{
                $path = "/Uploads/";
                $this->ajaxReturn(array("status"=>1,'msg'=>'上传成功',"path"=>$path.$imginfo['savename']),'json');
            }

        }
    }

    public function uploadPicApi($path){
        if(empty($path)){
            return false;
        }
        $param['file'] = curl_file_create($path);
        $url = get_api_info("file",'upload'); //获取路由地址
        $res = request_api($url,$param,'post',true); //上传
        //var_dump($res);
        if(empty($res['file_id'])){
            return false;
        }else{
            return $res;
        }
    }

}