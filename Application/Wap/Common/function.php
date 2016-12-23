<?php 
//wap 公用类库

	/**  
	 * @desc CURL 获取基地址 
	 * @param  string $mod  请求模块  
	 * @param  array  $op   请求参数  
	 * @return 返回json=>array
	 */ 
	function getDownUrl(){
		//检测手机系统
        $os = checkPhoneOs();
        if ($os == 'android'){
            //$down_url = 'http://oe7lhlnxu.bkt.clouddn.com/app-android-release.apk';
            $down_url = 'http://a.app.qq.com/o/simple.jsp?pkgname=com.finance.cainiaobangbang';
        } elseif ($os == 'ios'){
            $down_url = 'https://itunes.apple.com/us/app/cai-niao-bang-bang/id1002301865?mt=8';
        } else {
            $down_url = 'http://a.app.qq.com/o/simple.jsp?pkgname=com.finance.cainiaobangbang';
        }
        return $down_url;
	}