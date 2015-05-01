<?php
echo '
<body>
  <div id="container" style="width:1280px;height:1024">
    <div id="header" style="background-color: #33FFFF;height:32px">
      <h2 align="center" style="margin-bottom:0px;"><b>資源管理系統</b></h2>
    </div>

    <div id="menu" style="background-color:#F5F5F5;height:992px;width:200px;float:left;">
      <ul>
        <li><a href="../view/customer_insert_view.php">客戶新增</a></li>
        <li><a href="../view/customer_view.php">客戶查詢 / 修改 / 訂單處理</a></li><br><br>
                
        <li><a href="../view/item_insert_view.php">品項新增</a></li>
        <li><a href="../view/item_update_view.php">品項查詢 / 名稱修改</a></li><br><br>

        <li><a href="../view/group_insert_view.php">群組新增</a></li>
        <li><a href="../view/group_update_view.php">群組查詢 / 名稱修改</a></li><br><br>

        <li><a href="../view/unit_insert_view.php">單位新增</a></li>
        <li><a href="../view/unit_update_view.php">單位查詢 / 名稱修改</a></li><br><br>
        
        <li><a href="../view/order_view.php">訂單總表</a></li><br><br>
        
        <li><a href="../view/price_view.php">售價表查詢 / 修改</a></li><br><br>
        
        <li><a href="../logout.php">登出系統</a></li><br>
      </ul>
    </div>

    <div id="separator" style="background-color:#FFFFFF;height:768px;width:16px;float:left;">
    </div>

  </div>
';
?>
