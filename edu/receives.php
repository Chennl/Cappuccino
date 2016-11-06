<?php
 if(isset($_GET['department'])){
 	$department_id=$_GET['department'];
 	if($department_id ==100)
 		$department_name='小桔灯';
 	else if($department_id ==101)
 		$department_name='未来宝贝';
 	else 
 		$department_name='';
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
    var categories = [{ "value": "200", "text": "报名收款" }, { "value": "209", "text": "其它收款" }];
    var paymethods = [{ "value": "100", "text": "现金" }, 
                      { "value": "101", "text": "POS" }, 
                      { "value": "102", "text": "银行转账" },
                      { "value": "102", "text": "支付宝" },
                      { "value": "102", "text": "其它" }];
    
    var departments = [{'id':'100', 'name':'小桔灯'},{'id':'101','name':'未来宝贝'}];   
    
     function formatPrice(value, row) {
            if (value != null) {
                var myNum = Number(value);
                return myNum.toFixed(2);
            }
      }
 
    </script>
	<table id="dg<?php echo $department_id.'2';?>" class="easyui-datagrid" title="<?php echo $department_name;?>"  
			data-options="singleSelect:true,collapsible:true,url:'./api/dopayment.php',method:'get',iconCls: 'icon-edit', singleSelect: true, fit:true,fitColumns:true,toolbar: '#tb', loadMsg:'正在查询...',	 
                        onClickCell: onClickCell, 
                        onBeforeEdit: onBeforeEdit,
                        onAfterEdit: onAfterEdit,
                        onCancelEdit: onCancelEdit,
                        onEndEdit: onEndEdit,
                        queryParams:{action:'query',accountdate:'<?php echo date('y-m-01')?>',department:<?php echo $department_id?>,accounttype:1,description:'',category:''} ">
		<thead>
			<tr>
				<th data-options="field:'id',width:80,align:'center'">编号</th>
				<th data-options="field:'referencecode',width:80,align:'center',editor:{type:'textbox'}">凭证编号</th>
				<th data-options="field:'category',width:80,align:'center',editor:{
							type:'combobox',
							options:{
								valueField:'text',
								textField:'text',
								method:'get',
								 data:categories,
								required:true}
							}">收款类别</th>
				<th data-options="field:'description',width:180,align:'center',missingMessage:'项目摘要不能为空',editor:{type:'textbox'}">项目摘要</th>
				<th data-options="field:'amount',width:100,align:'right',formatter: formatPrice
					,editor:{type:'numberbox',options:{min:0,precision:2}}">发生金额</th>
				<th data-options="field:'accountdate',width:120,align:'center',formatter:formatDatebox,editor:{type:'datebox'}">发生日期</th>
                <th data-options="field:'paymethod',width:80,align:'center',editor:{
							type:'combobox',
							options:{
								valueField:'text',
								textField:'text',
								method:'get',
								data:paymethods,
								required:true}
							}">收款方式</th>
                <th data-options="field:'handleby',width:80,align:'center',missingMessage:'经办人不能为空',editor:{type:'textbox'}">经办人</th>
                <th data-options="field:'remark',width:120,align:'center',editor:{type:'textbox'}">备注</th>
                <th data-options="field:'action',title:'操作',width:70,align:'center',formatter:actionFormatter"></th>
			</tr>
		</thead>
	</table>
    <div id="tb" style="height:auto;padding:5px">
        <span><strong>项目摘要:</strong></span><input  class="easyui-textbox" type="text" id="targetdesc"  value="" size=10 /> 
        <span>收款类别:</span>
        <select id="targetcategory" class="easyui-combobox"   data-options="editable:false,panelHeight:'auto'" style="width:100px;height:auto;">
			<option value="" selected>全部类别</option>
			<option value="200">报名收款</option>
			<option value="209">其它收款出</option>
        </select>
        <span>收款年月:</span>                  
        <select id="accountdate" class="easyui-combobox" name="accountdate" style="width:100px;">      
             <?php       
		        $this_month =date('Y-m-01');
		        
		        for($i=0;$i<13;$i++){
		         	 $str_date = date("Y-m", strtotime("-".$i." months", strtotime($this_month)));
		         	 echo "<option value='".$str_date."-01'> $str_date</option>";
		        }
	        ?> 
       </select>

 
        <a href="javascript:doSearch()" class="easyui-linkbutton" data-options="iconCls:'icon-search',plain:true">搜索</a> 
	   	<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-add',plain:true" onclick="append()">添加</a>
		  <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-save',plain:true" onclick="saveall()">保存</a>
 
	</div>
     	<script type="text/javascript">
     		var $dg = $("#<?php echo $datagrid_id;?>");    	   
     	    var editIndex = undefined;
     	    function actionFormatter(value, row, index) {
     	        if (row.editing) {
     	            var s = '<a href="javascript:void(0)" onclick="saveRow(' + index + ')">保存</a> ';
     	            var c = '<a href="#javascript:void(0)" onclick="cancelRow(' + index + ')">取消</a>';
     	            return s + c;
     	        } else {
     	            var e = '<a href="#" class="button orange" onclick="editRow(' + index + ')">编辑</a> ';
     	            var d = '<a href="#" class="button red" onclick="deleterow(' + index + ')">删除</a>';
     	            return e + d;
     	        }
     	    }
     	    function isEditing() {
     	        return !(editIndex == undefined);
     	    }
     	    function editRow(index) {
     	        console.info("editRow");
     	        $dg.datagrid('beginEdit', index);
     	    }
     	    function doSearch() {
     	        
     	        console.info("");
     	        var descriptionVal = $('#targetdesc').textbox('getValue');
     	        var categoryVal = $('#targetcategory').combobox('getValue');
     	        var accountdateVal = $('#accountdate').combobox('getValue');  	     
     	        //查询参数直接添加在queryParams中     
     	        var queryParams = $dg.datagrid('options').queryParams;
     	        queryParams.accountdate = accountdateVal;
     	        queryParams.description = descriptionVal;
     	        queryParams.category = categoryVal;
     	        $dg.datagrid('options').queryParams = queryParams;
     	        $dg.datagrid('reload');
     	    }
      	    function saveRow(index) {
     	        $dg.datagrid('endEdit', index);
     	    }
     	    function cancelRow(index) {
     	        $dg.datagrid('cancelEdit', index);
     	    }
     	    function deleterow(index) {
     	        $.messager.confirm('确认', '是否真的删除?', function (r) {
     	            if (r) { $dg.datagrid('deleteRow', index); saveall(); }
     	        });
     	        editIndex = undefined;    	       
     	    }
     	    function addrow() {
     	        if (isEditing()) {
     	            $.messager.alert('警告', '当前记录正在编辑，不能增加记录!');
     	            return;
     	        }
     	        $dg.datagrid('appendRow', {
     	            id: '123',
     	            billcode: '',
     	            description: '',
     	            categoryid: 302,
     	            amount: '',
     	            accounttype:2,
     	            accountdate: '2016-10-25',
     	        });
     	        editIndex = $dg.datagrid('getRows').length - 1;
     	        $dg.datagrid('selectRow', editIndex)
                        .datagrid('beginEdit', editIndex);

     	    }
     	    function saveall() {
     	        console.info("saveall");
     	        if ($dg.datagrid('getChanges').length) {
     	            var inserted = $dg.datagrid('getChanges', "inserted");
     	            var deleted = $dg.datagrid('getChanges', "deleted");
     	            var updated = $dg.datagrid('getChanges', "updated");
     	            var effectRow = new Object();
     	            if (inserted.length) {
     	                effectRow["insertdata"] = JSON.stringify(inserted);
     	               effectRow["action"] = 'update';
     	            }
     	            if (deleted.length) {
     	                effectRow["deleted"] = JSON.stringify(deleted);
     	            }
     	            if (updated.length) {
     	                effectRow["updatedata"] = JSON.stringify(updated);
     	                effectRow["action"] = 'update';
     	            }
     	        }
     	        $.post("./api/dopayment.php", effectRow, function (rsp) {
     	            if (rsp.status) {
     	                $.messager.alert("提示", "提交成功！");
     	                $dg.datagrid('acceptChanges');
     	            }
     	        }, "JSON").error(function () {
     	            $.messager.alert("提示", "提交错误了！");
     	        });
     	    }
     	    function onClickCell(index, field) {
     	        //if (editIndex != index) {
     	        //    if (endEditing()) {
     	        //        $dg.datagrid('selectRow', index)
                //                .datagrid('beginEdit', index);
     	        //        var ed = $dg.datagrid('getEditor', { index: index, field: field });
     	        //        if (ed) {
     	        //            ($(ed.target).data('textbox') ? $(ed.target).textbox('textbox') : $(ed.target)).focus();
     	        //        }
     	        //        editIndex = index;
     	        //    } else {
     	        //        setTimeout(function () {
     	        //            $dg.datagrid('selectRow', editIndex);
     	        //        }, 0);
     	        //    }
     	        //}
     	    }
     	    function onBeforeEdit(index,row){   
     	        row.editing = true;
     	        editIndex = index;
     	        $dg.datagrid('refreshRow', index);
     	        console.info("onBeforeEdit");
     	        // updateActions(index,row);  
     	    } 
     	    function onCancelEdit(index, row) {
     	        console.info("onCancelEdit");
     	        row.editing = false;
     	        editIndex = undefined;
     	        $dg.datagrid('rejectChanges');
     	        $dg.datagrid('refreshRow', index);
     	    }
     	    function onEndEdit(index, row) {
     	        console.info("onEndEdit");
     	        var ed = $(this).datagrid('getEditor', {
     	             index: index,
     	             field: 'category'
     	         });
     	        var category = $(ed.target).combobox('getText');
     	         
     	        $.each(categories,function(i,obj){
         	        if(obj.text==category)
         	            row.categoryid = obj.value;
         	        });
     	       var ed = $(this).datagrid('getEditor', {
   	             index: index,
   	             field: 'paymethod'
   	            });
   	           var paymethod = $(ed.target).combobox('getText');
   	           $.each(paymethods,function(i,obj){
     	        if(obj.text==paymethod)
     	            row.paymethodid = obj.value;
     	        });
   	        	row.departmentid=<?php echo $department_id;?>;
   	        	row.department='<?php echo $department_name;?>';   		
     	        editIndex = undefined;
     	        saveall();
     	    }
     	    function onAfterEdit(index, row) {
     	        row.editing = false;
     	        $dg.datagrid('refreshRow', index);
     	        console.info("onAfterEdit");
     	    }


     	    function endEditing() {
     	        if (editIndex == undefined) { return true }
     	        if ($dg.datagrid('validateRow', editIndex)) {
     	            $dg.datagrid('endEdit', editIndex);
     	            editIndex = undefined;
     	            return true;
     	        } else {
     	            return false;
     	        }
     	    }
     	    function append() {
     	        if (endEditing()) {
     	            $dg.datagrid('appendRow', { status: 'P' });
     	            editIndex = $dg.datagrid('getRows').length - 1;
     	            $dg.datagrid('selectRow', editIndex)
                            .datagrid('beginEdit', editIndex);
     	        }
     	    }
     	    function removeit(){
     	        if (editIndex == undefined) { return }
     	        $dg.datagrid('cancelEdit', editIndex)
                        .datagrid('deleteRow', editIndex);
     	        editIndex = undefined;
     	    }
     	    function accept() {   	        
     	        if (endEditing()) {
     	            $dg.datagrid('acceptChanges');
     	        }
     	    }
     	    function reject() {
     	        $dg.datagrid('rejectChanges');
     	        editIndex = undefined;
     	    }
     	    function getChanges() {
     	        var effectRow = new Object();
     	        var rows = $dg.datagrid('getChanges');
     	        //var updates = $dg.datagrid('getChanges', "updated");

     	        //if (updates.length > 0) {
     	        //    effectRow['updates'] = JSON.stringify(updates);
     	        //    alert(JSON.stringify(updates));
     	        //}
     	        alert(rows.length + ' rows are changed!');
     	    }
	</script>
 
</body> 
</html>