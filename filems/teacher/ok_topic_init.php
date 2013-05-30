<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "毕业设计信息初始化";
$YM_ZT2 = "毕业设计信息初始化（慎用）";
$YM_MK = "毕业设计答辩管理系统";
$YM_PT = "答辩系统";
$YM_DH = 1; //需要导航条
$YM_QX = 80; //本页访问需要权限：管理员
include($baseDIR."/bysj/inc_head.php");

$teacher_id = $com_id;
   echo "<b>".$CURR_YEAR."届 ".$pro_name." 专业</b> 毕业设计最终统计一览表<br>";
 ?>

	<form name=ok_topic method=post action=<?php echo $PHP_SELF;?>>
	<input type=radio name=doit value=update checked>更新题目
	<input type=radio name=doit value=input>导入数据
	<input type=radio name=doit value=clear>清空数据
	确认：<input type=password name=mm size=8>
	<input type=submit value=立即执行操作>
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
	echo "完成题目同步 $cnt 项 <br>";
}

if($doit =="clear"&&$mm=="qingkong") {
	mysql_query("DELETE from `".$TABLE."ok_topic` WHERE year=$CURR_YEAR&&student_pro_id=$CURR_PID");
	echo "已清空当前专业的课题信息。<br>";
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
	echo "完成题目导入 $cnt 项 <br>";
}


   echo "<table width=830 border=1 align=center cellpadding=3 bordercolor=#000000>";
   echo "<tr align=center  bgColor=#5a6e8f  height=38>
	<td width=60><font color=#FFFFFF>教师</font></td>
	<td width=60><font color=#FFFFFF>职称</font></td>
<td width=98><font color=#FFFFFF>班级</font></td>
<td width=102><font color=#FFFFFF>学号</font></td>
<td width=60><font color=#FFFFFF>学生</font></td>
<td><font color=#FFFFFF>课题名称</font></td>
<td width=70><font color=#FFFFFF>课题类型</font></td>";

    echo "</tr>";
   $sql = "select topic,student_id,class,student.name as sname,teacher.name as tname, teacher.techpos as tpos,type from ".$TABLE."teacher_information as teacher,".$TABLE."student_sheet as student,".$TABLE."ok_topic as oktopic where student.number=oktopic.student_id && teacher.teacher_id = oktopic.teacher_id&&oktopic.year=$CURR_YEAR&&student_pro_id=$CURR_PID order by student.number";
   //echo $sql;
   $ab = mysql_query($sql);  
if($ab) $currrows=mysql_num_rows($ab);  
else $currrows = 0;
if($currrows<1){
	$currrows = 0;
	echo "<tr><td height=168 colspan=7 align=center><b>".$CURR_YEAR."届 $pro_name 专业</b><br>暂未进入答辩环节。请执行导入操作后进入答辩环节。</td></tr>";
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
