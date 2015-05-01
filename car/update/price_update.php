<?php
require_once "../include/inner_page_common.php";

$group_id     =  $_POST["group_id"];
$item_id      =  $_POST["item_id"];
$unit_id      =  $_POST["unit_id"];
$buy_price    =  $_POST["buy_price"];
$sell_price   =  $_POST["sell_price"];

if( empty($group_id))
{
     die("data input error!group_id missing!");
}

if( empty($item_id))
{
     die("data input error!item_id missing!");
}

if( empty($unit_id))
{
     die("data input error!unit_id missing!");
}

if( empty($buy_price))
{
     die("data input error!buy_price missing!");
}

if( empty($sell_price))
{
     die("data input error!sell_price missing!");
}

$link = connectCarDB();
$stmt = mysqli_prepare($link, "UPDATE price SET price.buy_price=?,price.sell_price=? where price.group_id=? AND price.item_id=? AND price.unit_id=?");
mysqli_stmt_bind_param($stmt, 'ddddd', $buy_price,$sell_price, $group_id , $item_id , $unit_id);
$r = mysqli_stmt_execute($stmt);

if(!$r)
{
    echo "mysql error:".mysqli_error($link)."<br>";
    mysqli_stmt_close($stmt);
    mysqli_close($link);
    die("Could not update data");
}

//printf("%d Row inserted.\n", mysqli_stmt_affected_rows($stmt));
mysqli_stmt_close($stmt);
mysqli_close($link);
echo DEF_UPDATE_OK;
echo "<meta http-equiv=\"refresh\" content=\"1;url=../view/price_view.php\" />"; // redirect after 3 seconds

?>
