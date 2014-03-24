<?php
/*
   +----------------------------------------------------------------------+
   | Author: Yang Yu <yangyu1@staff.sina.com.cn>    create@2009-5-18      |
   +----------------------------------------------------------------------+
*/
if(!defined('CURSCRIPT') || CURSCRIPT != 'index') {
	exit('<script>alert("无权访问！");window.close()</script>');
}
header("Content-Type:application/msword");   
header("Content-Disposition:attachment;filename=$ver".$res[0]['staffname']."的加班申请审批单.doc");
header("Pragma:no-cache");   
header("Expires:0");

error_reporting(0);

//$contents = file_get_contents("word.doc"); 
//echo $contents;exit;
$html = '
<html xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:w="urn:schemas-microsoft-com:office:word"
xmlns="http://www.w3.org/TR/REC-html40">

<head>
<meta http-equiv=Content-Type content="text/html; charset=gb2312">
<meta name=Generator content="Microsoft Word 11">
<title>加班申请/审批单</title>

<!--[if gte mso 9]><xml>
 <w:WordDocument>
  <w:View>Print</w:View>
  <w:Zoom>115</w:Zoom>
  <w:GrammarState>Clean</w:GrammarState>
  <w:ValidateAgainstSchemas/>
  <w:SaveIfXMLInvalid>false</w:SaveIfXMLInvalid>
  <w:IgnoreMixedContent>false</w:IgnoreMixedContent>
  <w:AlwaysShowPlaceholderText>false</w:AlwaysShowPlaceholderText>
  <w:Compatibility>
   <w:UseFELayout/>
  </w:Compatibility>
  <w:BrowserLevel>MicrosoftInternetExplorer4</w:BrowserLevel>
 </w:WordDocument>
</xml><![endif]--><!--[if gte mso 9]><xml>
 <w:LatentStyles DefLockedState="false" LatentStyleCount="156">
 </w:LatentStyles>
</xml><![endif]-->
<style>
<!--
 /* Font Definitions */
 @font-face
	{font-family:宋体;
	panose-1:2 1 6 0 3 1 1 1 1 1;}
@font-face
	{font-family:黑体;
	panose-1:2 1 6 0 3 1 1 1 1 1;}
@font-face
	{font-family:Calibri;}
@font-face
	{font-family:"\@宋体";
	panose-1:2 1 6 0 3 1 1 1 1 1;}
@font-face
	{font-family:"\@黑体";
	panose-1:2 1 6 0 3 1 1 1 1 1;}
 /* Style Definitions */
 p.MsoNormal, li.MsoNormal, div.MsoNormal
	{margin:0cm;
	margin-bottom:.0001pt;
	text-align:justify;
	text-justify:inter-ideograph;
	font-size:10.5pt;
	font-family:"Times New Roman";}
p.MsoHeader, li.MsoHeader, div.MsoHeader
	{margin:0cm;
	margin-bottom:.0001pt;
	text-align:center;
	layout-grid-mode:char;
	border:none;
	padding:0cm;
	font-size:9.0pt;
	font-family:"Times New Roman";}
p.MsoFooter, li.MsoFooter, div.MsoFooter
	{margin:0cm;
	margin-bottom:.0001pt;
	layout-grid-mode:char;
	font-size:9.0pt;
	font-family:"Times New Roman";}
span.CharChar1
	{font-family:"Times New Roman";}
span.CharChar
	{font-family:"Times New Roman";}
 /* Page Definitions */
 @page Section1
	{size:595.3pt 841.9pt;
	margin:32.9pt 64.35pt 1.0cm 62.95pt;
	layout-grid:15.6pt;}
div.Section1
	{page:Section1;}
-->
</style>

</head>
';

$html .= "
	<body lang=ZH-CN style='text-justify-trim:punctuation'>
	<div class=Section1 style='layout-grid:15.6pt'>
	<p class=MsoNormal align=center style='text-align:center'><b><span
	style='font-size:16.0pt;font-family:黑体'>加班申请<span lang=EN-US>/</span>审批单</span></b></p>
	<table class=MsoNormalTable border=1 cellspacing=0 cellpadding=0 width=737 style='width:552.85pt;margin-left:-37.15pt;border-collapse:collapse;border:none'>";

