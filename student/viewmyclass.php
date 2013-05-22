<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "选题情况一览";
$YM_ZT2 = "本班毕业设计选题情况一览表";
$YM_MK = "毕业设计双向选题系统";
$YM_DH = 1; //需要导航条
$YM_QX = 2; //本页访问需要权限：学委
include($baseDIR."/bysj/inc_head.php");

$number = $com_id;
$myclass = $com_from;
 ?>
 <table width="700" border="1"  bordercolor=#000000  cellpadding="3">
<tr><td colspan=5 vliang=top align=left>
	<b>学委注意：</b><br>
&nbsp;&nbsp;&nbsp;&nbsp; 请您每日查看一下本页，了解本班同学的选题提交情况，<font color=blue>请及时通知本班尚未选题或需要重新选题的同学尽快完成选题工作，谢谢</font>。同时，也请关注一下尚未填写联系方式的同学，请通知更新一下，该信息用于选题确认后发送给毕业设计指导老师用。
	</td></tr>
  <tr align=center bgColor=#5a6e8f  height=38>
    <td><font color=#FFFFFF>学号</font></td>
    <td><font color=#FFFFFF>姓名</font></td>
    <td><font color=#FFFFFF>班级</font></td>
    <td><font color=#FFFFFF>选题情况</font></td>
    <td><font color=#FFFFFF>联系方式</font></td>
  </tr>
<?php

$sql = "select class,name,number,mobilephone from ".$TABLE."student_sheet";
 $ss = mysql_query($sql);
 while($row = mysql_fetch_array($ss)){
 	  if($row["class"]!=$myclass) continue;
?>
  <tr align=center>
    <td><? echo $row["number"];?></td>
    <td align=left><? echo $row["name"];?></td>
    <td><? echo $row["class"];?></td>
    <td><? 
	 $sd = mysql_query("select is_select from ".$TABLE."topic where student_number = '$row[number]'&&verify>0");
	 $ds = mysql_fetch_array($sd);
	 $ol = mysql_query("select number from ".$TABLE."student_select where number = '$row[number]'");
	 $lo = mysql_fetch_array($ol);
    	if($ds["is_select"]==1) echo "<font color=blue>已确定选题</font>";
		elseif($lo["number"]) echo "已提交选题";
    	else echo "<font color=red>未选题或需再选题</font>";
    	?></td>
    <td align=left>&nbsp;<? 
    	if($row["mobilephone"]=="0") echo "尚未填写联系方式";
    	else "&nbsp;";
    	?></td>
  </tr>
  <?php
}
?>
</table>
<?
  @include($baseDIR."/bysj/inc_foot.php");
?>
