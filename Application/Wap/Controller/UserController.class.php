<?php
namespace Wap\Controller;

use Think\Controller;

class UserController extends Controller
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
     * @desc 验证码
     * @author zhuyi
     * @date 2016-07-02
     */
    public function verifyImg(){
        $Verify = new \Think\Verify();
        //$Verify->useImgBg = true; 
        $Verify->fontSize = 15;  
        $Verify->length   = 4;  
        //$Verify->useNoise = true;  
        $Verify->codeSet = '0123456789';
        $Verify->imageW = 100;  
        $Verify->imageH = 40; 
        $Verify->entry();
    }
    /**
     * @desc wap登出
     * @author zhuyi
     * @date 2016-12-06
     */
    public function logout(){
        $return = I('get.return','/m/login.html');
        // 清楚所有session
        session(null);
        redirect($return);
    }

    /**
     * @desc wap登录
     * @author zhuyi
     * @date 2016-12-06
     */
    public function login()
    {
        if(check_login()){
            $member = session("member");
            if($member['type'] == 1){
                redirect('/m/postList.html');
            } 
        }
        if (IS_POST) {
            $param['ip'] = getClientIp();
            $param['account_name'] = I('post.username');
            $param['password'] = I('post.password');
            $param['device'] = 2;
            $return = I('post.return_url');
            if (empty($param['account_name']) || empty($param['password'])){
                $this->error("请输入帐号和密码");exit;
            }
            $res = request_api(get_api_info(0,'login'),$param,'post'); //请求
            //print_r($res);
            //激活邮箱才能使用某些功能
            if(isset($res['un_events']) && $res['un_events'][0] == 'unverified_mail'){
            
                $this->ajaxReturn(array('msg'=>'请激活邮箱','status'=>0),'json');  
                exit;
            }
            if (!empty($res['access_token'])) {
                $res['account_name'] = $param['account_name'];//用户名
                $member = request_api(get_api_info(4,$res['uid']),array('access_token'=>$res['access_token']),'get'); //请求
                if($member['type'] ==1){
                            cookie('xscnbb_token',md5($res['access_token']));
                            session('user',$res);
                            //消息数量
                            session('message_num',_get_notice());
                            session('member',$member);
                            session('op_time',time());
                            if(!empty($return)){
                                $this->ajaxReturn(array('msg'=>'success','url'=>$return,'status'=>1),'json');   
                            }else{
                                $this->ajaxReturn(array('msg'=>'success','url'=>'/m/postList.html','status'=>1),'json');
                            }       
                    }else{
                        $this->ajaxReturn(array('msg'=>'请使用学生账号登录','status'=>0),'json');
                    }
                }else{
                    $this->ajaxReturn(array('msg'=>$res['error_description'],'status'=>0),'json');  
                     }
        }else{

                $this->display("login");
        }

    }

    /**
     * @desc wap注册
     * @author zhuyi
     * @date 2016-12-06
     */
    public function register()
    {
        if(check_login()){
            //die('登录成功！');
            $member = session("member");
            if($member['type'] == 1){
                redirect('/m/postList.html');
            } 
        }
        if (IS_POST) {
            //POST参数
            $param['ip'] = getClientIp();
            $param['account_name'] = I('post.username');
            $param['password'] = I('post.password');
            //$param['is_phone'] = I('post.is_phone');
            $param['is_phone'] = 'true';
            $param['verify_code'] = I('post.verify');
            $param['mt'] = I('post.mt');
            $param['device'] = 2;
            $return = I('post.return_url');
            if (empty($param['account_name']) || empty($param['password'])){
                $this->error("请输入帐号和密码");exit;
            }
            if (empty($param['verify_code'])){
                $this->error("请输入短信验证码");exit;
            }
            //提交注册信息
            $res = request_api(get_api_info('authorize','register'),$param,'post'); 
            if (!empty($res['uid'])) {
                    $param['access_token'] = $res['access_token'];
                    $url = get_api_info(4,$res['uid']); //获取登录路由地址
                    $member = request_api($url,$param,'get'); //请求用户信息
                    //print_r($member);
                    session('member',$member);
                    session('user',$res);
                    cookie('xscnbb_token',md5($res['access_token']));
                    cookie('cnbb_token',$res['access_token'],array('domain'=>C('CNBB_DOMAIN')));
                    if(!empty($return)){
                            $this->ajaxReturn(array('msg'=>'success','url'=>$return,'status'=>1),'json');   
                        }else{
                            $this->ajaxReturn(array('msg'=>'success','url'=>'/m/postList.html','status'=>1),'json');
                        }   
            }else {
                
                $this->error($res['error_description']);exit;
            }
        }else {
            $this->display("register");
        }

    }

    /**
     * @desc 企业验证提示
     * @author zhuyi
     * @date 2016-12-20
     */
    public function noticeOrgAuth() {
        $contents = '手机上暂不支持邮箱验证功能，请去PC上完成邮箱验证，谢谢！';
        $this->assign('contents',$contents);
        $this->display('notice');
    }
}