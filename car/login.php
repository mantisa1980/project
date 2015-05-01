<?php
ini_set('display_errors','On');
session_start();

require_once "const/define.php";
require_once "util/util.php";
require_once "config/html_header_common.php";

if(empty( $_SESSION[DEF_SESSION_PARAM_LOGIN]) )
{
    echo '
    <body>
        <h2>資源管理系統</h2>
        <form method="post" action="auth/auth.php">
            <table>
                <tr>
                    <th>帳號</th>
                    <td> <input type="text" name="account"> </td>
                </tr>
                <tr>
                    <th>密碼</th>
                    <td> <input type="password" name="password"> </td>
                </tr>
                <tr>
                    <td colspan="2" align="center"> 
                        <input type="submit" value="登入">
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>
';
}
else
{
    echo "<h2>您已登入系統!</h2>";
    outputRedirect(DEF_INNER_ENTRY_PAGE , 2);
}

?>
