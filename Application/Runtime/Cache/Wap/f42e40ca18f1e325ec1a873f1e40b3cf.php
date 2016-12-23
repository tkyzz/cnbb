<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
	<style type="text/css">
		body, html,#allmap {width: 100%;height: 100%;overflow: hidden;margin:0;}
		#golist {display: none;}
		@media (max-device-width: 780px){#golist{display: block !important;}}
	</style>
	<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=QE14lsaHjpl3lTkpSIKOcGnKYpPt68zu"></script>
	<!-- <script type="text/javascript" src="http://api.map.baidu.com/api?type=quick&ak=您的密钥&v=1.0"></script> -->
	<title>菜鸟帮帮</title>
        <link rel="shortcut icon" type="image/x-icon" href="/cnbb.ico" media="screen" /> 
    <link rel="stylesheet" type="text/css" href="/Public/css/h5/public.css">
	<script src="/Public/js/jquery.min.js"></script>
    <script src="/Public/js/layer/layer.js"></script>
</head>
<body>
    <header class="header">
        <a class="back" href="javascript:;" onclick="window.history.go(-1)"><i></i></a>
        <span class="title">菜鸟帮帮</span>
    </header>
    <div id="allmap"></div>
</body>
</html>
<script type="text/javascript">

  var map = new BMap.Map("allmap");    // 创建Map实例
    map.enableScrollWheelZoom(true);     //开启鼠标滚轮缩放
   var myGeo = new BMap.Geocoder();
  //map.setZoom(18);
  myGeo.getPoint("<?php echo ($_GET['addr']); ?>",function(point){
    if(point){
              var myIcon = new BMap.Icon("/Public/img/map/ditu.png", new BMap.Size(35, 50), {  
                        offset: new BMap.Size(15, 35),   // 指定定位位置  
                        imageOffset: new BMap.Size(0, 0) // 设置图片偏移 
                    }); 
     // var myIcon = new BMap.Icon("/Public/img/map/ditu.png", new BMap.Size(30, 30));  
      var marker = new BMap.Marker(point, {icon: myIcon});  // 创建标注
      map.centerAndZoom(point,18);
      map.addOverlay(marker);
    }else{
      alert("无法解析的地址~");
    }
  });
</script>