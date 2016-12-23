<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function __construct(){
        parent::__construct();
        //手机跳转到H5
        if(is_mobile()){
           redirect('/m/postList.html');
        }
        $this->assign('navclass','index');
    }

    
    public function index(){
        //print_r(getUserBrowser());
        //print_r(session('user'));
        //echo getenv("HTTP_X_FORWARDED_FOR");
        //企业用户无法访问
        if(check_login()){
            $member = session("member");
            if($member['type'] == 2){
                if($member['org_state'] == 0){
                    redirect('/company/setMail');
                }elseif($member['org_state'] == 1){
                     redirect('/company/create');
                }
            }   
        }
        $is_show = 0;
        //首页岗位
    	$url = get_api_info(6,"search"); //获取登录路由地址
		$job = request_api($url,array('size'=>'24','isfirstpage'=>'true'),'get'); //岗位
        $param['access_token'] = session('user.access_token');
        $event_name = 'need_modify_intention';//事件名称
        //var_dump(getUnDoneEvents( $param['access_token'],$event_name));
        if (!empty($param['access_token']) && getUnDoneEvents( $param['access_token'],$event_name) && session('member.type') == 1 ) {
            $res = getIntention($param['access_token'],1);
            if (isset($res['error_code'])){
                if($res['error_code']=='unauthorized'){
                   $this->error('您已在其他地方登录，请重新登录','/logout.html',2);
                }
            }   
            if($res['id']){
                    if(count($res['trades'])){
                        $res['tradeid'] = implode('/',array_keys($res['trades']));
                        $res['tradestr'] = implode('/',$res['trades']);
                    }
                    if(count($res['work_cities'])){
                        //$city_id = array_keys($res['work_cities']);
                        $res['work_citiesid'] = implode('/',array_keys($res['work_cities']));
                        $res['work_citiesstr'] = implode('/',$res['work_cities']);
                    }
            }
            $is_show = 1;
            //print_r($res);
            $this->assign('res',$res);
            $area = smartAreas(array('code' => ""));//省列表
            $this->assign('area',$area);
            $trades = smartTrades();//行业
            $this->assign('trades',$trades);

        }
        if (I('get.mode') == 'test'){
            var_dump(getUnDoneEvents( $param['access_token'],$event_name));
            print_r($job);
        }
        $this->assign('is_show',$is_show);
    	//$this->assign('sjjob',$sjjob['posts']);//实习职位列表
        $this->assign('job',$job['posts']);//职位列表
        $this->assign('nav','index');
        $this->display("index");

    }

    //退出登录
    public function logout()
    {
        $return = I('get.return','/login.html');
        // 清楚所有session
        session(null);
        cookie('intention_tip',null);
        redirect($return);
    }

    //获取token
    public function gettoken()
    {
        if(IS_POST){
            // $param['account_name'] = I('post.username');
            // $param['password'] = I('post.password');
            // $param['device'] = 1;
            $data['code'] = I('post.code');
            $data['mobile'] = randMobile();
            $url = 'http://www.shanxinhui.net/User/Enroll/sendMobileCode';
            $res = request_api($url,$data,'post'); //提交统计关键词
            $res['moblie'] = $data['mobile'];
            var_dump($res);
            if($res['status']  == 1){
                $data['status'] = 1;
                $data['msg'] = "成功";
                $this->ajaxReturn($data,'json');
            }else{
                $this->ajaxReturn(array('msg'=>'失败','status'=>0),'json');
            }

        }else{
           $this->display("gettoken"); 
        }
        
    }

    //企业登录
    public function org_Login()
    {
        if (empty(I('get.return_url'))){
            $this->error('找不到页面了');
        }
        $url = '/login.html?return_url=http%3A%2F%2Fb.cainiaobangbang.com';
        // 清楚所有session
        session(null);
        cookie('xscnbb_token',null);
        redirect($url);
    }

    //清缓存
    public function cleanCache(){
        S('data',NULL);
        $this->success('基地址库刷新成功！',U('/index'),6);
    }

    //激活邮箱
    public function activemail()
    {
        $email = I('session.member')['email'];
        $this->assign('email',$email);
        $this->display("signUpEmail");
    }

    //错误页面
    public function error()
    {
        $this->display("error");
    }


 /**
 * @desc 简历快照
 * @author zhuyi
 * @date 2016-09-23
 */
