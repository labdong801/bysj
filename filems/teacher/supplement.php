<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "����ͳ������";
$YM_ZT2 = "�����ҵ����������ͳ������";
$YM_MK = "��ҵ��ƴ�����ϵͳ";
$YM_PT = "���ϵͳ";
$YM_DH = 1; //��Ҫ������
$YM_QX = 10; //��ҳ������ҪȨ��
include($baseDIR."/bysj/inc_head.php");

$teacher_id = $com_id;
 ?>

<?php
$sid = $_GET["sid"];
if($_POST["sid"]!="")$sid = $_POST["sid"];

if($_POST["submit"]){
	//�ύ���˱���еĲ���
 	$difficulty = $_POST["difficulty"];
 	$new = $_POST["new"];
 	$count1 = $_POST["count1"];
 	$count2 = $_POST["count2"];
 	$count1 += 0;
 	$count2 += 0;
 	$supplement = $count1 + $count2;
 	$source = $_POST["source"];
 	
 	$source = HTMLSpecialChars($source); 	
  	
    $sql = "update ".$TABLE."ok_topic set 
            difficulty = '$difficulty',
            new = '$new',
            source = '$source',
            count1 = $count1,
            count2 = $count2,
            supplement = $supplement
            where student_id = '$sid' && teacher_id = '$teacher_id'";
   //echo $sql;
   $open = mysql_query($sql);
}
?>
<table width="660" border="1" align="center" cellpadding="5" cellspacing="0" bordercolor=#000000>
<tr>
<td colspan=5>
	��ҵ��ƹ�������Ҫ���ṩ��Ҫ��ͳ����Ϣ������ѧ������¼����Щ��Ϣ��лл��</td>
</tr>
<?php
 $sql = "select student_id,student.name as sname,supplement  from ".$TABLE."ok_topic as oktopic,".$TABLE."student_sheet as student where oktopic.student_id=student.number&&oktopic.teacher_id='".$teacher_id."'&&oktopic.year=$CURR_YEAR order by student_id";
 //echo $sql;
 $sqlquery = mysql_query($sql);
 if($sqlquery) $currrows=mysql_num_rows($sqlquery);  
  else $currrows = 0;
  if($currrows<1){
	$currrows = 0;
	echo "<tr><td colspan=5 height=68 align=center>�Բ���ϵͳ��û����ָ�� <b>".$CURR_YEAR."��</b> ��ҵ��Ƶ�ѧ����¼</td></tr>";
  }  
  $cnt = 0;
while($row = mysql_fetch_array($sqlquery)){
	if($cnt%5==0) echo "<tr>";
     echo "<td width=130 align=center><a href=".$PHP_SELF."?sid=".$row["student_id"]."><font color=blue><u>".$row["sname"]."</u></font></a>(".($row["supplement"]?"��¼":"<font color=red>δ¼</font>").")</td>";
     if($cnt%5==4)echo "</tr>";
    $cnt++;
}
for(;$cnt%5!=0;$cnt++){
	echo "<td width=130>&nbsp;</td>";
}
?>
</table>

<?php
$showit = true;

if($sid=="") $showit = false;
 $sql = "select student.profession as spro,class,type,student_id,student.name as sname,topic,new,supplement,count1,count2,source,difficulty
   from ".$TABLE."ok_topic as oktopic,".$TABLE."student_sheet as student where oktopic.student_id=student.number&&oktopic.student_id='".$sid."'&&oktopic.teacher_id='".$teacher_id."'";
//echo $sql;
 $sqlquery = mysql_query($sql);
 $detail = mysql_fetch_array($sqlquery);
 if($detail["student_id"]=="") $showit = false;

/////////�·��ǳɼ����˱�չʾ��
if($showit){
?>
<br>
<table border=0 width=660 align=center>
<form id="form1" name="form1" method="post" action="">
  <tr>
	<td valign=top align=center>
<div align="center">
<table width="580" border="1" cellpadding="5" cellspacing="0" bordercolor=#000000>
  <tr>
    <td width="74" height="30">������Ŀ</td>
    <td colspan="3">(<strong><?php echo $detail["sname"]; ?></strong>) <?php echo $detail["topic"];?></td>
  </tr>
  <tr>
    <td height="41">�������Ƿ�<br>���¿���</td>
    <td><input type="radio" name="new" value="1" <?php echo $detail["new"]?"  checked=checked":"";?>/>�ǣ����������¿���<br>
  <input name="new" type="radio" value="0" <?php echo $detail["new"]?"":"  checked=checked";?> />�񣬱������Ǿɿ���
 </td>
    <td><div align="right">��������</div></td>
    <td><input name="count1" type="text" id="count1" value="<?php echo $detail["count1"];?>" size="8" maxlength="6" /></td>
  </tr>
  <tr>
    <td height="30">��������Դ</td>
    <td colspan="3" ><input name="source" type="text" id="source" value="<?php echo $detail["source"]?>" size="30" maxlength="28" />����������Ŀ����ע����Ŀ��������ڣ�</td>
  </tr>
  <tr>
    <td height="30">�������Ѷ�</td>
    <td width="221"><input type="radio" name="difficulty" value="ƫ��" <?php echo $detail["difficulty"]=="ƫ��"?"  checked=checked":"";?>/> ƫ��
  <input name="difficulty" type="radio" value="����" <?php echo $detail["difficulty"]=="����"?"  checked=checked":"";?> />  ����
  <input name="difficulty" type="radio" value="ƫ��" <?php echo $detail["difficulty"]=="ƫ��"?"  checked=checked":"";?> />  ƫ��</td>
    <td><div align="right">������������</div></td>
    <td><input name="count2" type="text" id="count2" value="<?php echo $detail["count2"];?>" size="8" maxlength="6" /></td>
  </tr>
</table>
<br>
<input type=submit name=submit value=�ύ�ñ�ҵ��ƿ���Ĳ�����Ϣ>
<input type=hidden name=sid value=<?php echo $sid; ?>>
</td>
</tr>
</form>
</table>
<?php
}
?>

<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>
