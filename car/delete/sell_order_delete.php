<?php
require_once "../include/inner_page_common.php";

if( empty($_POST["order_id"]) ) // "" empty string is also empty;
{
    die("data input error! order_id missing !");
}

$id =  $_POST["order_id"];

$sql_statemanet = "DELETE FROM sell_order where id =".$id ;
   
$link = connectCarDB();
$result = mysqli_query($link, $sql_statemanet);

if( !$result )
{
    echo "mysql error:".mysqli_error($link)."<br>";
    mysqli_close($link);
    die("Could not delete data");
}

mysqli_close($link);
echo DEF_DELETE_OK;
echo "<meta http-equiv=\"refresh\" content=\"1;url=../view/customer_view.php\" />"; // redirect after 3 seconds

?>
