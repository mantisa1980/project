<?php
require_once "../include/inner_page_common.php";


$search  = NULL;
$query   = NULL;

if ( array_key_exists('search', $_POST) )
{
	$search = $_POST["search"];
}

if( empty($search))
{
	// default
	$query = "select customer.*, groups.name AS __gname from customer JOIN groups ON customer.group_id = groups.id ORDER BY customer.id ASC";
}
else
{
	$query = "select customer.*, groups.name AS __gname from customer JOIN groups ON customer.group_id = groups.id WHERE customer.name LIKE '%".$search."%' ORDER BY customer.id ASC";
}

echo "<br>";
// display search box
$u = new FormInputUtility();
$u->setAutoBr(false);
$u->beginForm("customer_view.php");
$u->addInputText("search", "搜尋姓名");
$u->addSubmitButton("搜尋",false);
$u->endForm();

if( !empty($search))
{
	echo "<br><br><h2>[ ".$search." ]搜尋結果</h2>";
}
else
{
	echo "<br><br><h2>客戶列表</h2>";
}

// display customer browsing data
$t = new DBTableUtility(DEF_DATABASE_HOST,DEF_USER_NAME,DEF_PASSWORD,DEF_DATABASE_NAME);
$keys=  ["id"      ,"name","company","vat" , "address","phone","cellphone","cellphone2", "email","group_id" ,"__gname" ];  //__gname will be passed to modify page; use __ to mean joined, non-used for-view-only data
$names= ["客戶代碼","姓名","公司"   ,"統編", "地址"   ,"電話" ,"手機號碼1","手機號碼2" , "Email","群組ID"   ,"群組名稱"];
$t->setColumnFields($keys,$names);
$t->setHiddenFields(["id","group_id"]); // display names are ignored if set hidden

$t->addLinkInfo("customer_update_view.php","修改客戶資料");
$t->addLinkInfo("../delete/customer_delete.php","刪除客戶", "注意!所有相關訂單會一併刪除!");
$t->addLinkInfo("customer_order_view.php","訂單處理");

$t->outputSelectQuery($query);

echo "<br><br>";

?>


</body>
</html>