$html .= "
 <tr style='page-break-inside:avoid'>
  <td width=737 colspan=7 style='width:552.85pt;border:none;border-bottom:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='line-height:150%'><b><span style='font-size:12.0pt;line-height:150%;font-family:宋体'>姓名：<u> ".$res[0]['staffname']." </u>&nbsp;员工编号：<u> <span
  lang=EN-US>".$res[0]['staffcode']."</span> </u><span lang=EN-US>&nbsp;</span>地区：<u> <span lang=EN-US>北京</span> </u><span
  lang=EN-US>&nbsp;</span>部门：<u>&nbsp;技术部&nbsp;</u>&nbsp;职务：<u>&nbsp;".$cls_excel->get_duty_by_code($res[0]['staffcode'])."&nbsp;</u></p>
  <p class=MsoNormal style='line-height:150%'><b><i><span style='font-size:
  12.0pt;line-height:150%;font-family:宋体'>平时加班申请：（</span></i></b><b><i><span
  lang=EN-US style='line-height:150%;font-family:宋体'>20</span></i></b><b><i><span
  style='line-height:150%;font-family:宋体'>：<span lang=EN-US>00</span>后开始填写）</span></i></b></p>
  </td>
 </tr>
 <tr style='page-break-inside:avoid'>
  <td width=47 style='width:35.45pt;border:solid windowtext 1.0pt;border-top:
  none;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal align=right style='text-align:right'><b><span
  style='font-size:9.0pt;font-family:宋体'>序号</span></b></p>
  </td>
  <td width=392 colspan=3 style='width:326.85pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal align=center style='text-align:center'><b><span
  style='font-size:9.0pt;font-family:宋体'>加班时间</span></b></p>
  </td>
  <td width=203 colspan=2 style='width:119.7pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal align=center style='text-align:center'><b><span
  style='font-size:9.0pt;font-family:宋体'>事由</span></b></p>
  </td>
  <td width=94 style='width:70.85pt;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal align=center style='text-align:center'><b><span
  style='font-size:9.0pt;font-family:宋体'>审批人</span></b></p>
  </td>
 </tr>";

