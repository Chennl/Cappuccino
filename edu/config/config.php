<?php 
 define('DB_SERVER','localhost');
//define('DB_SERVER','my3709549.xincache1.cn');
define('DB_USERNAME','my3709549');
define('DB_PASSPWORD','gbjy2015');
define('DB_DATABASE','my3709549');
$dblink = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSPWORD,DB_DATABASE);
if(mysqli_connect_errno()){
	printf("Connect failed:%s\n",mysqli_connect_error());
	exit();
}
if (!mysqli_set_charset($dblink,"utf8")) {
    printf("Error loading character set utf8: %s\n", mysqli_error($db));
    exit();
}
?>