<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "查看全部文档";
$YM_ZT2 = "毕业设计文档上交情况一览";
$YM_MK = "毕业设计文档管理系统";
$YM_PT = "文档系统";
$YM_DH = 1; //需要导航条
$YM_QX = 10; //本页访问需要权限:普通教师
include($baseDIR."/bysj/inc_head.php");

$teacher_id = $com_id;
?>

<?php
 if($timestr != "first_upload") $timestr = "last_uploadtime";
if($seeall!="yeah") $seeall = "";
    $tdcnt = sizeof($mission_list);  //计算任务文档数
?>
	<?php echo $CURR_YEAR; ?>届 毕业设计文档完成情况一览表
	<?php
	if($seeall!="yeah") echo "[<a href=".$PHP_SELF."?seeall=yeah&timestr=$timestr><font color=blue><u>查看所有人文档</u></font></a>]";
	else echo "[<a href=".$PHP_SELF."?timestr=$timestr><font color=blue><u>只看自己的文档</u></font></a>]";
	if($timestr == "last_uploadtime") 
	   echo   "[<a href=".$PHP_SELF."?seeall=$seeall&timestr=first_upload><font color=blue><u>按最初上传时间显示</u></font></a>]";
	else echo   "[<a href=".$PHP_SELF."?seeall=$seeall&timestr=last_uploadtime><font color=blue><u>按最后上传时间显示</u></font></a>]";

	?>
	<br><br>
<table width="830" align="center" border="1" bordercolor=#000000  cellpadding="2">
<tr align=center   bgColor=#5a6e8f  height=38>
	<td width=20><font color=#FFFFFF>教师</font></td>
<td width=50><font color=#FFFFFF>班级</font></td>
<td width=20><font color=#FFFFFF>学号</font></td>
<td width=66><font color=#FFFFFF>姓名</font></td>
<?php
    for($i=0;$i<$tdcnt;$i++){
    	echo "<td width=".ceil(626/$tdcnt)."><font color=#FFFFFF>".$mission_list[$i]["name"]."</font></td>";
    }
    if($tdcnt==0) echo "<td align=center><font color=#FFFFFF>目前暂无文档上传要求</font></td>";
    echo "</tr>";
    $tdcnt += 6;  //表格总的 td 数
    //print_r($mission_list);
    
    $all_doc = array();
    $count = 0;
    $missall = mysql_query("select * from ".$TABLE."mission_log");
    while($madata = mysql_fetch_array($missall)){
      	 $all_doc[$madata["mission_id"]][$madata["student_id"]]["teacherid"] = $madata["teacher_id"];
      	 $all_doc[$madata["mission_id"]][$madata["student_id"]]["filename"] = $madata["filename"];
      	 $all_doc[$madata["mission_id"]][$madata["student_id"]][$timestr] = $madata[$timestr];
    }
   $sql = "select topic,student_number,class,student.name as sname,teacher.name as tname, topic.teacher_id as tid,topic .id as did, ".$ART_TABLE."title_sort.name as typename from ".$TABLE."topic as topic,".$TABLE."teacher_information as teacher,".$TABLE."student_sheet as student,".$ART_TABLE."title_sort where student.number=topic.student_number && teacher.teacher_id = topic .teacher_id && is_select = 1  &&student.year=$CURR_YEAR&&student.profession='$pro_name'&& ".$ART_TABLE."title_sort.id = topic .type  order by topic .teacher_id, student.number";
   //echo $sql;
   $ab = mysql_query($sql);  
   $currrows = 0;
   $schedule = array();
   $tcnt = array();
   while($ba = mysql_fetch_array($ab)){
	   $tname = $ba["tname"];
	   $tid = $ba["tid"];
	   $did = $ba["did"];
	   $class = $ba["class"];
	   $sname = $ba["sname"];
	   $topic = $ba["topic"];
	   $typename = $ba["typename"];
	   $snumber = $ba["student_number"];
	   $schedule[$snumber]["teacher"] = $tname;
	   $schedule[$snumber]["tid"] = $tid;
	   $schedule[$snumber]["did"] = $did;
	   $tcnt[$tname] ++ ;
	   $schedule[$snumber]["class"] = $class;
	   $schedule[$snumber]["name"] = $sname;
	   $schedule[$snumber]["topic"] = $topic;
	   $schedule[$snumber]["typename"] = $typename;
   }
