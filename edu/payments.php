<?php
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

    
    	$dg<?php echo $rndId;?>=$('#dg<?php echo $rndId;?>');
	    function isEditing(e) {
	        var  $dg= e.closest('div[class="datagrid-toolbar"').parent().find('table[class=datagrid-f]');  
	      	var attributes=$dg.datagrid('options').attributes; 
	      	if(attributes.rowediting == true){  	     
    	      	return true;
	      	}
	      	else
	      	{
		      	return false;
		      	}
	    }
	   
	    function editRow(index,e) {
	       console.info("editRow");    
	 //      alert(e.closest('div[class=datagrid-view]').find('table[class=datagrid-f]').attr('id'));
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
	        queryParams.accountdate = targetaccountdateVal;
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
	    function deleterow(index,e) {
	    	console.info('deleterow');
	        $.messager.confirm('确认', '是否真的删除?', function (r) {
	            if (r) { 	
    	            $dg=e.closest('div[class=datagrid-view]').find('table[class=datagrid-f]');
	            	$dg.datagrid('deleteRow', index);  
    	            var effectRow =  $dg.datagrid('getChanges', "deleted");
    	            var postData = new Object();
    	            postData["postdata"] = JSON.stringify(effectRow);
    	            postData["action"]='delete';
    	            $.post("./api/dopayment.php", postData, function (rsp) {
        	            if (rsp.status) {          	                              	                
        	            	$dg.datagrid('acceptChanges');
        	                $.messager.alert("提示", "删除成功！");                	                                	                
        	            }
        	        }, "JSON").error(function () {
        	              $.messager.alert("提示", "删除错误了！");
        	        });           
    	         }
	        });
	        editIndex = undefined;    	       
	    }
	    function append(e) {  
	        var  $dg= e.closest('div[class="datagrid-toolbar"').parent().find('table[class=datagrid-f]');   	    	
	        if (isEditing(e)) {
	            $.messager.alert('警告', '当前记录正在编辑，不能增加记录!');
	            return;
	        }
 	        	
            $dg.datagrid('appendRow', { departmentid:<?php echo $department_id;?>,department:'<?php echo $department_name;?>',accoutdate:'<?php echo date('Y-m-d')?>'});
            editIndex = $dg.datagrid('getRows').length - 1;
            $dg.datagrid('selectRow', editIndex).datagrid('beginEdit', editIndex);
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
                        queryParams:{action:'query',accountdate:'<?php echo date('y-m-01')?>',department:<?php echo $department_id?>,accounttype:2,description:'',category:''}, 
                        loadMsg:'数据加载中请稍后……',  
                        pagination: true,  
                        rownumbers: true,
                        toolbar:tb<?php echo $rndId;?>,
                        onBeforeEdit: function(index,row){  
                	        	console.info("onBeforeEdit");                    	      	 
                    	      	var $target=$(this);                      	      	 
                    	      	var attributes=$target.datagrid('options').attributes; 
                    	      	if(attributes.rowediting == true){
                        	      	$.messager.confirm('警告','当前记录正在编辑，不能再修改记录!');
                        	      	return false;
                    	      	}
                    	      	$target.datagrid('unselectAll');
                    	      	$target.datagrid('selectRow', index);
                    	      	row.editing = true;	 
                    	      	attributes.rowediting = true;
                    	      	attributes.editIndex = index;
                    	      	$target.datagrid('options').attributes = attributes;
                    	      	$target.datagrid('refreshRow', index);                   	      	
                    	    } ,
                        onAfterEdit: function(index, row) {
	                	        console.info("onAfterEdit");
	                	        row.editing = false;
	                	        var $target=$(this);
	                	        $target.datagrid('refreshRow', index);
                	    },
                        onCancelEdit: function(index, row) {
	                	        console.info("onCancelEdit");
	                	        var $target=$(this);
	                	        var attributes=$target.datagrid('options').attributes; 
	                	        attributes.rowediting = false;
	                	        $target.datagrid('options').attributes = attributes;
	                	        row.editing = false;
	                	       // editIndex = undefined;
	                	        $target.datagrid('rejectChanges');
	                	        if ($target.datagrid('validateRow', editIndex)) {
	                	        	$target.datagrid('refreshRow', index);
	                	        }
                	    },
                        onEndEdit:  function(index, row) {
                	        console.info("onEndEdit");
                	        var $target=$(this);
                	        var ed = $target.datagrid('getEditor', {
                	             index: index,
                	             field: 'category'
                	         });
                	        var category = $(ed.target).combobox('getText');
                	         
                	        $.each(categories,function(i,obj){
                    	        if(obj.text==category)
                    	            row.categoryid = obj.value;
                    	        });
                	       var ed = $target.datagrid('getEditor', {
                	             index: index,
                	             field: 'paymethod'
                	            });
                	           var paymethod = $(ed.target).combobox('getText');
                	           $.each(paymethods,function(i,obj){
                	        if(obj.text==paymethod)
                	            row.paymethodid = obj.value;
                	        });               	        
	                	        row.editing = false;	        
	                	        var attributes=$(this).datagrid('options').attributes; 
	                	        attributes.rowediting = false;
	                	      	attributes.editIndex = undefined;
	                	      	$target.datagrid('options').attributes = attributes;

                	       if ($target.datagrid('getChanges').length) {
                	            var inserted = $target.datagrid('getChanges', "inserted");
                	            var deleted = $target.datagrid('getChanges', "deleted");
                	            var updated = $target.datagrid('getChanges', "updated");
                	            var effectRow = new Object();
                	            if (inserted.length) {
                	                effectRow["insertdata"] = JSON.stringify(inserted);
                	                effectRow["action"] = 'update';
                	            }
                	            if (deleted.length) {
                	                effectRow["deleted"] = JSON.stringify(deleted);
                	                effectRow["action"] = 'update';
                	            }
                	            if (updated.length) {
                	                effectRow["updatedata"] = JSON.stringify(updated);
                	                effectRow["action"] = 'update';
                	            }
                	        }
               	        if(effectRow==undefined)
               	        {
                   	      $.messager.alert("提示", "没有修改需要保存！");
                   	      return                 	        }
                	        $.post("./api/dopayment.php", effectRow, function (rsp) {
                	            if (rsp.status) {               	                              	                
                	                	$target.datagrid('acceptChanges');
                	                	$.messager.alert("提示", "提交成功！");                	                                	                
                	            }
                	        }, "JSON").error(function () {
                	              $.messager.alert("提示", "提交错误了！");
                	        });
                	        
                	    },
                    attributes:{rowediting:false,editIndex:'undefined'},     
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
                                    onChange:function(newValue,oldValue){
                                        console.info('category onChange');
                                    //	var vals = $(this).combox('getValues');
                                       // alert(newValue);
                                        }
                            }
                        }},
                        {field:'description',title:'项目摘要',width:180,align:'center',missingMessage:'项目摘要不能为空',editor:{type:'textbox'}},
                        {field:'amount',title:'发生金额',width:100,align:'right',
                                    formatter: function(value, row) {
                                    if (value != null) {
                                        var myNum = Number(value);
                                        return myNum.toFixed(2);
                                    }
                            },
                                    editor:{type:'numberbox',options:{min:0,precision:2}}
                                },
                        {field:'accountdate',title:'发生日期',width:120,align:'center',formatter:formatDatebox,editor:{type:'datebox'}},
                        {field:'paymethod',title:'支付方式',width:80,align:'center',editor:{
                                type:'combobox',
                                options:{
                                    valueField:'text',
                                    textField:'text',
                                    method:'get',
                                    data:paymethods,
                                    required:true}
                                }},
                            {field:'handleby',title:'经办人',width:80,align:'center',missingMessage:'经办人不能为空',editor:{type:'textbox'}},
                           {field:'remark',title:'备注',width:120,align:'center',editor:{type:'textbox'}},
                            {field:'action',title:'操作',width:70,align:'center', 
                                formatter:function(value, row, index) {
                                	 if (row.editing) {
                          	            var s = '<a href="javascript:void(0)" onclick=" var $this=$(this); saveRow(' + index + ',$this)">保存</a> ';
                          	            var c = '<a href="#javascript:void(0)" onclick=" var $this=$(this); cancelRow(' + index + ',$this)">取消</a>';
                          	            return s + c;
                          	        } else {
                          	            var e = '<a href="#" class="button orange" onclick="var $this=$(this); editRow(' + index + ',$this)">编辑</a> ';
                          	            var d = '<a href="#" class="button red" onclick="var $this=$(this);deleterow(' + index + ',$this)">删除</a>';
                          	            return e + d;
                          	        }
                                }}                                                   
                    ]]  
                });  
    }  

 
  //页面加载  
     $(document).ready(function(){  
          loadGrid();  
     }); 
    </script>
	<table id='dgpaybatch'></table>
    <div id="tb<?php echo $rndId;?>" style="height:auto;padding:5px">
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
         <a href="javascript:void(0)" onclick="var $this=$(this);doSearch($this);" class="easyui-linkbutton" data-options="iconCls:'icon-search',plain:true">搜索</a> 
	   	 <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-add',plain:true" onclick="var $this=$(this);append($this)">添加</a>
	</div>
     	 
</body> 
</html>