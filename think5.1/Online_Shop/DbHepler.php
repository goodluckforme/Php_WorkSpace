<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/9
 * Time: 8:56
 */
header("content-type:text/html;charset=utf-8");
function doDB(){
    global $mysqli;
    $mysqli = mysqli_connect('localhost', 'root', 'much', 'online_shop', '3306');
    if (mysqli_connect_errno()) {
        printf("Connnect failed:%s\n",mysqli_connect_error());
    } else {
        printf("Connnect Success:%s\n",mysqli_connect_error());
    }
}
?>