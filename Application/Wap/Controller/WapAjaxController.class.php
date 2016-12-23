<?php
namespace Wap\Controller;

use Think\Controller;

class WapAjaxController extends Controller
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
     * @desc 获取岗位列表
     * @author zhuyi
     * @date 2016-07-02
     */
    public function getJobList(){
        $is_val = 0;
        if (!empty(session("user.access_token"))){
            $param['access_token'] = session('user.access_token');
        }
        $param['size'] = C("PAGE_SIZE");//页大小
        if (!empty(I('get.page'))){//页码
            $param['page'] = I('get.page');
        }
        if (!empty(I('get.trade'))){//行业
            $is_val = 1;
            $param['org_trades'] = I('get.trade');
        }
        if (!empty(I('get.city'))){//城市
            $is_val = 1;
            $param['cities'] = I('get.city');
        }
        if (!empty(I('get.work_type'))){//工作类型
            $is_val = 1;
            $param['work_type'] = I('get.work_type');
        }
        if (!empty(I('get.work_day'))){//工作时长
            $is_val = 1;
            $param['work_duration'] = I('get.work_day')*30;
        }
        if (!empty(I('get.week_day'))){//每周工作天数
            $is_val = 1;
            $param['week_workdays'] = I('get.week_day');
        }

        //print_r($param);
        $url = get_api_info('post',"search"); //获取登录路由地址
        $res = request_api($url,$param,'get'); //请求
        //print_r($res);
        if(empty($res['posts'])){
            $this->ajaxReturn(array('msg' => '没有更多岗位了','status'=> 0),'json');
        }
        $this->assign('res',$res);
        $data['html'] = $this->fetch("ajax_list");
        $data['page'] = ceil($res['total']/10);
        $data['count'] = $res['total']?$res['total']:0;
        $data['is_val'] = $is_val;
        $data['param'] = $param;
        $data['msg'] = "success";
        $data['status'] =1;
        $this->ajaxReturn($data,'json');
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