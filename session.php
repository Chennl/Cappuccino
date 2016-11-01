<?php
	include 'config.php';
	session_start();
	/*
		$user_check = $_SESSION['login_user'];
		$rsult = mysqli_query($db, "select username from dt_user where username='$user_check'");
		$row = mysqli_fetch_array($result, MYSQL_ASSOC);
		$login_session = $row['username'];
	*/
	
	if(!isset($_SESSION['login_user'])){
		header("location:login.php");
	}else{
		$login_session = $_SESSION['login_user'];
	}
?>