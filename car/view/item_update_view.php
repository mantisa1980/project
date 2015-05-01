<?php
require_once "../include/inner_page_common.php";
echo "<h2>品項列表</h2>";
// display customer browsing data

$pageNo = !empty($_GET["PageNo"])?$_GET["PageNo"]:0;


$t = new DBTableUtility(DEF_DATABASE_HOST,DEF_USER_NAME,DEF_PASSWORD,DEF_DATABASE_NAME);
$keys=  ["id" ,"name"];
$names= ["品項代碼","名稱"];
$t->setColumnFields($keys,$names);

$t->setEditableFields(["name"], "../update/item_update.php");
//$t->addLinkInfo("../update/item_update.php","送出");

$query = 'SELECT item.id, item.name from item order by item.id';
//$t->setPaging(DEF_PAGING_SIZE,$pageNo); // demark if you wanna try paging ... 
$t->outputSelectQuery($query);


//$paging = new PagingUtility("item_update_view.php", "PageNo", ceil($t->getTotalLimitRowCount()/DEF_PAGING_SIZE)-1 );
//$paging->setCurrentPageNo($pageNo);
//$paging->outputHTML();

echo "<br><br>";

?>


</body>
</html>
