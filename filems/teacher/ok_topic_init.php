<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "��ҵ�����Ϣ��ʼ��";
$YM_ZT2 = "��ҵ�����Ϣ��ʼ�������ã�";
$YM_MK = "��ҵ��ƴ�����ϵͳ";
$YM_PT = "���ϵͳ";
$YM_DH = 1; //��Ҫ������
$YM_QX = 80; //��ҳ������ҪȨ�ޣ�����Ա
include($baseDIR."/bysj/inc_head.php");

$teacher_id = $com_id;
   echo "<b>".$CURR_YEAR."�� ".$pro_name." רҵ</b> ��ҵ�������ͳ��һ����<br>";
 ?>

	<form name=ok_topic method=post action=<?php echo $PHP_SELF;?>>
	<input type=radio name=doit value=update checked>������Ŀ
	<input type=radio name=doit value=input>��������
	<input type=radio name=doit value=clear>�������
	ȷ�ϣ�<input type=password name=mm size=8>
	<input type=submit value=����ִ�в���>
</form>
<?php
$doit = $_POST["doit"];
$mm = $_POST["mm"];
if($doit=="update"&&$mm=="timu") {
	$sql = "select oktopic.student_id,oktopic.topic as old,topic.topic as new from ".$TABLE."ok_topic as oktopic, ".$TABLE."topic as topic where is_select = 1 &&topic.year=$CURR_YEAR&&topic.student_pro_id=".$CURR_PID."&&oktopic.topic<>topic.topic&&oktopic.student_id=topic.student_number";
	//echo $sql;
	$que = mysql_query($sql);
	$cnt = 0;
	while($fet = @mysql_fetch_array($que)){
		$cnt ++;
		$tmpsql = "update ".$TABLE."ok_topic set topic='".$fet["new"]."' where topic='".$fet["old"]."'&&student_id='".$fet["student_id"]."'";
		//echo "<br>".$tmpsql;
		@mysql_query($tmpsql);
	}
	echo "�����Ŀͬ�� $cnt �� <br>";
}

if($doit =="clear"&&$mm=="qingkong") {
	mysql_query("DELETE from `".$TABLE."ok_topic` WHERE year=$CURR_YEAR&&student_pro_id=$CURR_PID");
	echo "����յ�ǰרҵ�Ŀ�����Ϣ��<br>";
}

if($doit=="input"&&$mm=="daoru")  {
      $sql = "select topic,student_number,topic .teacher_id as tid, teacher.name as tname, teacher.techpos as tpos, sort.name as typename,student_pro_id
                  from ".$TABLE."topic as topic ,".$TABLE."student_sheet as student,".$ART_TABLE."title_sort as sort, ".$TABLE."teacher_information as teacher
                  where student.number=topic .student_number &&topic.teacher_id=teacher.teacher_id&&is_select = 1 &&topic.year=$CURR_YEAR
                  &&student_pro_id=$CURR_PID && sort.id = topic .type order by student.number";
      $ab = mysql_query($sql);  
      $cnt = 0;
       while($ba = mysql_fetch_array($ab)){
            $cnt ++;
            mysql_query("INSERT INTO `".$TABLE."ok_topic` (  `topic` , `type` ,`student_id` , `student_pro_id`,`teacher_id`,`teacher_name`,`techpos`,`fenzu`,`year`) 
                 VALUES ('".$ba["topic"]."', '".$ba["typename"]."', '".$ba["student_number"]."', '".$ba["student_pro_id"]."', '".$ba["tid"]."', '".$ba["tname"]."', '".$ba["tpos"]."', '".$CURR_YEAR."A', '".$CURR_YEAR."'
            );");
       }
	echo "�����Ŀ���� $cnt �� <br>";
}


   echo "<table width=830 border=1 align=center cellpadding=3 bordercolor=#000000>";
   echo "<tr align=center  bgColor=#5a6e8f  height=38>
	<td width=60><font color=#FFFFFF>��ʦ</font></td>
	<td width=60><font color=#FFFFFF>ְ��</font></td>
<td width=98><font color=#FFFFFF>�༶</font></td>
<td width=102><font color=#FFFFFF>ѧ��</font></td>
<td width=60><font color=#FFFFFF>ѧ��</font></td>
<td><font color=#FFFFFF>��������</font></td>
<td width=70><font color=#FFFFFF>��������</font></td>";

    echo "</tr>";
   $sql = "select topic,student_id,class,student.name as sname,teacher.name as tname, teacher.techpos as tpos,type from ".$TABLE."teacher_information as teacher,".$TABLE."student_sheet as student,".$TABLE."ok_topic as oktopic where student.number=oktopic.student_id && teacher.teacher_id = oktopic.teacher_id&&oktopic.year=$CURR_YEAR&&student_pro_id=$CURR_PID order by student.number";
   //echo $sql;
   $ab = mysql_query($sql);  
if($ab) $currrows=mysql_num_rows($ab);  
else $currrows = 0;
if($currrows<1){
	$currrows = 0;
	echo "<tr><td height=168 colspan=7 align=center><b>".$CURR_YEAR."�� $pro_name רҵ</b><br>��δ�����绷�ڡ���ִ�е������������绷�ڡ�</td></tr>";
  }   
   while($v = mysql_fetch_array($ab)){
     	echo "<tr>";
       echo "<td >".$v["tname"]."</td>";
       echo "<td >".$v["tpos"]."</td>";
       echo "<td>".$v["class"]."</td>".
                "<td>".$v["student_id"]."</td>".
                "<td>".$v["sname"]."</td>".
                "<td>".$v["topic"]."</td>".
                "<td>".$v["type"]."</td>";
        echo "</tr>";
   }            
      echo    "</table><br><br>";	
?>
<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>
