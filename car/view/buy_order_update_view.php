<?php
require_once "../include/inner_page_common.php";
$order_id = $_POST["order_id"];
if( empty($order_id) )
{
    die("data input error! order_id missing !");
}

//DBTableUtility
echo "<h2>訂單明細</h2>";
$t = new DBTableUtility(DEF_DATABASE_HOST,DEF_USER_NAME,DEF_PASSWORD,DEF_DATABASE_NAME);
$keys=  ["__iname","__uname","__ua","__up"];
$names= ["品項","單位","單位數量","單位售價"];
$query = 'SELECT item.name AS __iname, unit.name AS __uname, buy_order_item.unit_amount AS __ua, buy_order_item.final_per_unit_price AS __up
 FROM buy_order_item JOIN buy_order ON buy_order_item.order_id=buy_order.id
 JOIN item ON buy_order_item.item_id = item.id
 JOIN unit ON buy_order_item.unit_id = unit.id
 where buy_order_item.order_id='.$order_id;
$t->setColumnFields($keys,$names);
$t->outputSelectQuery($query);

$result_data = $t->getLastQueryData();
$total = 0;
foreach($result_data as $i)
{
	$total+=$i["__ua"]*$i["__up"];
}
echo "<br>";
echo "總價格=<b>".$total."</b>";

echo "<br><br>";

echo "<h2>修改買入訂單</h2>";
$du = new DBUtility(DEF_DATABASE_HOST,DEF_USER_NAME,DEF_PASSWORD,DEF_DATABASE_NAME);
$result = $du->getQueryData('SELECT paid,note from buy_order where id='.$order_id);

if( count($result) !=1 )
{
    die("order_id query error!".order_id);
}

$u = new FormInputUtility();
$u->beginForm("../update/buy_order_update.php");
$u->addInputText("paid", "已付" , $result[0]["paid"]);
//$u->addInputText("note", "備註" , $result[0]["note"]);
$u->addTextArea("note", "備註" , $result[0]["note"]);
$u->addHiddenInput("order_id",$order_id);
$u->addSubmitButton();
$u->endForm();

// get all item options

echo "<br><br><br>";

echo "</body></html>";


?>
