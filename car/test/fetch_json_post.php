<?php
ini_set('display_errors','On');
echo "result begin <br>";

$data = json_decode($_POST["data"],true);
echo gettype($data)."<br>";
/*
echo $data["A"]."<br>";
echo $data["B"][0]["X"]."<br>";
echo $data["B"][0]["Y"]."<br>";
echo $data["B"][1]["X"]."<br>";
echo $data["B"][1]["Y"]."<br>";
*/
echo $data[0]["X"]."<br>";
echo $data[0]["Y"]."<br>";

echo "<br>";

echo "result end ";
?>
