<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "�����Ϣ";
$YM_ZT2 = "�ҵı�ҵ��ƣ����ģ������Ϣ��ѯ";
$YM_MK = "��ҵ����ĵ�����ϵͳ";
$YM_PT = "�ĵ�ϵͳ";
$YM_DH = 1; //��Ҫ������
$YM_QX = 1; //��ҳ������ҪȨ�ޣ�ѧ��
include($baseDIR."/bysj/inc_head.php");

$number = $com_id;
?>

<?php
echo "<script  type=\"text/javascript\" src=\"ajax_js_student.js\"></script>";
$sql = "select fenzu,teacher2_id,spmissionid,year from ".$TABLE."ok_topic  where student_id = '$number'";
$aa = mysql_query($sql);
$bb = mysql_fetch_array($aa);
if($bb["fenzu"]==""){
	Show_Message("�Բ���Ŀǰδ�����绷�ڣ���û����ķ�����Ϣ");
	@include($baseDIR."/bysj/inc_foot.php");
	exit;
}


$sql = "select filename from ".$TABLE."mission_log as log where log.mission_id = $spmissionid && log.student_id = '$number'";
$que = mysql_query($sql);
$fet = mysql_fetch_array($que);
$spfilename = $fet["filename"];

if($bb["spmissionid"]<1){
	echo "<table width=700 border=1 bordercolor=#00000000>";
	echo "<tr><td>
	<p>&nbsp;&nbsp;&nbsp;&nbsp;
	����ѧУ�涨����ҵ��ƴ��������������ɣ�ָ����ʦ���ˡ����Ľ�ʦ���ġ����С�����󡣱�ҵ��Ƴɼ����������ڶ����÷���Ӷ��ã����������������ڲ����ϵ����һ����δͨ�������ܲμ���һ���ڵĿ��ˡ�</p>
	<p>&nbsp;&nbsp;&nbsp;&nbsp;
	����Ҫ�����ϴ�����<b>".$spname."</b>���е��ĵ���Ϊ�������ģ������Ľ�ʦ���ģ����Ľ�ʦ���Ը��ĵ���׫д��������ı�ҵ��ƣ����ģ��������ĺ����֡�����ȷ���Ѿ��ϴ�����ȷ���������ģ��Ա����Ľ�ʦ�����ַ���ʵ�������</p>
	<p>&nbsp;&nbsp;&nbsp;&nbsp;
	<b><font color=red>�����·��ġ�����������������ť���ύ�����������롣</font></b><b>���ύ�����δ��ָ��ʱ��ǰ�ύ���룬��ʾ��������ҵ������ĺʹ����ᡣ</b>�ύ����������ڴ˴��鿴�Լ��Ĵ����鰲�ŵ���Ϣ��<p>
	<p>&nbsp;&nbsp;&nbsp;&nbsp;
	��Ȼ���ύ�������������ʽ����ǰ�����������ظ��ύ���ĵ���".$spname."���У����Ľ�ʦ���������һ���ύ�����������ݽ�������</p>
	</td></tr>";
	echo "</table><br>";
}

if($spfilename==""||!file_exists("../../../Docs/".$com_bysj."/$spaddress/$spfilename")){
	Show_Message("�����ĳ���δ�ύ�����޷������绷�ڡ�<br><a href=student_m.php?mission_id=$spmissionid><font color=blue><u>�뾡���ύ������ĳ���</u></font></a>");
	@include($baseDIR."/bysj/inc_foot.php");
	exit;
}


if($bb["spmissionid"]<1){
	echo "<span id=s".$number.">";
	echo "<input type=button onClick=\"lunwensongshen('s".$number."','".$number."','".$spmissionid."')\" value=������������> ";
	echo "</span>";
	@include($baseDIR."/bysj/inc_foot.php");
	exit;
}
?>
<?php
	echo "<table width=780 border=0 bordercolor=#00000000>";
	echo "<tr><td>";

