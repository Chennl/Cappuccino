<?php
	include 'config.php';
?>
<!DOCTYPE html>
<html> 
<head>
<title>Index</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" href="./content/site.css">
<link rel="stylesheet" type="text/css" href="./Content/jquery-easyui-1.5/themes/default/easyui.css">
<link rel="stylesheet" type="text/css" href="./Content/jquery-easyui-1.5/themes/icon.css">
<script type="text/javascript" src="./Content/jquery-easyui-1.5/jquery.min.js"></script>
<script type="text/javascript" src="./Content/jquery-easyui-1.5/jquery.easyui.min.js"></script>
<script type="text/javascript" src="./Content/jquery-easyui-1.5/locale/easyui-lang-zh_CN.js"></script>
<script type="text/javascript" src="./Content/scripts/easyuiExtension.js"></script>


<link rel="stylesheet" href="./Content/ztree-v3/css/zTreeStyle/zTreeStyle.css" type="text/css">
<link rel="stylesheet" href="./Content/site.css" type="text/css">
<script type="text/javascript" src="./Content/ztree-v3/js/jquery.ztree.core.js"></script>

<style type="text/css">
 
div.layout-panel-west>.panel-header {
	text-align: center;
}
div.layout-panel-west>.panel-header>.panel-title{
	font-size: 14px;
	font-weight: bold;
	text-align: center;
	width: 100%;
}

#navmenu {
line-height: 45px;
display: table-cell;
vertical-align: middle;
}
#navmenu, #navmenu li {
list-style: none;
padding: 0;
margin: 0;
display: inline;
}

#navmenu li {
float: right;
display: inline;
list-style-type: none;
}
#navmenu li a {
font-size: 14px;
display: block;
padding: 10px;
color: #fff;
text-decoration: none;
margin-top: 8px;
}

#navmenu li a:hover {
color: #fff;
text-decoration: none;
background-color: #16669e;
}

#navmenu li a.last {
border-right: 0;
}
 
</style>
<script type="text/javascript">
// Ztree
var setting = {	
		callback: {
			//beforeClick: beforeClick,
			onClick: onZTreeClick
		}
};
function onZTreeClick(event, treeId, treeNode, clickFlag){
	var strTitle = treeNode.name;//node.attributes.tabid;
	var ctrlTab = $('#maintabs');
	if (treeNode.isParent) return;
	if (!ctrlTab.tabs('exists', strTitle)) {
		ctrlTab.tabs('add',
		{
			title: strTitle,
			id: treeNode.tId,
			selected: true,
			closable: true,
			cache: true,
			method: "POST",
			//content: createFrame(treeNode.alink)
			href: treeNode.alink
		});
	}
	else {
		ctrlTab.tabs('select', strTitle);
	}
}
var zNodes =[
 				{ name:"支出账务", open:true,click:false,
 					children: [
 					  {name:"支出记账-xjd",alink:"payments.php?department=100"},
 					  {name:"支出记账-wlbb",alink:"payments.php?department=101"} 
 					]
 				 },
 				 { name:"收入账务", open:true,click:false,
  					children: [
  		 				{name:"收入记账-小桔灯",alink:"receives.php?department=100"},
  		 				{name:"收入记账-未来宝贝",alink:"receives.php?department=101"} 
  		 				]
  		 		 }
				];
 
$(document).ready(function () {
	$.fn.zTree.init($("#mnfinacemgr"), setting, zNodes);
/* 	$.ajax({
		type: "GET",
		dataType: "JSON",
		contentType: "application/JSON",
		url: "./api/getmenus.php",
		success: function (data) {//begin success
			$.each(data, function (i, obj) {//begin each	
			//	alert("add_before-"+obj.id);	
				pid=obj.id;
				$('#topMenus').accordion('add', {
					title: obj.name,
					selected: (obj.sort == 1),
					iconcls: 'icon-save',
					content: "<div style='padding:10px'><ul  name='" + obj.name + "' menuid="+ obj.id+" ></ul></div>"
				});
			//	alert("add_after");
			});//end each
		}//end success
	}); */

	/* 	$('#topMenus').accordion({
			onSelect: function (title, index) {
				var pp = $('#topMenus').accordion('getSelected');    // get the selected panel
				if (pp) {
					var attrobj = $("ul[name='" + title + "']")[0].attributes['menuid'];
					var menuid = attrobj.value;
					if (menuid.length > 0) {
						$("ul[name='" + title + "']").tree({
							url: '/api/GetSubMenus?pid=' + menuid,
							animate: true,
							onClick: TreeOnClick
						});
							attrobj.value = '';
					}
				}
			}
		}); */

});

	function createFrame(url) {
		var s = '<iframe name="mainFrame"   scrolling="no" frameborder="0"  src="' + url + '" style="width:100%;height:100%;"></iframe>';
		return s;

	}
	</script>
	</head>
	<body class="easyui-layout">
	<div data-options="region:'north',border:false" class="loc_header"  style="height: 50px; ">
	<a class="loc-navbar-logo">客户电子审批管理系统</a><span class="loc-navbar-ver">V2.20150918</span>
	<ul id="navmenu">
	<li><a href="\account\profile"  data-options="iconCls:'icon-man'" >我的资料</a></li>
	<li><a href="\account\password"  data-options=" iconcls:'icon-lock'">修改密码</a></li>
	<li><a href="\account\logout"   data-options=" iconcls:'icon-redo'">注销登录</a></li>
	</ul>

	</div>

	<div data-options="region:'west',split:true,title:'导航菜单'" style="width:200px;">
	<div class="easyui-accordion" data-options="fit:true,border:false" id="topMenus" >
		<div title="财务管理" data-options="iconCls:'icon-edit'" style="overflow:auto;padding:5px;">
			<ul id="mnfinacemgr" class="ztree" style="overflow:auto;padding:1px;"></ul>
		</div>

		<div title="财务报表" data-options="iconCls:'icon-search'" style="overflow:auto;padding:5px;">
				<h3 style="color:#0099FF;">Accordion for jQuery</h3>
				<p>Accordion is a part of easyui framework for jQuery. It lets you define your accordion component on web page more easily.</p>
		</div>
	</div>
 </div>

	<div data-options="region:'center',title:'Center'" style="overflow: hidden;">
	<div  id="maintabs" class="easyui-tabs" data-options="fit:true,border:false,plain:true">
	<div title="About" data-options="href:'index_layout.html?m=Home&c=index&a=main'" style="padding:10px"></div>
	</div>
	</div>
	 
	<div data-options="region:'south',split:'true'" style="text-align:left; overflow: hidden; height: 40px;">
	<span class="footer">版权所有：<a href="http://www.app.swirebev.com" target=_blank >太古饮料信息科技有限公司</a>服务热线：400-86-12580</span>
	</div>

	</body>
	</html>
