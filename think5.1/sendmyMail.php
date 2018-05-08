<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/8
 * Time: 15:39
 */

include "DbHelper.php";
if (!$_POST) {
    $display_block = <<<END_OF_BLOCK
        <p style="font-size: 24px;">发送邮件</p>
		<form method="post" action="$_SERVER[PHP_SELF]">
			<p><label for="subject">Subject :</label></p>
			<input type="text" name="subject" id="subject" size="40" /><br />
			<p><label for="message">Mail Body :</label></p>
			<p><textarea name="message" rows="10" cols="40" style="width: 95%;"></textarea>
			</p>
			<button type="submit" name="submit" value="submit">Submit</button>
		</form>
END_OF_BLOCK;
} elseif ($_POST) {
    if ($_POST['subject'] == '' || $_POST['message'] == '') {
        header("Location:sendmyMail.php");
        exit;
    }
    doDB();
    if (mysqli_connect_errno()) {
        printf("Connect failed %s\n", mysqli_connect_error());
    } else {
        $sql = "SELECT email FROM subscribers WHERE  email='" . $_POST['subject'] . "'";
        $result = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));
        $mailheaders = "From:Your Mailing List <you@yourmail.com>";
        if (mysqli_num_rows($result) < 1) {
            $display_block= "you should register this mail then you can send mail";
        }else
        while ($row = mysqli_fetch_array($result)) {
            set_time_limit(0);
            $email = $row['email'];
            mail("$email", stripcslashes($_POST['subject']),stripcslashes($_POST['message']), $mailheaders);
            $display_block = "newsLetters send to " . $email . "<br/>";
        }
        mysqli_free_result($result);
        mysqli_close($mysqli);
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
    <title>发送邮件</title>
    <style type="text/css">

    </style>
</head>

<body>
<h1> Sending a NewsLetter</h1>
<?php
echo $display_block;
?>
</body>

</html>
