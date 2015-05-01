<?php
require_once "../include/inner_page_common.php";
echo '<h2>新增單位</h2>
    ';

$u = new FormInputUtility();
$u->beginForm("../insert/unit_insert.php");
$u->addInputText("name", "單位名稱");
$u->addSubmitButton();
$u->endForm();

?>
</body>
</html>