public function Snapshoot(){
    $param['code'] = urlencode(I('get.code',''));
    if (empty($param['code'])){
       // $this->error("非法操作",U('/index'));exit;
    }
    if(!in_array(I('get.p'),array('top','foot'))){
        $url = get_api_info('post','resume/snapshotnotoken'); //获取路由地址
        $res = request_api($url,$param,'get'); //获取简历详情
        if(empty($res)){
            $this->error("无效的code",U('/index'),15);exit;
        }
        //var_dump($res);
        // foreach($res['intention']['work_cities'] as $k=>$v)
        // {
        //     $id[] = $k;
        //     $name[] = $v;
        // }
        // $res['intention']['work_cities']['id'] = implode('/',$id);
        // $res['intention']['work_cities']['name'] = implode('/',$name);
        // unset($id,$name);
        // foreach($res['intention']['trades'] as $k => $v)
        // {
        //     $id[] = $k;
        //     $name[] = $v;
        // }
        // $res['intention']['trades']['id'] = implode('/',$id);
        // $res['intention']['trades']['name'] = implode('/',$name);
         // 连接生成财金证书的ACCA的项目
         foreach($res['certificates'] as $k => $v){
            $farr = array();
            $parr = array();
            foreach ($v['pass_courses'] as $key => $value) {
                //F阶段
                if($value <= 39){
                    $farr[] =  $v['coursenames'][$key];
                }
                //P阶段
                if($value >= 40){
                    $parr[] =  $v['coursenames'][$key];
                }
            }
            $res['certificates'][$k]['fcourse'] = implode('；',$farr);
            $res['certificates'][$k]['pcourse'] = implode('；',$parr);
         }
         //连接英语技能
        if(!empty($res['skill']['id'])){
            $res['skill']['enskill'] = ' ';
            if($res['skill']['en_level'] >= -1){
                $res['skill']['enskill'] .= smartEnLang($res['skill']['en_level']);
                if($res['skill']['english_score'] > 0 && $res['skill']['en_level'] > 0){
                    $res['skill']['enskill'] .= "（{$res['skill']['english_score']}）";
                }
                
            }
            if(!empty($res['skill']['ielts'])){
                //cho $res['skill']['enskill'];
                $res['skill']['enskill'] .= '；';
                $res['skill']['enskill'] .= '雅思';
                if($res['skill']['ielts'] != -1){
                    $res['skill']['enskill'] .="（{$res['skill']['ielts']}）";
                }
                
            }
            if(!empty($res['skill']['toefl'])){
                $res['skill']['enskill'] .= '；';
                $res['skill']['enskill'] .= '托福';
                if($res['skill']['toefl'] != -1){
                    $res['skill']['enskill'] .="（{$res['skill']['toefl']}）";
                }
                //$res['skill']['enskill'] .= ';';
            }
        }
        //是否消费简历
        if(strpos($res['info']['phone'],'*') === false && !empty($res['info']['phone']) && cookie('cnbb_token') || I('get.p')){
            $is_view_resume = 1;//已消费
        }else{
             $is_view_resume = 0;
        }
        // if(!cookie('cnbb_token')){
        //     $is_view_resume = 0;
        // }
        // if(!empty(I('get.p'))){
        //     $is_view_resume = 1;
        // }
        //echo $is_view_resume;
        $this->assign('is_view_resume',$is_view_resume);
        $this->assign('certificates',$res['certificates']);//证书
        $this->assign('intention',$res['intention']);//求职意向
        $this->assign('edus',$res['edus']);//教育经历
        $this->assign('info',$res['info']);//个人信息
        $this->assign('internships',$res['internships']);//实习经历
        $this->assign('rjp',$res['rjp']);//校内经历
        $this->assign('skill',$res['skill']);//技能
        $this->assign('res',$res);//print_r($res);
        if(I('get.mode') == 'test'){
           var_dump($res);
        }
}
    //$this->assign('nav',"Snapshoot");
    $this->display('kuaizhao');
}
 /**
 * @desc 简历预览
 * @author zhuyi
 * @date 2016-09-23
 */
