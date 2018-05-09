<?php
//echo '我现在在测试数据库链接';
header("content-type:text/html;charset=utf-8");
function doDB()
{
    global $mysqli;
//    echo phpinfo();
    $mysqli = mysqli_connect('localhost', 'root', 'much', 'much', '3306');
    if (mysqli_connect_errno()) {
        printf('链接事失败:%s\n', mysqli_connect_error());
        exit();
    }
}

function emailChecker($email)
{
    global $mysqli, $safe_email, $check_res;
    $safe_email = mysqli_real_escape_string($mysqli, $email);
    echo "\n连接数据库开始查询\n". $safe_email;
    $check_sql = "SELECT id FROM SUBSCRIBERS WHERE email ='" . $safe_email . "'";
    $check_res = mysqli_query($mysqli, $check_sql) or die(mysqli_error($mysqli));
    echo $check_res-> fetch_object（） -> memTotal;
}