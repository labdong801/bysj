<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
if($fz!=2) $fz="";
$YM_ZT = "�ɼ��鿴";
$YM_ZT2 = "��".($fz?"ר":"��")."�ơ����ճɼ�һ��";
$YM_MK = "��ҵ���˫��ѡ��ϵͳ";
$YM_DH = 1; //��Ҫ������
$YM_QX = 40; //��ҳ������ҪȨ�ޣ�רҵ����
include($baseDIR."/bysj/inc_head.php");

$teacher_id = $com_id;
 ?>

<table width="770" border="0" align="center" cellpadding="2" cellspacing="3">
<tr>
<td align=center>
	<font size=+2><strong>��ҵ��ƣ����ģ����ճɼ�һ����<?php echo $fz==2?"��ר�ƣ�":""?></strong></font><br />
<table width="780" border="1" align="center" cellpadding="2" cellspacing="3">
<tr bgcolor=#CCCCCC height=28>
<td><div align="center">����</div></td>
<td><div align="center">�༶</div></td>
<td><div align="center">ѧ������</div></td>
<td><div align="center">��ҵ�����Ŀ</div></td>
<td><div align="center">����</div></td>
<td><div align="center">����</div></td>
<td><div align="center">���</div></td>
<td><div align="center">�ɼ�</div></td>
<td><div align="center">�ȼ�</div></td>
</tr>
<?php
 $sql = "select fenzu,".$TABLE."ok_topic.student_id,".$TABLE."ok_topic.type,".$TABLE."student_sheet.name as sname,".$TABLE."ok_topic.topic,class,
                score1_1,score1_2,score1_3,
                score2_1,score2_2,score2_3,
                score3_1,score3_2,score3_3, score3_4
            from ".$TABLE."ok_topic,".$TABLE."student_sheet
            where ".$TABLE."ok_topic.student_id=".$TABLE."student_sheet.number&&".$TABLE."ok_topic.year=$CURR_YEAR
            order by student_id";
 //echo $sql;
  $result = mysql_query($sql);  //��ȡ��ؼ�¼
  $cnt = 0;
$num_rows = mysql_num_rows($result);  

$nn = 1;
$cntji = array();
while($row = mysql_fetch_array($result)){
	if($row["type"]=="��ѧ�о�") $typeclass = 1;
	else $typeclass = 0;	

     $score1_1 = $row["score1_1"]*10.0/100.0;
     $score1_2 = $row["score1_2"]*10.0/100.0;
     $score1_3 = $row["score1_3"]*10.0/100.0;
     $score2_1 = $row["score2_1"]*8.0/100.0;
     $score2_2 = $row["score2_2"]*6.0/100.0;
     $score2_3 = $row["score2_3"]*6.0/100.0;
	 if($typeclass==1){
         $score3_1 = $row["score3_1"]*15.0/100.0;
         $score3_2 = $row["score3_2"]*15.0/100.0;
         $score3_3 = $row["score3_3"]*20.0/100.0;
         $score3_4 = 0;
     } else {
         $score3_1 = $row["score3_1"]*10.0/100.0;
         $score3_2 = $row["score3_2"]*10.0/100.0;
         $score3_3 = $row["score3_3"]*15.0/100.0;
         $score3_4 = $row["score3_4"]*15.0/100.0;
    }
    
    $score1_1 = ceil($score1_1*10)/10.0;
    $score1_2 = ceil($score1_2*10)/10.0;
    $score1_3 = ceil($score1_3*10)/10.0;
    $score2_1 = ceil($score2_1*10)/10.0;
    $score2_2 = ceil($score2_2*10)/10.0;
    $score2_3 = ceil($score2_3*10)/10.0;
    $score3_1 = ceil($score3_1*10)/10.0;
    $score3_2 = ceil($score3_2*10)/10.0;
    $score3_3 = ceil($score3_3*10)/10.0;
    $score3_4 = ceil($score3_4*10)/10.0;
     
	 $score1 = $score1_1+$score1_2+$score1_3;
	 $score2 = $score2_1+$score2_2+$score2_3;
	 $score3 = $score3_1+$score3_2+$score3_3+$score3_4;
	 $totalscore = ceil($score1 + $score2 + $score3);
	 
     $dengji = array("<font color=red><b>����</b></font>","<font color=red>����</font>","�е�","����","<font color=green><b>����</b></font>");
     $ji = ($totalscore-50-$totalscore%10)/10;
     if($ji < 0) $ji = 0;
     if($ji >4) $ji = 4;	 
     
     $cntji[$row["class"]][$ji]++;
 echo "<tr align=center>";
 ?>
<td><?php 	echo $row["fenzu"][4]; 	?></td>
<td><?php 	echo $row["class"]; 	?></td>
<td><?php 	echo $row["sname"]; 	?></td>
<td align=left><?php	echo $row["topic"]; 	?></td>
<td> <?php echo $score1; ?></td>
<td> <?php echo $score2; ?></td>
<td> <?php echo $score3; ?></td>
<td> <?php echo $totalscore; ?></td>
<td><?php echo $dengji[$ji]; ?></td>
</tr>
<?php
}
?>
</table>
<?php
   while(list($k,$v)=each($cntji)){
      echo $k."�����";
      for($i=0;$i<5;$i++){
   	      echo $dengji[$i]."��".$v[$i]."��&nbsp;&nbsp;";
     }
     echo "<br>";
  }
?>
</td>
</tr>
</table>
<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>

