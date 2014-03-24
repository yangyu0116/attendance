<?php /* Smarty version 2.6.18, created on 2010-09-16 10:15:17
         compiled from index.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'index.html', 9, false),array('modifier', 'escape', 'index.html', 16, false),array('modifier', 'rawurlencode', 'index.html', 59, false),array('modifier', 'date_format', 'index.html', 62, false),array('function', 'html_options', 'index.html', 21, false),array('function', 'mailto', 'index.html', 93, false),)), $this); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD><TITLE><?php echo $this->_tpl_vars['ver']; ?>
技术部考勤表</TITLE>
<META http-equiv=Content-Language content=zh-cn>
<META http-equiv=Content-Type content="text/html; charset=gb2312">
<META NAME="Author" content="杨宇 yangyu1@staff.sina.com.cn create@20090415"> 
<LINK href="/css/style.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="/js/common.js"></script>
</head>
<body style="background:url(/images/bg/<?php echo ((is_array($_tmp=@$_COOKIE['excel_bg'])) ? $this->_run_mod_handler('default', true, $_tmp, 12) : smarty_modifier_default($_tmp, 12)); ?>
.gif)">
<br id="top"/><br>
<table class="td_style" width="100%">
    <tr>
	<form method="post" name="form" action="/">
      <td style="text-align:right;width:50%;">
		  <input class="submit" type="button" value="所有员工" onClick="location.href='/'"/>
		  &nbsp;&nbsp;<input id="keywords" type="text" name="keywords" class="input_box" value=<?php if ($_POST['keywords']): ?><?php echo ((is_array($_tmp=$_POST['keywords'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
<?php elseif ($_GET['staffname']): ?><?php echo ((is_array($_tmp=$_GET['staffname'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
<?php elseif ($_GET['staffcode']): ?><?php echo ((is_array($_tmp=$_GET['staffcode'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
<?php elseif ($_GET['uname']): ?><?php echo ((is_array($_tmp=$_GET['uname'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
<?php else: ?>'请输入员工编号或姓名'<?php endif; ?> class="input_box" onfocus="if (this.value=='请输入员工编号或姓名') this.value=''" onblur="if(this.value=='') this.value='请输入员工编号或姓名'" style="color:gray" title="请输入员工编号或姓名"/> 
		  <input class="submit" type="submit" name="searchsubmit" value="搜索" style="background:url(/images/button/bt1.gif) no-repeat;width:63px;"/>
		  &nbsp;&nbsp;<input class="submit" type="button" value="生成加班申请审批单" onClick="javascript:toword('<?php echo ((is_array($_tmp=@$this->_tpl_vars['keywords'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
','<?php echo $this->_tpl_vars['ver']; ?>
');" style="background:url(/images/button/bt2.gif) no-repeat;width:160px;font-weight:bold"/>
	  </td>
	  <td style="text-align:left;width:30%;padding-left:50px">
		  <select name=ver onChange="document.form.submit();"><?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['ver_info'],'selected' => $this->_tpl_vars['ver']), $this);?>
</select>
		  &nbsp;
		  <select name=department><option value="tec">技术部</option></select>
		  &nbsp;
	  </td>
	  <td style="text-align:left;width:20%;padding-left:10px">
		  <select name=img onChange="changeSkin(this.value)"><?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['dict_css'],'selected' => ((is_array($_tmp=@$_COOKIE['excel_bg'])) ? $this->_run_mod_handler('default', true, $_tmp, 12) : smarty_modifier_default($_tmp, 12))), $this);?>
</select>
	  </td>
	  <br />
    </tr>
	<tr><td colspan=3>&nbsp;<p></td></tr>
	</form>
    <tr>
      <td style="text-align:left;color:gray;" colspan=2>小贴士：带(*)表示具备倒休条件；<s>&nbsp;迟到&nbsp;</s>表示因为恶劣天气影响在9:30以前不计迟到；<s>&nbsp;早退&nbsp;</s>表示因为特殊情况不计早退；本系统数据以EXCEL考勤数据为准。</td>
    </tr>
</table>
<hr>
<table class="td_style" id="table" width="100%" bgColor=#ffffff borderColorDark=#ffffff borderColorLight=#c0c0c0 border=1 style="<?php if ($this->_tpl_vars['keywords']): ?>filter:Alpha(opacity=70);<?php endif; ?>border-left:1px solid #ffffff;border-right:1px solid #ffffff;">
  <tbody> 
  <tr height="50">
	   <td width="70">员工编号</td>
       <td width="70">姓名</td>
       <td width="70">日期</td>
	   <td width="60">星期</td>
       <td width="90">上班打卡时间</td>
	   <td width="90">下班打卡时间</td>
	   <td width="70">是否迟到</td>
	   <td width="70">是否早退</td>
	   <td>加班描述</td>
	   <td>加班时间</td>
	   <td>休息日加班小时数</td>
	   <td>休息日</td>
  </tr>
	<tr>
	<?php $this->assign('i', 1); ?>
	<?php $_from = $this->_tpl_vars['res']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['list']):
?>
		
		<td id="<?php echo $this->_tpl_vars['list']['staffcode']; ?>
"><a href="?staffcode=<?php echo $this->_tpl_vars['list']['staffcode']; ?>
&ver=<?php echo $this->_tpl_vars['ver']; ?>
"><?php echo $this->_tpl_vars['list']['staffcode']; ?>
</a></td>
		<td id="<?php echo $this->_tpl_vars['list']['staffname']; ?>
"><a href="?staffname=<?php echo ((is_array($_tmp=$this->_tpl_vars['list']['staffname'])) ? $this->_run_mod_handler('rawurlencode', true, $_tmp) : rawurlencode($_tmp)); ?>
&ver=<?php echo $this->_tpl_vars['ver']; ?>
"><?php echo $this->_tpl_vars['list']['staffname']; ?>
</a></td>
		<td style="text-align:left;">&nbsp;<?php echo $this->_tpl_vars['list']['datetime']; ?>
</td>
		<td><?php echo $this->_tpl_vars['dict_week'][$this->_tpl_vars['list']['weekday']]; ?>
</td>
		<td><?php echo ((is_array($_tmp=$this->_tpl_vars['list']['get_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%H:%M:%S") : smarty_modifier_date_format($_tmp, "%H:%M:%S")); ?>
</td>
		<td><?php echo ((is_array($_tmp=$this->_tpl_vars['list']['leave_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%H:%M:%S") : smarty_modifier_date_format($_tmp, "%H:%M:%S")); ?>
</td>
		<td><?php echo ((is_array($_tmp=@$this->_tpl_vars['list']['is_late'])) ? $this->_run_mod_handler('default', true, $_tmp, '&nbsp;') : smarty_modifier_default($_tmp, '&nbsp;')); ?>
</td>
		<td><?php echo ((is_array($_tmp=@$this->_tpl_vars['list']['is_early'])) ? $this->_run_mod_handler('default', true, $_tmp, '&nbsp;') : smarty_modifier_default($_tmp, '&nbsp;')); ?>
</td>
		<td><?php echo ((is_array($_tmp=@$this->_tpl_vars['list']['desc'])) ? $this->_run_mod_handler('default', true, $_tmp, '&nbsp;') : smarty_modifier_default($_tmp, '&nbsp;')); ?>
</td>
		<td><?php echo ((is_array($_tmp=@$this->_tpl_vars['list']['overtime'])) ? $this->_run_mod_handler('default', true, $_tmp, '&nbsp;') : smarty_modifier_default($_tmp, '&nbsp;')); ?>
</td>
		<td><?php echo ((is_array($_tmp=@$this->_tpl_vars['list']['hours'])) ? $this->_run_mod_handler('default', true, $_tmp, '&nbsp;') : smarty_modifier_default($_tmp, '&nbsp;')); ?>
</td>
		<td><?php echo ((is_array($_tmp=@$this->_tpl_vars['list']['weekend'])) ? $this->_run_mod_handler('default', true, $_tmp, '&nbsp;') : smarty_modifier_default($_tmp, '&nbsp;')); ?>
</td>
		<?php if (+ + $this->_tpl_vars['i']%2): ?></tr><tr><?php endif; ?>
	<?php endforeach; else: ?>
		<td colspan=12 height="50px">没有找到相关记录</td>
	<?php endif; unset($_from); ?>
	<?php if ($this->_tpl_vars['keywords']): ?></tr><tr><td colspan=12 style="text-align:left;padding-left:20px">打卡记录：<?php echo $this->_tpl_vars['attend_num']; ?>
 &nbsp;&nbsp;&nbsp; 迟到：<?php echo $this->_tpl_vars['is_late_num']; ?>
 次&nbsp;&nbsp;&nbsp; 补假：<?php echo $this->_tpl_vars['no_attend_num']; ?>
 次</td><?php endif; ?>
	</tr>
	<tr><td colspan=12 style="text-align:left;padding-left:20px">实用工具：<a href="JavaScript:window.external.AddFavorite(location.href,'考勤说明表')">加入收藏</a>&nbsp;&nbsp;&nbsp; <a href="/templates/date.html" target="_blank">查看日历</a></td>
</tbody> 
</table>
<?php if (! $this->_tpl_vars['keywords']): ?>
<!--floating tools bar start-->
<div id="toolbar" class="toolbar">
<table class="td_style" height="50px" width="450px" border=0 cellspacing="0" cellpadding="3" bgcolor=#FFFFFF> 
<tr>
	<td>
			<label><span style="color:#000;font-weight:bold;">员工编号或姓名： </span></label><input id="code" type="text" name="code" class="input_box"/> <input type="submit" value="快速定位"  onClick="javascript:loaction();" class="button"/> <input type="button" value="回到顶部" onClick="location.href='#top'" class="button"/><br />
	</td>
</tr>
</table>
</div>
<!--floating tools bar end-->
<?php endif; ?>
<hr>
<div style="text-align:right;font-size:12px">suggestion：<?php echo smarty_function_mailto(array('address' => "yangyu1@staff.sina.com.cn",'encode' => 'javascript'), $this);?>
</div>
<?php echo '
<script language="JavaScript">
<!--
float_toolBar("toolbar");

var texts = document.getElementsByTagName("input");
for(var i=0;i<texts.length;i++){   
	var text = texts[i];
   if(text.attributes["default"]){
	  var defaultValue = text.attributes["default"].value;
	  text.value = defaultValue;
	  if(text.addEventListener){  
		text.addEventListener("click",disappearHint,false);
		text.addEventListener("blur",appearHint,false);
	  }
	  else{
		text.attachEvent("onclick",disappearHint);
		text.attachEvent("onblur",appearHint);
	  }
	}
} 
function disappearHint(){

   var sender =document.all?event.srcElement:this;
   if(sender.value==sender.attributes["default"].value){
	sender.value="";
   }
}
function appearHint(){
	var sender =document.all?event.srcElement:this;
	if(sender.value==""){sender.value=sender.attributes["default"].value;}
} 
-->
</script>
'; ?>

<!--<script language="JavaScript" src="http://www.sinaimg.cn/hs/chengzhi/Geyes/Geyes.js" type="text/javascript"></script>-->
</BODY>
</HTML>