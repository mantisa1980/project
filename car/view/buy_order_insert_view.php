<?php
require_once "../include/inner_page_common.php";
$customer_id = $_POST["id"];
if( empty($customer_id) )
{
    die("data input error! customer_id missing !");
}

echo "<h2>新增購入訂單</h2>";
echo "<h3>客戶資料</h3>";
// display customer data 
$t = new DBTableUtility(DEF_DATABASE_HOST,DEF_USER_NAME,DEF_PASSWORD,DEF_DATABASE_NAME);
$keys=  ["id","name","company","vat", "address", "phone","cellphone","cellphone2", "email","group_id" ,"__gname" ];  //__gname will be passed to modify page; use __ to mean joined, non-used for-view-only data
$names= ["客戶代碼","姓名","公司","統編", "地址", "電話","手機號碼1","手機號碼2", "Email","群組ID", "群組名稱" ];
$t->setColumnFields($keys,$names);
$t->outputSelectQuery('select customer.*, groups.name AS __gname from customer JOIN groups ON customer.group_id = groups.id where customer.id='.$customer_id);

// display price table
echo "<br><br>";
echo "<h3>客戶群組價目參考表</h3>";
$t->clear();
$keys=  ["item_name","unit_name","buy_price"];
$names= ["品項","單位","購買價格"];
$t->setColumnFields($keys,$names);

$query = 'select item.name AS item_name, unit.name AS unit_name, price.buy_price, customer.name as __cname from price JOIN customer ON price.group_id = customer.group_id JOIN item on price.item_id=item.id JOIN unit ON price.unit_id=unit.id where customer.id ='.$customer_id.' ORDER BY item_name' ;
$t->outputSelectQuery($query);

// get all item options

$du = new DBUtility(DEF_DATABASE_HOST,DEF_USER_NAME,DEF_PASSWORD,DEF_DATABASE_NAME);

$item_html_str="";
$result = $du->getQueryData('SELECT id,name from item order by id ASC');
foreach($result as $i)
{
    $item_html_str=$item_html_str.'<option value="'.$i["id"].'">'.$i["name"].'</option>';
}

// get all unit options

$unit_html_str="";
$result = $du->getQueryData('SELECT id,name from unit order by id ASC');
foreach($result as $i)
{
     $unit_html_str=$unit_html_str.'<option value="'.$i["id"].'">'.$i["name"].'</option>';
}

echo "<br><br>";
// output first input row, which is also a clone template 
echo '
        <form id="form"  method="post" action="../insert/buy_order_insert.php">
            <h3>輸入訂單資料</h3>
            
            <input type="hidden" name="customer_id" value="'.$customer_id.'">
            <br><br>
            <table>
                <thead>
                    <tr>
                        <th>品項</th>
                        <th>單位</th>
                        <th>單位數量</th>
                        <th>單位價格</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                    <tr id="tr0">

                        <td><select name="item" class="item">'.$item_html_str.'
                        </select></td>

                        <td><select name="unit" class="unit">'.$unit_html_str.'
                        </select></td>
                        <td><input type="text" class="amount"> </td>
                        <td><input type="text" class="unit_price"> </td>
                    </tr>
                </tbody>
            </table>
            <br><br>
            <textarea id="note" name="note" rows="4" cols="100">備註文字</textarea>
            <br>
            <input type="button" style="width:100px;height:30px" value="新增一列" onClick="on_add_input_row()">
            <input type="button" style="width:100px;height:30px" value="送出" onClick="on_submit_order_insert()">
        </form>
    </body>
</html>
    ';

echo "<br><br>";

$js_src = file_get_contents("../js/dynamic_input_util.js");
echo $js_src;

?>
