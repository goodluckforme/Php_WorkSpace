<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/9
 * Time: 10:06
 */
include "DbHepler.php";

if (!$_POST || $_GET['master_id'] != "") {
    if (isset($_GET['master_id'])) {
        doDB();
        //显示人名
        $master_id = mysqli_real_escape_string($mysqli, $_GET['master_id']);
        $get_master_sql = "SELECT concat_ws('',f_name,l_name) as display_name FROM master_name WHERE id = '" . $master_id . "'";
        $get_master_res = mysqli_query($mysqli, $get_master_sql) or die(mysqli_error($mysqli));
        while ($name_info = mysqli_fetch_array($get_master_res)) {
            $display_name = stripcslashes($name_info['display_name']);
            $display_block = "	<p><strong>Adding infomation for " . $display_name . "</strong></p>";
        }
        mysqli_free_result($get_master_res);
        mysqli_close($mysqli);
        $display_block .= <<<END_OF_TEXT
        	<form action="$_SERVER[PHP_SELF]" method="post">
        		<input type="hidden" name="master_id" value="$master_id"/>
                <p><label for="note">Person Note :</label><br />
                    <textarea name="note" rows="3" cols="35"></textarea></p>
                <button type="submit" name="submit" value="send">send Note</button>
            </form>
END_OF_TEXT;
    } else {
        $display_block = <<<END_OF_TEXT
        	<form action="$_SERVER[PHP_SELF]" method="post">
			<fieldset id="">
				<legend>First/Last Names:</legend><br />
				<input type="text" name="f_name" id="f_name" size="30" value="" maxlength="75" required="required" />
				<input type="text" name="l_name" id="l_name" size="30" value="" maxlength="75" required="required" />
			</fieldset>
			<p><label for="address">Street Address:</label>
				<input type="text" name="address" id="address" value="" size="30" /></p><br/>
			<fieldset id="">
				<legend>City/State/Zip</legend><br />
				<input type="text" name="city" id="city" value="" size="30" maxlength="50" />
				<input type="text" name="state" id="state" value="" size="5" maxlength="2" />
				<input type="text" name="zipcode" id="zipcode" value="" size="10" maxlength="10" />
			</fieldset>
			<fieldset id="">
				<legend>Address Type:</legend><br />
				<input type="radio" name="add_type" id="add_type_h" value="home" checked="checked" /><label for="add_type_h">home</label>
				<input type="radio" name="add_type" id="add_type_w" value="work" /><label for="add_type_w">work</label>
				<input type="radio" name="add_type" id="add_type_o" value="ohter" /><label for="add_type_o">ohter</label>
			</fieldset>
			<fieldset id="">
				<legend>Telephone Number :</legend><br />
				<input type="text" name="tel_number" id="tel_number" size="30" maxlength="25" value="" /><br /><br />
				<input type="radio" name="tel_type" id="tel_type_h" value="home" checked="checked" /><label for="tel_type_h">home</label>
				<input type="radio" name="tel_type" id="tel_type_w" value="work" /><label for="tel_type_w">work</label>
				<input type="radio" name="tel_type" id="tel_type_o" value="ohter" /><label for="tel_type_o">ohter</label>
			</fieldset>

			<fieldset id="">
				<legend>Fax Number :</legend><br />
				<input type="text" name="fax_number" id="fax_number" size="30" maxlength="25" value="" /><br /><br />
				<input type="radio" name="fax_type" id="fax_type_h" value="home" checked="checked" /><label for="fax_type_h">home</label>
				<input type="radio" name="fax_type" id="fax_type_w" value="work" /><label for="fax_type_w">work</label>
				<input type="radio" name="fax_type" id="fax_type_o" value="ohter" /><label for="fax_type_o">ohter</label>
			</fieldset>
			<fieldset id="">
				<legend>Address Number :</legend><br />
				<input type="text" name="email" id="email" size="30" maxlength="25" value="" /><br /><br />
				<input type="radio" name="email_type" id="email_type_h" value="home" checked="checked" /><label for="email_type_h">home</label>
				<input type="radio" name="email_type" id="email_type_w" value="work" /><label for="email_type_w">work</label>
				<input type="radio" name="email_type" id="email_type_o" value="ohter" /><label for="email_type_o">ohter</label>
			</fieldset>

			<p><label for="note">Person Note :</label><br />
				<textarea name="note" rows="3" cols="35"></textarea></p>
			<button type="submit" name="submit" value="send">Add Entry</button>
		</form>
END_OF_TEXT;
    }
} elseif (isset($_POST['master_id']) && isset($_POST['note'])) {
    doDB();
    $note = mysqli_real_escape_string($mysqli, $_POST['note']);
    //修改私人笔记
    $change_note_sql = "UPDATE personal_notes set note ='" . $note . "', date_modified =now() WHERE master_id='" . $_POST['master_id'] . "'";
    $change_note_res = mysqli_query($mysqli, $change_note_sql) or die(mysqli_error($mysqli));
    $display_block = "<p>Your Personal note has been change .Would you like to <a href='selentry.php'>retry</a>?</p>";
    mysqli_free_result($change_note_res);
    mysqli_close($mysqli);
} elseif ($_POST) {
    doDB();
    if (($_POST['f_name'] == "") || ($_POST['l_name'] == "")) {
        header("Location:addentry.php");
        exit;
    }
    $safe_f_name = mysqli_real_escape_string($mysqli, $_POST['f_name']);
    $safe_l_name = mysqli_real_escape_string($mysqli, $_POST['l_name']);
    $safe_address = mysqli_real_escape_string($mysqli, $_POST['address']);
    $safe_city = mysqli_real_escape_string($mysqli, $_POST['city']);
    $safe_state = mysqli_real_escape_string($mysqli, $_POST['state']);
    $safe_zipcode = mysqli_real_escape_string($mysqli, $_POST['zipcode']);
    $safe_tel_number = mysqli_real_escape_string($mysqli, $_POST['tel_number']);
    $safe_fax_number = mysqli_real_escape_string($mysqli, $_POST['fax_number']);
    $safe_email = mysqli_real_escape_string($mysqli, $_POST['email']);
    $safe_note = mysqli_real_escape_string($mysqli, $_POST['note']);
//    存人
    $add_master_sql = "INSERT INTO master_name (date_added,date_modified,f_name,l_name) VALUES (now(),now(),'" . $safe_f_name . "','" . $safe_l_name . "')";
    $add_master_res = mysqli_query($mysqli, $add_master_sql) or die(mysqli_error($mysqli));
    $master_id = mysqli_insert_id($mysqli);

    //存地址
    if ($_POST['address'] || $_POST['city'] || $_POST['state'] || $_POST['zipcode']) {
        $add_address_sql = "INSERT INTO address (master_id, date_added,date_modified,address,city,state,zipcode,type) VALUES
    ('" . $master_id . "',now(),now(),'" . $safe_address . "','" . $safe_city . "','" . $safe_state . "','" . $safe_zipcode . "','" . $_POST['add_type'] . "')";
        $add_address_res = mysqli_query($mysqli, $add_address_sql) or die(mysqli_error($mysqli));
    }
    //存电话
    if ($_POST['tel_number']) {
        $add_tel_sql = "INSERT INTO telephone (master_id,date_added,date_modified,tel_num,type)VALUES 
    ( '" . $master_id . "',now(),now(), '" . $safe_tel_number . "', '" . $_POST['add_type'] . "')";
        $add_tel_res = mysqli_query($mysqli, $add_tel_sql) or die(mysqli_error($mysqli));
    }
    //存chuanzhen
    if ($_POST['fax_number']) {
        $add_fax_sql = "INSERT INTO fax (master_id,date_added,date_modified,fax_num,type)VALUES 
( '" . $master_id . "',now(),now(), '" . $safe_fax_number . "', '" . $_POST['add_type'] . "')";
        $add_fax_res = mysqli_query($mysqli, $add_fax_sql) or die(mysqli_error($mysqli));
    }
    //存邮件
    if ($_POST['email']) {
        $add_email_sql = "INSERT INTO email (master_id,date_added,date_modified,email,type)VALUES 
( '" . $master_id . "',now(),now(), '" . $safe_email . "', '" . $_POST['add_type'] . "')";
        $add_email_res = mysqli_query($mysqli, $add_email_sql) or die(mysqli_error($mysqli));
    }
    //存私人笔记
    if ($_POST['note']) {
        $add_note_sql = "INSERT INTO personal_notes (master_id,date_added,date_modified,note)VALUES 
( '" . $master_id . "',now(),now(), '" . $safe_note . "')";
        $add_note_res = mysqli_query($mysqli, $add_note_sql) or die(mysqli_error($mysqli));
    }
    $display_block = "<p>Your entry has been added .Would you like to <a href='addentry.php'>add anohter</a>?</p>";
    mysqli_close($mysqliq);
}


?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>ADD Address Book</title>
    <meta name="viewport"
          content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
</head>

<body>
<h1>ADD Address Book</h1>
<?php
echo $display_block;
?>
</body>

</html>