$oldteacher = "";   
while(list($k,$v) = each($schedule)){
	if($seeall!="yeah"&&$v["tid"]!=$teacher_id){
		 continue;  //只看自己的学生
	}
	$currrows ++;
	echo "<tr align=center>";
	if($oldteacher != $v["teacher"]){
		 $oldteacher = $v["teacher"];
		 echo "<td  width=20 rowspan=".$tcnt[$oldteacher].">";
   		if($com_auth<40 &&$v["tid"]!=$teacher_id) echo $v[teacher];
   		else echo TeacherArchiveDown($CURR_YEAR,$CURR_PID,$v["tid"],"allstudent","allmission","alldoc",$v["teacher"],false);
		 echo "</td>";
	}
	//echo "<td>".$all_doc[$mission_list[0]["id"]][$k]["teacherid"]."</td>";
   echo "<td>".substr($v["class"],0,strpos($v["class"],"0"))."</td>".
            "<td>".substr($k,strlen($k)-2)."</td>";
   echo "<td>";
   if($com_auth<40 &&$v["tid"]!=$teacher_id) echo $v[name];
   else echo TeacherArchiveDown($CURR_YEAR,$CURR_PID,$v["tid"],$k,"allmission","alldoc",$v["name"]);
   echo "</td>";
    for($i=0;$i<$tdcnt-6;$i++){
    	$tstr = $all_doc[$mission_list[$i]["id"]][$k][$timestr];
    	$tstr = substr($tstr,5);
    	if($com_auth<40 &&$v["tid"]!=$teacher_id){    		
       	if($tstr=="") $tstr = "&nbsp;";
    		echo "<td>".$tstr."</td>";
    	}else {
       		if($tstr=="") echo "<td>&nbsp;</td>";
    	    	else {
    	    		echo "<td>";
    	    		TeacherArchiveDown($CURR_YEAR,$CURR_PID,$v["tid"],$k,$mission_list[$i]["id"],"mydoc",$tstr);
    	    		echo "</td>";
    	    		//echo "<td><a href=\"/Docs/".$CURR_YEAR."/".$mission_list[$i]["address"]."/".$all_doc[$mission_list[$i]["id"]][$k]["filename"]."\"><font color=blue><u>".$tstr."</u></font></a></td>";
    	    	}
    	}
    }
    echo "</tr>";
}            
   if($currrows < 1){
	echo "<tr><td colspan=".($tdcnt)." height=138 align=center>对不起，<b>".$CURR_YEAR."届 $pro_name 专业</b> 目前没有文档任务。</td></tr>";
   }  
        echo    "</table>";
?>
<table width="780" align="center">
<tr align=left>
<td><br>说明：<br />
	<li>本功能用于方便各位指导教师了解当前文档上交情况</li>
	<li><?php
		echo "批量打包下载毕业设计文档：";
		TeacherArchiveDown($CURR_YEAR,$CURR_PID,$teacher_id,"allstudent","allmission","alldoc","本人指导学生的全部文档");
		if($com_auth>80){
			echo "&nbsp;";
			TeacherArchiveDown($CURR_YEAR,$CURR_PID,"allteacher","allstudent","allmission","alldoc","本专业全部学生的文档");
		}
		if($com_auth>80){
			echo "&nbsp;";
			TeacherArchiveDown($CURR_YEAR,"allpro","allteacher","allstudent","allmission","alldoc",$CURR_YEAR."届全部学生的文档");
		}
		?></li>
</td>
</tr>
</table>
</td>
</tr>

<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>