<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "毕业设计题目修改";
$YM_ZT2 = "修改毕业设计题目和类型";
$YM_MK = "毕业设计答辩管理系统";
$YM_PT = "答辩系统";
$YM_DH = 1; //需要导航条
$YM_QX = 10; //本页访问需要权限：管理员
include($baseDIR."/bysj/inc_head.php");

$teacher_id = $com_id;
?>
 
 <?php
 if($seeall!="yeah") $seeall = "";
 ?>
<table width=800 border=1 align=center cellpadding=3 bordercolor=#000000>
<tr align=center  bgColor=#5a6e8f  height=38>
	<td width=18><font color=#FFFFFF>教师</font></td>
<td width=110><font color=#FFFFFF>班级</font></td>
<td width=18><font color=#FFFFFF>学号</font></td>
<td width=66><font color=#FFFFFF>学生姓名</font></td>
<td><font color=#FFFFFF>课题名称 <font size=+1><b><?php echo $CURR_YEAR;?>届</b></font></font></td>
<td width=80><font color=#FFFFFF>课题类型</font></td>
<td width=60><font color=#FFFFFF>操作</font></td>
<?php
    echo "</tr>";
    $tdcnt += 6;  //表格总的 td 数
    //print_r($mission_list);
    
    $all_doc = array();
    $count = 0;
    $missall = mysql_query("select * from ".$TABLE."mission_log");
    while($madata = mysql_fetch_array($missall)){
      	 $all_doc[$madata["mission_id"]][$madata["student_id"]]["teacherid"] = $madata["teacher_id"];
      	 $all_doc[$madata["mission_id"]][$madata["student_id"]]["filename"] = $madata["filename"];
      	 $all_doc[$madata["mission_id"]][$madata["student_id"]]["first_upload"] = $madata["first_upload"];
    }
   $sql = "select topic,student_number,class,".$TABLE."student_sheet.name as sname,".$TABLE."teacher_information.name as tname, ".$TABLE."topic .teacher_id as tid,".$TABLE."topic .id as did, ".$TABLE."title_sort.name as typename from ".$TABLE."topic ,".$TABLE."teacher_information,".$TABLE."student_sheet,".$TABLE."title_sort where ".$TABLE."student_sheet.number=".$TABLE."topic .student_number && ".$TABLE."teacher_information.teacher_id = ".$TABLE."topic .teacher_id && is_select = 1  && ".$TABLE."title_sort.id = ".$TABLE."topic .type&& ".$TABLE."topic.year=$CURR_YEAR   order by ".$TABLE."topic .teacher_id, ".$TABLE."student_sheet.number";
   $ab = mysql_query($sql);  
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
	if($seeall!="yeah"&&$v["tid"]!=$teacher_id) continue;  //只看自己的学生
	echo "<tr align=center height=32>";
	if($oldteacher != $v["teacher"]){
		 $oldteacher = $v["teacher"];
		 echo "<td  width=18 rowspan=".$tcnt[$oldteacher].">".$oldteacher."</td>";
	}
	//echo "<td>".$all_doc[$mission_list[0]["id"]][$k]["teacherid"]."</td>";
   echo "<td>".$v["class"]."</td>".
            "<td>".substr($k,strlen($k)-2)."</td>".
            "<td>".$v["name"]."</td>".
            "<td align=left>".$v["topic"]."</td>".
            "<td width=80>".$v["typename"]."</td>".
            "<td width=60>".
            (($bbb["authority"]==99||$v["tid"]==$teacher_id)?("[<a href=/bysj/teacher/revise.php?id=".$v["did"]." target=_blank>修改</a>] "):"").
            "</td>";
    echo "</tr>";
}            
      echo    "</table>";
?>
<table width="780" align="center">
<tr align=left>
<td><br>说明：<br />
	<li><font color=red>【特别注意】</font>请核对各文档是否与题目一致，以及题目、类型是否合适，若有误，请修改！</li>
</td>
</tr>
</table>
<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>

