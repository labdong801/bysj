<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "����ѡ������";
$YM_ZT2 = "��ҵ���ʱ������";
$YM_MK = "����ϵ�γ�˫��ѡ��ϵͳ";
$YM_PT ="ȫ���趨";
$YM_DH = 1; //��Ҫ������
$YM_QX = 40; //��ҳ������ҪȨ��:רҵ����
include($baseDIR."/bysj/inc_head.php");

$teacher_id = $com_id;

function ShowDateHint($dtime)
{
	$now = time(0);
	$now = $now - $now%86400;
	$dtime = $dtime - $dtime%86400;
	$cnt = ($dtime-$now)/86400;
	echo "&nbsp;(";
	if($cnt>330) echo "<font color=red>��Խ�У��뱨��</font>";
	else if($cnt>120) echo "��� $cnt �죡";
	else if($cnt>61)  echo "�����º�";
	else if($cnt>30)  echo "һ���º�";
	else if($cnt>2)  echo "$cnt ���";
	else if($cnt==2) echo "����";
	else if($cnt==1) echo "����";
	else if($cnt==0) echo "����";
	else if($cnt>-7) echo "<font color=blue>����ѹ�ȥ ".(-1*$cnt)." ��</font>";
	else if($cnt>-15) echo "<font color=blue>����ѹ�ȥһ��</font>";
	else if($cnt>-31) echo "<font color=blue>����ѹ������</font>";
	else if($cnt>-61) echo "<font color=blue>����ѹ�һ����</font>";
	else if($cnt>-200) echo "����ѹ�ȥ ".(-1*$cnt)." ��";
	else if($cnt>-560) echo "<font color=red>ȥ������ã�</font>";
	else if($cnt>-860) echo "<font color=red>ǰ������ã�</font>";
	else if($cnt>-15640) echo "<font color=red>�����Զ</font>";
	else echo "ʱ��δ���ã�������";
	echo ")";
}
 ?>
<script language="JavaScript" src="/bysj/images/My97DatePicker/WdatePicker.js" defer="defer"></script>  


<?php

      $pro_list = explode(",", $com_pro_id);  
      
      if($_POST["submit"]){
         	//������
         //print_r($_POST);
         $topic_start = strtotime(trim($_POST["topic_start"]));
       	 $topic_end = strtotime(trim($_POST["topic_end"]))+86399;
         $student_start = strtotime(trim($_POST["student_start"]));
       	 $student_end = strtotime(trim($_POST["student_end"]))+86399;
       	 $teacher_start = strtotime(trim($_POST["teacher_start"]));
       	 $teacher_end = strtotime(trim($_POST["teacher_end"]))+86399;
       	 if($_POST['topic_start'] == "")
       	 {
       	 	echo "<script language='JavaScript' >alert('��ʦ�ύѡ����ʼʱ�䲻��Ϊ�գ�');</script>";
       	 }
       	 else if($_POST['topic_end'] == "")
       	 {
       	 	echo "<script language='JavaScript' >alert('��ʦ�ύѡ�����ʱ�䲻��Ϊ�գ�');</script>";
       	 }
       	 else if($topic_end <= $topic_start)
       	 {
       	 	echo "<script language='JavaScript' >alert('��ʦ�ύѡ�����ʱ��С����ʼʱ�䣡');</script>";
       	 }
         else if($_POST['student_start']=="")
         {
         	echo "<script language='JavaScript' >alert('ѧ��ѡ������ʼʱ�䲻��Ϊ�գ�');</script>";
         }
         else if($_POST['student_end']=="")
         {
         	echo "<script language='JavaScript' >alert('ѧ��ѡ�������ʱ�䲻��Ϊ�գ�');</script>";
         }
         else if($student_end <= $student_start)
         {
         	echo "<script language='JavaScript' >alert('ѧ��ѡ�������ʱ��С����ʼʱ�䣡');</script>";
         }
         else if($_POST['teacher_start']=="")
         {
         	echo "<script language='JavaScript' >alert('��ʦѡѧ����ʼʱ�䲻��Ϊ�գ�');</script>";
         }
         else if($_POST['teacher_end']=="")
         {
         	echo "<script language='JavaScript' >alert('��ʦѡѧ������ʱ�䲻��Ϊ�գ�');</script>";
         }
         else if($teacher_end <= $teacher_start)
         {
         	echo "<script language='JavaScript' >alert('��ʦѡѧ������ʱ��С����ʼʱ�䣡');</script>";
         }
         else
         {
         	//�ų�����ʱ�䲻��������أ���ʼ��¼���ݿ�
         	$sql = "UPDATE `".$ART_TABLE."set_date` SET `topic_start`='".$topic_start."',`topic_end`='".$topic_end."',`student_start` = '".$student_start."',`student_end` = '".$student_end."',`teacher_start`='".$teacher_start."',`teacher_end`='".$teacher_end."'  WHERE `grade` =4;";
         	mysql_query($sql);
         }
         
      }      
      else if($_POST["clean"]){
      	$sql = "UPDATE `".$ART_TABLE."set_date` SET `topic_start`='0',`topic_end`='0',`student_start` = '0',`student_end` = '0',`teacher_start`='0',`teacher_end`='0'  WHERE `grade` =4;";
      	mysql_query($sql);
      }
