<?php
	setcookie('vegetable','artichoke',time()+6,"/","localhost",0);
	if (isset($COOKIE['vegetable'])) {
		echo "<p>Hello World : ".$COOKIE['vegetable']."<p/>";	
	}else{
		echo "<p>No COOKIE<p/>";	
	}
	echo $_SERVER['HTTP_COOKIE']."<br/>";
	echo getenv('HTTP_COOKIE')."<br/>";
	echo $_COOKIE['vegetable']."<br/>";
?>
<! DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>测试Cookie</title>
	</head>
	<body>	
		<form method="POST" enctype="multipart/form-data" action="test_session.php">
			<button type="submit" name="submit" value="submit"></button>
		</form>
	</body>
</html>qu