<!DOCTYPE HTML>
<?php 
include 'session.php';
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<link href="css/site.css" rel="stylesheet">
<title>费用查询</title>
<style type="text/css">
</style>
</head>
     <?php  
      if(isset($_POST['submit'])){
      	$display = 'display:table';
      	$from_date = $_POST['qrydate']; 	
      	$to_date = date('Y-m-d',strtotime('+1 month',strtotime($from_date)));
      	$description=mysqli_real_escape_string($db,  $_POST['description']);
      	$query="SELECT  accountdate,description,category,amount,accounttype FROM my3709549.dt_statement where accountdate between '".$from_date."' and '".$to_date."'  and departmentid =100 and description like '%".$description."%'";
      	$result = mysqli_query($db, $query);
      }
      else{
      	$display='display:none';
      }?>
<body>
 	<form method = "post" action = "<?php echo htmlentities($_SERVER["PHP_SELF"]);?>">
         <table>
            <!--  <tr>
               <td>学校:</td>
               <td>
                  <input type = "radio" name = "department" value = "100">小桔灯
                  <input type = "radio" name = "department" value = "101">未来宝贝
               </td>
            </tr> -->
            <tr>
               <td>日期: &nbsp;<select id="qrydate" name='qrydate'>
				 <?php 
				 for($i=0;$i<12;$i++){
				 	$val = date('Y-m-01',strtotime('-'.$i.' month '));
				 	$txt = date('Y 年 m 月',strtotime('-'.$i.' month '));
				 	if(isset($from_date) && $from_date==$val.'-01')
				    	echo "<option value='".$val."' selected >".$txt.'</option>' ;
				 	else
				 		echo "<option value='".$val."'>".$txt.'</option>' ;
				 }
				 ?>
				 </select> </td>
            
               <td>类别:&nbsp; <input type="checkbox" name="ayout" value="1" checked>支出 
					<input type="checkbox" name="payin" value="2" checked>收入<br />
				</td>
            </tr>           
            <tr>
               <td>摘要:&nbsp;
               <input type = "text" style="width: 104px" name = "description" value='<?php  if(isset($description)){ echo $description; }else{ echo '';}?>'  ></td>
               <td>
                  <input type = "submit" name = "submit" value = "查询"> </tr>
         </table>
         <br/></br>
      </form>
 
	    <table id='table-result-1' style='<?php echo $display?>'>
	    <caption>Specification values: <b>Steel</b>, <b>Castings</b>,
   Ann. A.S.T.M. A27-16, Class B;* P max. 0.06; S max. 0.05.</caption>
	    	<thead>
	             <tr>
	               <th rowspan="2">发生日期</th>
	               <th rowspan="2">凭证类别</th>
	               <th rowspan="2" >摘要</th>
	               <th colspan="2">发生金额</th>
	               </tr>
	               <tr>
	               <th>贷方<sup>2</sup></th>
	               <th>借方<sup>2</sup></th>
	            </tr>
            </thead>
            <tbody>
            <?php 
            $str_row_format="<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%2.2f</td></tr>";
            $in_total_amount=$out_total_amount=0.0;
            while( $row = mysqli_fetch_array($result, MYSQL_ASSOC) ) {
            	if($row['accounttype']==1){
            		$in_amount=$row['amount'];
            		$out_amount=0.0;
            		$in_total_amount+=$row['amount'];
            	}else
            	{
            		$in_amount=0;
            		$out_amount=$row['amount'];
            		$out_total_amount+=$row['amount'];
            	}
           	$dt=date(' m月d日',strtotime($row['accountdate']));
            	printf($str_row_format,$dt,$row['category'],$row['description'],$in_amount,$out_amount);          	 
            }
            ?>
            </tbody>
            <tfoot>
	            <tr>
	               <td colspan=3 >合 计：</td>
	               <?php printf("<td>%2.2f</td> <td>%2.2f</td>",$in_total_amount,$out_total_amount); ?>
	            </tr>
            </tfoot>
        </table>
    </body>
 <?php mysql_close($conn); ?>
</html>