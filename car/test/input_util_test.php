<?php
require_once "../include/inner_page_common.php";

$u = new FormInputUtility();

$u->beginForm("fetch_post_test2.php");
$u->addHiddenInput("id",1);
$u->addInputText("name", "姓名" , "曹操");
$u->addInputText("email","信箱" ,"123@456.com");
$u->addSelection("group_id","群組" , [1,2,3],["TSMC","HTC" , "FOXCONN"]  );

$u->addSubmitButton();

$u->endForm();

?>
