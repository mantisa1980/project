<?php
//require_once "config/html_header_common.php";

session_start();

if (ini_get("session.use_cookies")) 
{
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

session_destroy();

require_once "config/html_header_common.php";

echo "<h2>您已登出系統!</h2>";
echo "<meta http-equiv=REFRESH CONTENT=\"2;url=login.php\" >";
?>
