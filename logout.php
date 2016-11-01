<?php
session_start();
/*unset($_SESSION["username"]);
unset($_SESSION["password"]);
unset($SESSION["valid"]);
echo 'You have cleaned session';
header('Refresh:2; URL = login.php');*/
if(session_destroy()){
	header('location:login.php');
}
?>