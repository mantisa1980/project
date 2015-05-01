<?php
require_once "../include/inner_page_common.php";
echo '<h2>新增群組</h2>
    ';

$u = new FormInputUtility();
$u->beginForm("../insert/group_insert.php");
$u->addInputText("name", "群組名稱");
$u->addSubmitButton();
$u->endForm();
?>

</body>
</html>
