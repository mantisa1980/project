<?php
require_once "../include/inner_page_common.php";
echo '<h2>新增品項</h2>
    ';

$u = new FormInputUtility();
$u->beginForm("../insert/item_insert.php");
$u->addInputText("name", "品項名稱");
$u->addSubmitButton();
$u->endForm();

?>
</body>
</html>
