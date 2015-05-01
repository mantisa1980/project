<?php
require_once "../include/inner_page_common.php";

$paid     =  $_POST["paid"];
$note     =  $_POST["note"];
$order_id =  $_POST["order_id"];

if( empty($order_id))
{
     die("data input error!order_id missing!");
}
if( empty($paid) && ($paid!=0) )
{
     die("data input error!paid missing!");
}

$note   =  !empty($_POST["note"])?$_POST["note"]:"";

$link = connectCarDB();
$stmt = mysqli_prepare($link, 'UPDATE sell_order SET paid=?,note=? where id=?');
mysqli_stmt_bind_param($stmt, 'dsd', $paid, $note, $order_id);
$r = mysqli_stmt_execute($stmt);

if(!$r)
{
    echo "mysql error:".mysqli_error($link)."<br>";
    mysqli_stmt_close($stmt);
    mysqli_close($link);
    die("Could not update data");
}

mysqli_stmt_close($stmt);
mysqli_close($link);
echo DEF_UPDATE_OK;
echo "<meta http-equiv=\"refresh\" content=\"1;url=../view/customer_view.php\" />";

?>
