<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
//$YM_ZT = "���˻��ڣ����˱��ӡ";
//$YM_ZT2 = "���˻��ڣ����С���ӡѧ���ɼ����˱�";
$YM_ZT = "���˻��ڣ���������鿴";
$YM_ZT2 = "���˻��ڣ��������˶Ա��鿼�����׫д���";
$YM_MK = "��ҵ��ƴ�����ϵͳ";
$YM_PT = "���ϵͳ";
$YM_DH = 1; //��Ҫ������
$YM_QX = 10; //��ҳ������ҪȨ��
include($baseDIR."/bysj/inc_head.php");

$teacher_id = $com_id;
 ?>
<?php
include("inc_print.php");
$sid = $_GET["sid"];
if($_POST["sid"]!="")$sid = $_POST["sid"];
?>
<table width="660" border="1" align="center" cellpadding="5" cellspacing="0" bordercolor=#000000>
<tr>
<td colspan=5>
	<font class=bigdate ><strong><font color=blue>&nbsp;&nbsp;���˱�鿴&nbsp;&nbsp;</font></strong></font>
	���ѧ����������ʾ�ʹ�ӡѧ���ı�ҵ��ƿ��˳ɼ���<?php
	if($com_auth>=20){
		if($seemy!="yeah")	  echo "[<a href=".$PHP_SELF."?seemy=yeah>ֻ���Լ���</a>]";
		else 	  echo "[<a href=".$PHP_SELF.">����С��ȫ��</a>]";
	}
	?></td>
</tr>
<?php
//if( $seemy!="yeah"&&$com_auth>=20) {
//	 $tiaojian = "&& oktopic.fenzu = '".$com_fenzu."' && oktopic.year =$CURR_YEAR";
//} else $tiaojian = "&& oktopic.teacher2_id = '".$teacher_id."' && oktopic.year =$CURR_YEAR";
  $tiaojian = "&& oktopic.year =$CURR_YEAR";
  $tiaojian .= "&& oktopic.fenzu = '$com_fenzu'";
  if($seemy == "yeah") $tiaojian .= "&& oktopic.teacher2_id = '$teacher_id'";
  
 $sql = "select student_id,oktopic.fenzu,oktopic.teacher2_id,student.name as sname  from ".$TABLE."ok_topic as oktopic,".$TABLE."student_sheet as student where oktopic.student_id=student.number&&oktopic.year=$CURR_YEAR".$tiaojian." order by student_id";
 //echo $sql;
 $sqlquery = mysql_query($sql);
  if($sqlquery) $currrows=mysql_num_rows($sqlquery);  
  else $currrows = 0;
  if($currrows<1){
	$currrows = 0;
	echo "<tr><td colspan=5 height=68 align=center>�Բ��𣬴�����黹û�и����������������������Դ˴�Ҳ����������Ҫ�����ѧ��������</td></tr>";
  }  
  $cnt = 0;
while($row = mysql_fetch_array($sqlquery)){
	if($cnt%5==0) echo "<tr>";
     echo "<td width=130 align=center><a href=".$PHP_SELF."?seemy=$seemy&sid=".$row["student_id"]."><font color=blue><u>".$row["sname"]."</u></font></a></td>";
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
else {
 $sql = "select student.profession as spro,class,type,student_id,oktopic.teacher2_id,oktopic.teacher_id,student.name as sname,topic,
   score1_1,score1_2,score1_3,score2_1,score2_2,score2_3,score3_1,score3_2,score3_3,score3_4,
   comment1,comment2,comment3,comment4,oktopic.year
   from ".$TABLE."ok_topic as oktopic,".$TABLE."student_sheet as student,".$TABLE."teacher_information as teacher where oktopic.student_id=student.number&&oktopic.teacher2_id=teacher.teacher_id&&oktopic.student_id='".$sid."'".$tiaojian;
//echo $sql;
 $sqlquery = mysql_query($sql);
 $detail = mysql_fetch_array($sqlquery);
 if($detail["student_id"]=="") $showit = false;
}

/////////�·��ǳɼ����˱�չʾ��
if($showit){
	examine_show($detail);
	//echo "</td></tr><tr><td>";
	//echo "<input type=button value=��ӡ�ɼ����˱� onclick=\"javascript:location.href='examine_print.php?sid=".$sid."'\">";
	echo "<input type=button value=��ӡ�ɼ����˱� onclick=\"javascript:window.open('examine_print.php?sid=".$sid."','fullscreen')\">";
} else if($com_auth>=20 && $seemy!="yeah"){
	// ����ʾ����ɼ��Ļ�������ɿ�������δ��ɽ�ʦ�������
 $sql = "select class,student_id,teacher.name as tname2,oktopic.teacher_name as tname1,
 					student.name as sname,oktopic.year,oktopic.fenzu as zu,
 					Length(comment1) as com1,Length(comment2) as com2,
 					Length(comment3) as com3,Length(comment4) as com4
   from ".$TABLE."ok_topic as oktopic,".$TABLE."student_sheet as student,".$TABLE."teacher_information as teacher where oktopic.student_id=student.number&&oktopic.teacher2_id=teacher.teacher_id&&(Length(comment1)<10||Length(comment2)<10||Length(comment3)<10||Length(comment4)<10||comment1 IS NULL||comment2 IS NULL||comment3 IS NULL||comment4 IS NULL)&&oktopic.year=$CURR_YEAR".($com_auth>=80?"":"&& oktopic.fenzu = '$com_fenzu'")." order by oktopic.fenzu,oktopic.teacher2_id";
  //echo $sql;
 $comsqlquery = mysql_query($sql);
 $currrows=mysql_num_rows($comsqlquery);
 if($currrows>0) {
 		echo "<br><font size=+1>������ο������������δ�������һ����</font><br>";
 		echo "<table width=800 border=1 align=center cellpadding=5 cellspacing=0 bordercolor=#000000><tr align=center bgcolor=#5aFF8f height=22><td>����</td><td>�༶</td><td>ѧ��</td><td>ѧ��</td><td>ָ����ʦ</td><td>�������</td><td>���Ľ�ʦ</td><td>�������</td><td>������</td><td>�ۺ����</td></tr>\n";
 		$cnt = 0;
 		while($row = mysql_fetch_array($comsqlquery)){
 				$col1 = ($row["com1"]>10?"":" bgcolor=#EEEEEE");
 				$col2 = ($row["com2"]>10?"":" bgcolor=#CCCCCC");
 						$col5 = $col2;
 				$col3 = ($row["com3"]>10?"":" bgcolor=#CCCCCC");
 						if($col5=="") $col5 = $col3;
 				$col4 = ($row["com4"]>10?"":" bgcolor=#CCCCCC");
 						if($col5=="") $col5 = $col4;
    		 echo "<tr align=center><td>".$row["zu"]."</td><td>".$row["class"]."</td><td>".$row["student_id"]."</td><td><a href=".$PHP_SELF."?seemy=$seemy&sid=".$row["student_id"]."><font color=".($row[zu]!=$com_fenzu?"":blue)."><u>".$row["sname"]."</u></font></a></td><td $col1>".$row["tname1"]."</td><td $col1>".($row["com1"]>10?"��":"ȱ")."</td><td $col5>".substr($row["tname2"],0,10)."</td><td $col2>".($row["com2"]>10?"��":"ȱ")."</td><td $col3>".($row["com3"]>10?"��":"ȱ")."</td><td $col4>".($row["com4"]>10?"��":"ȱ")."</td></tr>";
    		$cnt++;
 		}
 		echo "</table>";
 	}
}
?>
<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>
