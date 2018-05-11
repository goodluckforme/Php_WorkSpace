<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/10
 * Time: 11:51
 */
include "DbHepler.php";
doDB();
//查询列表页
//INSERT INTO `forum`.`forum_topics` (`topic_id`, `topic_create_time`, `topic_title`, `topic_owner`) VALUES ('1', '2018-05-10 11:27:01', 'Demo', '马齐');
$get_topics_sql =
    "SELECT `topic_id`,`topic_title`, date_format ( `topic_create_time`,'%b %e %Y at %r') as fmt_topic_create_time,
 `topic_owner` FROM forum_topics ORDER BY `topic_create_time` desc ";
$get_topics_res = mysqli_query($mysqli, $get_topics_sql) or die(mysqli_error($mysqli));
if (mysqli_num_rows($get_topics_res) < 1) {
    $display_block = "<p><em>No Topic exit</em></p>";
} else {
    $display_block = <<<END_OF_BLOCK
		<table>
			<tr>
				<th>Topic Title</th>
				<th># of POSTS</th>
			</tr>
END_OF_BLOCK;
    while ($topic_info = mysqli_fetch_array($get_topics_res)) {
        $topic_id = $topic_info['topic_id'];
        $topic_title = stripcslashes($topic_info['topic_title']);
        $topic_owner = stripcslashes($topic_info['topic_owner']);
        $topic_create_time = stripcslashes($topic_info['topic_create_time']);

        //查询文章
        $get_num_posts_sql =
            "SELECT COUNT(`post_id`) AS post_count FROM forum_posts WHERE topic_id='" . $topic_id . "'";
        $get_num_posts_res = mysqli_query($mysqli, $get_num_posts_sql) or die(mysqli_error($mysqli));
        while ($posts_info = mysqli_fetch_array($get_num_posts_res)) {
            $num_posts = $posts_info['post_count'];
        }
        $display_block .= <<<END_OF_BLOCK
            <tr>
				<td>
				<a href="showtopic_title.php?topic_id=$topic_id"><strong>$topic_title</strong></br></a>
				Create on $topic_create_time create time by $topic_owner
				</td>
				<td class ="num_post_col">
				    $num_posts
				</td>
			</tr>
END_OF_BLOCK;
    }
}
mysqli_free_result($get_topics_res);
mysqli_free_result($get_num_posts_res);
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
        .num_post_col {
            text-align: center;
        }

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

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "http://www.wanandroid.com/project/list/1/json?cid=294",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    $display_block .= "cURL Error #:" . $err;
} else {
    $display_block .= $response;
}
echo $display_block;
?>
<p>Would you like to <a href="addtopic.html">add a Topic</a>?</p>
</body>

</html>