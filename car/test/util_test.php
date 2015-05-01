<!DOCTYPE html>
<html>
    <head>
    </head>
<body>

<?php
require_once "../util/util.php";
function do_test()
{
    $link = connectDB("localhost" , "root", "root", "car");
    setConnLang($link,'utf8');
    //$link = @mysqli_connect("localhost" , "root", "root", "car");
    useDB($link,"car");

    $cursor = queryDB($link, "select * from customer");

    echo "<Table>";
    //outputTableRowWithFetchArray($cursor, ["id","name","email"]);
    
    outputTableWithModifyButton($cursor, ["id","name","email"]);
    
    //echo "<td><button type="button"></button></td>";
    
    
    echo "</Table>";
    closeDB($link);
}

do_test();
?>

</body>
</html>