for ($j = 0; $j < $count; $j++){

  if ($res[$j]['desc'] == '晚上加班' || $res[$j]['desc'] == '晚上加班到翌日'){

	if ($res[$j+1]){

	   if (date("G",$res[$j]['leave_time']) <= 23  &&  date("G",$res[$j+1]['get_time']) >= 6){

			$html .= "
			 <tr style='page-break-inside:avoid;height:19.5pt'>
			  <td width=47 style='width:35.45pt;border:solid windowtext 1.0pt;border-top:none;padding:0cm 5.4pt 0cm 5.4pt;height:19.5pt'>
			  <p class=MsoNormal align=center style='margin-top:4.65pt;text-align:center'><span lang=EN-US style='font-size:9.0pt;font-family:宋体'>".++$yangyu."</span></p>
			  </td>
			  <td width=302 colspan=3 valign=top style='width:226.85pt;border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;height:19.5pt'>
			  <p style='margin-top:4.65pt'><u><span lang=EN-US style='font-size:9.0pt;font-family:宋体'>&nbsp;".date("n",$res[$j]['leave_time'])."&nbsp;</u>月<u><span lang=EN-US style='font-size:9.0pt;font-family:宋体'>&nbsp;".date("j",$res[$j]['leave_time'])."&nbsp;</span></u>日<u><span lang=EN-US style='font-size:9.0pt;font-family:宋体'>&nbsp;20:00&nbsp;</span></u>时至<u><span lang=EN-US style='font-size:9.0pt;font-family:宋体'>&nbsp;".date("n",$res[$j]['leave_time'])."&nbsp;</span></u>月<u><span lang=EN-US style='font-size:9.0pt;font-family:宋体'>&nbsp;".date("j",$res[$j]['leave_time'])."&nbsp;</span></u>日<u><span lang=EN-US style='font-size:9.0pt;font-family:宋体'>&nbsp;".date("H:i",$res[$j]['leave_time'])."&nbsp;</span></u>时</span></p>
			  </td>
			  <td width=293 colspan=2 valign=top style='width:219.7pt;border-top:none;
			  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
			  padding:0cm 5.4pt 0cm 5.4pt;height:19.5pt'>
			  <p class=MsoNormal style='margin-top:4.65pt;text-align:center'><span lang=EN-US
			  style='font-size:9.0pt;font-family:宋体'>加班</span></p>
			  </td>
			  <td width=94 valign=top style='width:70.85pt;border-top:none;border-left:
			  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
			  padding:0cm 5.4pt 0cm 5.4pt;height:19.5pt'>
			  <p class=MsoNormal style='margin-top:4.65pt'><span lang=EN-US
			  style='font-size:9.0pt;font-family:宋体'>&nbsp;</span></p>
			  </td>
			 </tr>"; 
	   }else if(date("G",$res[$j+1]['get_time'])  < 6){

		   	$html .= "
			 <tr style='page-break-inside:avoid;height:19.5pt'>
			  <td width=47 style='width:35.45pt;border:solid windowtext 1.0pt;border-top:
			  none;padding:0cm 5.4pt 0cm 5.4pt;height:19.5pt'>
			  <p class=MsoNormal align=center style='margin-top:4.65pt;text-align:center'><span
			  lang=EN-US style='font-size:9.0pt;font-family:宋体'>".++$yangyu."</span></p>
			  </td>
			  <td width=392 colspan=3 valign=top style='width:326.85pt;border-top:none;
			  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
			  padding:0cm 5.4pt 0cm 5.4pt;height:19.5pt'>
			  <p class=MsoNormal style='margin-top:4.65pt'><u><span lang=EN-US
			  style='font-size:9.0pt;font-family:宋体'>&nbsp;".date("n",$res[$j]['leave_time'])."&nbsp;</span></u><span
			  style='font-size:9.0pt;font-family:宋体'>月<u><span lang=EN-US style='font-size:9.0pt;font-family:宋体'>&nbsp;".date("j",$res[$j]['leave_time'])."&nbsp;</span></u>日<u><span lang=EN-US style='font-size:9.0pt;font-family:宋体'>&nbsp;20:00&nbsp;</span></u>时至<u><span lang=EN-US style='font-size:9.0pt;font-family:宋体'>&nbsp;".date("n",$res[$j]['leave_time'])."&nbsp;</span></u>月<u><span lang=EN-US style='font-size:9.0pt;font-family:宋体'>&nbsp;".date("j",$res[$j+1]['leave_time'])."&nbsp;</span></u>日<u><span lang=EN-US style='font-size:9.0pt;font-family:宋体'>&nbsp;".date("H:i",$res[$j+1]['get_time'])."&nbsp;</span></u>时</span></p>
			  </td>
			  <td width=203 colspan=2 valign=top style='width:119.7pt;border-top:none;
			  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
			  padding:0cm 5.4pt 0cm 5.4pt;height:19.5pt'>
			  <p class=MsoNormal style='margin-top:4.65pt;text-align:center'><span lang=EN-US
			  style='font-size:9.0pt;font-family:宋体'>加班</span></p>
			  </td>
			  <td width=94 valign=top style='width:70.85pt;border-top:none;border-left:
			  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
			  padding:0cm 5.4pt 0cm 5.4pt;height:19.5pt'>
			  <p class=MsoNormal style='margin-top:4.65pt'><span lang=EN-US
			  style='font-size:9.0pt;font-family:宋体'>&nbsp;</span></p>
			  </td>
			 </tr>";
	   }
	}else{

	   		$html .= "
			 <tr style='page-break-inside:avoid;height:19.5pt'>
			  <td width=47 style='width:35.45pt;border:solid windowtext 1.0pt;border-top:
			  none;padding:0cm 5.4pt 0cm 5.4pt;height:19.5pt'>
			  <p class=MsoNormal align=center style='margin-top:4.65pt;text-align:center'><span
			  lang=EN-US style='font-size:9.0pt;font-family:宋体'>".++$yangyu."</span></p>
			  </td>
			  <td width=392 colspan=3 valign=top style='width:326.85pt;border-top:none;
			  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
			  padding:0cm 5.4pt 0cm 5.4pt;height:19.5pt'>
			  <p class=MsoNormal style='margin-top:4.65pt'><u><span lang=EN-US style='font-size:9.0pt;font-family:宋体'>&nbsp;".date("n",$res[$j]['leave_time'])."&nbsp;</span></u><span style='font-size:9.0pt;font-family:宋体'>月<u><span lang=EN-US style='font-size:9.0pt;font-family:宋体'>&nbsp;".date("j",$res[$j]['leave_time'])."&nbsp;</span></u>日<u><span lang=EN-US style='font-size:9.0pt;font-family:宋体'>&nbsp;20:00&nbsp;</span></u>时至<u><span lang=EN-US style='font-size:9.0pt;font-family:宋体'>&nbsp;".date("n",$res[$j]['leave_time'])."&nbsp;</span></u>月<u><span lang=EN-US style='font-size:9.0pt;font-family:宋体'>&nbsp;".date("j",$res[$j]['leave_time'])."&nbsp;</span></u>日<u><span lang=EN-US style='font-size:9.0pt;font-family:宋体'>&nbsp;".date("H:i",$res[$j]['leave_time'])."&nbsp;</span></u>时</span></p>
			  </td>
			  <td width=203 colspan=2 valign=top style='width:119.7pt;border-top:none;
			  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
			  padding:0cm 5.4pt 0cm 5.4pt;height:19.5pt'>
			  <p class=MsoNormal style='margin-top:4.65pt;text-align:center'><span lang=EN-US
			  style='font-size:9.0pt;font-family:宋体'>加班</span></p>
			  </td>
			  <td width=94 valign=top style='width:70.85pt;border-top:none;border-left:
			  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
			  padding:0cm 5.4pt 0cm 5.4pt;height:19.5pt'>
			  <p class=MsoNormal style='margin-top:4.65pt'><span lang=EN-US
			  style='font-size:9.0pt;font-family:宋体'>&nbsp;</span></p>
			  </td>
			 </tr>";
	}
  }
  //if ($yangyu == '15')  break;
}


