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
    	
    function endEditing(dg){
    	var opts = dg.datagrid('options'); 
		if (opts.editIndex == undefined){return true}
		if (dg.datagrid('validateRow', opts.editIndex)){
			dg.datagrid('endEdit', opts.editIndex);
			opts.editIndex = undefined;
			return true;
		} else {
			return false;
		}
	}
	   
	    function editRow(index,e) {
	       console.info("editRow");    
	       e.closest('div[class=datagrid-view]').find('table[class=datagrid-f]').datagrid('beginEdit', index);
	    }
	    function doSearch(e) {    	        
	        console.info("doSearch");
	        var  tb=e.closest('div[class="datagrid-toolbar"');
	        var  $dg= tb.parent().find('table[class=datagrid-f]'); 
	        var targetdescVal = '';
	        var targetcategoryVal =  '';
	        var targetaccountdateVal = ''; 
	        
	        tb.find('input:hidden[name]').each(function(i,obj){
		        
	        	if($(obj).attr('name')=='targetdesc'){
	        		targetdescVal = $(obj).val();
		        };
		        if($(obj).attr('name')=='targetcategory'){
		        	targetcategoryVal = $(obj).val();
		        };
		        if($(obj).attr('name')=='targetaccountdate'){
		        	targetaccountdateVal = $(obj).val();
		        }
			        
		        });
	        	     
	        //查询参数直接添加在queryParams中     
	        var queryParams = $dg.datagrid('options').queryParams;
	        queryParams.begindate = targetaccountdateVal;
	        queryParams.description = targetdescVal;
	        queryParams.category = targetcategoryVal;
	        $dg.datagrid('options').queryParams = queryParams;
	        $dg.datagrid('reload');
	    }
 	    function saveRow(index,e) {
     	    console.info('saverow');
     	    e.closest('div[class=datagrid-view]').find('table[class=datagrid-f]').datagrid('endEdit', index);
	    }
	    function cancelRow(index,e) {
	    	console.info('cancelRow');
	    	e.closest('div[class=datagrid-view]').find('table[class=datagrid-f]').datagrid('cancelEdit', index);
	    }

		function removeit(e){
	    	console.info('removeit');
	    	var  dg= e.closest('div[class="datagrid-toolbar"').parent().find('table[class=datagrid-f]');
	    	//var selectedRowIndex=dg.datagrid('getRowIndex',dg.datagrid('getSelected'));
            var opts = dg.datagrid('options');   
	    	if (opts.editIndex == undefined){
	    		$.messager.alert('提示','请先选择操作行！');
		    	return;
		    	}
	        $.messager.confirm('确认', '是否删除?', function (r) {
	            if (r) { 		            	  
    	            dg.datagrid('cancelEdit', opts.editIndex).datagrid('deleteRow', opts.editIndex);
    	            opts.editIndex = undefined;        
    	         }
	        });	 
		}
		
	    function append(e) { 
	        var dg= e.closest('div[class="datagrid-toolbar"').parent().find('table[class=datagrid-f]');
	        var opts = dg.datagrid('options');  
	    	if (endEditing(dg)){
				dg.datagrid('appendRow', { departmentid:<?php echo $department_id;?>,department:'<?php echo $department_name;?>',accountdate:'<?php echo date('Y-m-d')?>',handleby:'沈梨丽'});
				opts.editIndex = dg.datagrid('getRows').length-1;
				dg.datagrid('selectRow', opts.editIndex).datagrid('beginEdit', opts.editIndex);		 
	            
			} 
	      
	    }
		function saveAll(e){
			 console.info('saveAll');
			 var  dg= e.closest('div[class="datagrid-toolbar"').parent().find('table[class=datagrid-f]');  
			 if (endEditing(dg)){
				 //dg.datagrid('acceptChanges');				 
				// alert(dg.datagrid('getChanges').length);
				 if (dg.datagrid('getChanges').length) {
	 	            var inserted = dg.datagrid('getChanges', "inserted");
	 	            var deleted = dg.datagrid('getChanges', "deleted");
	 	            var updated = dg.datagrid('getChanges', "updated");
	 	            var effectRow = new Object();
	 	            effectRow["action"] = 'update';
	 	            if (inserted.length) {
	 	                effectRow["insertdata"] = JSON.stringify(inserted);	 	               
	 	            }
	 	            if (deleted.length) {
	 	                effectRow["deletedata"] = JSON.stringify(deleted);
	 	            }
	 	            if (updated.length) {
	 	                effectRow["updatedata"] = JSON.stringify(updated);
	 	            } 	            
	 	        }
      	        if(effectRow==undefined)
       	        {
           	      $.messager.alert("提示", "没有修改需要保存！");
           	      return  
       	        }
        	    $.post("./api/dopayment.php", effectRow, function (rsp) {
        	        if (rsp.status) {               	                              	                
        	            	dg.datagrid('acceptChanges');
        	            	dg.datagrid('reload');
        	                $.messager.alert("提示", "保存成功！");                	                                	                
        	         }
        	     }, "JSON").error(function () {
        	              $.messager.alert("提示", "保存失败了！");
        	      });
        	           
			 }
	 	        

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
                        title:'<?php echo $department_name;?>',
                        fit:true,
                        fitColumns:true,
                        url:'./api/dopayment.php',  
                        method:'get',
                        queryParams:{action:'query',begindate:'<?php echo date('Y-m-01')?>',enddate:'<?php echo date('Y-m-d')?>',department:<?php echo $department_id?>,accounttype:2,description:'',category:''}, 
                        loadMsg:'数据加载中请稍后……',  
                        pagination: true,  
                        rownumbers: true,
                        toolbar:tb<?php echo $rndId;?>,
                        onClickCell:function (index, field){
            	        	console.info("onClickCell");
            	        	var dg = $(this);
                            var opts = dg.datagrid('options');                                           	      	 
            	    		if (opts.editIndex != index){
            					if (endEditing(dg)){
            						dg.datagrid('selectRow', index)
            								.datagrid('beginEdit', index);
            						var ed = dg.datagrid('getEditor', {index:index,field:field});
            						if (ed){
            							($(ed.target).data('textbox') ? $(ed.target).textbox('textbox') : $(ed.target)).focus();
            						}
            						opts.editIndex = index;
            					} else {
            						setTimeout(function(){
            							dg.datagrid('selectRow', opts.editIndex);
            						},0);
            					}
            				}
                		} ,
                		onLoadSuccess: function(){
/*                 			var dg = $(this);
                    		var rows = dg.datagrid("getRows");
                    		var total_amount=0;
                    		for(var i=0;i<rows.length;i++){
                    			total_amount += row.amount;
                    		}
                    		dg.datagrid('appendRow', { itemid: '<b>统计：</b>', listprice: ptotal, unitcost: utotal }); */
                		},
                        onBeforeEdit: function(index,row){  
       		  	        	console.info("onBeforeEdit");                    	      	               	      	
                    	    } ,
                        onAfterEdit: function(index, row) {
	                	        console.info("onAfterEdit");
	                	        row.editing = false;
	                	        $(this).datagrid('refreshRow', index);
                	    },
                        onCancelEdit: function(index, row) {
	                	        console.info("onCancelEdit");
	                	        var dg=$(this);
	                	        row.editing = false; 
	                	        if (dg.datagrid('validateRow', index)) {
	                	        	//dg.datagrid('refreshRow', index);  ??
	                	        }
                	    },
                        onEndEdit:  function(index, row) {
                	        console.info("onEndEdit");
            	        	var dg = $(this);
                            var opts = dg.datagrid('options');  
                	        var ed = dg.datagrid('getEditor', {
                	             index: index,
                	             field: 'category'
                	         });
                	        var category = $(ed.target).combobox('getText');
                	         
                	        $.each(categories,function(i,obj){
                    	        if(obj.text==category)
                    	            row.categoryid = obj.value;
                    	        });
                	       var ed = dg.datagrid('getEditor', {
                	             index: index,
                	             field: 'paymethod'
                	            });
                	           var paymethod = $(ed.target).combobox('getText');
                	           $.each(paymethods,function(i,obj){
                	        if(obj.text==paymethod)
                	            row.paymethodid = obj.value;
                	        });               	        
	                	        row.editing = false;	        
	                	        opts.editIndex = undefined;
                	    },
                    idField:'id', 
                    editIndex:undefined,
                    attributes:{rowediting:false},    
                    columns:[[  
                        {field:'id',title: '编号',align: 'center',width: 80},  
                        {field:'referencecode',title: '凭证编号',width:80,align:'center',editor:{type:'textbox'}},  
                        {field:'category',title: '支出类别',width:80,align:'center',
                            formatter: function(value,row){return row.category;},
                            editor:{
                                type:'combobox',
                                options:{
                                    valueField:'text',
                                    textField:'text',
                                    method:'get',
                                    data:categories,
                                    required:true,
                                    editable:false, 
                                    onChange:function(newValue,oldValue){
                                        //console.info('category onChange');
                                        }
                            }
                        }},
                        {field:'description',title:'项目摘要',width:180,align:'center',missingMessage:'项目摘要不能为空',editor:{type:'textbox',required:true}},
                        {field:'amount',title:'发生金额',width:100,align:'right',
                                    formatter: function(value, row) {
                                    if (value != null) {
                                        var myNum = Number(value);
                                        return myNum.toFixed(2);
                                    }
                            },
                                    editor:{type:'numberbox',options:{min:0,precision:2}}
                                },
                        {field:'accountdate',title:'发生日期',width:120,align:'center',formatter:formatDatebox,
                                editor:{
		                            type:'datebox',
		                            editable:false,
		                            readonly:true 
                            }},
                        {field:'paymethod',title:'支付方式',width:80,align:'center',editor:{
                                type:'combobox',
                                options:{
                                    valueField:'text',
                                    textField:'text',
                                    method:'get',
                                    editable:false,
                                    data:paymethods,
                                    required:true}
                                }},
                        {field:'handleby',title:'经办人',width:80,align:'center',missingMessage:'经办人不能为空',editor:{type:'textbox'}},
                        {field:'remark',title:'备注',width:120,align:'center',editor:{type:'textbox'}}                                  
                    ]]  
                });  
    }  

 
  //页面加载  
     $(document).ready(function(){  
          loadGrid();  
     }); 
    </script>
	<table id='dg<?php echo $rndId;?>'></table>
    <div id="tb<?php echo $rndId;?>" style="height:auto;padding:5px">
        
  <!--    <span>学校:</span>
        <select name="targetschool" class="easyui-combobox"   data-options="editable:false,panelHeight:'auto'" style="width:80px;height:auto;">
			<option value="100" selected>小桔灯</option>
			<option value="101">未来宝贝</option>
        </select> -->   
         <span><strong>项目摘要:</strong></span><input id='targetdesc<?php echo $rndId;?>' class="easyui-textbox" type="text" name="targetdesc"  value="" size=10 /> 
        <span>支出类别:</span>
        <select name="targetcategory" class="easyui-combobox"   data-options="editable:false,panelHeight:'auto'" style="width:100px;height:auto;">
			<option value="" selected>全部类别</option>
			<option value="302">网购支出</option>
			<option value="303">现金支出</option>
			<option value="304">其它支出</option>
        </select>
       
        <span>支出年月:</span>                  
        <select class="easyui-combobox" name="targetaccountdate" style="width:100px;">      
           <?php    echo $select_date_options; ?> 
         </select>
         <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-search',plain:true" onclick="var $this=$(this);doSearch($this);" >搜索</a> 
	   	 <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-add',plain:true" onclick="var $this=$(this);append($this)">添加</a>
	   	 <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-remove',plain:true" onclick="var $this=$(this);removeit($this)">删除</a>
	   	 <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-save',plain:true" onclick="var $this=$(this); saveAll($this)">保存</a>	   	 
	</div>    	 
</body> 
</html>