<?php /* Smarty version 2.6.18, created on 2010-08-11 12:47:01
         compiled from user_list.html */ ?>
<html>
<head>
<title>用户列表</title>
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
<table width="95%" align="center" cellspacing="1" cellpadding="3" class="i_table">
<tr><td class="head" colspan="5">员工列表 &nbsp;- &nbsp;<a href="?action=add_form"><b>添加新员工(+)</b></a></td></tr>
<tr class="head_2" align="center">
<td>编号</td>
<td>姓名</td>
<td>账号</td>
<td>职位</td>
<td>操作</td>
</tr>
<?php $_from = $this->_tpl_vars['user_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['list']):
?>
<tr class="b" align="center">
<td><?php echo $this->_tpl_vars['list']['code']; ?>
</td>
<td><?php echo $this->_tpl_vars['list']['name']; ?>
</td>
<td><?php echo $this->_tpl_vars['list']['email']; ?>
</td>
<td><?php echo $this->_tpl_vars['list']['duty']; ?>
</td>
<td><a href="?action=edit&staffcode=<?php echo $this->_tpl_vars['list']['code']; ?>
">编辑</a></td>
</tr>
<?php endforeach; endif; unset($_from); ?>
</table>
<center>
<blockquote><br />
<hr class="hr" size="1">
Powered by <a href="#"><b>yangyu</b></a>
</blockquote><br />
</center>
</body></html>