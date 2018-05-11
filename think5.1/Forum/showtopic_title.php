<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/10
 * Time: 14:15
 */

include "DbHepler.php";

doDB();
if (!isset($_GET['topic_id'])) {
    header("Location:view_record.php");
    exit;
}
$safe_topic_id = mysqli_escape_string($mysqli, $_GET['topic_id']);
//查询主题详情
//INSERT INTO `forum`.`forum_topics` (`topic_id`, `topic_create_time`, `topic_title`, `topic_owner`) VALUES ('1', '2018-05-10 11:27:01', 'H5写一个区块链系统', '马齐');
$verify_topic_sql =
    "SELECT  `topic_title` FROM forum_topics WHERE topic_id='" . $safe_topic_id . "'";
$verify_topic_res = mysqli_query($mysqli, $verify_topic_sql) or die(mysqli_error($mysqli));

if (mysqli_num_rows($verify_topic_res) < 1) {
    $display_block = "<p><em>You have selected an invaild topic.</br>
Please <a href='showtopic_title.php'>Try again</a>.</em></p> ";
} else {
    while ($topic_info = mysqli_fetch_array($verify_topic_res)) {
        $topic_title = stripcslashes($topic_info['topic_title']);
    }
//查找文章详情页post
    $get_post_sql =
        "SELECT `post_id`,`post_text`, date_format ( `post_create_time`,'%b %e %Y at %r') as fmt_post_create_time,
 `post_owner` FROM forum_posts WHERE topic_id ='" . $safe_topic_id . "' ORDER BY `post_create_time` ASC ";
    $get_post_res = mysqli_query($mysqli, $get_post_sql) or die(mysqli_error($mysqli));
    $display_block = <<<END_OF_BLOCK
    <p>Showing posts for the <strong>$topic_title</strong> topic: </p>
		<table>
			<tr>
				<th>AUTHOR</th>
				<th>POST</th>
			</tr>
END_OF_BLOCK;
    while ($posts_info = mysqli_fetch_array($get_post_res)) {
        $post_id = $posts_info['post_id'];
        $post_text = stripcslashes($posts_info['post_text']);
        $post_owner = stripcslashes($posts_info['post_owner']);
        $fmt_post_create_time = stripcslashes($posts_info['fmt_post_create_time']);

        $display_block .= <<<END_OF_BLOCK
            <tr>
				<td>
				 $post_owner</br></br>
				 created on:</br>$fmt_post_create_time
				</td>
				<td ></br></br>
                    $post_text
                    <a href="replaytopost.php?post_id=$post_id"></br>
                        <strong>REPLY TO POST </strong>
                    </a>
				</td>
			</tr>
END_OF_BLOCK;
    }
}
mysqli_free_result($verify_topic_res);
mysqli_free_result($get_post_res);
mysqli_close($mysqli);
$display_block .= "</table>"

?>
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport"
          content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
    <meta charset="UTF-8">
    <title></title>
    <style type="text/css">
        table {
            border: 1px solid black;
            border-collapse: collapse;
        }

        td {
            border: 1px solid black;
            padding: 6px;
        }

        th {
            border: 1px solid black;
            padding: 6px;
            font-weight: bold;
            background: #ccc;
        }
    </style>
</head>

<body>
<?php
echo $display_block;
?>
</body>

</html>