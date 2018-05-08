<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/7
 * Time: 10:50
 */
include 'DbHelper.php';
if (!$_POST) {
    $display_block = <<<END_OF_BLOCK
        <form method="post" action="$_SERVER[PHP_SELF]">
			<p><label for="email">Your E-Mail Address:</label></p><br />
			<input type="email" id="email" name="email" size="40" maxlength="150" />
			<fieldset>
				<legend>Action:</legend><br />
				<input type="radio" id="action_sub" value="sub"name="action" />
				<label for="action_sub">subscribe</label><br />
				<input type="radio" id="action_unsub" value="unsub"name="action" />
				<label for="action_unsub">unsubscribe</label>
			</fieldset>
			<button type="submit" name="submit" value="submit">Submit</button>
		</form>
END_OF_BLOCK;
} else if (($_POST) && (isset($_POST['action']) && $_POST['action'] == 'sub')) {
    $display_block = "断个点 兄弟";
    if ($_POST['email'] == '') {
        header("Location:manage.php");
        exit;
    } else {
        //链接数据库
        doDB();
        //检查该邮箱
        emailChecker($_POST['email']);
        if (mysqli_num_rows($check_res) < 1) {
            mysqli_free_result($check_res);
            $add_sql = "INSERT INTO subscribers (email) VALUES('" . $safe_email . "')";
            $add_res = mysqli_query($mysqli, $add_sql) or die(mysqli_error($mysqli));
            $display_block = '<p>Thanks for singing up!</p>';
            mysqli_close($mysqli);
        } else {
            $display_block = '<p>You are Already subscribed!</p>';
        }
    }
}/*反订阅*/
else if (($_POST) && ($_POST['action'] == 'unsub')) {
    if ($_POST['email'] == "") {
        header("Lcation:manage.php");
        exit();
    } else {
        doDB();
        emailChecker($_POST['email']);
        if (mysqli_num_rows($check_res) < 1) {
            mysqli_free_result($mysqli);
            $display_block = "<p>Couldn't find your address!</p>
                                <p>no Action was taken</p>";
        } else {
            while ($row = mysqli_fetch_array($check_res)) {
                $id = $row['id'];
            }
            $del_sql = "DELETE FROM subscribers WHERE id = " . $id;
            $del_res = mysqli_query($mysqli, $del_sql) or die(mysqli_error($mysqli));
            $display_block = "<p> YOU're unsubscriber!</p>";
        }
        mysqli_close($mysqli);
    }
}
?>
<html>

<head>
    <meta name="viewport"
          content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
    <meta charset="UTF-8"/>
    <title>Subscribe/Unscubscribe to a Mailling List</title>
</head>

<body>
<h1>Subscribe/Unscubscribe to a Mailling List</h1>
<?php
echo "$display_block"; ?>
</body>

</html>