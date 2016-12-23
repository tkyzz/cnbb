<?php
return array(
	//数据库配置信息
	// 'DB_TYPE'   => 'mysqli', // 数据库类型
	// 'DB_HOST'   => '192.168.0.114', // 服务器地址
	// 'DB_NAME'   => 'resume', // 数据库名
	// 'DB_USER'   => 'root', // 用户名
	// 'DB_PWD'    => 'root123', // 密码
	// 'DB_PORT'   => 3306, // 端口
	// 'DB_PREFIX' => 'resume_', // 数据库表前缀 
	// 'DB_CHARSET'=> 'utf8', // 字符集
	// 'DB_DEBUG'  =>  TRUE, // 数据库调试模式 开启后可以记录SQL日志 3.2.3新增

	/*----------------------------------------------------------------------------------------------*/
	//'API_ADDRESS'=>'http://api.cainiaobangbang.com:8081/base/servers', // API基地址
	'API_ADDRESS'=>'http://183.195.157.158:8081/base/servers', // API基地址
	//'EE_URL' => 'http://b.cainiaobangbang.com/',//企业版地址
	'EE_URL' => 'http://b.tp.com/Company/Index/index',//企业版地址
	//'EE_URL' => 'http://www.cnbb.com/Info/Index/index',//线下企业版地址
	'PAGE_SIZE'=>'10',
	'URL_MODEL'=>'1',
	'CNBB_DOMAIN' => '.tp.com',
	// 'ERROR_PAGE'            =>  './public/error.html',	// 错误定向页面
	// 'TMPL_ACTION_ERROR'     =>  './public/errorPage-normal.html', // 默认错误跳转对应的模板文件
	 //'TMPL_EXCEPTION_FILE' =>  './public/errorPage-serious.html', // 默认错误跳转对应的模板文件
	/*----------------------------------------------------------------------------------------------*/
	'URL_ROUTER_ON'   => true, //开启路由
	'URL_ROUTE_RULES'=>array(	//定义路由

	/*-----------------------------------HomeController--------------------------------------------*/
		//public
								'picUpload'					=> 'Home/Public/uploads',//图片上传
		//about
								'about/aboutUs'				=> 'Home/About/About',//关于我们
								'about/team'				=> 'Home/About/Team',//管理团队
								'about/joinUs'				=> 'Home/About/Join',//招贤纳士
								'about/contactUs'			=> 'Home/About/Contact',//联系我们
								'about/ourPartner'			=> 'Home/About/Partner',//合伙人
								'about/mileStone'			=> 'Home/About/Events',//大事记
								'activity'					=> 'Home/About/activity',//活动
								'app'						=> 'Home/About/Download_App',//下载APP
								'about/test'				=> 'Home/About/Baidu_Map',//百度地图

		//自定义
								'clean'						=> 'Home/Index/cleanCache',//清缓存
		//index
								'index'						=> 'Home/Index/index',//首页
								'orgLogin'					=> 'Home/Index/org_Login',//企业登录
								'logout'					=> 'Home/Index/logout',//退出登录
								'error'						=> 'Home/Index/error',//错误页面
								'snapshot'					=> 'Home/Index/Snapshoot',//简历快照
								'resumePreview'				=> 'Home/Index/resume_preview',//简历预览
								'zhuyi'						=> 'Home/Index/gettoken',//获取token
		//user
								'login' 					=> 'Home/User/login',//登录
								'hrLogin' 					=> 'Home/User/org_login',//企业登录
								'register'					=> 'Home/User/signup',//注册
								'hrRegister' 				=> 'Home/User/org_register',//企业注册
								'registerActive'			=> 'Home/User/Active_Email',//注册验证邮箱
								'check_verify'				=> 'Home/User/check_verify_code',//检查验证码
								'checkPhonecode'			=> 'Home/User/auth_Phone_code',//验证手机验证码是否有效
								'authEmail'					=> 'Home/User/Auth_Email',//找回密码验证邮箱
								'verifyImg'					=> 'Home/User/verifyImg',//验证码
								'sendCode'					=> 'Home/User/Send_Phone_Verifycode',//发送验证码
								'mailReset'					=> 'Home/User/Mail_Verify',//邮箱重置密码
								'phoneReset'				=> 'Home/User/Phone_Verify',//手机重置密码
								'authFail'					=> 'Home/User/Auth_Fail',//验证失败
								'reAuth'					=> 'Home/User/Re_Auth_Email',//重新填写邮箱
								'reSendEmail'				=> 'Home/User/Re_Send_Email',//重新发送邮箱
								'test'						=> 'Home/User/test',//test
								'upload'					=> 'Home/User/ppp',//upload



		//student
								'userInfo/setting$'			=> 'Home/Student/Account_Setting',//个人中心设置
								'userInfo/Update$'			=> 'Home/Student/Update_Info',//修改个人信息
								'userInfo/changePwd$'		=> 'Home/Student/Change_Pwd',//修改密码
								'userInfo/invitation'		=> 'Home/Student/Invitation',//邀请码
								'resume/myFavorite'			=> 'Home/Student/My_Favorite',//我收藏的简历
							    'resume/list$' 				=> 'Home/Student/Resume_List',//我的简历列表
							    //'resume/:id$' 				=> 'Home/Student/Resume_Detail',//
							    'resume/:type/:id$' 		=> 'Home/Student/Resume_Detail',//我的简历详情/我的简历预览
							    'resume/myFeedback$'		=> 'Home/Student/My_Feedback',//我的投递反馈
							    'resume/myNotice$'			=> 'Home/Student/My_Notice',//我的通知
							    'messages'					=> 'Home/Student/Message_Center',//专属推荐
							    'systemNotice'   			=> 'Home/Student/System_Notice',//系统通知
							    

		//studentAjax
								'get_resumeInfo$'			=> 'Home/StudentAjax/Ajax_BaseInfo',//获取简历个人信息
								'get_resumeIntention$'		=> 'Home/StudentAjax/Ajax_Intention',//获取简历求职意向
								'get_resumeEdu$'			=> 'Home/StudentAjax/Ajax_Edu',//获取简历教育经历
								'get_resumeSkill$'			=> 'Home/StudentAjax/Ajax_Skill',//获取简历技能
								'get_resumeCert$'			=> 'Home/StudentAjax/Ajax_Cert',//获取简历证书
								'get_resumeInternship$'		=> 'Home/StudentAjax/Ajax_Internship',//获取简历实习经验
								'get_resumeXnjl$'			=> 'Home/StudentAjax/Ajax_Xnjl',//获取简历校内经历

		//post
								'postList$'					=> 'Home/Post/Post_List',//岗位列表
								'get_postList'				=> 'Home/Post/Post_List_Ajax',//岗位列表ajax
								'post/:id$'					=> 'Home/Post/Post_Detail',//职位详情
								'post/company/:id$'			=> 'Home/Post/Company',//企业详情
								//'post/company/job/:id$'		=> 'Home/Post/Company_Post',//企业更多职位
								'post/:id\d/deliver$'		=> 'Home/Post/Deliver_Success',//投递成功
								'ajax/simjob'				=> 'Home/post/Sim_Job',//获取相似岗位
								'ajax/post/searchhint'		=> 'Home/postAjax/Search_Hint',//搜索预查

		//company
								'company/create$'			=> 'Home/Company/Create_Company_Basic',//创建企业
								'company/extra$'			=> 'Home/Company/Create_Company_Extra',//填写企业额外信息
								'company/setMail$'			=> 'Home/Company/Set_Contacter_mail',//设置企业邮箱
								'company/success$'			=> 'Home/company/comRegSuccess',//企业注册成功
								'company/authlxMail$'		=> 'Home/company/Active_Com_Contarctmail',//验证联系邮箱
								'company/resendEmail$'		=> 'Home/company/Re_Auth_Contarct_Email',//重新发送邮箱
								'company/reInputEmail$'		=> 'Home/company/Re_Input_Contract_email',//企业注册成功
								'ajax/company/confirmsee'	=> 'Home/company/Confirm_See',//查看简历联系方式

		//ajax
								'ajax/upload'				=> 'Home/Ajax/Up_Load',//上传图片
								'ajax/getcity'				=> 'Home/Ajax/Get_City',//获取省市
								'ajax/gettrade'				=> 'Home/Ajax/Get_Trade',//获取二级行业
								'ajax/getwfs'				=> 'Home/Ajax/Get_Wfs',//获取二级职能
								'ajax/updateResume'			=> 'Home/StudentAjax/Update_Resume',//更新简历
								'ajax/fav'					=> 'Home/Ajax/User_Fav',//收藏简历
								'ajax/deliver'				=> 'Home/Ajax/Post_Resume',//投递简历
								'ajax/getIntention'			=> 'Home/Ajax/Get_Intention',//获取求职意向
								'ajax/createUpdateResume'	=> 'Home/Ajax/Cre_Up_Resume',//创建简历
								'ajax/setDefault'			=> 'Home/Ajax/Set_Default',//设置默认简历
								'ajax/ProvinceSchool'		=> 'Home/Ajax/Province_Get_School',//根据省获取学校
								'ajax/getMajorCategories'	=> 'Home/Ajax/Get_Major_Categories',//获取专业
								'ajax/getEduDetail'			=> 'Home/Ajax/Get_Edu_Detail',//获取单个教育经历详情
								'ajax/getCertCourses'		=> 'Home/Ajax/Get_Cert_Courses',//根据证书类型获取科目
								'ajax/getInternship'		=> 'Home/Ajax/Get_Internship',//获取单个实习经验
								'ajax/getSkill'				=> 'Home/Ajax/Get_Skill',//获取语言技能
								'ajax/getCert'				=> 'Home/Ajax/Get_cert',//获取证书
								'ajax/getReward'			=> 'Home/Ajax/Get_Reward',//获取荣誉
								'ajax/getPractice'			=> 'Home/Ajax/Get_Practice',//获取社会实践
								'ajax/getSchoolJob'			=> 'Home/Ajax/Get_School_Job',//获取校内职位
								'ajax/getPractice'			=> 'Home/Ajax/Get_School_Practice',//获取社会实践
								'ajax/yjIntention'			=> 'Home/Ajax/yj_Update_intention',//一键修改求职意向
								'ajax/messageReply'			=> 'Home/Ajax/Message_Reply',//通知反馈
								'ajax/getResumeFile'		=> 'Home/Ajax/Get_Resume_file',//下载简历
								'ajax/feedbackmsg'			=> 'Home/Ajax/Feedback_Msg',//投递反馈通知数量反馈
								'ajax/getmsgnum'			=> 'Home/Ajax/Get_Msg',//获取通知数量
								'ajax/msgcenterop'			=> 'Home/Ajax/Message_Center_Op',//消息中心操作
								'ajax/setclose'				=> 'Home/Ajax/Setcookies',//关闭弹框设置cookie

/*-----------------------------------WapController--------------------------------------------*/
		//user
								'm/login'					=> 'Wap/User/login',//登录
								'm/logout'					=> 'Wap/User/logout',//登出
								'm/register'				=> 'Wap/User/register',//注册
								'm/Verify'					=> 'Wap/User/verifyImg',//验证码
								'm/notice/orgAuth'			=> 'Wap/User/noticeOrgAuth',//企业验证提示
		//post
								'm/postList'				=> 'Wap/Post/jobList',//岗位列表
								'm/jobSetCity'				=> 'Wap/Post/jobSetCity',//岗位城市筛选
								'm/post/:id'				=> 'Wap/Post/postDetail',//岗位详情
								'm/map'						=> 'Wap/Post/baiduMap',//地图页
								'm/deliver'					=> 'Wap/Post/deliverSUccess',//投递成功
		//student
								'm/feedback'				=> 'Wap/student/feedback',//投递反馈
								'm/myResume'				=> 'Wap/student/myResume',//我的简历
								'm/resumeBase'				=> 'Wap/student/updateResumeBase',//简历个人信息
								'm/resumeEdu'				=> 'Wap/student/updateResumeEdu',//简历教育经历
		//postAjax
								'm/getJobList'				=> 'Wap/postAjax/getJobList',//获得岗位列表ajax
		//sutdentajax
								'updateAvatar'				=> 'Wap/StudentAjax/updateAvatar',//更改默认简历id


		//test
								'getschool'					=> 'Home/School/getSchoolList',//获取学校	
								'school/test'				=> 'Home/School/test',//获取学校
								'school/wechat'				=> 'Home/School/wechat',//微信	
								'school/getcode'			=> 'Home/School/getcode',//获取code		
								'xyweixin'					=> 'Home/School/Response_Wechat',//响应微信					

	

),

);