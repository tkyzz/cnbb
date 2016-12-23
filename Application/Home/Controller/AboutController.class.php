<?php
namespace Home\Controller;

use Think\Controller;

class AboutController extends Controller
{

    /**
     * @desc 构造
     * @author zhuyi
     * @date 2016-07-02
     */
    public function __construct()
    {
        parent::__construct();
        //手机跳转到H5
        if(is_mobile()){
           redirect('/m/postList.html');
        }
        $this->assign('navclass', 'about');

    }

    /**
     * @desc 关于我们
     * @author zhuyi
     * @date 2016-09-02
     */
    public function About()
    {
        //E('服务器错误',500);
        $this->assign('about','women');
        $this->display('aboutUs');
    }

    /**
     * @desc 管理团队
     * @author zhuyi
     * @date 2016-09-02
     */
    public function Team()
    {
        $this->assign('about','team');
        $this->display('ourTeam');
    }

    /**
     * @desc 招贤纳士
     * @author zhuyi
     * @date 2016-09-02
     */
    public function Join()
    {
        $this->assign('about','join');
        $this->display('ourRecruit');
    }

    /**
     * @desc 联系我们
     * @author zhuyi
     * @date 2016-09-02
     */
    public function Contact()
    {
        $this->assign('about','contact');
        $this->display('contactUs');
    }

    /**
     * @desc 合伙人
     * @author zhuyi
     * @date 2016-09-13
     */
    public function Partner()
    {
        $this->assign('about','partner');
        $this->display('partner');
    }

    /**
     * @desc 大事记
     * @author zhuyi
     * @date 2016-09-30
     */
    public function Events()
    {
        $this->assign('about','events');
        $this->display('ourEvents');
    }

    /**
     * @desc APP下载
     * @author zhuyi
     * @date 2016-09-13
     */
    public function Download_App()
    {
        $this->display('appDownload');
    }


    /**
     * @desc 活动
     * @author zhuyi
     * @date 2016-09-13
     */
    public function activity()
    {
        $this->error('sorry~~ 活动已结束','/index.html',3);
        //邀请码
        $icode = I('get.icode');
        if(!empty($icode)){
            cookie('icode',$icode,1800);
        }
        $app = I('get.app');
        $token = I('get.token');
		if(is_mobile()){
            if (is_weixin()){
                //微信浏览器
                $drive = 'wx';
            }elseif($app == 1){
                if(empty($token)){
                    //未登录的app
                    $drive = 'app';
                }else{
                    //已登录的app
                    $drive = 'app_auth';
                }
            }else{
                //手机浏览器
                $drive = 'h5';
            }
            $this->assign('drive',$drive);
			$this->display('activity-h5');
		}else{
            $this->display('activity');
        }
       // $this->display('activity');
    }


    /**
     * @desc 百度地图
     * @author zhuyi
     * @date 2016-09-13
     */
    public function Baidu_Map()
    {
        $this->display('test');
    }

    public function Redirect_Down_App() {
        if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')||strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')){
            header("Location:https://itunes.apple.com/cn/app/cai-niao-bang-bang/id1002301865?mt=8");
        }else if(strpos($_SERVER['HTTP_USER_AGENT'], 'Android')){
            header("Location:http://a.app.qq.com/o/simple.jsp?pkgname=com.finance.cainiaobangbang");
        }else{
            header("Location:http://www.cainiaobangbang.com/app.html");
        }
    }
}