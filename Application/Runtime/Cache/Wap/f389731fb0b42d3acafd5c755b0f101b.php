<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>提示</title>
</head>
<body>
	<script type="text/javascript">
	alert('<?php echo ($contents); ?>');
	window.location.href = '/m/postList.html';
	</script>
</body>
</html>