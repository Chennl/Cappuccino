<?php
	header('Content-Type: application/json');
	include_once('../config/config.php');
	$company_code=0;
	$today = date("Y-m-d H:i:s");
	$login_user='sys';

	$account_type=2;
	if(isset($_SESSION['login_user'])){
		$login_user = $_SESSION['login_user'];
	}

	$action='';
	if(isset($_REQUEST['action']))$action=$_REQUEST['action'];
	if(empty($action)) return '';
	if($action=='query'){
		$desc='';
		$category='';
		$department_id=0;
		$begin_date=date('Y-m-01');
		$page=1;
		$page_size=10;
		if(isset($_REQUEST['begindate'])){
			$begin_date = $_REQUEST['begindate'].'';
		}
		if(isset($_REQUEST['enddate'])){
			$end_date = $_REQUEST['enddate'].'';
		}
		else{
			$end_date = date('Y-m-01',strtotime("+1 months",strtotime($begin_date)));
		}
		
		if(isset($_REQUEST['description']))$description=$_REQUEST['description'];
		if(isset($_REQUEST['category']))$category=$_REQUEST['category'];
		if(isset($_REQUEST['department']))$department_id=$_REQUEST['department'];
		if(isset($_REQUEST['page']))$page=$_REQUEST['page'];
		if(isset($_REQUEST['rows']))$page_size=$_REQUEST['rows'];
		
		
		$query_where='where accounttype= '.$account_type.' and departmentid='.$department_id.' and accountdate between "'.$begin_date.'" and "'.$end_date.'" ';
		
		if(strlen($description)>0)
			$query_where = $query_where.' and description like "%'.$description.'%"';
		if($category>0)
			$query_where = $query_where.' and categoryid = '.$category ;
		
		$query='select count(1) as rows from dt_statement '.$query_where;
		$result = mysqli_query($dblink,$query);
		$arr_count = mysqli_fetch_assoc($result);
		$count =$arr_count['rows'];
		mysqli_free_result($result);
		
		$query='select * from dt_statement '.$query_where.'  limit '. (($page -1)*$page_size).','.$page_size;
		$result = mysqli_query($dblink,$query);
		$total_amount=0;
		if($count==0){
			echo '{"total":0,"rows":[]}';
		}
		else {
			while($row =mysqli_fetch_assoc($result))
			{
				$arr[] =  $row;
				$total_amount += $row['amount'];
			}
			 $footer= array(array('department'=>'合计:','amount'=>$total_amount));
			echo json_encode(array('total'=>$count,'rows'=>$arr,'footer'=>$footer));
		}
		/* free result set */
		mysqli_free_result($result);
		
	}elseif ($action=='delete'){
		if(isset($_POST['postdata'])){
			$postdata = $_POST['postdata'];
			if(!empty($postdata)){
				$json_array=json_decode($postdata,true)[0];
				$sql="delete from dt_statement where id= ".$json_array['id'];
				$result = mysqli_query($dblink, $sql);
				if($result){						
					echo json_encode(array('status'=>true));
				}
				else{
					echo json_encode(array('status'=>false,'errMsg'=>'Failed to delete'));
				}
				/* free result set */
				mysqli_free_result($result);
			}}
	}
	else if($action=='update'){
		$db_batch_CRUD_status='';
		$db_batch_CRUD_success_count=0;
		$db_batch_CRUD_fail_count=0;
		//begin update
		if(isset($_POST['updatedata'])){
			$updated = $_POST['updatedata'];
			if(!empty($updated)){
				foreach(json_decode($updated,true) as $json_array){
					$db_batch_CRUD_rows++;
					//$json_array=json_decode($updated,true)[0];
					$json_array['updatedate'] = $today;
					$json_array['updateby'] = $login_user;				
					$updateSql="update dt_statement set ".
							"billcode='".$json_array['billcode']."',".
							"accountdate='".$json_array['accountdate']."',".
							"amount='".$json_array['amount']."',".
							"description='".$json_array['description']."',".
							"handleby='".$json_array['handleby']."',".
							"categoryid=".$json_array['categoryid'].",".
							"category='".$json_array['category']."',".
							"accounttype='".$json_array['accounttype']."',".
							"paymethodid=".$json_array['paymethodid'].",".
							"paymethod='".$json_array['paymethod']."',".
							"departmentid=".$json_array['departmentid'].",".
							"department='".$json_array['department']."',".
							"referencecode='".$json_array['referencecode']."',".
							"lockflag='".$json_array['lockflag']."',".
							"remark='".$json_array['remark']."',".
							"companycode='".$json_array['companycode']."',".
							"createdate='".$json_array['createdate']."',".
							"createby='".$json_array['createby']."',".
							"updatedate='".$json_array['updatedate']."',".
							"updateby='".$json_array['updateby']."'".
							" where id=".$json_array['id'];
					$result = mysqli_query($dblink, $updateSql);
					if($result){												 
						$db_batch_CRUD_success_count++;						
					}
					else{
						$db_batch_CRUD_fail_count++;
						$db_batch_CRUD_status=$db_batch_CRUD_status.'Failed to update Id:'.$json_array['id'];						
					}
				}
				
				/* free result set */
				mysqli_free_result($result);
			}
		}//end update
		if(isset($_POST['insertdata'])){
			$inserted = $_POST['insertdata'];
			if(!empty($inserted)){
				foreach(json_decode($inserted,true) as $json_array){
					//$json_array=json_decode($inserted,true)[0];
					$result = mysqli_query($dblink, 'select max(id)+1 as maxid from dt_statement');
					$rst = mysqli_fetch_assoc($result);
					mysqli_free_result($result);
					$id=$rst['maxid'];
					$json_array['id'] = $id;
					$json_array['accounttype'] = $account_type;
					$json_array['updatedate'] = $today;
					$json_array['createdate'] = $today;
					$json_array['updateby'] = $login_user;
					$json_array['createby'] = $login_user;
					$json_array['companycode'] = $company_code;
					$json_array['lockflag'] = 0;
					
					$insertSql= "insert into dt_statement(".
							"id,billcode,accountdate,amount,description,handleby,categoryid,category,accounttype,paymethodid,paymethod,departmentid,department,referencecode,lockflag,remark,companycode,createdate,createby,updatedate,updateby)".
							" values (".
							$json_array['id'].",'".$json_array['billcode']."','".$json_array['accountdate']."',".$json_array['amount'].",'".$json_array['description']."','".$json_array['handleby']."',".$json_array['categoryid'].",'".$json_array['category']."',".$json_array['accounttype'].",".$json_array['paymethodid'].",'".$json_array['paymethod']."',".$json_array['departmentid'].",'".$json_array['department']."','".$json_array['referencecode']."',".$json_array['lockflag'].",'".$json_array['remark']."','".$json_array['companycode']."','".$json_array['createdate']."','".$json_array['createby']."','".$json_array['updatedate']."','".$json_array['updateby']."')";
					$result = mysqli_query($dblink, $insertSql);
					if($result){												 
						$db_batch_CRUD_success_count++;						
					}
					else{
						$db_batch_CRUD_fail_count++;
						$db_batch_CRUD_status=$db_batch_CRUD_status.'Failed to Insert Id:'.$json_array['id'];						
					}
				}
				/* free result set */
				mysqli_free_result($result);
			}
		}
		if(isset($_POST['deletedata'])){
			$deleted = $_POST['deletedata'];
			if(!empty($deleted)){
				foreach(json_decode($deleted,true) as $json_array){
					//$json_array=json_decode($updated,true)[0];  		
					$insertSql= "delete from dt_statement where id=".$json_array['id'];
					$result = mysqli_query($dblink, $insertSql);
					if($result){												 
						$db_batch_CRUD_success_count++;						
					}
					else{
						$db_batch_CRUD_fail_count++;
						$db_batch_CRUD_status=$db_batch_CRUD_status.'Failed to delete Id:'.$json_array['id'];						
					}
				}
				/* free result set */
				mysqli_free_result($result);
			}
			
		}
		
		if(strlen($db_batch_CRUD_status)>0){
			echo json_encode(array('status'=>false,'errMsg'=>'Failed to update'));
		}
		else {
			echo json_encode(array('status'=>true,'msg'=>'成功保存'));
		}
	}
	mysqli_close($dblink);
	

?>