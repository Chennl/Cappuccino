<!DOCTYPE html>
<?php 
ob_start();
//session_start();
?>
<html>
<head>
<meta charset="UTF-8">
<title>Tutorialspoint.com</title>
<link href="css/bootstrap.min.css" rel="stylesheet">

<style>
body {
	padding-top: 40px;
	padding-bottom: 40px;
	background-color: #FFF;
}

.form-signin {
	max-width: 330px;
	padding: 15px;
	margin: 0 auto;
	color: #017572;
}

.form-signin .form-signin-heading, .form-signin .checkbox {
	margin-bottom: 10px;
}

.form-signin .checkbox {
	font-weight: normal;
}

.form-signin .form-control {
	position: relative;
	height: auto;
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	box-sizing: border-box;
	padding: 10px;
	font-size: 16px;
}

.form-signin .form-control:focus {
	z-index: 2;
}

.form-signin input[type="email"] {
	margin-bottom: -1px;
	border-bottom-right-radius: 0;
	border-bottom-left-radius: 0;
	border-color: #017572;
}

.form-signin input[type="password"] {
	margin-bottom: 10px;
	border-top-left-radius: 0;
	border-top-right-radius: 0;
	border-color: #017572;
}

h2 {
	text-align: center;
	color: #017572;
}
</style>

</head>

<body>
<?php
$dbserver="";
$mysql_connect("");
 ?>
	<h2>查询登录</h2>
	<div class="container form-signin">
         
         <?php
			$msg = '';		
			if (isset ( $_POST ['login'] ) && ! empty ( $_POST ['username'] ) && ! empty ( $_POST ['password'] )) {
				
				$name =$_POST ['username'];
				$password=$_POST ['password'];
				
				if ($_POST ['username'] == 'php' && $_POST ['password'] == '1234') {
					$_SESSION ['valid'] = true;
					$_SESSION ['timeout'] = time ();
					$_SESSION ['username'] = $_POST ['username'];
					$_SESSION['password'] = $_POST['password'];
					
					echo 'You have entered valid use name and password';
				} else {
					$msg = 'Wrong username or password';
				}
			}
			?>
      </div>
	<!-- /container -->

	<div class="container">

		<form class="form-signin" role="form"
			action="<?php echo htmlspecialchars ( $_SERVER ['PHP_SELF'] ); ?>" method="post">
			<h4 class="form-signin-heading"><?php echo $msg; ?></h4>
			<input type="text" class="form-control" name="username"
				placeholder="请输入用户名" required autofocus></br> <input
				type="password" class="form-control" name="password"
				placeholder="请输入密码" required>
			<button class="btn btn-lg btn-primary btn-block" type="submit"
				name="login">登录</button>
		</form>

		Click here to clean <a href="logout.php" tite="Logout">Session. 
	
	</div>

</body>

</html>
<?php   //ob_end_flush();?>