<?php

require_once "../const/define.php";

session_start();
if(empty( $_SESSION[DEF_SESSION_PARAM_LOGIN]))
{
   
	echo '<!DOCTYPE html>
	<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	</head>';
   echo("<h1>認證失效,請重新登入!</h1>");
   echo "<meta http-equiv=\"refresh\" content=\"2; url=../login.php \" />";
   exit();
}
?>