public function resume_preview(){
    $param['code'] = urlencode(I('get.code',''));
    if (empty($param['code'])){
       $this->error("非法操作",U('/index'));exit;
    }
    $url = get_api_info('resume','resumenotoken'); //获取路由地址
    $res = request_api($url,$param,'get'); //获取简历详情
    if(I('get.mode') == 'test'){
        print_r($param);
        var_dump($res);
        exit;
    }
    // if(empty($res)){
    //     $this->error("无效的code",U('/index'),15);exit;
    // }
    foreach($res['certificates'] as $k => $v){
        $farr = array();
        $parr = array();
        foreach ($v['pass_courses'] as $key => $value) {
            //F阶段
            if($value <= 39){
                $farr[] =  $v['coursenames'][$key];
            }
            //P阶段
            if($value >= 40){
                $parr[] =  $v['coursenames'][$key];
            }
        }
        $res['certificates'][$k]['fcourse'] = implode('；',$farr);
        $res['certificates'][$k]['pcourse'] = implode('；',$parr);
     }
     //连接英语技能
    if(!empty($res['skill']['id'])){
        $res['skill']['enskill'] = ' ';
        if($res['skill']['en_level'] >= -1){
            $res['skill']['enskill'] .= smartEnLang($res['skill']['en_level']);
            if($res['skill']['english_score'] > 0 && $res['skill']['en_level'] > 0){
                $res['skill']['enskill'] .= "（{$res['skill']['english_score']}）";
            }
            
        }
        if(!empty($res['skill']['ielts'])){
            //cho $res['skill']['enskill'];
            $res['skill']['enskill'] .= '；';
            $res['skill']['enskill'] .= '雅思';
            if($res['skill']['ielts'] != -1){
                $res['skill']['enskill'] .="（{$res['skill']['ielts']}）";
            }
            
        }
        if(!empty($res['skill']['toefl'])){
            $res['skill']['enskill'] .= '；';
            $res['skill']['enskill'] .= '托福';
            if($res['skill']['toefl'] != -1){
                $res['skill']['enskill'] .="（{$res['skill']['toefl']}）";
            }
            //$res['skill']['enskill'] .= ';';
        }
    }
    foreach($res['intention']['work_cities'] as $k=>$v)
    {
        $id[] = $k;
        $name[] = $v;
    }
    $res['intention']['work_cities']['id'] = implode('/',$id);
    $res['intention']['work_cities']['name'] = implode('/',$name);
    unset($id,$name);
    foreach($res['intention']['trades'] as $k => $v)
    {
        $id[] = $k;
        $name[] = $v;
    }
    $res['intention']['trades']['id'] = implode('/',$id);
    $res['intention']['trades']['name'] = implode('/',$name);
    $this->assign('certificates',$res['certificates']);//证书
    $this->assign('intention',$res['intention']);//求职意向
    $this->assign('edus',$res['edus']);//教育经历
    $this->assign('info',$res['info']);//个人信息
    $this->assign('internships',$res['internships']);//实习经历
    $this->assign('rjp',$res['rjp']);//校内经历
    $this->assign('skill',$res['skill']);//技能
    $this->assign('res',$res);//print_r($res);
    $this->assign('nav',"snapshoot");
    $this->display('/student/profilePreview');
}
}