$html .= "
 <tr style='page-break-inside:avoid;height:19.5pt'>
  <td width=136 colspan=2 style='width:101.65pt;border:solid windowtext 1.0pt;
  border-top:none;padding:0cm 5.4pt 0cm 5.4pt;height:19.5pt'>
  <p class=MsoNormal align=center style='margin-top:4.65pt;text-align:center'><span
  style='font-size:9.0pt;font-family:宋体'>合计</span></p>
  </td>
  <td width=177 valign=top style='width:132.85pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:19.5pt'>
  <p class=MsoNormal style='margin-top:4.65pt'><span style='font-size:9.0pt;
  font-family:宋体'>加班次数：".$yangyu."</span></p>
  </td>
  <td width=198 colspan=2 valign=top style='width:148.25pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:19.5pt'>
  <p class=MsoNormal style='margin-top:4.65pt'><span style='font-size:9.0pt;
  font-family:宋体'>倒休次数：</span></p>
  </td>
  <td width=227 colspan=2 valign=top style='width:6.0cm;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:19.5pt'>
  <p class=MsoNormal style='margin-top:4.65pt'><span style='font-size:9.0pt;
  font-family:宋体'>餐补个数：".$yangyu."</span></p>
  </td>
 </tr>
</table>
";

$html .= "
<p class=MsoNormal><b><span lang=EN-US style='font-size:9.0pt;font-family:宋体'>&nbsp;</span></b></p>

<p class=MsoNormal><b><i><span style='font-family:宋体'>双休、法定节假日加班申请：</span></i></b></p>

