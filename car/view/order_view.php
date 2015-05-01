<?php
require_once "../include/inner_page_common.php";

// buy_order
echo "<h2>未完成買入訂單總表</h2>";

$t = new DBTableUtility(DEF_DATABASE_HOST,DEF_USER_NAME,DEF_PASSWORD,DEF_DATABASE_NAME);
$keys=  ["order_id","cname"   ,"paid" , "__total" ,"created_on", "note"];
$names= ["訂單代碼","客戶名稱","已付" , "應付"    ,"建立時間"  , "備註"];
$t->setColumnFields($keys,$names);
$t->addLinkInfo("buy_order_update_view.php","更新訂單");
$t->addLinkInfo("../delete/buy_order_delete.php","刪除訂單","注意!總支出將會扣除該訂單支出,確認刪除?");

$query ='SELECT buy_order.id AS order_id,
 customer.name AS cname,
 buy_order.paid,
 sum(buy_order_item.unit_amount*buy_order_item.final_per_unit_price) AS __total,
 buy_order.created_on,buy_order.note
 FROM buy_order
 JOIN buy_order_item ON buy_order.id = buy_order_item.order_id
 JOIN customer ON buy_order.customer_id = customer.id
 GROUP BY buy_order_item.order_id
 HAVING buy_order.paid < __total
 ORDER BY buy_order.created_on ASC
';
$t->outputSelectQuery($query);
echo "<br><br><hr>";

// sel_order
echo "<h2>未完成賣出訂單總表</h2>";
$t->clear();
//$t = new DBTableUtility(DEF_DATABASE_HOST,DEF_USER_NAME,DEF_PASSWORD,DEF_DATABASE_NAME);
$keys=  ["order_id","cname"   , "paid" , "__total" ,"created_on", "note"];
$names= ["訂單代碼","客戶名稱", "已付" , "應付"    ,"建立時間"  , "備註"];
$t->setColumnFields($keys,$names);
$t->addLinkInfo("sell_order_update_view.php","更新訂單");
$t->addLinkInfo("../delete/sell_order_delete.php","刪除訂單","注意!總收入將會扣除該訂單收入,確認刪除?");

$query ='SELECT sell_order.id AS order_id,
 customer.name AS cname,
 sell_order.paid,
 sum(sell_order_item.unit_amount*sell_order_item.final_per_unit_price) AS __total,
 sell_order.created_on,sell_order.note
 FROM sell_order
 JOIN sell_order_item ON sell_order.id = sell_order_item.order_id
 JOIN customer ON sell_order.customer_id = customer.id
 GROUP BY sell_order_item.order_id
 HAVING sell_order.paid < __total
 ORDER BY sell_order.created_on ASC
';
$t->outputSelectQuery($query);
echo "<br><br><hr>";


// buy statistics 
 
echo "<h2>買入訂單總值</h2>";
$t->clear();
$keys=  ["TOTAL"];
$names= ["買入總花費"];
$query = 'SELECT COALESCE(sum(order_total),0) AS TOTAL FROM 
 ( SELECT sum(buy_order_item.unit_amount*buy_order_item.final_per_unit_price) AS order_total FROM buy_order_item GROUP BY buy_order_item.order_id
 ) AS derived';
$t->setColumnFields($keys,$names);
$t->outputSelectQuery($query);

$result_data = $t->getLastQueryData();
$buy_total = 0;
if( count( $result_data ) > 0 )
{
	$buy_total = $result_data[0]["TOTAL"];
}

echo "<br><br><hr>";
// sell statistics
echo "<h2>賣出訂單總值</h2>";
$t->clear();
$keys=  ["TOTAL"];
$names= ["賣出總收入"];
$query = 'SELECT COALESCE( sum(order_total),0 ) AS TOTAL FROM 
 ( SELECT sum(sell_order_item.unit_amount*sell_order_item.final_per_unit_price) AS order_total FROM sell_order_item GROUP BY sell_order_item.order_id
 ) AS derived';
$t->setColumnFields($keys,$names);
$t->outputSelectQuery($query);

echo "<br><br><hr>";

$result_data = $t->getLastQueryData();
$sell_total = 0;
if( count( $result_data ) > 0 )
{
	$sell_total = $result_data[0]["TOTAL"];
}

$profit = $sell_total - $buy_total;

if($profit > 0)
{
	echo "<h3>淨利:<font color=green>". $profit."</h3></font>" ;
}
else
{
	echo "<h3>淨利:<font color=red>". $profit."</h3></font>" ;
}

echo "<br><br>";
?>

</body>
</html>
