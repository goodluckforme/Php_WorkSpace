<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/10
 * Time: 15:36
 */
include "DbHepler.php";
doDB();
if (!$_POST) {
    if (!isset($_GET['post_id'])) {
        header("Location:showtopic_title.php");
        exit;
    }
    $safe_post_id = mysqli_escape_string($mysqli, $_GET['post_id']);
    $verify_sql =
        "SELECT ft.`topic_id`,ft.`topic_title`, 
 ft.`topic_owner` FROM forum_posts AS fp LEFT JOIN  forum_topics AS ft  ON fp.topic_id = ft.topic_id WHERE fp.post_id='" . $safe_post_id . "'";
    $gverify_res = mysqli_query($mysqli, $verify_sql) or die(mysqli_error($mysqli));
    if (mysqli_num_rows($gverify_res) < 1) {
        header("Location:showtopic_title.php");
        exit;
    } else {
        while ($topic_info = mysqli_fetch_array($gverify_res)) {
            $topic_id = stripcslashes($topic_info['topic_id']);
            $topic_title = stripcslashes($topic_info['topic_title']);
        }
        ?>
        <!DOCTYPE html>
        <html>

        <head>
            <meta charset="UTF-8">
            <meta name="viewport"
                  content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
            <title>POST Your Replay in <?php echo $topic_title; ?></title>
            <style type="text/css">

            </style>
        </head>

        <body>
        <h1>POST Your Replay in <?php echo $topic_title; ?></h1>
        <p style="font-size: 24px;">发送邮件</p>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <p><label for="post_owner">Your Email Address :</label></p>
            <input type="email" name="post_owner" id="post_owner" size="40"/><br/>
            <p><label for="post_text">Post Text :</label></p>
            <p><textarea name="post_text" rows="10" cols="40" style="width: 95%;"></textarea></p>
            <input type="hidden" name="topic_id" id="topic_id" value="<?php echo $topic_id; ?>"/>
            <button type="submit" name="submit" value="submit">Add Post</button>
        </form>
        </body>
        </html>
        <?php
    }
    mysqli_free_result($gverify_res);
    mysqli_close($mysqli);
} elseif ($_POST) {
    if (!$_POST['post_text'] || !$_POST['topic_id'] || !$_POST['post_owner']) {
        header("Location:showtopic_title.php");
        exit;
    }
    $safe_post_text = mysqli_real_escape_string($mysqli, $_POST['post_text']);
    $safe_topic_id = mysqli_real_escape_string($mysqli, $_POST['topic_id']);
    $safe_post_owner = mysqli_real_escape_string($mysqli, $_POST['post_owner']);

    $add_post_sql = "INSERT INTO `forum`.`forum_posts` ( `topic_id`, `post_create_time`, `post_text`, `post_owner`)
 VALUES ('" . $safe_topic_id . "',now(),'" . $safe_post_text . "', '" . $safe_post_owner . "'); ";
    $add_post_res = mysqli_query($mysqli, $add_post_sql) or die(mysqli_error($mysqli));
    mysqli_close($mysqli);
    header("Location:showtopic_title.php?topic_id=$safe_topic_id");
    exit;
}
?>

