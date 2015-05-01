<?php
require_once "../include/inner_page_common.php";
echo "<h2>未定價品項列表</h2>";
$t = new DBTableUtility(DEF_DATABASE_HOST,DEF_USER_NAME,DEF_PASSWORD,DEF_DATABASE_NAME);

$keys=  ["group_id","__gname","item_id","__iname", "unit_id", "__uname","buy_price","sell_price"];
$names= ["群組代碼","群組名稱","品項代碼","品項名稱", "單位代碼", "單位名稱", "買入價格", "賣出價格"];
$t->setColumnFields($keys,$names);
$t->setHiddenFields(["group_id","item_id","unit_id"]); // display names are ignored if set hidden
//$t->addLinkInfo("price_update_view.php","修改價格");
$t->setEditableFields(["buy_price","sell_price"] , "../update/price_update.php", "編輯售價");
$query ='SELECT price.group_id, groups.name AS __gname, price.item_id, item.name AS __iname, price.unit_id, unit.name AS __uname, price.buy_price, price.sell_price
FROM price
 JOIN groups ON price.group_id = groups.id
 JOIN item ON price.item_id = item.id
 JOIN unit ON price.unit_id = unit.id 
 WHERE price.buy_price = 0 OR price.sell_price = 0
 ORDER BY price.group_id,price.item_id,price.unit_id';

$t->outputSelectQuery($query);

//if( count($t->getLastQueryData()) == 0 )
//{
//	echo "無未定義資料";
//}
echo "<br><hr>";
echo "<h2>已定價品項列表</h2>";

$t->clear();
$keys=  ["group_id","__gname","item_id","__iname", "unit_id", "__uname","buy_price","sell_price"];
$names= ["群組代碼","群組名稱","品項代碼","品項名稱", "單位代碼", "單位名稱", "買入價格", "賣出價格"];
$t->setColumnFields($keys,$names);
$t->setHiddenFields(["group_id","item_id","unit_id"]); // display names are ignored if set hidden
//$t->addLinkInfo("price_update_view.php","修改價格");
$t->setEditableFields(["buy_price","sell_price"] , "../update/price_update.php", "編輯售價");
$query ='SELECT price.group_id, groups.name AS __gname, price.item_id, item.name AS __iname, price.unit_id, unit.name AS __uname, price.buy_price, price.sell_price
 FROM price
 JOIN groups ON price.group_id = groups.id
 JOIN item ON price.item_id = item.id
 JOIN unit ON price.unit_id = unit.id
 WHERE price.buy_price > 0 and price.sell_price > 0
 ORDER BY price.group_id,price.item_id,price.unit_id';
$t->outputSelectQuery($query);



echo "<br><br>";

?>


</body>
</html>
