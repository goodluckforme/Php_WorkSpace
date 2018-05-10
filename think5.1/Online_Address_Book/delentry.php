<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/9
 * Time: 14:24
 */
include "DbHepler.php";
doDB();
if (!$_POST) {
    $display_block = "<h1>Selct an Entry</h1>";
    $get_list_sql = "SELECT id ,CONCAT_WS(',',l_name,f_name) AS display_name FROM master_name ORDER by l_name,f_name";
    $get_list_res = mysqli_query($mysqli, $get_list_sql) or die(mysqli_error($mysqli));
    if (mysqli_num_rows($get_list_res) < 1) {
        $display_block .= "<p><em>Sorry,no records to select!</em></p>";
    } else {
        $display_block .= "<form action=\"$_SERVER[PHP_SELF]\" method=\"post\">
                                <p><label for=\"sel_id\">Select a Record:</label></p><br />
                                <select name=\"sel_id\"name=\"sel_id\" required=\"required\">
                                    <option value=\"\">-- Select one --</option>";
        while ($recs = mysqli_fetch_array($get_list_res)) {
            $id = $recs['id'];
            $display_name = stripcslashes($recs['display_name']);
            $display_block .= " <option value=\"" . $id . "\">$display_name</option>";
        }
        $display_block .= "
        </select><br />
        <button type=\"submit\" name=\"submit\" value=\"view\">View Delete Entry</button>
        </form>";
    }
    mysqli_free_result($get_list_res);
} else if ($_POST) {
    if ($_POST['sel_id'] == "") {
        header("Location:delentry.php");
        exit;
    }
    //删除人
    $safe_id = mysqli_real_escape_string($mysqli, $_POST['sel_id']);
    $del_master_sql = "DELETE FROM master_name WHERE id = '" . $safe_id . "'";
    $del_master_res = mysqli_query($mysqli, $del_master_sql) or die(mysqli_error($mysqli));
    //删除地址
    $del_address_sql = "DELETE FROM address WHERE master_id = '" . $safe_id . "'";
    $del_address_res = mysqli_query($mysqli, $del_address_sql) or die(mysqli_error($mysqli));
    //删除电话
    $del_telephone_sql = "DELETE FROM telephone WHERE master_id = '" . $safe_id . "'";
    $del_telephone_res = mysqli_query($mysqli, $del_telephone_sql) or die(mysqli_error($mysqli));
    //删除邮件
    $del_email_sql = "DELETE FROM email WHERE master_id = '" . $safe_id . "'";
    $del_email_res = mysqli_query($mysqli, $del_email_sql) or die(mysqli_error($mysqli));
    //删除传真
    $del_fax_sql = "DELETE FROM fax WHERE master_id = '" . $safe_id . "'";
    $del_fax_res = mysqli_query($mysqli, $del_fax_sql) or die(mysqli_error($mysqli));
    //删除个人笔记
    $del_note_sql = "DELETE FROM personal_notes WHERE master_id = '" . $safe_id . "'";
    $del_note_res = mysqli_query($mysqli, $del_note_sql) or die(mysqli_error($mysqli));
    $display_block = "<h1>Record(s) Deleted</h1>
<p>Would you like to <a href=\"" . $SERVER['PHP_SELF'] . "\">Delete anohter</a>?</p>";

}
mysqli_close($mysqli);
?>
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport"
          content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
    <meta charset="UTF-8">
    <title>浏览全纪录</title>
</head>

<body>
<?php
echo $display_block;
?>
</body>

</html>
