<?php
namespace Wap\Controller;

use Think\Controller;

class StudentController extends Controller
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
        //下载链接
        $this->assign('download_url',getDownUrl());
        //设置返回地址
        if (!empty(I('get.return'))){
            cookie('return',I('get.return'));
        }
    }

    /**
     * @desc 投递反馈
     * @author zhuyi
     * @date 2016-12-06
     */
    public function feedback(){
        $this->display('feedback');
    }


    /**
     * @desc 我的简历
     * @author zhuyi
     * @date 2016-12-09
     */
    public function myResume(){
        if(!check_login()){
                redirect('/m/login.html');
        }
        $param['access_token'] = session("user.access_token");
        //$url_id = substr(base64_decode(I('get.id')),6);
        if (empty($param['access_token'])){
            $this->error("非法操作");
        }
        //个人信息
        $res = $this->_getDefaultResumeBase();
        $edu = $this->_getDefaultResumeEdu()[0];
        //print_r($edu);
        if ($res == 'unauthorized' || $edu == 'unauthorized') {
            redirect('/m/logout.html');
        }
        $intention = getIntention($param['access_token'],1);
        //print_r($intention);
        if ( empty($intention['id']) ){
            //自动创建求职意向
            $data['access_token'] = session("user.access_token");
            $data['resume_id'] = $res['resume_id'];
            $data['work_type'] = 1;
            $data['week_workdays'] = 0;
            $data['work_duration'] = 0;
            $data['arrive_days'] = 0;
            $url = get_api_info('resume','intention/create'); //获取路由地址
            $res = request_api($url,$data,'post'); //请求
        }
        $this->assign('res',$res);
        //教育经历
        $this->assign('edu',$edu);
        $this->display('myresume');
    }

    /**
     * @desc 获取简历列表
     * @author zhuyi
     * @date 2016-12-09
     */
    public function _getResumeList(){
        $param['access_token'] = session("user.access_token");
        if (empty($param['access_token'])){
            return false;
        }
        //获取路由地址
        $url = get_api_info('resume','list/my'); 
        //简历列表
        $list = request_api($url,$param,'get'); 
        return $list;
    }

    /**
     * @desc 获取简历个人信息内容
     * @author zhuyi
     * @date 2016-12-09
     */
    public function _getDefaultResumeBase(){
        $param['access_token'] = session("user.access_token");
        if (empty($param['access_token'])){
            return false;
        }
        $list = $this->_getResumeList();
        if (isset($list['error_code']) && $list['error_code']=='unauthorized'){
            return 'unauthorized';
        }
        //没有简历创建简历
        if (empty($list)){
            $param['name'] = '未命名简历';
            $param['open_level'] = 0;
            $url = get_api_info('resume','create'); //获取路由地址
            $res = request_api($url,$param,'post'); //创建简历
            if ( $res['error_code'] == 'success' ) {
                $list = $this->_getResumeList();
            }else{
                return false;
            }
        }
        $uid = $list[0]['uid'];//用户id
        //默认简历ID
        $resume_id = $list[0]['id'];
        //print_r($res);

        //获取路由地址
        $url = get_api_info('resume','base/get'); 
        //获取默认简历的基本信息
        $res = request_api($url,array('uid' => $uid , 'resume_id' => $resume_id , 'access_token' => $param['access_token']),'get');
        $res['resume_id'] = $resume_id;
        return $res;
    }

    /**
     * @desc 获取简历教育经历
     * @author zhuyi
     * @date 2016-12-09
     */
    public function _getDefaultResumeEdu(){
        $param['access_token'] = session("user.access_token");
        if (empty($param['access_token'])){
            return false;
        }
        //获取路由地址
        $url = get_api_info(1,'list/my'); 
        //简历列表
        $list = request_api($url,$param,'get'); 
        if (isset($res['error_code']) && $res['error_code']=='unauthorized'){
            return 'unauthorized';
        }
        $uid = $list[0]['uid'];//用户id
        //默认简历ID
        $resume_id = $list[0]['id'];
        //获取路由地址
        $url = get_api_info('resume','edu/list'); 
        //获取默认简历的基本信息
        $res = request_api($url,array('resume_id' => $resume_id , 'access_token' => $param['access_token']),'get');
        $res[0]['resume_id'] = $resume_id;
        //print_r($res);
        return $res;
    }
    /**
     * @desc 编辑个人信息
     * @author zhuyi
     * @date 2016-12-09
     */
    public function updateResumeBase(){
        if ( IS_POST ) {
            $data = I('post.post');
            $data['access_token'] = session("user.access_token");
            if ( empty($data['access_token']) ){
                 $this->ajaxReturn(array('msg' => '请重新登录','status'=> 0),'json');
            }
            $data['birthday'] = explode('-',$data['birthday']);
            $data['birthday'] = implode('',$data['birthday']);
            if ( $data['type'] == 'create' ) {
                $url = get_api_info('resume','base/create'); 
                $res = request_api($url,$data,'post'); 
            } elseif ( $data['type'] == 'update' ) {
                $url = get_api_info('resume','base/update'); 
                $res = request_api($url,$data,'put');
            }
            //print_r($data);
            if ( $res['error_code'] == 'success' ) {
                 $this->ajaxReturn(array('msg' => 'success','status'=> 1),'json');
             } else {
                 $this->ajaxReturn(array('msg' => $res['error_description'],'status'=> 0),'json');
             }
        }else {
            if( !check_login() ){
                redirect('/m/login.html');
            }
            $res = $this->_getDefaultResumeBase();
            if ($res == 'unauthorized') {
                redirect('/m/logout.html');
            }
            $area = smartAreas(array('code' => "",'nohw'=>'true'));//省列表
            $this->assign('prov',$area);
            $this->assign('res',$res);
            $this->display('resumeBasic');
        }

    }

    /**
     * @desc 编辑教育信息
     * @author zhuyi
     * @date 2016-12-09
     */
    public function updateResumeEdu(){
        if(!check_login()){
                redirect('/m/login.html');
        }
        if ( IS_POST ) {
            $data = I('post.post');
            $data['access_token'] = session("user.access_token");
            if ( empty($data['access_token']) ){
                 $this->ajaxReturn(array('msg' => '缺少参数','status'=> 0),'json');
            }
            $data['sdate'] = explode('-',$data['sdate']);
            $data['grade'] = $data['sdate'][0];
            $data['edate'] = explode('-',$data['edate']);
            $data['sdate'] = implode('',$data['sdate']);
            $data['edate'] = implode('',$data['edate']);
            if ( $data['sdate'] > $data['edate'] ) {
                $this->ajaxReturn(array('msg' => '毕业时间必须晚于入校时间','status'=> 0),'json');
            }
            //print_r($data);
            if ( $data['type'] == 'create' ) {
                //创建教育经历
                $url = get_api_info('resume','edu/create'); 
                $res = request_api($url,$data,'post'); 
            } elseif ( $data['type'] == 'update' ) {
                //更新教育经历
                //unset($data['resume_id']);
                $url = get_api_info('resume','edu/update');
                $res = request_api($url,$data,'put'); 
            }
            //print_r($res);
            if ( $res['error_code'] == 'success' ) {
                 $this->ajaxReturn(array('msg' => 'success','status'=> 1),'json');
             } else {
                 $this->ajaxReturn(array('msg' => $res['error_description'],'status'=> 0),'json');
             }
            
        } else {
            $res = $this->_getDefaultResumeEdu()[0];
            if ($res == 'unauthorized') {
                redirect('/m/logout.html');
            }
            $this->assign('major_list',$major_list = getMajorCategories(array('access_token' => session("user.access_token"))));
            $area = smartAreas(array('code' => "",'nohw'=>'true'));//省列表
            $this->assign('prov',$area);
            //第一份教育经历
            $this->assign('res',$res);
            $this->display('resumeEducation');
        }

    }


}