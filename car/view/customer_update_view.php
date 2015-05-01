<?php
require_once "../include/inner_page_common.php";

$id        =  $_POST["id"];
$name      =  $_POST["name"];
$company   =  $_POST["company"];
$vat       =  $_POST["vat"];
$address   =  $_POST["address"];
$phone     =  $_POST["phone"];
$cellphone =  $_POST["cellphone"];
$cellphone2=  $_POST["cellphone2"];
$email     =  $_POST["email"];
$group_id  =  $_POST["group_id"];

if( empty($id) ) // "" empty string is also empty;
{
    die("data input error! id missing !");
}

//
$u = new FormInputUtility();
echo "<h2>修改客戶資料</h2>";
$u->beginForm("../update/customer_update.php");
$u->addHiddenInput("id",$id);
$u->addInputText("name", "姓名" , $name);
$u->addInputText("company", "公司" , $company);
$u->addInputText("vat", "統編" , $vat);
$u->addInputText("address", "地址" , $address);
$u->addInputText("phone", "電話" , $phone);
$u->addInputText("cellphone", "手機號碼1" , $cellphone);
$u->addInputText("cellphone2", "手機號碼2" , $cellphone2);
$u->addInputText("email", "Email" , $email);

// fetch groups
$db_util = new DBUtility(DEF_DATABASE_HOST,DEF_USER_NAME,DEF_PASSWORD,DEF_DATABASE_NAME);
$group_query_result = $db_util->getQueryData("select id,name from groups");
$group_ids   = [];
$group_names = [];

$found=false;
$default_index = 0;

foreach($group_query_result as $i)
{
   //echo $i["id"].$i["name"]."<br>";
   array_push($group_ids,$i["id"]);
   array_push($group_names,$i["name"]);

   // find current customer's group value
   if( !$found )
   {
       if($i["id"] == $group_id)
       {
           $found=true;
       }
       else
       {
           $default_index+=1;
       }
   }
}

$u->addSelection("group_id","群組" , $group_ids,$group_names,$default_index); // $group_id as default selected
$u->addSubmitButton();
$u->endForm();


echo "<br><br>";
?>

</body>
</html>
