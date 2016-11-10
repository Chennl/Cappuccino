<?php
include_once 'config.php';
//include_once 'session.php';
if(isset($_GET['department'])){
	$department_id=$_GET['department'];
	if($department_id ==100)
		$department_name='小桔灯';
		else if($department_id ==101)
			$department_name='未来宝贝';
			else
				$department_name='';
				$rndId='obj'.mt_rand();
				$this_month =date('Y-m-01');
				$select_date_options="";
				for($i=0;$i<13;$i++){
					$str_date = date("Y-m", strtotime("-".$i." months", strtotime($this_month)));
					$select_date_options=$select_date_options."<option value='".$str_date."-01'> $str_date</option>";
				}
}
?>
 <html>
     <head>
    <meta name="viewport" content="width=device-width" />
    <title>ss</title>
    <script type="text/javascript" src="./Content/scripts/easyuiExtension.js"></script>
 
 </head>
    <body>
    <script type="text/javascript">  
    var categories = [{ "value": "302", "text": "网购支出" }, { "value": "303", "text": "现金支出" }, { "value": "304", "text": "其它支出" }];
    var paymethods = [{ "value": "100", "text": "现金" }, 
                      { "value": "101", "text": "POS" }, 
                      { "value": "102", "text": "银行转账" },
                      { "value": "102", "text": "支付宝" },
                      { "value": "102", "text": "其它" }];
   
	    function doSearch(e) {    	        
	        console.info("doSearch");
	        var  tb=e.closest('div[class="datagrid-toolbar"');
	        var  $dg= tb.parent().find('table[class=datagrid-f]'); 
	        var queryParams = $dg.datagrid('options').queryParams;
	        queryParams.department = $('#qryPaymentDepartment').val();
	        queryParams.begindate = $('#qryPaymentBeginDate').datebox('getValue');
	        queryParams.enddate = $('#qryPaymentEndDate').datebox('getValue');
	        queryParams.description = $('#qryPaymentDesc').val();
	        queryParams.category = $('#qryPaymentCategory').combobox('getValue');	 
	        queryParams.department = $('#qryPaymentDepartment').combobox('getValue');	        
	        $dg.datagrid('options').queryParams = queryParams;
	        $dg.datagrid('reload');
	    }
 	

		
    function loadGrid()  
    { 

        //加载数据  
     $('#dg<?php echo $rndId;?>').datagrid({  
                        width: 'auto',  
                        height:300,               
                        striped: true,  
                        singleSelect : true,
                        collapsible:true,  
                        iconCls: 'icon-edit',
                        title:'支出费用明细查询',
                        fit:true,
                        fitColumns:true,
                        url:'./api/dopayment.php',  
                        method:'get',
                        queryParams:{action:'query',begindate:'<?php echo date('Y-m-01')?>',enddate:'<?php echo date('Y-m-d')?>',department:<?php echo $department_id?>,accounttype:2,description:'',category:''}, 
                        loadMsg:'数据加载中请稍后……',  
                        pagination: false, 
                        showFooter:true, 
                        rownumbers: true,
                        toolbar:tb<?php echo $rndId;?>,    
                        onBeforeLoad:function(){
                        	console.info('onBeforeLoad');}, 
                		onLoadSuccess: function(){
                    		console.info('onLoadSuccess');
/*                 			var dg = $(this);
                    		var rows = dg.datagrid("getRows");
                    		var total_amount=0;
                    		for(var i=0;i<rows.length;i++){
                    			total_amount += rows[i].amount;
                    		}
                    		dg.datagrid('appendRow', { department: '<b>统计：</b>', amount: total_amount }); */  
                		},                   
                    idField:'id',  
                    columns:[[  
                        {field:'department',title: '学校',align: 'center',width: 80},
                        {field:'id',title: '编号',align: 'center',width: 80},  
                        {field:'referencecode',title: '凭证编号',width:80,align:'center',editor:{type:'textbox'}},  
                        {field:'category',title: '支出类别',width:80,align:'center',formatter: function(value,row){return row.category;}},
                        {field:'description',title:'项目摘要',width:180,align:'center',missingMessage:'项目摘要不能为空'},
                        {field:'amount',title:'发生金额',width:100,align:'right',
                                    formatter: function(value, row) {
                                    if (value != null) {
                                        var myNum = Number(value);
                                        return myNum.toFixed(2);
                                    }
                            }},
                        {field:'accountdate',title:'发生日期',width:120,align:'center',formatter:formatDatebox},
                        {field:'paymethod',title:'支付方式',width:80,align:'center'},
                        {field:'handleby',title:'经办人',width:80,align:'center',missingMessage:'经办人不能为空'},
                        {field:'remark',title:'备注',width:120,align:'center'}                                  
                    ]]  
                });  
    }  

 
  //页面加载  
    function myformatter(date){
			var y = date.getFullYear();
			var m = date.getMonth()+1;
			var d = date.getDate();
			return y+'-'+(m<10?('0'+m):m)+'-'+(d<10?('0'+d):d);
		}
		function myparser(s){
			if (!s) return new Date();
			var ss = (s.split('-'));
			var y = parseInt(ss[0],10);
			var m = parseInt(ss[1],10);
			var d = parseInt(ss[2],10);
			if (!isNaN(y) && !isNaN(m) && !isNaN(d)){
				return new Date(y,m-1,d);
			} else {
				return new Date();
			}
		}
		
     $(document).ready(function(){  
 
        
         loadGrid();  
     }); 
 
		
 
	
    </script>
	<table id='dg<?php echo $rndId;?>'></table>
    <div id="tb<?php echo $rndId;?>" style="height:auto;padding:10px">       
 	   <span >学校:</span>
        <select id="qryPaymentDepartment" class="easyui-combobox"   data-options="editable:false,panelHeight:'auto'" style="width:100px;height:auto;">
			<option value="100" selected>小桔灯</option>
			<option value="101">未来宝贝</option>
        </select>        
        <span style="padding-left:10px">支出类别:</span>
        <select id="qryPaymentCategory" class="easyui-combobox"   data-options="editable:false,panelHeight:'auto'" style="width:100px;height:auto;">
			<option value="" selected>全部类别</option>
			<option value="302">网购支出</option>
			<option value="303">现金支出</option>
			<option value="304">其它支出</option>
        </select> 
        <span style="padding-left:10px">支出日期:</span> <input id='qryPaymentBeginDate' name='qryPaymentBeginDate' class="easyui-datebox"  value='<?php echo date('Y-m-01');?>'  style="width:110px;height:auto;">
		<span >至</span>	<input id='qryPaymentEndDate' name='qryPaymentEndDate' class="easyui-datebox" value='<?php echo date('Y-m-d');?>'  style="width:110px;height:auto;">
		<span style="padding-left:10px">项目摘要:</span><input id='qryPaymentDesc' class="easyui-textbox" type="text"   value="" size=20 /> 	
         <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-search',plain:true" onclick="var $this=$(this);doSearch($this);" >搜索</a>    	 
         <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-search',plain:true" onclick="var $this=$(this);doSearch($this);" >导出</a>    
	</div>    	 
</body> 
</html>