<?php
require_once "../include/inner_page_common.php";

echo "<h2>單位列表</h2>";
// display customer browsing data
$t = new DBTableUtility(DEF_DATABASE_HOST,DEF_USER_NAME,DEF_PASSWORD,DEF_DATABASE_NAME);
$keys=  ["id" ,"name"];
$names= ["單位代碼","名稱"];
$t->setColumnFields($keys,$names);

$t->setEditableFields(["name"], "../update/unit_update.php");
$query = 'SELECT unit.id, unit.name from unit order by unit.id';
$t->outputSelectQuery($query);

echo "<br><br>";

?>
</body>
</html>
