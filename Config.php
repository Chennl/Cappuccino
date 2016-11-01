<?php 
define('DB_SERVER','localhost:3306');
define('DB_USERNAME','my3709549');
define('DB_PASSPWORD','gbjy2015');
define('DB_DATABASE','my3709549');
$db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSPWORD,DB_DATABASE);
if(mysqli_connect_errno()){
	printf("Connect failed:%s\n",mysqli_connect_error());
	exit();
}
if (!mysqli_set_charset($db,"utf8")) {
    printf("Error loading character set utf8: %s\n", mysqli_error($db));
    exit();
}
?>