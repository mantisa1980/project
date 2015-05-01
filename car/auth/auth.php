<?php

session_start();

require_once "../const/define.php";
require_once "../util/util.php";
require_once "../config/html_header_common.php";

if(empty( $_SESSION[DEF_SESSION_PARAM_LOGIN]))
{
    $account = $_POST['account'];
    $password = $_POST['password'];
    //
    $link = connectCarDB();
    $cursor = queryDB($link, "select * from user where account='".$account."' and password='".$password."'");
    $user_info = mysqli_fetch_array($cursor);
    if ( getQueryCount($cursor) > 0 )
    {
        $_SESSION['login'] = 1;
        echo "<h2>登入成功!</h2>";
        outputRedirect("../".DEF_INNER_ENTRY_PAGE , 2);
    }
    else
    {
        echo "<h2>登入失敗!</h2>";
        outputRedirect("../login.php", 2);
    }
    mysqli_free_result($cursor);
    closeDB($link);
}
else
{
    echo "<h2>您已登入系統!</h2>";
    outputRedirect("../".DEF_INNER_ENTRY_PAGE , 2);
}

?>

</body>
</html>