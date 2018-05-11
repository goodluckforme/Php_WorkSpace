<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/11
 * Time: 13:38
 */

include "DbHepler.php";
doDB();
$display_block = "<h1> My Store - Item Detail</h1>";

if (isset($_GET['item_id']) && $_GET['item_id'] != "") {
    $safe_item_id = mysqli_real_escape_string($mysqli, $_GET['item_id']);
    $get_item_sql = "SELECT  c.id as cat_id,c.cat_title,si.item_title,si.item_price,si.item_image,si.item_desc FROM store_items AS si left join  store_categories AS c on c.id = si.cat_id 
WHERE si.id = '" . $safe_item_id . "'";
    $get_item_res = mysqli_query($mysqli, $get_item_sql) or die(mysqli_error($mysqli));
    if (mysqli_num_rows($get_item_res) < 0) {
        $display_block .= "<p>NO Any  goods detail  show<a href='seestore.php'>please back Try again</a>?</p> ";
    } else {
        while ($item_info = mysqli_fetch_array($get_item_res)) {
            $cat_id = $item_info['cat_id'];
            $item_price = $item_info['item_price'];
            $item_image = $item_info['item_image'];
            $item_title = stripcslashes($item_info['item_title']);
            $cat_title = stripcslashes($item_info['cat_title']);
            $item_desc = stripcslashes($item_info['item_desc']);
        }
        $display_block .= <<<END_OF_BLOCK
        <p> you Are Viewing : </p>
		<p><a href="seestore.php?cat_id=$cat_id" >$cat_title></a>$item_title</p>
		<div class="image_container">
			<img src="$item_image" alt="$item_image"/>
		</div>
		<div class="image_container">
			<p><strong>Description:</strong>$item_desc</p>
			<p><strong>Prices:</strong>$item_price</p>
		
END_OF_BLOCK;


        //联查颜色
        $get_colors_sql = "select item_color from  store_item_color where item_id ='" . $cat_id . "' ";
        $get_colors_res = mysqli_query($mysqli, $get_colors_sql) or die(mysqli_error($mysqli));
        if (mysqli_num_rows($get_colors_res) > 0) {
            $display_block .= "<p> Avaliable Colors : </p>";
            while ($colors = mysqli_fetch_array($get_colors_res)) {
                $display_block .= $colors['item_color'] . "</br>";
            }
        }
        //联查size
        $get_size_sql = "select item_size from  store_item_size where item_id ='" . $cat_id . "' ";
        $get_size_res = mysqli_query($mysqli, $get_size_sql) or die(mysqli_error($mysqli));
        if (mysqli_num_rows($get_size_res) > 0) {
            $display_block .= "<p> Avaliable sizes: </p>";
            while ($colors = mysqli_fetch_array($get_size_res)) {
                $display_block .= $colors['item_size'] . "</br>";
            }
        }
        $display_block .= "</div>";
    }
    mysqli_free_result($get_item_res);
    mysqli_free_result($get_colors_res);
    mysqli_free_result($get_size_res);
} else {
    $display_block .= "<p>NO Any  goods detail  show<a href='seestore.php'>please back Try again</a>?</p> ";
} ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
    <title></title>
    <style type="text/css">
        .image_container {
            margin: 0px 12px 0px 12px;
            float: left;
        }
    </style>
</head>

<body>
<?php
echo $display_block;
?>
</body>

</html>