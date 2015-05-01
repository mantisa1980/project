<?php
require_once "../include/inner_page_common.php";
?>

<?php
echo "<h2>新增客戶資料</h2>";
$u = new FormInputUtility();
$u->beginForm("../insert/customer_insert.php");
$u->addInputText("name", "姓名");
$u->addInputText("company", "公司");
$u->addInputText("vat", "統編");
$u->addInputText("address", "地址");
$u->addInputText("phone", "電話");
$u->addInputText("cellphone", "手機號碼1");
$u->addInputText("cellphone2", "手機號碼2");
$u->addInputText("email", "Email");

$db_util = new DBUtility(DEF_DATABASE_HOST,DEF_USER_NAME,DEF_PASSWORD,DEF_DATABASE_NAME);
$group_query_result = $db_util->getQueryData("select id,name from groups");

$group_ids   = [];
$group_names = [];
foreach($group_query_result as $i)
{
   //echo $i["id"].$i["name"]."<br>";
   array_push($group_ids,$i["id"]);
   array_push($group_names,$i["name"]);
}

$u->addSelection("group_id","群組" , $group_ids,$group_names);
$u->addSubmitButton();
$u->endForm();

?>

</body>
</html>
