<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "ѡ�����һ��";
$YM_ZT2 = "�����ҵ���ѡ�����һ����";
$YM_MK = "��ҵ���˫��ѡ��ϵͳ";
$YM_DH = 1; //��Ҫ������
$YM_QX = 2; //��ҳ������ҪȨ�ޣ�ѧί
include($baseDIR."/bysj/inc_head.php");

$number = $com_id;
$myclass = $com_from;
 ?>
 <table width="700" border="1"  bordercolor=#000000  cellpadding="3">
<tr><td colspan=5 vliang=top align=left>
	<b>ѧίע�⣺</b><br>
&nbsp;&nbsp;&nbsp;&nbsp; ����ÿ�ղ鿴һ�±�ҳ���˽Ȿ��ͬѧ��ѡ���ύ�����<font color=blue>�뼰ʱ֪ͨ������δѡ�����Ҫ����ѡ���ͬѧ�������ѡ�⹤����лл</font>��ͬʱ��Ҳ���עһ����δ��д��ϵ��ʽ��ͬѧ����֪ͨ����һ�£�����Ϣ����ѡ��ȷ�Ϻ��͸���ҵ���ָ����ʦ�á�
	</td></tr>
  <tr align=center bgColor=#5a6e8f  height=38>
    <td><font color=#FFFFFF>ѧ��</font></td>
    <td><font color=#FFFFFF>����</font></td>
    <td><font color=#FFFFFF>�༶</font></td>
    <td><font color=#FFFFFF>ѡ�����</font></td>
    <td><font color=#FFFFFF>��ϵ��ʽ</font></td>
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
    	if($ds["is_select"]==1) echo "<font color=blue>��ȷ��ѡ��</font>";
		elseif($lo["number"]) echo "���ύѡ��";
    	else echo "<font color=red>δѡ�������ѡ��</font>";
    	?></td>
    <td align=left>&nbsp;<? 
    	if($row["mobilephone"]=="0") echo "��δ��д��ϵ��ʽ";
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
