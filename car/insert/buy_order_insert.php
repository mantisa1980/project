<?php
require_once "../include/inner_page_common.php";
ini_set('display_errors','On');
$json_data = $_POST["json_data"];
$customer_id = $_POST["customer_id"];
$note = $_POST["note"];

if ( empty($customer_id) )
{
	die("input error! customer_id missing!");
}
if ( empty($json_data) )
{
	die("input error! json_data missing!");
}

$json_data = json_decode($json_data,true);
//echo "row count=" + count($json_data)."<br>";
$link = connectCarDB();


// create order 
$stmt = mysqli_prepare($link, "INSERT INTO buy_order(`paid`, `created_on`, `note`, `customer_id`) VALUES (0,NOW(),?,?)");
mysqli_stmt_bind_param($stmt, 'sd', $note, $customer_id);
$r = mysqli_stmt_execute($stmt);
if(!$r)
{
    echo "mysql error:".mysqli_error($link)."<br>";
    mysqli_stmt_close($stmt);
    mysqli_close($link);
    die("Could not insert data");
}

$order_id = mysqli_insert_id($link); // get last inserted auto increment id
//echo "order id=".$order_id;
mysqli_stmt_close($stmt);

foreach($json_data as $d)
{
	//echo "item=".$d["item"]."<br>";
	//echo "unit=".$d["unit"]."<br>";
	//echo "amount=".$d["amount"]."<br>";
	//echo "unit_price=".$d["unit_price"]." ---- <br>";

	$stmt = mysqli_prepare($link, "INSERT INTO buy_order_item(`order_id`,`item_id`,`unit_id`,`unit_amount`,`final_per_unit_price`) VALUES (?,?,?,?,?)");
	mysqli_stmt_bind_param($stmt, 'ddddd', $order_id, $d["item"],$d["unit"],$d["amount"],$d["unit_price"] ); // note : cannot bind const value; put const value in query's VALUES
	$r = mysqli_stmt_execute($stmt);
	if(!$r)
	{
	    echo "mysql error:".mysqli_error($link)."<br>";
	    mysqli_stmt_close($stmt);
	    mysqli_close($link);
	    die("Could not insert data");
	}
	mysqli_stmt_close($stmt);

}

//mysqli_close($link);
echo DEF_INSERT_OK;
echo "<meta http-equiv=\"refresh\" content=\"1;url=../view/customer_view.php\" />";

?>
