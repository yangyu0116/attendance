<?php /* Smarty version 2.6.18, created on 2010-04-16 15:20:37
         compiled from user_add.html */ ?>
<html>
<head>
<title>员工添加</title>
<meta http-equiv="Content-Type" content="text/html; charset=gbk">
<meta http-equiv="Expires" content="0">
<meta http-equiv="Pragma" content="no-cache">
<?php echo '
<style type="text/css">
table { BORDER-TOP: 0px; BORDER-LEFT: 0px; BORDER-BOTTOM: 2px}
select {
	FONT-SIZE: 12px;
	COLOR: #000000; background-color: #E0E2F1;
}
a { TEXT-DECORATION: none; color:#333}
a:hover{ text-decoration: underline;}
body {font-family:Tahoma;FONT-SIZE: 12px;MARGIN: 0;color: #666;background: #fff;}
textarea,input,select{font-size: 12px; background:#FFFCF0}
td { BORDER-RIGHT: 1px; BORDER-TOP: 0px; FONT-SIZE: 12px; COLOR: #666;}
img{border:0;}
#right-top a{ color:#666; margin:0 7px; line-height:24px}
#right-top a img{ border:0; vertical-align:middle; margin-right:6px}
.b{background:#fff;}
.left_over{background:#F0F0F0;}
.head { color: #005681;background: #D0E6F1;font-weight:bold; padding:4px 4px 3px 4px}
.head a{color: #4691B7; font-weight:normal}
.head_2 { background:fffcf0 }
.head_2 td{color: #000000;}
.hr  {border-top: 1px solid #739ACE; border-bottom: 0; border-left: 0; border-right: 0; }
.bold {font-weight:bold;}
.smalltxt {font-family: Tahoma, Verdana; font-size: 12px;color: #000000;}
.i_table{border: 1px solid #8EC1DB;background:#FFF0ee;}
.i_table .head{border-bottom:1px solid #8EC1DB}
.pages { margin-top:10px; margin-bottom:10px; margin-left:8px }
.pages * { vertical-align: middle;}
.pages a{padding:1px 4px ; background:#f9fcff;  border:1px solid #ADD2E1; margin:0 1px; color: #002F79; text-align: center; text-decoration: none; font:normal 12px Tahoma,Arial; }
.pages a:hover { border:#37A717 1px solid; background:#EDFFE4; text-decoration:none; color: #002F79}
.pages input { border:1px solid #ccc; font: Verdana;text-align: center; margin-left:2px}
.pages b { padding:2px ;  margin: 0 3px;font:bold  11px/12px Tahoma}
</style>
'; ?>

</head>
<body>
<div id="right-top" style="margin:0 1% 2%; border-bottom:1px solid #F0EFEF; padding:5px" align="center">

</div>

<form action="?action=add" method="post">
<table width="95%" align="center" cellspacing="1" cellpadding="3" class="i_table">
<tr><td class="head" colspan="2">添加员工：</td></tr>
<tr class="b"><td>员工编号：</td>
<td><input type="text" name="code" size="30" ></td></tr>
<tr class="b"><td>员工姓名：</td>
<td><input type="text" name="name" size="30" ></td></tr>
<tr class="b"><td>员工账号：</td>
<td><input name="email" size="30"></td></tr>
<tr class="b"><td>员工职位：</td>
<td><input name="duty" size="30" value=""></td></tr>
</table><br />
<center><input type="submit" value="提 交"></center>

</form>

<center>
<blockquote><br /><br /><br /><br />
<hr class="hr" size="1">
Powered by <a href="#"><b>yangyu</b></a>&nbsp;
</blockquote><br />
</center>
</body></html>