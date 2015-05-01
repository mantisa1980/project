<?php
require_once "../include/inner_page_common.php";
echo "<h2>群組列表</h2>";
// display customer browsing data
$t = new DBTableUtility(DEF_DATABASE_HOST,DEF_USER_NAME,DEF_PASSWORD,DEF_DATABASE_NAME);
$keys=  ["id" ,"name"];
$names= ["群組代碼","名稱"];
$t->setColumnFields($keys,$names);

$t->setEditableFields(["name"], "../update/group_update.php");
$query = 'SELECT groups.id, groups.name from groups order by groups.id';
$t->outputSelectQuery($query);

echo "<br><br>";

?>
</body>
</html>
