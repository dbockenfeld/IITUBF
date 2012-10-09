<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel='stylesheet' type='text/css' href='../js/jquery/themes/iitubf/jquery-ui-1.8.5.custom.css' />
<link rel='stylesheet' type='text/css' href='../js/jquery/css/ui.jqgrid.css' />
<link rel='stylesheet' type='text/css' href='../js/jquery/src/css/jquery.searchFilter.css' />
<script type="text/javascript" src="../js/jquery/js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../js/jquery/js/jquery-ui-1.8.5.custom.min.js"></script>
<script type="text/javascript" src="../js/jquery/js/i18n/grid.locale-en.js"></script>
<script type="text/javascript" src="../js/jquery/src/jquery.searchFilter.js"></script>
<script type="text/javascript" src="../js/jquery/js/jquery.jqGrid.min.js"></script>
<script type="text/javascript" src="../js/jquery/src/jqModal.js"></script>
<script type="text/javascript" src="../js/jquery/src/jqDnR.js"></script>
<script language="JavaScript">

$(document).ready(function(){
    jQuery("#jq_messages").jqGrid({
        url:'models/admin/m_messages_view.php',
        datatype: 'json',
        colNames:['ID', 'Passage', 'Title', 'Message Description', 'Message File', 'Question File'],
        colModel :[
			{name:'message_id', index:'message_id', width:50},
			{name:'passage',index:'passage', width:120,align:'left',editable:true},
            {name:'title',index:'title',width:200,align:'left',editable:true,editoptions:{size:25}},
            {name:'message_description',index:'message_description', width:300,align:'left',sortable:false,editable:true,edittype:"textarea", editoptions:{rows:"5",cols:"50"}},
			{name:'message_file',index:'message_file',width:100,sortable:false,editable:true},
			{name:'question_file',index:'question_file',width:100,sortable:false,editable:true}
            ],
        pager: '#jq_page', 
        rowNum:20,
        rowList:[10,20,100],
        sortname: 'message_id',
        sortorder: 'desc',
        viewrecords: true,
		height: "100%",
        caption: 'Messages',
    });
			jQuery("#jq_messages").jqGrid('navGrid','#jq_page',{search:false},{width:500,reloadAfterSubmit:true},{width:500,reloadAfterSubmit:true},{reloadAfterSubmit:true},{}); 
});

</script>
</head>

<body>


<h1>IIT UBF Admin Site - Add/Edit Messages</h1>



<!-- Edit start -->
<table id="jq_messages"></table> 
<div id="jq_page"></div>

</div>
<!-- Content end -->

</body>
</html>
