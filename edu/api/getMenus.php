<?php
 
	header('Content-Type: application/json');
	include('../config/config.php');
	if(isset($_REQUEST['pid']))
		$pid=$_REQUEST['pid'];
	else 
		$pid=0;
	$query='select id,name from dt_menuext where pid='.$pid.' and status=1';
	$result = mysqli_query($dblink,$query);
	while($row =mysqli_fetch_assoc($result))
	{
		$arr[] = $row;
	}	 
	echo json_encode($arr);
	mysqli_close($dblink);
?>