//  
//     $majiorlist = get_majior_list($com_pro);
//	 $curr_pro_id = $set_pro_id;
//	 echo "��ѡ��Ҫ���õ�רҵ��";
//	 $pro_name = "";
//	 while(list($k,$v)=each($majiorlist)){
//	 	   if(in_array($k,$pro_list)&&$v[open]){
//	 	   	   if($curr_pro_id ==0) $curr_pro_id = $k;
//	 	   	   if($curr_pro_id == $v["id"]){
//	 	   	   	    echo "[<b>".$v["name"]."</b>]";
//			 	    $pro_name = $v["name"];
//	 	   	   } else echo "[<a href=".$PHP_SELF."?set_pro_id=".$k."><font color=blue><u>".$v["name"]."</u></font></a>]";
//	 	   	   echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
//	 	   }
// 	 }
//      	 
	 $sql = "select * from ".$ART_TABLE."set_date where grade = '4'";
	 $que_sql = mysql_query($sql);
	 $row = mysql_fetch_array($que_sql);
?>
<p>
<a href="art_grade1_set_date.php"><font color=blue>[����ѡ��ʱ������]</font></a>
<a href="art_grade2_set_date.php"><font color=blue>[���١�����ʱ������]</font></a>
<a href="art_grade3_set_date.php"><font color=blue>[���޷���ʱ������]</font></a>
<a href="art_grade4_set_date.php"><font color=blue>[��ҵ���ʱ������]</font></a>
</p>
<form name="form1" action="<?php echo $PHP_SELF; ?>" method="post">

 <?php if($row["student_start"]<10000) echo "<font color=red><b>��ʾ��</b>��ǰ��δ�����κ����ڡ��������ã��������޸�ѡ��ʱ�Ρ���ť��</font> <br>"; ?>
 <br>
<table width="600" border="1" cellpadding="6" bordercolor=#000000>
<tr>
<td rowspan="2" width="128"><div align="center" width><span class="STYLE1"><FONT color=red size=+2 face=����><B>1.</B></FONT>��ʦ�ύѡ��</span></div></td>
<td width="100">��ʼʱ�䣺</td>
<td><input type="text" name="topic_start"  value="<?php echo date("Y-m-d",$row["topic_start"]>0?$row["topic_start"]:time(0));?>"  onclick="WdatePicker()" onchange="checkInputDate(this)" class="Wdate"/><?php ShowDateHint($row["topic_start"]); ?></td>
</tr>
<tr>
<td>��ֹʱ�䣺</td>
<td><input type="text" name="topic_end"   value="<?php echo date("Y-m-d",$row["topic_end"]>0?$row["topic_end"]:(time(0)+5*86400));?>"  onclick="WdatePicker()" onchange="checkInputDate(this)" class="Wdate"/><?php ShowDateHint($row["topic_end"]); ?></td>
</tr>
<tr>
<td rowspan="2"><div align="center"><span class="STYLE1"><FONT color=red size=+2 face=����><B>2.</B></FONT>ѧ��ѡ�����</span></div></td>
<td width="100">��ʼʱ�䣺</td>
<td><input type="text" name="student_start"  value="<?php echo date("Y-m-d",$row["student_start"]>0?$row["student_start"]:(time(0)+6*86400));?>"   onclick="WdatePicker()" onchange="checkInputDate(this)" class="Wdate"/><?php ShowDateHint($row["student_start"]); ?></td>
</tr>
<tr>
<td>��ֹʱ�䣺</td>
<td><input type="text" name="student_end"  value="<?php echo date("Y-m-d",$row["student_end"]>0?$row["student_end"]:(time(0)+8*86400));?>"  onclick="WdatePicker()" onchange="checkInputDate(this)" class="Wdate"/><?php ShowDateHint($row["student_end"]); ?></td>
</tr>
<tr>
<td rowspan="2"><div align="center"><span class="STYLE1"><FONT color=red size=+2 face=����><B>3.</B></FONT>��ʦѡ��ѧ��</span></div></td>
<td width="100">��ʼʱ�䣺</td>
<td><input type="text" name="teacher_start" value="<?php echo date("Y-m-d",$row["teacher_start"]>0?$row["teacher_start"]:(time(0)+9*86400));?>"  onclick="WdatePicker()" onchange="checkInputDate(this)" class="Wdate"/><?php ShowDateHint($row["teacher_start"]); ?></td>
</tr>
<tr>
<td>��ֹʱ�䣺</td>
<td><input type="text" name="teacher_end"  value="<?php echo date("Y-m-d",$row["teacher_end"]>0?$row["teacher_end"]:(time(0)+13*86400));?>"  onclick="WdatePicker()" onchange="checkInputDate(this)" class="Wdate"/><?php ShowDateHint($row["teacher_end"]); ?></td>
</tr>

</table>


 <?php if($row["student_start"]<10000) echo "<br><font color=red><b>��ʾ��</b>��ǰרҵ��δ�����κ����ڡ��������ã��������޸�ѡ��ʱ�Ρ���ť��</font> <br>"; ?>
	<br><input type=hidden name=set_pro_id value=<?php echo $curr_pro_id; ?>>	
	<input type="submit" name="submit" value="�޸�ѡ��ʱ��">
	<input type="submit" name="clean" value="���ʱ������">
</form>

<table width="500">
<tr>
<td align="center">
  <span class="STYLE2">ע�⣺ʱ��������ʽΪ��XXXX-XX-XX����<?php echo date("Y-m-d");?></span></td>
</tr>
</table>


<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>