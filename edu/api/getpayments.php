<?php
	header('Content-Type: application/json');
	include_once('../config/config.php');
	function getData($account_type,$department_code,$accoun_date,$desc,$category){
		$from=$account_date;
		$to = strtotime("+1 months",strtotime($account_date));
		$query='select * from dt_statement where accounttype='.$account_type.
				' and department='.$department_code.' and accountdate between "'.$from.'" and "'.$to.'"';
		if(strlen($desc)>0) 
			$query = $query.' and description like "%'.$desc.'%"';
		if(strlen($category)>0)
			$query = $query.'and category= '.category ;
		
		$result = mysqli_query($dblink,$query);
		while($row =mysqli_fetch_assoc($result))
		{
			$arr[] =  $row;
		}
		return json_encode($arr);
	}
	
 
	$desc='';
	$category='';
	$account_type=2;
	$department_code=100;
	$from=date('Y-m-01');
	if(isset($_REQUEST['accountdate']))$from=$_REQUEST['accountdate'];
	if(isset($_REQUEST['desc']))$desc=$_REQUEST['desc'];
	if(isset($_REQUEST['category']))$category=$_REQUEST['category'];
	 	
	
	$to = date('Y-m-01',strtotime("+1 months",strtotime($from)));
	$query='select * from dt_statement where accounttype='.$account_type.
	' and departmentid='.$department_code.' and accountdate between "'.$from.'" and "'.$to.'"';
	if(strlen($desc)>0)
		$query = $query.' and description like "%'.$desc.'%"';
	if($category>0)
		$query = $query.'and category= '.$category ;

	$result = mysqli_query($dblink,$query);
	$count = mysqli_num_rows($result);
	if($count==0){
		echo '{"total":0,"rows":[]}';
	}
	else {
		while($row =mysqli_fetch_assoc($result))
		{
			$arr[] =  $row;
		}
		echo json_encode(array('total'=>$count,'rows'=>$arr));
	}
	
	mysqli_close($dblink);
	

?>