<table class=MsoNormalTable border=1 cellspacing=0 cellpadding=0 width=737
 style='width:552.85pt;margin-left:-37.15pt;border-collapse:collapse;
 border:none'>
 <tr style='page-break-inside:avoid'>
  <td width=46 style='width:34.55pt;border:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal align=right style='text-align:right'><b><span
  style='font-size:9.0pt;font-family:宋体'>序号</span></b></p>
  </td>
  <td width=394 colspan=2 style='width:317.75pt;border:solid windowtext 1.0pt;
  border-left:none;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal align=center style='text-align:center'><b><span
  style='font-size:9.0pt;font-family:宋体'>加班时间</span></b></p>
  </td>
  <td width=93 style='width:47.15pt;border:solid windowtext 1.0pt;border-left:
  none;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal align=center style='text-align:center'><b><span
  style='font-size:9.0pt;font-family:宋体'>小时数</span></b></p>
  </td>
  <td width=105 style='width:68.75pt;border:solid windowtext 1.0pt;border-left:
  none;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal align=center style='text-align:center'><b><span
  style='font-size:9.0pt;font-family:宋体'>事由</span></b></p>
  </td>
  <td width=85 style='width:83.8pt;border:solid windowtext 1.0pt;border-left:
  none;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal align=center style='text-align:center'><b><span
  style='font-size:9.0pt;font-family:宋体'>倒休</span></b></p>
  </td>
  <td width=44 style='width:20.85pt;border:solid windowtext 1.0pt;border-left:
  none;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal align=center style='text-align:center'><b><span
  style='font-size:9.0pt;font-family:宋体'>审批人</span></b></p>
  </td>
 </tr>
 ";

