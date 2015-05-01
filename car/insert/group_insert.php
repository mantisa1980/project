<?php
require_once "../include/inner_page_common.php";

$name = $_POST["name"];

if( empty($name) ) // "" empty string is also empty;
{
    die("data input error! name missing !");
}

$link = connectCarDB();
$stmt = mysqli_prepare($link, "INSERT INTO groups(`name`) VALUES (?)");
mysqli_stmt_bind_param($stmt, 's', $name);
$r = mysqli_stmt_execute($stmt);

if(!$r)
{
    echo "mysql error:".mysqli_error($link)."<br>";
    mysqli_stmt_close($stmt);
    mysqli_close($link);
    die("Could not insert data");
}
$new_insert_id = mysqli_insert_id($link);  // get last inserted AUTO INCREMENT ID of this connection
mysqli_stmt_close($stmt);

$du = new DBUtility(DEF_DATABASE_HOST,DEF_USER_NAME,DEF_PASSWORD,DEF_DATABASE_NAME);
// get all group_id, unit_id combinations
$query='SELECT item.id AS item_id, unit.id AS unit_id FROM item, unit GROUP BY item_id, unit_id';
$result = $du->getQueryData($query);

foreach ($result as $i)
{
	$item_id = $i["item_id"];
	$unit_id = $i["unit_id"];
	//print "group id=".$group_id."<br>";
	//print "unit_id=".$unit_id."<br>";
	//print "item_id=".$new_insert_id."<br>";
	$stmt = mysqli_prepare($link, "INSERT INTO price(`group_id`,`item_id`,`unit_id`,`buy_price`, `sell_price`) VALUES (?,?,?,0,0)");
	
	mysqli_stmt_bind_param($stmt, 'ddd', $new_insert_id, $item_id ,$unit_id);
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

mysqli_close($link);
echo DEF_INSERT_OK;
echo "<meta http-equiv=\"refresh\" content=\"1;url=../view/price_view.php\" />"; // redirect after 3 seconds

?>
