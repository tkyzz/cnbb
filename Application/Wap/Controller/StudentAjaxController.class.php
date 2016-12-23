<?php
namespace Wap\Controller;

use Think\Controller;

class StudentAjaxController extends Controller
{

    /**
     * @desc 构造
     * @author zhuyi
     * @date 2016-07-02
     */
    public function __construct()
    {
        parent::__construct();
        $this->assign('navclass', 'h5');

    }

    /**
     * @desc 更新默认简历头像
     * @author zhuyi
     * @date 2016-07-02
     */
    public function updateAvatar(){
        $param['access_token'] = session('user.access_token');
        if ( empty($param['access_token']) ){
             $this->ajaxReturn(array('msg' => '请登录！','status'=> 0),'json');
        }
        $param['avatar_id'] = I('post.avatar_id');
        $param['id'] = I('post.id');
        if ( empty($param['avatar_id']) || empty($param['id']) ){
             $this->ajaxReturn(array('msg' => '需要先填写个人信息','status'=> 0),'json');
        }
        $url = get_api_info("resume",'base/update_avatar'); //获取路由地址
        $res = request_api($url,$param,'put'); //上传
        ///var_dump($res);
        if ( $res['error_code'] == 'success' ) {
             $this->ajaxReturn(array('msg' => 'success','status'=> 1),'json');
         } else {
            $this->ajaxReturn(array('msg' => $res['error_description'],'status'=> 0),'json');
         }
    }




}