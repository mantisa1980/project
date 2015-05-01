<?php
require_once "../include/inner_page_common.php";

$id        =  $_POST["id"];
$group_id  =  $_POST["group_id"];
$name      =  $_POST["name"];

if( empty($id))
{
     die("data input error!id missing!");
}
if( empty($group_id))
{
     die("data input error!group_id missing!");
}
if( empty($name))
{
     die("data input error!name missing!");
}

$company   =  !empty($_POST["company"])?$_POST["company"]:NULL;
$vat       =  !empty($_POST["vat"])?$_POST["vat"]:NULL;
$address   =  !empty($_POST["address"])?$_POST["address"]:NULL;
$phone     =  !empty($_POST["phone"])?$_POST["phone"]:NULL;
$cellphone =  !empty($_POST["cellphone"])?$_POST["cellphone"]:NULL;
$cellphone2=  !empty($_POST["cellphone2"])?$_POST["cellphone2"]:NULL;
$email     =  !empty($_POST["email"])?$_POST["email"]:NULL;

$link = connectCarDB();
$stmt = mysqli_prepare($link, 'UPDATE customer SET name=?,company=?,vat=?,address=?,phone=?,cellphone=?,cellphone2=?,email=?,group_id=? where id=?');
mysqli_stmt_bind_param($stmt, 'ssssssssdd', $name, $company, $vat, $address,$phone,$cellphone,$cellphone2,$email,$group_id , $id);
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
echo "<meta http-equiv=\"refresh\" content=\"1;url=../view/customer_view.php\" />";

?>
