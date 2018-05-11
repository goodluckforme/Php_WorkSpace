<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/11
 * Time: 11:37
 */
include "DbHepler.php";
doDB();
$display_block = "<h1>My Categories</h1>
<p>Select a category to see its items</p>";
//显示购物分类
$get_cat_sql = "SELECT id,cat_title ,cat_desc FROM store_categories order BY cat_title";
$get_cat_res = mysqli_query($mysqli, $get_cat_sql) or die(mysqli_error($mysqli));
if (mysqli_num_rows($get_cat_res) > 0) {
    $display_block = "<p><strong>Addresses:</strong></p>";
    while ($cats = mysqli_fetch_array($get_cat_res)) {
        $cat_id = $cats['id'];
        $cat_desc = stripcslashes($cats['cat_desc']);
        $cat_title = strtoupper(stripcslashes($cats['cat_title']));
        $display_block .= "<p><a href=" . $SERVER['PHP_SELF'] . "?cat_id=$cat_id" . "> $cat_title</a></br>$cat_desc</br></p>";
        if (isset($_GET['cat_id']) && $_GET['cat_id'] == $cat_id) {
            //查找该分类下的所有商品
            $safe_cat_id = mysqli_real_escape_string($mysqli, $_GET['cat_id']);
            $get_items_sql = "SELECT id,item_title ,item_price ,item_price,item_image FROM store_items WHERE  cat_id ='" . $safe_cat_id . "' order BY item_title";
            $get_items_res = mysqli_query($mysqli, $get_items_sql) or die(mysqli_error($mysqli));

            if (mysqli_num_rows($get_items_res) < 1) {
                $display_block .= "<p><em> Sorry , no items in this category.</em></p>";
            } else {
                $display_block .= "<ul>";
                while ($items = mysqli_fetch_array($get_items_res)) {
                    $item_id =$items['id'];
                    $item_title = stripcslashes($items['item_title']);
                    $item_price = stripcslashes($items['item_price']);
                    $display_block .= "<li><a href='showitem.php?item_id=$item_id'>$item_title</a>&nbsp;￥( $item_price )</li>";
                }
                $display_block .= "</ul>";
            }
            mysqli_free_result($get_items_res);
        }
    }
} else {
    $display_block = "<p><em>Sorry ,no categories to brower.</em></p>";
}
mysqli_free_result($get_cat_res);
mysqli_close($mysqli);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no"/>
    <title>发送邮件</title>

</head>

<body>
<?php
echo $display_block;
?>
</body>

</html>
