<?php
 	header('Content-Type: application/json');
	include_once('../config/config.php');	
	function getSubNode($dblink,$pid){	 
		$query='select id,name,haschildren,alink from dt_menuext where pid='.$pid.' and status=1';
		$result = mysqli_query($dblink,$query);
		while($row =mysqli_fetch_assoc($result))
		{
			if($row['haschildren']==1){
				$children=getSubNode($dblink,$row['id']);
				$arr[] = array('id'=>$row['id'],'text'=>$row['name'],'children'=>$children);
			}
			else{
				$a=array('alink'=>$row['alink']);
				$arr[] = array('id'=>$row['id'],'text'=>$row['name'],'attributes'=>$a);
			}
		}
		return $arr;
	}
	$pid = $_GET['pid'];
	$arr = getSubNode($dblink,$pid);
	echo json_encode($arr);
	mysqli_close($dblink);
?>