$pysql = "select pyfilename as filename,teacher.name as tname from ".$TABLE."ok_topic as oktopic,".$TABLE."teacher_information as teacher where oktopic.teacher2_id=teacher.teacher_id&&oktopic.student_id = '$number';";
$pyque = mysql_query($pysql);
$pyfet = @mysql_fetch_array($pyque);
echo "<p align=left><font color=red size=+1><b>��ע�⣺</b></font>";
if($pyfet[filename]!=""&& file_exists("../../../Docs/".$com_bysj."/LunWenPingYue/".$pyfet[filename])){
   	   	$crc = md5("stu".$number.date("Ymd")."crc");
   	   	echo $pyfet["tname"]."��ʦ�Ѿ��ϴ������������<a href =StudentArchiveDown.php?obj=pingyue&crc=$crc title='���ظ��ĵ�'><font color = blue><u>�����������</u></font></a>��������޶����ģ����ڴ��ʱ����ʦ�㱨�޶������";
} else {   
	echo "<font color=blue><b><u>����������ʽ��������֮ǰ����������ʱ�����������ĵ��Ӹ嵽��".$spname."���У���</u></b></font>";
}
echo "<br><font size=+1>����С�飺<b>".$bb["fenzu"][4]."��</b>";
$dbsql = "select name,mobilephone,short_number from ".$TABLE."teacher_information  where fenzu = '".$bb["fenzu"]."'&&authority=20";
//echo $dbsql;
$dbq = mysql_query($dbsql);
$dbf = mysql_fetch_array($dbq);
if($dbf["name"]!=""){
	echo " (������飺".$dbf["name"]."��ʦ���绰��".$dbf["mobilephone"].($dbf["short_number"]?("���̺ţ�".$dbf[short_number]):"").")";
}
echo "<br>���ʱ�䣺<b>".$dabian[$bb["fenzu"]][0]."</b><br>���ص㣺<b>".$dabian[$bb["fenzu"]][1]."������ǰ��ʵ��������Ҫ׼����</b><br>�뱾С��ͬѧ�໥ת�[<font color=green>���֮ǰ������ʱ���������ע��ҳ������Ϣ</font>]</font><br>
<font color=blue size=+1><b>�������ʱ�䣺".$gooddabian[$CURR_YEAR][0]."���ص㣺".$gooddabian[$CURR_YEAR][1]."��</b></font>";
?>

<table width="660" border="1" align="center" cellpadding="5" cellspacing="0" bordercolor=#000000>
<tr bgColor=#5a6e8f height=38>
<td width="60"><font color=#FFFFFF><b><div align=center>������</div></b></font></td>
<td width="90"><font color=#FFFFFF><b><div align="center">ѧ���༶</div></b></font></td>
<td width="80"><font color=#FFFFFF><b><div align="center">ѧ������</div></b></font></td>
<td><font color=#FFFFFF><b><div align="center">��ҵ�����Ŀ</div></b></font></td>
<td width="60"><font color=#FFFFFF><b><div align="center">���ڷ���</div></b></font></td>
</tr>

<?php
 $sql = "SELECT oktopic.fenzu, topic,student.name as sname,class,oktopic.student_id as sid
FROM ".$TABLE."ok_topic as oktopic,".$TABLE."student_sheet as student
WHERE oktopic.fenzu = '".$bb["fenzu"]."'&&oktopic.student_id=student.number&&teacher2_id!=''
ORDER BY sequence, student_id";

//echo $sql;
 $sql = mysql_query($sql);
  $cnt = 1;
if($sql) $currrows=mysql_num_rows($sql);  
else $currrows = 0;
if($currrows<1){
	$currrows = 0;
	echo "<tr><td height=168 colspan=5 align=center><b>������ʹ��������δ׼���ã����Ժ�鿴��</td></tr>";
  }      
while($row = mysql_fetch_array($sql)){
	if($row["sid"]==$number)$bgcolor="#EEEEEE";
	else $bgcolor="";
 echo "<tr align=center bgcolor=$bgcolor>";
    echo "<td>".($cnt++)."</td>";
   echo "<td>".$row["class"]."</td>";
   echo "<td>".$row["sname"]."</td>";
   echo "<td align=left>&nbsp;".$row["topic"]."</td>";
   echo "<td>".$row["fenzu"][4]."��</td>";
   echo "</tr>";
}
 echo "</table>";
 echo "</td></tr></table>";
?>
<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>
