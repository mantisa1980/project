<?php
require_once "../include/inner_page_common.php";
$customer_id = $_POST["id"];
if( empty($customer_id) )
{
    die("data input error! customer_id missing !");
}
echo "<h2>客戶資料</h2>";

$t = new DBTableUtility(DEF_DATABASE_HOST,DEF_USER_NAME,DEF_PASSWORD,DEF_DATABASE_NAME);
$keys=  ["id"      ,"name","company","vat" , "address", "phone","cellphone","cellphone2", "email","group_id" ,"__gname"  ];  //__gname will be passed to modify page; use __ to mean joined, non-used for-view-only data
$names= ["客戶代碼","姓名","公司"   ,"統編", "地址"   , "電話" ,"手機號碼1","手機號碼2" , "Email","群組ID"   , "群組名稱"];
$t->setColumnFields($keys,$names);
$t->setHiddenFields(["id" , "group_id"]);
$t->addLinkInfo("buy_order_insert_view.php","新增買入訂單");
$t->addLinkInfo("sell_order_insert_view.php","新增賣出訂單");
$t->outputSelectQuery('select customer.*, groups.name AS __gname from customer JOIN groups ON customer.group_id = groups.id where customer.id='.$customer_id);


// ================= buy orders
echo "<h4>買入訂單列表</h4>";
//$t = new DBTableUtility(DEF_DATABASE_HOST,DEF_USER_NAME,DEF_PASSWORD,DEF_DATABASE_NAME);

$t->clear();
$keys=  ["order_id","paid" , "__total" ,"created_on", "note"];
$names= ["訂單代碼","已付" , "應付"    ,"建立時間"  , "備註"];
$t->setColumnFields($keys,$names);
$t->addLinkInfo("buy_order_update_view.php","更新訂單");
$t->addLinkInfo("../delete/buy_order_delete.php","刪除訂單","注意!總支出將會扣除該訂單支出,確認刪除?");

$query ='SELECT buy_order.id AS order_id,buy_order.paid, sum(buy_order_item.unit_amount*buy_order_item.final_per_unit_price) AS __total, buy_order.created_on,buy_order.note
FROM buy_order
JOIN buy_order_item ON buy_order.id = buy_order_item.order_id
WHERE buy_order.customer_id = '.$customer_id.'
 group by buy_order_item.order_id
 ORDER BY buy_order.created_on ASC
';

$t->outputSelectQuery($query);
echo "<br><br>";

// ================= sell order
echo "<h4>賣出訂單列表</h4>";
//$t = new DBTableUtility(DEF_DATABASE_HOST,DEF_USER_NAME,DEF_PASSWORD,DEF_DATABASE_NAME);

$t->clear();
$keys=  ["order_id","paid" , "__total" ,"created_on", "note"];
$names= ["訂單代碼","已付" , "應付"    ,"建立時間"  , "備註"];
$t->setColumnFields($keys,$names);
$t->addLinkInfo("sell_order_update_view.php","更新訂單");
$t->addLinkInfo("../delete/sell_order_delete.php","刪除訂單","注意!總收入將會扣除該訂單收入,確認刪除?");



$query ='SELECT sell_order.id AS order_id,sell_order.paid, sum(sell_order_item.unit_amount*sell_order_item.final_per_unit_price) AS __total, sell_order.created_on,sell_order.note
FROM sell_order
JOIN sell_order_item ON sell_order.id = sell_order_item.order_id
WHERE sell_order.customer_id = '.$customer_id.'
 group by sell_order_item.order_id
 ORDER BY sell_order.created_on ASC
';

$t->outputSelectQuery($query);
echo "<br><br>";

?>

</body>
</html>
