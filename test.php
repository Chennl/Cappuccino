<!DOCTYPE HTML>
<?php 
//include 'session.php';
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Insert title here</title>
</head>
    <body><?php
define('DB_SERVER','localhost:3306');
define('DB_USERNAME','my3709549');
define('DB_PASSPWORD','gbjy2015');
define('DB_DATABASE','my3709549');
$link = mysqli_connect('localhost','my3709549', 'gbjy2015', 'my3709549', '3306');
/* check connection*/
if(mysqli_connect_errno()){
	printf("Connect failed:%s\n",mysqli_connect_error());
	exit();
}
printf("Initial character set:%s\n",mysqli_character_set_name($link));
/* change character set to utf8 */
if (!mysqli_set_charset($link,"utf8")) {
    printf("Error loading character set utf8: %s\n", mysqli_error($link));
    exit();
} else {
    printf("Current character set: %s\n", mysqli_character_set_name($link));
}
$SELECT_WHAT=" accountdate,description,category,amount,accounttype ";
$WHICH_TBL=" dt_statement ";
$ON_WHAT_CONDITION="accountdate between '2016-5-1' and '2016-6-1'   and departmentid =100";
$slct_stmnt = "SELECT ".$SELECT_WHAT." FROM ".$WHICH_TBL." WHERE ".$ON_WHAT_CONDITION;

 /* Create table doesn't return a resultset */
/* if (mysqli_query($link, "CREATE TEMPORARY TABLE myCity LIKE City") === TRUE) {
    printf("Table myCity successfully created.\n");
} */


/* Select queries return a resultset */
if ($result = mysqli_query($link, $slct_stmnt)) {
    printf("Select returned %d rows.\n", mysqli_num_rows($result));

	
	while($row =mysqli_fetch_assoc($result)){
		printf("<p>%s - %s \n",$row["description"],$row["accounttype"]);
	};
	 
    /* free result set */
    mysqli_free_result($result);
}


mysqli_close($link);

 
echo '<p>'.md5('hzgbjy');

?>
</body>
</html>