<?php
ini_set('display_errors','On');


$json_data = $_POST["json_data"];

if ( empty($json_data) )
{
	die("input error! json_data missing!");
}
$json_data = json_decode($json_data,true);

echo "row count=" + count($json_data)."<br>";

foreach($json_data as $d)
{
	echo "item=" + $d["item"]."<br>";
	echo "unit=" + $d["unit"]."<br>";
	echo "amount=" + $d["amount"]."<br>";
	echo "unit_price=" + $d["unit_price"]."<br>";
}
?>