$sec = $min = '';
$hours_num = $holi_hours_num = array();
for ($n = 0; $n < $count; $n++){

	if (($res[$n]['leave_time'] != $res[$n]['get_time'])){

		if ( $res[$n]['desc'] == '双休日加班'){

			$real_get_time = strtok($res[$n]['overtime'], ' - ');
			$real_leave_time = str_replace('(翌日)','',strtok(' - '));
			$real_day = (strrpos($real_leave_time, '00:00')!==false) ? date("j",$res[$n]['leave_time']+86400) : date("j",$res[$n]['leave_time']);
			$real_month = ((date("j",$res[$n]['leave_time'])+1) != $real_day) ? date("n",$res[$n]['leave_time']+86400) : date("n",$res[$n]['leave_time']);

			$hours_num[$n] = hours_min($real_leave_time, $real_get_time);

			$html .= "
			 <tr style='page-break-inside:avoid;height:19.5pt'>
			  <td width=46 style='width:34.55pt;border:solid windowtext 1.0pt;border-top:
			  none;padding:0cm 5.4pt 0cm 5.4pt;height:19.5pt'>
			  <p class=MsoNormal align=center style='margin-top:4.65pt;text-align:center'><span
			  lang=EN-US style='font-size:9.0pt;font-family:宋体'>".++$yangyu1."</span></p>
			  </td>
			  <td width=304 colspan=2 valign=top style='width:317.75pt;border-top:none;
			  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
			  padding:0cm 5.4pt 0cm 5.4pt;height:19.5pt'>
			  <p class=MsoNormal style='margin-top:4.65pt'><u><span lang=EN-US
			  style='font-size:9.0pt;font-family:宋体'>&nbsp;".date("n",$res[$n]['get_time'])."&nbsp;</span></u><span
			  style='font-size:9.0pt;font-family:宋体'>月<u><span lang=EN-US style='font-size:9.0pt;font-family:宋体'>&nbsp;".date("j",$res[$n]['get_time'])."&nbsp;</span></u>日<u><span lang=EN-US style='font-size:9.0pt;font-family:宋体'>&nbsp;".$real_get_time."&nbsp;</span></u>时至<u><span lang=EN-US style='font-size:9.0pt;font-family:宋体'>&nbsp;".$real_month."&nbsp;</span></u>月<u><span lang=EN-US style='font-size:9.0pt;font-family:宋体'>&nbsp;".$real_day."&nbsp;</span></u>日<u><span lang=EN-US style='font-size:9.0pt;font-family:宋体'>&nbsp;".$real_leave_time."&nbsp;</span></u>时</span></p>
			  </td>
			  <td width=93 valign=top style='width:47.15pt;border-top:none;border-left:
			  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
			  padding:0cm 5.4pt 0cm 5.4pt;height:19.5pt'>
			  <p class=MsoNormal align=center style='margin-top:4.65pt;text-align:center'><span
			  lang=EN-US style='font-size:9.0pt;font-family:宋体'>".$hours_num[$n]."</span></p>
			  </td>
			  <td width=115 valign=top style='width:68.75pt;border-top:none;border-left:
			  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
			  padding:0cm 5.4pt 0cm 5.4pt;height:19.5pt'>
			  <p class=MsoNormal align=center style='margin-top:4.65pt;text-align:center'><span
			  lang=EN-US style='font-size:9.0pt;font-family:宋体'>加班</span></p>
			  </td>
			  <td width=85 valign=top style='width:63.8pt;border-top:none;border-left:none;
			  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
			  padding:0cm 5.4pt 0cm 5.4pt;height:19.5pt'>
			  <p class=MsoNormal style='margin-top:4.65pt'><span lang=EN-US
			  style='font-size:9.0pt;font-family:宋体'>[ ]</span><span style='font-size:9.0pt;font-family:宋体'>是<span lang=EN-US>&nbsp;[ ]</span>否</span></p>
			  </td>
			  <td width=94 valign=top style='width:20.85pt;border-top:none;border-left:
			  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
			  padding:0cm 5.4pt 0cm 5.4pt;height:19.5pt'>
			  <p class=MsoNormal style='margin-top:4.65pt'><span lang=EN-US
			  style='font-size:9.0pt;font-family:宋体'>&nbsp;</span></p>
			  </td>
			 </tr>
			  ";
		  }else if ( $res[$n]['desc'] == '节假日加班'){

				
				$real_get_time = strtok($res[$n]['overtime'], ' - ');
				$real_leave_time = str_replace('(翌日)','',strtok(' - '));
				$real_day = (strrpos($real_leave_time, '00:00')!==false) ? date("j",$res[$n]['leave_time']+86400) : date("j",$res[$n]['leave_time']);

				$holi_hours_num[$n] = hours_min($real_leave_time, $real_get_time);

				$html .= "
				 <tr style='page-break-inside:avoid;height:19.5pt'>
				  <td width=46 style='width:34.55pt;border:solid windowtext 1.0pt;border-top:
				  none;padding:0cm 5.4pt 0cm 5.4pt;height:19.5pt'>
				  <p class=MsoNormal align=center style='margin-top:4.65pt;text-align:center'><span
				  lang=EN-US style='font-size:9.0pt;font-family:宋体'>".++$yangyu1."</span></p>
				  </td>
				  <td width=304 colspan=2 valign=top style='width:227.75pt;border-top:none;
				  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
				  padding:0cm 5.4pt 0cm 5.4pt;height:19.5pt'>
				  <p class=MsoNormal style='margin-top:4.65pt'><u><span lang=EN-US style='font-size:9.0pt;font-family:宋体'>&nbsp;".date("n",$res[$n]['get_time'])."&nbsp;</span></u><span style='font-size:9.0pt;font-family:宋体'>月<u><span lang=EN-US style='font-size:9.0pt;font-family:宋体'>&nbsp;".date("j",$res[$n]['get_time'])."&nbsp;</span></u>日<u><span lang=EN-US style='font-size:9.0pt;font-family:宋体'>&nbsp;".$real_get_time."&nbsp;</span></u>时至<u><span lang=EN-US style='font-size:9.0pt;font-family:宋体'>&nbsp;".date("n",$res[$n]['leave_time'])."&nbsp;</span></u>月<u><span lang=EN-US style='font-size:9.0pt;font-family:宋体'>&nbsp;".$real_day."&nbsp;</span></u>日<u><span lang=EN-US style='font-size:9.0pt;font-family:宋体'>&nbsp;".$real_leave_time."&nbsp;</span></u>时</span></p></td>
				  <td width=63 valign=top style='width:47.15pt;border-top:none;border-left:
				  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
				  padding:0cm 5.4pt 0cm 5.4pt;height:19.5pt'>
				  <p class=MsoNormal align=center style='margin-top:4.65pt;text-align:center'><span
				  lang=EN-US style='font-size:9.0pt;font-family:宋体'>".$holi_hours_num[$n]."</span></p>
				  </td>
				  <td width=115 valign=top style='width:108.75pt;border-top:none;border-left:
				  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
				  padding:0cm 5.4pt 0cm 5.4pt;height:19.5pt'>
				  <p class=MsoNormal align=center style='margin-top:4.65pt;text-align:center'><span
				  lang=EN-US style='font-size:9.0pt;font-family:宋体'>加班</span></p>
				  </td>
				  <td width=85 valign=top style='width:63.8pt;border-top:none;border-left:none;
				  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
				  padding:0cm 5.4pt 0cm 5.4pt;height:19.5pt'>
				  <p class=MsoNormal style='margin-top:4.65pt'><span lang=EN-US
				  style='font-size:9.0pt;font-family:宋体'>[ ]</span><span style='font-size:9.0pt;
				  font-family:宋体'>是<span lang=EN-US>&nbsp;[ ]</span>否</span></p>
				  </td>
				  <td width=94 valign=top style='width:70.85pt;border-top:none;border-left:
				  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
				  padding:0cm 5.4pt 0cm 5.4pt;height:19.5pt'>
				  <p class=MsoNormal style='margin-top:4.65pt'><span lang=EN-US
				  style='font-size:9.0pt;font-family:宋体'>&nbsp;</span></p>
				  </td>
				 </tr>
				  ";
		  
		  
		  }
	}
}


