<?php 

	//公用方法库

    /**  
     * @desc CURL 获取基地址 
     * @param  string $mod  请求模块  
     * @param  array  $op   请求参数  
     * @return 返回json=>array
     */ 
    function get_api_info($mod , $op){
        $data = S('data');
        //是否存在缓存
        if ( empty($data) ){
            $data=file_get_contents(C('API_ADDRESS')); 
            $data = json_decode($data,true);
            //写入文件缓存
            S(array('type'=>'file','expire'=>3600));
            S('data',$data,3600);
        }
        if ($mod == '0' || $mod == 'authorize'){
            $mod = 'authorize';
        }elseif ($mod == '1' || $mod == 'resume'){
            $mod = 'resume';
        }elseif ($mod == '2' || $mod == 'infrastructure'){
            $mod = 'infrastructure';
        }elseif ($mod == '3' || $mod == 'file'){
            $mod = 'file';
        }elseif ($mod == '4' || $mod == 'passport'){
            $mod = 'passport';
        }elseif ($mod == '5' || $mod == 'org'){
            $mod = 'org';
        }elseif ($mod == '6' || $mod == 'post'){
            $mod = 'post';
        }
        foreach($data['servers'] as $k => $v){
           
            if ($v['mod'] == $mod){
                $res = $data['servers'][$k];
            }
        }
        $data = $res;
        $url = $data['schema']."://".$data['host'].":".$data['port']."/".$data['version']."/".$data['mod']."/".$op;
        return $url;
    }

    /**  
     * @desc CURL 请求  
     * @param  string $url   请求地址  
     * @param  array  $param 请求内容  
     * @param  string $act   请求类型  
     * @param  bool   $multi 是否为文件  
     * @return 返回json=>array
     */  
    function request_api ( $url = '', $param = '', $act = 'get', $multi = false ) {
        //设置头
        if ( $multi ) {
            $header = array("Content-Type:multipart/form-data");
        }else {
            $header = array("Content-Type: application/x-www-form-urlencoded;charset=utf8");
        }
        $opts = [
            CURLOPT_TIMEOUT        => 300,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_HTTPHEADER     => $header
        ];
        /* 根据请求类型设置特定参数 */
        switch( strtoupper( $act ) ){
            case 'GET':
                $opts[CURLOPT_URL] = $url . '?' . http_build_query($param);
                break;
            case 'POST':
                //判断是否传输文件
                $param = $multi ? $param : http_build_query($param);
                $opts[CURLOPT_URL] = $url;
                $opts[CURLOPT_POST] = 1;
                $opts[CURLOPT_POSTFIELDS] = $param;
                break;
            case 'PUT':
                $param = $multi ? $param : http_build_query($param);
                $opts[CURLOPT_URL] = $url;
                $opts[CURLOPT_CUSTOMREQUEST] = "PUT";
                $opts[CURLOPT_POSTFIELDS] = $param;
                break;
            case 'DELETE':
                $opts[CURLOPT_URL] = $url . '?' . http_build_query($param);
                $opts[CURLOPT_CUSTOMREQUEST] = "DELETE";
                break;
            default:
                throw new Exception('不支持的请求方式:'.$act);
        }

        /* 初始化并执行curl请求 */
        $ch = curl_init();
        curl_setopt_array($ch, $opts);
        $data  = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);
        if($error){
            throw new Exception('CNBB CURL ERROR:' . $error);
        }
        //echo $url.'<br>';
        $data = json_decode($data,true,512,JSON_BIGINT_AS_STRING);
        //$data['url'] = $url;
        return $data;

    }

    /**  
     * @desc 检查登录状态  
     * @return 返回 BOOL
     */  
    function check_login(){
        if(empty(cookie('xscnbb_token'))){
            return false;
        }elseif(cookie('xscnbb_token') == md5(session('user.access_token'))){
            return true;
        }
    }

    /**  
     * @desc CURL 验证验证码  
     * @param  string $code 验证码 
     * @param  array  $id   验证码ID  
     * @return 返回BOOL
     */  
    function check_verify($code, $id = ""){  
        $verify = new \Think\Verify();  
        return $verify->check($code, $id);  
    } 

    /**  
     * @desc 得到手机系统  
     * @return 返回 STRING
     */ 
    function checkPhoneOs() {
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')||strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')) {
            return 'ios';
        } else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Android')) {
            return 'android';
        }
    }


    /**
     * @desc 得到消息数量
     * @return string
     */
    function _get_notice() {

        $param['access_token'] = session("user.access_token"); //access_token
        if(empty($param['access_token'])){
            return false;
        }
        //获取地址
        $url = get_api_info('post','notice/messages/myunread'); 
        //获取消息数量
        $res = request_api($url,$param,'get'); 
        return $res;
    }


    /**  
     * @desc 模板截取  
     * @param array/string $data       数组  
     * @param string $output    转换后的编码  
     * @return 返回编码后的数据
     */  
    function msubstr($str, $start=0, $length){
        //return "mb_substr($str, $start, $length)";
        //echo mb_strlen($str,utf-8);
        if (mb_strlen($str) > $length){
            return mb_substr($str, $start, $length)."...";
        }else{
            return $str;
        }

    }

    /**  
     * @desc 获取当前页面URL
     * @param array/string $data       数组  
     * @param string $output    转换后的编码  
     * @return 返回编码后的数据
     */ 
    function get_url() {

        $sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
        $php_self = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
        $path_info = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
        $relate_url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $php_self.(isset($_SERVER['QUERY_STRING']) ? '?'.$_SERVER['QUERY_STRING'] : $path_info);


        return $sys_protocal.(isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '').$relate_url;
    }

    /**  
     * @desc 对数据进行编码转换  
     * @param array/string $data       数组  
     * @param string $output    转换后的编码  
     * @return 返回编码后的数据
     */  
    function array_iconv($data,  $output = 'utf-8') {  
        $encode_arr = array('UTF-8','ASCII','GBK','GB2312','BIG5','JIS','eucjp-win','sjis-win','EUC-JP');  
        $encoded = mb_detect_encoding($data, $encode_arr);  
      
        if(empty($encoded)) $encoded='UTF-8';
        
        if (!is_array($data)) {  
            return @mb_convert_encoding($data, $output, $encoded);  
        }  
        else {  
            foreach ($data as $key=>$val) {  
                $key = array_iconv($key, $output);  
                if(is_array($val)) {  
                    $data[$key] = array_iconv($val, $output);  
                } else {  
                $data[$key] = @mb_convert_encoding($data, $output, $encoded);  
                }  
            }  
        return $data;  
        }  
    }


    /**
     * @desc 随机手机
     */
    function randMobile()
    {
        $arr = array(139,138,137,136,135,134,159,158,150,151,152,157,188,187,130,131,132,155,156,133,153,189,180);
        $head =  $arr[array_rand($arr)];
        $chars_array = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
        $charsLen = count($chars_array) - 1;

        $outputstr = "";
        for ($i=0; $i<8; $i++)
        {
            $outputstr .= $chars_array[mt_rand(0, $charsLen)];
        }
        return $head.$outputstr;
    }


    /**
     * @desc 二维数组排序，按其中一个键来排
     * @param unknown $multi_array
     * @param unknown $sort_key
     * @param string $sort SORT_DESC
     * @return boolean|unknown
     */
    function multi_array_sort($multi_array, $sort_key, $sort=SORT_ASC){
    	if(is_array($multi_array)){
    		foreach ($multi_array as $row_array){
    			if(is_array($row_array)){
    				$key_array[] = $row_array[$sort_key];
    			}else{
    				return false;
    			}
    		}
    	}else{
    		return false;
    	}
    	array_multisort($key_array,$sort,$multi_array);
    	return $multi_array;
    }


   /**
     * @desc smarty 地区
     */
    function smartAreas($param,$type=1) {
            $url = get_api_info(2,'areas'); //获取路由地址
            $res = request_api($url,$param,"get"); //请求
            // if($type == 1 && empty($param['code'])){
            //     //移出最后一个（海外）
            //     array_pop($res);
            // }
            return $res;
    }

   /**
     * @desc smarty 主要、热门地区
     */
    function hotMainAreas($param) {

            $url = get_api_info(2,'areas/'.$param['type']); //获取路由地址
            $res = request_api($url,$param,"get"); //请求
            return $res;
    }


    /**
     * @desc smarty 获取字典行业
     */
    function smartTrades($params) {

            $url = get_api_info(2,'trades'); //获取路由地址
            $res = request_api($url,$param,"get"); //请求
            return $res;
    }

    /**
     * @desc smarty 企业亮点标签
     */
    function smartTag($param){
            $url = get_api_info('org','tag/list'); //获取路由地址
            $res = request_api($url,$param,"get"); //请求
            if(isset($res['error'])){
                return false;
            }
            return $res;
    }
    /**
     * @desc smarty 获取职能
     */
    function smartWfs($params) {

            $url = get_api_info(2,'wfs/all'); //获取路由地址
            $res = request_api($url,$param,"get"); //请求
            return $res;
    }

    /**
     * @desc smarty 获取简历字典
     * @param [string] $[name] [字典类型] politics 政治面貌,cardtype 证件类型,hktype 户口类型
     * @param  [int] $[id] [字典id]
     */
    function smartResumeDict($name,$id) {
            if (empty($name)) {
                return false;
            }
            $name = $name.'/list';
            $url = get_api_info(1,$name); //获取路由地址
            $res = request_api($url,$param,"get"); //请求
            foreach($res as $k => $v){
                if($v['id'] == $id){
                    return $v['name'];
                }
            }
            //return false;
    }

    /**
     * @desc 获取简历字典数据
     * @param   $[name] [字典类型] politics 政治面貌,cardtype 证件类型,hktype 户口类型 ,self_tag 标签
     */
    function ResumeDict($name) {
            if (empty($name)) { 
                return false;
            }
            $name = $name.'/list';
            $url = get_api_info(1,$name); //获取路由地址
            $res = request_api($url,$param,"get"); //请求
            //print_r($res);
            return $res;
    }

    /**
     * @desc 获取简历字典数据集
     * @param  t(int) 工作类型=1,机构性质=2,机构规模=3,职能分类=4
     */
    function Dicts($t) {
            if (empty($t)) { 
                return false;
            }
            $param['t'] = $t;
            $url = get_api_info(2,"dicts"); //获取路由地址
            $res = request_api($url,$param,"get"); //请求
            return $res;
    }

    /**
     * @desc 获取简历字典数据集
     * @param  t(int) 工作类型=1,机构性质=2,机构规模=3,职能分类=4
     */
    function smartDicts($t,$k) {
            if (empty($t)) { 
                return false;
            }
            $param['t'] = $t;
            $url = get_api_info(2,"dicts"); //获取路由地址
            $res = request_api($url,$param,"get"); //请求
            return $res['$k'];
    }

    /**
     * @desc 获取简历字典单一数据
     * @param  t(int) 工作类型=1,机构性质=2,机构规模=3,职能分类=4
     */
    function smartdictval($id) {
            if (empty($id)) {
                return false;
            }
            $param['id'] = $id;
            $url = get_api_info(2,"dict/".$param['id']); //获取路由地址
            $res = request_api($url,$param,"get"); //请求
            return $res['name'];
    }

    /**
     * @desc 当天(时分)3天前3天后（日期）
     * @param $time 时间戳
     * @return string
     */
    function smartJobStrTime($times)
    {

        $times = substr($times,0,10).' '.substr($times,11,8);
        $tomorrow = strtotime("tomorrow");
       $times = strtotime($times);
        $time = $tomorrow - $times;
        $time2 = time() - $times;
        $d = floor($time/(60*60*24));
        if ($time2 < 60)
            return  '刚刚';
        elseif ($time2 < 60 * 60)
        {
            $min = floor($time2/60);
            return  $min.'分钟前';
        }
        elseif ($time2 < 60 * 60 * 24)
        {
            $h = floor($time2/(60*60));
            return  $h.'小时前';
        }
        // if ($d < 1)
        // {
        //     $h = floor($time/(60*60));
        //     $str = date('H:i',$times);
        // }
        elseif ($d == 1)
        {
            $str = '昨天';
        }
        elseif($d == 2)
        {
            $str = '前天';
        }elseif ($d>2 && $d<=7)
        {
            $str = $d.'天前';
        }else
            $str = date("Y-m-d",$times);
        return $str;
    }

    /**
     * @desc 距离什么时间还有多少天
     * @param $time 
     * @return string
     */
    function smartPostStrTime($times)
    {
        $times = strtotime($times);
        $time = $times - time();
        if ($time < 60 * 60 * 24)
        {
            
            $d = 0;
        }
        elseif ($time >= 60 * 60 * 24)
        {
            $d = floor($time/(60*60*24));
        }
        return $d;
    }


    /**
     * @desc 枚举学历
     * @param $degree 学历id
     * @return string
     */
    function smartDegree($degree)
    {
        switch ($degree) {
            case '0':
                 $str = '不限';
                break;
            case '1':
                $str = '大专';
                break;
            case '2':
                $str = '本科';
                break;
            case '3':
                $str = '硕士';
                break;
            case '4':
               $str = '博士';
                break;
        }
       
        return $str;
    }

    /**
     * @desc 枚举英语水平等级
     * @param $degree 学历id
     * @return string
     */
    function smartEnLang($en)
    {
        switch ($en) {
            case '-1':
               $str = '尚未考证';
                break;
            case '0':
                 $str = 'CET4';
                break;
            case '1':
                $str = 'CET6';
                break;
            case '2':
                $str = '专业四级';
                break;
            case '3':
                $str = '专业六级';
                break;
            case '4':
               $str = '专业八级';
                break;
        }
       
        return $str;
    }

    /**
     * @desc 枚举熟练程度
     * @param $degree 学历id
     * @return string
     */
    function smartShulian($num)
    {
        switch ($num) {
            case '0':
                 $str = '一般';
                break;
            case '1':
                $str = '良好';
                break;
            case '2':
                $str = '熟练';
                break;
            case '3':
                $str = '精通';
                break;
        }
       
        return $str;
    }

    /**
     * @desc 枚举学校奖励等级
     * @param $degree 学历id
     * @return string
     */
    function smartRewardLevel($num)
    {
        switch ($num) {
            case '0':
                 $str = '国家级';
                break;
            case '1':
                $str = '省市级';
                break;
            case '2':
                $str = '校级';
                break;
        }
       
        return $str;
    }


    /**
     * @desc 枚举项目角色
     * @param $degree 学历id
     * @return string
     */
    function smartRole($en)
    {
        switch ($en) {
            case '0':
                 $str = '参与者';
                break;
            case '1':
                $str = '负责人';
                break;
        }
       
        return $str;
    }

    /**
     * @desc 男女枚举
     * @param $degree 学历id
     * @return string
     */
    function smartGender($gender)
    {
        $str = '';
        switch ($gender) {
            case '1':
                 $str = '男';
                break;
            case '2':
                $str = '女';
                break;
        }
       
        return $str;
    }

    /**
     * @desc 枚举工作类型
     * @param $degree 学历id
     * @return string
     */
    function smartWorkType($id)
    {
        switch ( $id ) {
            case '0':
                 $str = '不限';
                break;
            case '1':
                 $str = '假期';
                break;
            case '2':
                $str = '日常';
                break;
            default:
                $str = '不限';
        }
       
        return $str;
    }

    /**
     * @desc 枚举到岗时间
     * @param $degree 学历id
     * @return string
     */
    function smartArrDay($num)
    {
        if($num == -1){
            $str = '立即到岗';
        }elseif($num == 0){
            $str = '待定';
        }else{
            $str = $num.'天内';
        }
       
        return $str;
    }

    /**
     * @desc 是否在读
     * @param $degree 学历id
     * @return string
     */
    function is_edu_read($date)
    {
        if(empty($date)){
            return '(在读)';
        }
        if(substr($date,0,4) == date('Y')){
            if(substr($date,4,2) > date('m')){
                return '(在读)';
            }
        }
        if(substr($date,0,4) > date('Y')){
            return '(在读)';
        }
    }

    //获取专业列表
    function getMajorCategories($param){
        if (empty($param['access_token'])){
            return false;
        }
        $url = get_api_info(1,"edu/major_categories"); //获取路由地址
        $res = request_api($url,$param,"get"); //请求
        if(empty($res)){
            return false;
        }
        return $res;
    }

    //获取证书列表
    function getCertificateTypes(){

        $url = get_api_info(1,"certificate/types"); //获取路由地址
        $res = request_api($url,$param,"get"); //获取证书类别
        if(empty($res)){
            return false;
        }
        return $res;
    }

    //检查事件是否存在用户未完成事件列表中
    function getUnDoneEvents($token,$event){
        $param['access_token'] = $token;
        $url = get_api_info('passport',"undone_events"); //获取路由地址
        $res = request_api($url,$param,"get"); //获取证书类别
        //var_dump($res);
        if(in_array($event,$res)){
            return true;
        }
        return false;
    }

    //更新用户未完成事件
    function putDoneEvent($token,$event){
        $param['access_token'] = $token;
        $param['event_name'] = $event;
        $url = get_api_info('passport',"done_event"); //获取路由地址
        $res = request_api($url,$param,"put"); //获取证书类别
        if ($res['error_code'] == 'success'){
            return true;
        }
        return false;
    }


    //获取单个简历意向
    function getIntention($token,$id){
        $param['access_token'] = $token;
        $param['resume_id'] = $id;
        $url = get_api_info('resume',"intention/get"); //获取路由地址
        $res = request_api($url,$param,"get"); //获取证书类别
        if (isset($res['error_code'])){
            return false;
        }
        return $res;
    }

    //获取国家列表
    function getCountry(){
        $url = get_api_info(2,"countries"); //获取路由地址
        $res = request_api($url,$param,"get"); //获取证书类别
        if(empty($res)){
            return false;
        }
        return $res;
    }

    //时间格式转换
    function smartTimeFormat($time){
        if(empty($time)){
            return flase;
        }
        $time = substr($time,0,4).'年'.substr($time,5,2).'月'.substr($time,8,2).'日'.'  '.substr($time,11,8);
        //$time = str_replace('-','.',$time);
        return $time;
    }

    //base64加密
    function smartBase64($str){
        if(empty($str)){
            return flase;
        }
        $str = base64_encode(substr(time(),0,6).$str);
        return $str;
    }

    //是否为直辖市
    function is_zhixia($str){
        if(empty($str)){
            return flase;
        }
        $prov = array('上海市','北京市','天津市','重庆市');
        return in_array($str,$prov);
    }

    //返回url
    function return_url($url,$type=0){
        if(empty($url)){
            return flase;
        }
        if ($type == 1){
            return urlencode($url);
        }else{
            return urlencode('http://'.$_SERVER['HTTP_HOST'].$url);
        }
       
    }

    //URL是否带有http,没有则加上
    function addHttp($url){
        if (empty($url)){
            return true;
        }
        if (stripos($url,'http') === false){
            $url = 'http://'.$url;
        }
        return $url;
    }
    
    /**
     * @desc 是否为手机
     * @return bool
     */
    function is_mobile(){
        // 先检查是否为wap代理，准确度高
        if(stristr($_SERVER['HTTP_VIA'],"wap")){
            return true;
        }
        // 检查浏览器是否接受 WML.
        elseif(strpos(strtoupper($_SERVER['HTTP_ACCEPT']),"VND.WAP.WML") > 0){
            return true;
        }
        //检查USER_AGENT
        elseif(preg_match('/(blackberry|configuration\/cldc|hp |hp-|htc |htc_|htc-|iemobile|kindle|midp|mmp|motorola|mobile|nokia|opera mini|opera |Googlebot-Mobile|YahooSeeker\/M1A1-R2D2|android|iphone|ipod|mobi|palm|palmos|pocket|portalmmm|ppc;|smartphone|sonyericsson|sqh|spv|symbian|treo|up.browser|up.link|vodafone|windows ce|xda |xda_)/i', $_SERVER['HTTP_USER_AGENT'])){
            return true;
        }
        else{
            return false;
        }
    }

    /**
     * @desc 获取用户浏览器
     * @return string
     * @author fengzi
     * @date 2014-04-09
     */
    function getUserBrowser()
    {
        $sys = $_SERVER['HTTP_USER_AGENT'];
        if (stripos($sys, "NetCaptor") > 0) {
            $exp[0] = "NetCaptor";
            $exp[1] = "";
        } elseif (stripos($sys, "Firefox/") > 0) {
            preg_match("/Firefox\/([^;)]+)+/i", $sys, $b);
            $exp[0] = "Mozilla Firefox";
            $exp[1] = $b[1];
        } elseif (stripos($sys, "MAXTHON") > 0) {
            preg_match("/MAXTHON\s+([^;)]+)+/i", $sys, $b);
            preg_match("/MSIE\s+([^;)]+)+/i", $sys, $ie);
            $exp[0] = $b[0] . " (IE" . $ie[1] . ")";
            $exp[1] = $ie[1];
        } elseif (stripos($sys, "MSIE") > 0) {
            preg_match("/MSIE\s+([^;)]+)+/i", $sys, $ie);
            $exp[0] = "Internet Explorer";
            $exp[1] = $ie[1];
        } elseif (stripos($sys, "Netscape") > 0) {
            $exp[0] = "Netscape";
            $exp[1] = "";
        } elseif (stripos($sys, "Opera") > 0) {
            $exp[0] = "Opera";
            $exp[1] = "";
        } elseif (stripos($sys, "Chrome") > 0) {
            $exp[0] = "Chrome";
            $exp[1] = "";
        } else {
            $exp = "未知浏览器";
            $exp[1] = "";
        }
        return $exp;
    }

    /**
     * @desc 是否在微信浏览器中打开
     * @return boolean
     */
    function is_weixin() {
        if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
            return true;
        }
        return false;
    }

    /**
     * @desc 入学时间转成年级
     * @return string
     */
    function smartEduGrade($time){
        if(empty($time)){
            return false;
        }
        $year = substr($time,0,4);
        $month = (int)substr($time,4,2);
        return $year.'级'.$month.'月';
    }

    /**
     * @desc 文本域回车转化
     * @return string
     */
    function smartTextarea($str)
    {
        if(!$str){
            return false;
        }
        $str = explode("\n",$str);
        // if(count($str) <1){
        //     return $str;
        // }
        $res = '';
        foreach($str as $v){
            // if(empty($v)){
            //     continue;
            // }
            $res .= '<span class="list-point"></span><span>'.$v.'</span>';
        }
        echo $res;
        //return $res;
    }

    /**
     * @desc 查找某个字符串从它第一次出现的位置去除
     * @return string
     */
    function smartSubstr($str,$char){
        if(empty($str)){
            return false;
        }
        //$str = 'ACCA（特许公';
        //echo strpos($str,'$char');exit;
        //echo mb_strpos($str,$char);
        if(strpos($str,$char) === false){
            return $str;
        }else{
            return mb_substr($str,0,strpos($str,$char));
        }
        
    }

    /**
     * @desc 隐藏邮箱
     * @return string
     */
    function smartycemail($str){
        if(empty($str)){
            return false;
        }
        $email_array = explode("@", $str); 
        $prevfix = (strlen($email_array[0]) < 4) ? "" : substr($str, 0, 3); //邮箱前缀 
        $count = 0; 
        $str = preg_replace('/([\d\w+_-]{0,100})@/', '***@', $str, -1, $count); 
        return $prevfix . $str;
        
        
    }

    /**
     * @desc 获取IP地址
     * @return string
     */
    function getClientIp(){
        $ip = 'unknown';
        if ( isset($_SERVER) ) {
            if ( isset($_SERVER['HTTP_X_FORWARDED_FOR']) ) {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } elseif ( isset($_SERVER['HTTP_CLIENT_IP']) ) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } else {
                 $ip = $_SERVER['REMOTE_ADDR'];
            }
        } else {
            if ( getenv('HTTP_X_FORWARDED_FOR') ) {
                $ip = getenv('HTTP_X_FORWARDED_FOR');
            } elseif ( getenv('HTTP_CLIENT_IP') ) {
                $ip = getenv('HTTP_CLIENT_IP');
            } else {
                $ip = getenv('REMOTE_ADDR');
            }
        }
        if ( trim($ip) == "::1") {
            $ip = "127.0.0.1";
        }

        return $ip;
    }