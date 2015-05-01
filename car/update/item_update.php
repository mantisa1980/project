<?php
require_once "../include/inner_page_common.php";

$id     =  $_POST["id"];
$name   =  $_POST["name"];

if( empty($id))
{
     die("data input error!id missing!");
}

if( empty($name))
{
     die("data input error!name missing!");
}

//echo "item_id=".$item_id." item_name=".$item_name;

$link = connectCarDB();
$stmt = mysqli_prepare($link, "UPDATE item SET name=? where id=?");
mysqli_stmt_bind_param($stmt, 'sd', $name,$id);
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
echo "<meta http-equiv=\"refresh\" content=\"1;url=../view/item_update_view.php\" />"; // redirect after 3 seconds

?>