$html .= "
 <tr style='page-break-inside:avoid;height:22.7pt'>
  <td width=132 colspan=2 style='width:99.25pt;border:solid windowtext 1.0pt;
  border-top:none;padding:0cm 5.4pt 0cm 5.4pt;height:22.7pt'>
  <p class=MsoNormal align=center style='margin-top:4.65pt;text-align:center'><span
  style='font-size:9.0pt;font-family:宋体'>合计</span></p>
  </td>
  <td width=280 colspan=2 valign=top style='width:210.2pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:22.7pt'>
  <p class=MsoNormal style='margin-top:4.65pt'><span style='font-size:9.0pt;
  font-family:宋体'>双休加班小时数：".hours_sum($hours_num)."</span></p>
  <p class=MsoNormal style='margin-top:4.65pt'><span style='font-size:9.0pt;
  font-family:宋体'>倒休小时数：</span></p>
  <p class=MsoNormal style='margin-top:4.65pt'><span style='font-size:9.0pt;
  font-family:宋体'>餐补个数：</span></p>
  <p class=MsoNormal style='margin-top:4.65pt'><span style='font-size:9.0pt;
  font-family:宋体'>支付加班费小时数：".hours_sum($hours_num)."</span></p>
  </td>
  <td width=325 colspan=3 valign=top style='width:243.4pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:22.7pt'>
  <p class=MsoNormal align=left style='margin-top:4.65pt;text-align:left'><span
  style='font-size:9.0pt;font-family:宋体'>法定节假日加班小时数：".hours_sum($holi_hours_num)."</span></p>
  <p class=MsoNormal style='margin-top:4.65pt'><span style='font-size:9.0pt;
  font-family:宋体'>倒休小时数：</span></p>
  <p class=MsoNormal align=left style='margin-top:4.65pt;text-align:left'><span
  style='font-size:9.0pt;font-family:宋体'>餐补个数：</span></p>
  <p class=MsoNormal align=left style='margin-top:4.65pt;text-align:left'><span
  style='font-size:9.0pt;font-family:宋体'>支付加班费小时数：".hours_sum($holi_hours_num)."</span></p>
  </td>
 </tr>
</table>

<p class=MsoNormal><span lang=EN-US>&nbsp;</span></p>

</div>

</body>

</html>

";

echo $html;