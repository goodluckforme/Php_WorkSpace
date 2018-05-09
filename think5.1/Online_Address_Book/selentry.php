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
        <button type=\"submit\" name=\"submit\" value=\"view\">View Selected Entry</button>
        </form>";
    }
    mysqli_free_result($get_list_res);

} else if ($_POST) {
    if ($_POST['sel_id'] == "") {
        exit;
    }
    //显示人名
    $safe_id = mysqli_real_escape_string($mysqli, $_POST['sel_id']);
    $get_master_sql = "SELECT concat_ws('',f_name,l_name) as display_name FROM master_name WHERE id = '" . $safe_id . "'";
    $get_master_res = mysqli_query($mysqli, $get_master_sql) or die(mysqli_error($mysqli));
    while ($name_info = mysqli_fetch_array($get_master_res)) {
        $display_name = stripcslashes($name_info['display_name']);
        $display_block .= "<h1> Showing Record for " . $display_name . "</h1>";
    }
    mysqli_free_result($get_master_res);

    //显示地址
    $get_address_sql = "SELECT address ,city,state ,zipcode,type FROM address WHERE master_id = '" . $safe_id . "'";
    $get_address_res = mysqli_query($mysqli, $get_address_sql) or die(mysqli_error($mysqli));
    if (mysqli_num_rows($get_address_res) > 0) {
        $display_block .= "<p><strong>Addresses:</strong></p><ul>";
        while ($add_info = mysqli_fetch_array($get_address_res)) {
            $address = stripcslashes($add_info['address']);
            $city = stripcslashes($add_info['city']);
            $state = stripcslashes($add_info['state']);
            $zipcode = stripcslashes($add_info['zipcode']);
            $address_type = stripcslashes($add_info['type']);
            $display_block .= "<li>.$address  $city $state  $zipcode  $address_type</li>";
        }
        $display_block .= "</ul>";
        mysqli_free_result($get_address_res);
    }
//    显示电话
    $get_tel_sql = "SELECT tel_num FROM telephone WHERE master_id = '" . $safe_id . "'";
    $get_tel_res = mysqli_query($mysqli, $get_tel_sql) or die(mysqli_error($mysqli));
    if (mysqli_num_rows($get_tel_res) > 0) {
        $display_block .= "<p><strong>Telphone:</strong></p><ul>";
        while ($add_info = mysqli_fetch_array($get_tel_res)) {
            $tel_num = stripcslashes($add_info['tel_num']);
            $display_block .= "<li>$tel_num</li>";
        }
        $display_block .= "</ul>";
        mysqli_free_result($get_tel_res);
    }
//    显示传真
    $get_fax_sql = "SELECT fax_num FROM fax WHERE master_id = '" . $safe_id . "'";
    $get_fax_res = mysqli_query($mysqli, $get_fax_sql) or die(mysqli_error($mysqli));
    if (mysqli_num_rows($get_fax_res) > 0) {
        $display_block .= "<p><strong>Fax:</strong></p><ul>";
        while ($add_info = mysqli_fetch_array($get_fax_res)) {
            $fax_num = stripcslashes($add_info['fax_num']);
            $display_block .= "<li>$fax_num</li>";
        }
        $display_block .= "</ul>";
        mysqli_free_result($get_fax_res);
    }
//    显示邮件
    $get_email_sql = "SELECT email FROM email WHERE master_id = '" . $safe_id . "'";
    $get_email_res = mysqli_query($mysqli, $get_email_sql) or die(mysqli_error($mysqli));
    if (mysqli_num_rows($get_email_res) > 0) {
        $display_block .= "<p><strong>Email:</strong></p><ul>";
        while ($add_info = mysqli_fetch_array($get_email_res)) {
            $email = stripcslashes($add_info['email']);
            $display_block .= "<li>$email</li>";
        }
        $display_block .= "</ul>";
        mysqli_free_result($get_email_res);
    }
//    显示笔记
    $get_note_sql = "SELECT note FROM personal_notes WHERE master_id = '" . $safe_id . "'";
    $get_note_res = mysqli_query($mysqli, $get_note_sql) or die(mysqli_error($mysqli));
    if (mysqli_num_rows($get_note_res) > 0) {
        $display_block .= "<p><strong>Personal notes:</strong></p><ul>";
        while ($add_info = mysqli_fetch_array($get_note_res)) {
            $note = stripcslashes($add_info['note']);
            $display_block .= "<li>$note</li>";
        }
        $display_block .= "</ul>";
        mysqli_free_result($get_note_res);
    }
    $display_block .= "<p style=\"text-align: center;\">
			<a href=\"addentry.php?master_id=".$_POST['sel_id']."\"> Add info</a>
			&nbsp;&nbsp;&nbsp;
			<a href=\"" . $_SERVER['PHP_SELF'] . "\"> Select Another</a>
		</p>";
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
