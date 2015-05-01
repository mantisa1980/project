<?php

if( empty($_POST["__action"]) )
{

}
else
{
    $key        =  $_POST["key"];
    $action    =  $_POST["__action"];
    echo "key posted is:".$key;
    echo "<br>";

    echo "Clicked action is:" . $action;
    echo "<br>";
    echo "result end ";
    exit(0);
}

?>

<Table border=1>
    <th>id</th>
    <tr>
        <form method="post" action="fetch_post_test.php">
            <td><input type="hidden" name="key" value="123">GG</td>
            <td><input type="submit" name="__action" value="Modify"></td>
            <td><input type="submit" name="__action" value="Add"></td>
        </form>
    </tr>
    <tr>
        <form method="post" action="fetch_post_test.php">
            <td><input type="hidden" name="key" value="456">YY</td>
            <td><input type="submit" name="__action" value="Modify"></td>
            <td><input type="submit" name="__action" value="Add"></td>
        </form>
    </tr>
</table>
