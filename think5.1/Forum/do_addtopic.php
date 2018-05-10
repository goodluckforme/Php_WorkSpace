<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/10
 * Time: 10:57
 */
include "DbHepler.php";
doDB();
if (!$_POST['topic_owner'] && !$_POST['topic_title'] && !$_POST['post_text']) {
    header("Location:do_addtopic.php");
    exit;
}

$clean_topic_owner = mysqli_real_escape_string($mysqli, $_POST['topic_owner']);
$clean_topic_title = mysqli_real_escape_string($mysqli, $_POST['topic_title']);
$clean_post_text = mysqli_real_escape_string($mysqli, $_POST['post_text']);

$add_topic_sql = "INSERT INTO `forum_topics` ( `topic_create_time`, `topic_title`, `topic_owner`) VALUES (now(), '" . $clean_topic_title . "', '" . $clean_topic_owner . "');";
$add_topic_res = mysqli_query($mysqli, $add_topic_sql) or die(mysqli_error($mysqli));

$topic_id = mysqli_insert_id($mysqli);
$add_post_sql = "INSERT INTO `forum_posts` (`topic_id`, `post_create_time`, `post_text`, `post_owner`) VALUES ( $topic_id, now(),  '" . $clean_post_text . "',  '" . $clean_topic_owner . "');";
$add_post_res = mysqli_query($mysqli, $add_post_sql) or die(mysqli_error($mysqli));

mysqli_close($mysqli);

$dislpay_block = "<p>The<strong> " . $_POST['topic_title'] . "</strong> topic has been created &nbsp<a href='view_record.php'>查看主题列表</a></p>";
?>
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport"
          content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
    <meta charset="UTF-8">
    <title>版主添加一个主题</title>
</head>

<body>
<?php
echo $dislpay_block;
?>
</body>

</html>