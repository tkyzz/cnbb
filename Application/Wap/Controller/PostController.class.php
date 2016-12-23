<?php
namespace Wap\Controller;

use Think\Controller;

class PostController extends Controller
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
        //获得下载链接
        $this->assign('download_url',getDownUrl());
    }

    /**
     * @desc 岗位列表
     * @author zhuyi
     * @date 2016-12-07
     */
    public function jobList(){

        // if (!empty(session("user.access_token"))){
        //     //$param['access_token'] = session('user.access_token');
        // }
        $param['size'] = C("PAGE_SIZE");//页大小
        if (!empty(I('get.page'))){//页码
            $param['page'] = I('get.page');
        }
        if (!empty(I('get.trade'))){//行业
            $param['org_trades'] = I('get.trade');
        }
        if (!empty(I('get.city'))){//城市
            $param['cities'] = I('get.city');
            $city_arr = hotMainAreas(array('type'=>'major','t'=>2));
            //echo $param['cities'];
            foreach ($city_arr as $key => $v) {
                //echo $v['code'];
                if($param['cities'] == $v['code']){
                    //echo $v['name'];
                    $nowcity = mb_substr($v['name'],0,-1);
                    break;
                }
            }
        }
        if (!empty(I('get.natures'))){//机构性质
            $param['org_natures'] = I('get.natures');
        }
        if (!empty(I('get.work_type'))){//工作类型
            $param['work_type'] = I('get.work_type');
        }
        if (!empty(I('get.work_day'))){//工作时长
            $param['work_duration'] = I('get.work_day')*30;
        }
        if (!empty(I('get.week_day'))){//每周工作天数
            $param['week_workdays'] = I('get.week_day');
        }
        // if (!empty(I('get.degrees'))){//学历
        //     $param['degrees'] = I('get.degrees');
        // }
        // if (!empty(I('get.sort'))){//排序
        //     $param['sortby'] = I('get.sort');
        // }

        if (!empty(I('get.keyword'))){//关键字
            if (!empty(I('get.keyword_by'))){//搜索模式1公司2岗位
                $param['keyword_by'] = I('get.keyword_by');
            }
            $param['keyword'] = I('get.keyword');
        }
        //print_r($param);
        
        $url = get_api_info(6,"search"); //获取路由地址
        $res = request_api($url,$param,'get'); //请求

        $page['total'] = $res['total'];
        $page['nowpage'] = $res['pages'];
        $page['size'] = $res['page_size'];
        $page['pages'] = ceil($res['total']/$res['page_size']);
        if (I('get.mode') == 'test'){
            print_r($res);
        }
        $this->assign('nowcity',$nowcity);
        $this->assign('page',$page);//页面信息
        $this->assign('res',$res);
        $this->assign('nav','post');
        $this->display("postList");
    }

    /**
     * @desc 岗位详情
     * @author zhuyi
     * @date 2016-12-07
     */
    public function postDetail(){
        //邀请码
        $icode = I('get.icode');
        if(!empty($icode)){
            cookie('icode',$icode,1800);
        }
        //$device = I('get.t');
        if (!empty(session("user.access_token"))){
            $param['access_token'] = session('user.access_token');
        }
        if (empty(I('get.id'))){
            $this->error("页面找不到了");exit;
        }
        //var_dump(smartdictval(1));exit;
        $param['id'] = substr(base64_decode(I('get.id')),6);
        $url = get_api_info('post',$param['id']); //获取登录路由地址
        $res = request_api($url,$param,'get'); //获取详情
        //print_r($res);
        if(empty($res)){
            $this->error('页面找不到了','/index.html',2);
        }
        if(!empty($res['weal_tags'])){
            $res['fl_tags'] = explode('|',$res['weal_tags']);
        }
        // if(!empty($res['ssalary'])){
        //  $res['esalary'] = 2000;
        // }
        $this->assign('res',$res);//职位详情
        if(!empty(session('user.access_token'))){
            //我的简历列表
            $url = get_api_info(1,'list/my'); //获取路由地址
            $myresume = request_api($url,array('access_token'=>session('user.access_token'),'need_deliver'=>'0'),'get')[0]; //获取我的简历列表
            //print_r($myresume);
            if ( !empty($myresume) ) {
                $is_show = 1;
            }else {
                $is_show = -1;
            }
            $this->assign('myresume',$myresume);//我的简历列表
        }else {
            $is_show = 0;
        }
        //h5页面
        //$company_jobs = PostController::_company_more_post(array('org_id'=>$res['org']['id'],'exclude_ids'=>$param['id']));
        // $os = checkPhoneOs();
        // if ($os == 'android'){
        //  $down_url = 'http://a.app.qq.com/o/simple.jsp?pkgname=com.finance.cainiaobangbang';
        // }elseif ($os == 'ios'){
        //  $down_url = 'https://itunes.apple.com/us/app/cai-niao-bang-bang/id1002301865?mt=8';
        // }
        $this->assign('down_url','http://a.app.qq.com/o/simple.jsp?pkgname=com.finance.cainiaobangbang');//app下载链接
        $this->assign('is_show',$is_show);
        //$this->assign('jobs',$company_jobs);//公司更多岗位
        $this->display('postDetail');
        
    }

    /**
     * @desc 岗位列表选择城市
     * @author zhuyi
     * @date 2016-12-06
     */
    public function jobSetCity(){
        $city = hotMainAreas(array('type'=>'major','t'=>2));
        $this->assign('city',$city);//主要城市
        $this->display('workingPlace');
    }

    /**
     * @desc 投递成功
     * @author zhuyi
     * @date 2016-12-09
     */
    public function deliverSUccess(){
        $this->display('deliverySUccess');
    }
    
    /**
     * @desc 百度地图页
     * @author zhuyi
     * @date 2016-12-09
     */
    public function baiduMap(){
        $this->display('baidumap');
    }

}