<!DOCTYPE HTML>
<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style type="text/css">
body {
    font-family: -apple-system-font,Helvetica Neue,Helvetica,sans-serif;
}
.page, body {
    background-color: #f8f8f8;
}
.page__ft img {
    height: 19px;
}
.page__ft {
    text-align: center;
    padding-bottom: 10px;
    padding-top: 40px;
    text-align: center;
}
</style>
<link rel="stylesheet" href="css/weui.css"/>
<title>登录</title>
</head>
<?php 
include('config.php');
session_start(); 	
if(isset($_POST['submit'])){
	$username=mysqli_real_escape_string($db,$_POST['username']);
	$password=mysqli_real_escape_string($db,$_POST['password']);
	//$username=$_POST['name'];
	$sql = "SELECT id, password  FROM dt_user where username='$username';";
	$result=mysqli_query($db,$sql);
	//$row = mysqli_fetch_array($result,MYSQL_ASSOC);
	//$active =$row['active'];
	$count = mysqli_num_rows($result);
	 if($count==1){
		 $_SESSION['login_user']=$username;
		 header('location: query.php');
	 }
	 else
	 {
		 $error = "你的用户名或密码不正确！";
	 }
//		echo "User has submitted the form and entered this name:<b> $name</b>";
//		echo "<br> You can use th following form again to enter a new name";
}
 
?>
<body ontouchstart=''>

<div class="page">
	<div class="page__hd">
        <h1 class="page__title">登录</h1>
    </div>
	<div class="page__bd page__bd_spacing">
	  <form method = "post" action = "<?php echo htmlentities($_SERVER["PHP_SELF"]);?>" id='loginform'>
	  <div class="weui-cells weui-cells_form">
            <div class="weui-cell">
                <div class="weui-cell__hd"><label class="weui-label">用户ID</label></div>
                <div class="weui-cell__bd">
                    <input class="weui-input" type="text" name='username' placeholder="请输入用户ID">
                </div>
            </div>
            <div class="weui-cell">
                <div class="weui-cell__hd"><label class="weui-label">密码</label></div>
                <div class="weui-cell__bd">
                    <input class="weui-input" type="password" name ="password" placeholder="请输入密码">
                </div>
            </div>

        </div>
         <label class="weui-agree" for="weuiAgree">
            <input type="checkbox" class="weui-agree__checkbox" id="weuiAgree">
            <span class="weui-agree__text">
                阅读并同意<a href="javascript:void(0);">《相关条款》</a>
            </span>
        </label>
    <div class="weui-btn-area">
            <button class="weui-btn weui-btn_primary"  name="submit" id="submit">确定</button>
    </div>
		  </form>		   
	</div>
	<div class="page__ft">
        <a href="javascript:home()"><img src="./images/icon_footer_link.png"></a>
    </div>
 </div>    
 
 </body>
 <?php mysql_close($conn); ?>
</html>
<script src="./zepto.min.js"></script>
<script type="text/javascript" src="./jweixin-1.0.0.js"></script>