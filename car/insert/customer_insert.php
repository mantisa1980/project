<?php
require_once "../include/inner_page_common.php";

if( empty($_POST["group_id"]) ) // "" empty string is also empty;
{
    die("data input error! group_id missing !");
}

$name      =  !empty($_POST["name"])?$_POST["name"]:NULL;
$company   =  !empty($_POST["company"])?$_POST["company"]:NULL;
$vat       =  !empty($_POST["vat"])?$_POST["vat"]:NULL;
$address   =  !empty($_POST["address"])?$_POST["address"]:NULL;
$phone     =  !empty($_POST["phone"])?$_POST["phone"]:NULL;
$cellphone =  !empty($_POST["cellphone"])?$_POST["cellphone"]:NULL;
$cellphone2=  !empty($_POST["cellphone2"])?$_POST["cellphone2"]:NULL;
$email     =  !empty($_POST["email"])?$_POST["email"]:NULL;
$group_id  =  $_POST["group_id"];



$link = connectCarDB();
$stmt = mysqli_prepare($link, "INSERT INTO customer(`name`,`company`, `vat`, `address`, `phone`,`cellphone`,`cellphone2`, `email`, `created_on`, `group_id`) VALUES (?,?,?,?,?,?,?,?,NOW(),?)");
mysqli_stmt_bind_param($stmt, 'ssssssssd', $name, $company, $vat, $address,$phone,$cellphone,$cellphone2,$email,$group_id );
$r = mysqli_stmt_execute($stmt);

if(!$r)
{
    echo "mysql error:".mysqli_error($link)."<br>";
    mysqli_stmt_close($stmt);
    mysqli_close($link);
    die("Could not insert data");
}

//printf("%d Row inserted.\n", mysqli_stmt_affected_rows($stmt));
mysqli_stmt_close($stmt);
mysqli_close($link);
echo DEF_INSERT_OK;
echo "<meta http-equiv=\"refresh\" content=\"1;url=../view/customer_view.php\" />"; // redirect after 3 seconds


?>
