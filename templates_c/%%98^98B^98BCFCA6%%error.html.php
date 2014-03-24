<?php /* Smarty version 2.6.18, created on 2010-03-15 15:34:36
         compiled from error.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'mailto', 'error.html', 20, false),)), $this); ?>
<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=gb2312">
<TITLE> 错误信息 </TITLE>
<?php echo '
<style type="text/css">
.red{color:red}
</style>
'; ?>

</HEAD>
<BODY background=http://image2.sina.com.cn/home/images/tz-001.gif >
<table border=0 cellpadding=0 cellspacing=0 >
 <tr><td height=134></td></tr>
</table>
<table width=544 height=157 border=0 cellpadding=0 cellspacing=0 align=center>
  <tr valign=middle align=middle>
	<td background=http://image2.sina.com.cn/home/images/tz-002.gif>
	    <table border=0 cellpadding=0 cellspacing=0 >
		 <tr>
		    <td  style="padding-left:80px;padding-top:10px;font-size:15px">对不起，您还没有访问权限，请将<span class="red">员工编号，姓名，<br>邮箱和职位</span>发送到<?php echo smarty_function_mailto(array('address' => "yangyu1@staff.sina.com.cn",'subject' => "申请考勤访问权限"), $this);?>
</td>
                 </tr>
            </table>
	</td>
  </tr>
</table>