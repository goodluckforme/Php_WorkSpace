<?php
session_start();
echo "<p>你的Session ID : ".session_id()."<p/>";
echo "现在开始获取你的Session数组："."<br/>";
if (isset($_POST['names'])) {
	print_r($_POST['names']);
	echo "<br/>";
	if (!empty($_SESSION['names'])) {
		print("存在参数：SESSION:\n");
		print_r($_SESSION['names']);
		print("<br/>");
		$news=	array_merge(unserialize($_SESSION['names']),$_POST['names']);
		print("存在参数：news:\n");
		print_r($news) ;
		$_SESSION['names']=	array_unique($news);
	}else{
		echo "不存在参数：_SESSION";
		$_SESSION['names'] = serialize($_POST['names']);
	}
}
?>
<! DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>测试SESSION</title>
	</head>
	<body>	
		<form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
			<p>
				<label for="names">请选择</label><br/>
				<select id="names" name="names[]" multiple="multiple" size="3" >
				<option value="马齐">  马齐  </option>
				<option value="陈浩">  陈浩  </option>
				<option value="多多">  多多  </option>
			</select></p>
			<button type="submit" name="submit" value="submit">传递Session数组</button>
		</form>
		<a href="test_session2.php">去界面test_session.php</a>
	</body>
</html>