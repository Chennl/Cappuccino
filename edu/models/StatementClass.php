<?php
class StatementClass{
	var $id; 				
	var $billcode; 		
	var $accountdate; 		
	var $amount; 			
	var $description; 		
	var $handleby; 		
	var $categoryid; 		
	var $category; 		
	var $accounttype; 		
	var $paymethodid; 		
	var $paymethod; 		
	var $departmentid; 	
	var $department; 		
	var $referencecode; 	
	var $lockflag; 		
	var $remark; 			
	var $companycode; 		
	var $createdate; 		
	var $createby; 		
	var $updatedate; 		
	var $updateby; 
	function update(){
		$updateSql="update dt_statement set ".
				"billcode='".$model.billcode."'".
				"accountdate='".$model.accountdate."'".
				"amount='".$model.amount."'".
				"description='".$model.description."'".
				"handleby='".$model.handleby."'".
				"categoryid=".$model.categoryid."".
				"category='".$model.category."'".
				"accounttype='".$model.accounttype."'".
				"paymethodid=".$model.paymethodid.
				"paymethod='".$model.paymethod."'".
				"departmentid=".$model.departmentid.
				"department='".$model.department."'".
				"referencecode='".$model.referencecode."'".
				"lockflag='".$model.lockflag."'".
				"remark='".$model.remark."'".
				"companycode='".$model.companycode."'".
				"createdate='".$model.createdate."'".
				"createby='".$model.createby."'".
				"updatedate='".$model.updatedate."'".
				"updateby='".$model.updateby."'".
				" where id=".$model.id;
		return 1;
	}
	function insert(){
		$insertSql= "insert into dt_statement(".
				"id,billcode,accountdate,amount,description,handleby,categoryid,category,accounttype,paymethodid,paymethod,departmentid,department,referencecode,lockflag,remark,companycode,createdate,createby,updatedate,updateby)".
				" values (".
				$model->id.",'".$model->billcode."','".$model->accountdate."',".$model->amount.",'".$model->description."','".$model->handleby."',".$model->categoryid.",'".$model->category."',".$model->accounttype.",".$model->paymethodid.",'".$model->paymethod."',".$model->departmentid.",'".$model->department."','".$model->referencecode."','".$model->lockflag."','".$model->remark."','".$model->companycode."','".$model->createdate."','".$model->createby."','".$model->updatedate."','".$model->updateby.")";
	}
}
?>