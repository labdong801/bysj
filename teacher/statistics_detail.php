<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "设计情况一览";
$YM_ZT2 = "毕业设计课题情况一览表";
$YM_MK = "毕业设计双向选题系统";
$YM_DH = 1; //需要导航条
$YM_QX = 40; //本页访问需要权限：专业主任
include($baseDIR."/bysj/inc_head.php");

$teacher_id = $com_id;
if($select_year<$YEAR_S) $select_year = $CURR_YEAR;
 ?>

 <?php
	echo "按年度显示统计数据：";
	for($i=$YEAR_C;$i>=$YEAR_S;$i--){
		if($select_year==$i) echo "[<b>".$i."届</b>]&nbsp;";
		else echo "[<a href=".$PHP_SELF."?select_year=".$i."><font color=blue><u>".$i."届</u></font></a>]&nbsp;";
	}
	echo "<br>";
	$pro_list = explode(",", $com_pro_id);
	$majiorlist = get_majior_list($com_pro);
	$curr_pro_id = $set_pro_id;
	echo "请选择要查看的专业：";
	$pro_name = "";
	while(list($k,$v)=each($majiorlist)){
		if(in_array($k,$pro_list)&&$v[open]){
			if($curr_pro_id ==0) $curr_pro_id = $k;
			if($curr_pro_id == $v["id"]){
				echo "[<b>".$select_year."届".$v["name"]."专业</b>]";
				$pro_name = $v["name"];
			} else {
				echo "[<a href=".$PHP_SELF."?select_year=$select_year&set_pro_id=".$k."><font color=blue><u>".$select_year."届".$v["name"]."专业</u></font></a>]";
			}
			echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		}
	}
	echo "<br><br>";
?>

<table width="830" align=center border=1 bordercolor=#000000  cellpadding=3>
<tr  align=center  bgColor=#5a6e8f  height=38>
	<td width=60><font color=#FFFFFF>教师</font></td>
	<td width=70><font color=#FFFFFF>职称</font></td>
<td width=98><font color=#FFFFFF>班级</font></td>
<td width=102><font color=#FFFFFF>学号</font></td>
<td width=60><font color=#FFFFFF>学生</font></td>
<td><font color=#FFFFFF>课题名称</font></td>
<td width=70><font color=#FFFFFF>课题类型</font></td>
<?php
    echo "</tr>";
    $all_doc = array();
    $count = 0;
    $missall = mysql_query("select * from ".$TABLE."mission_log");
    while($madata = mysql_fetch_array($missall)){
      	 $all_doc[$madata["mission_id"]][$madata["student_id"]]["teacherid"] = $madata["teacher_id"];
      	 $all_doc[$madata["mission_id"]][$madata["student_id"]]["filename"] = $madata["filename"];
      	 $all_doc[$madata["mission_id"]][$madata["student_id"]]["first_upload"] = $madata["first_upload"];
    }
   $sql = "select topic,student_number,class,student.name as sname,teacher.name as tname, topic.teacher_id as tid, teacher.techpos as tpos,title.name as typename from ".$TABLE."topic as topic,".$TABLE."teacher_information as teacher,".$TABLE."student_sheet as student,".$ART_TABLE."title_sort  as title where student.number=topic.student_number && teacher.teacher_id = topic.teacher_id && is_select = 1 && title.id = topic.type&&student.year='$select_year'&&student_pro_id='$curr_pro_id' order by student.number";
   $ab = mysql_query($sql);  
   $schedule = array();
   $tcnt = array();
   while($ba = mysql_fetch_array($ab)){
	   $tname = $ba["tname"];
	   $tid = $ba["tid"];
	   $class = $ba["class"];
	   $sname = $ba["sname"];
	   $topic = $ba["topic"];
	   $tpos = $ba["tpos"];
	   $typename = $ba["typename"];
	   $snumber = $ba["student_number"];
	   $schedule[$snumber]["teacher"] = $tname;
	   $schedule[$snumber]["tpos"] = $tpos;
	   $schedule[$snumber]["tid"] = $tid;
	   $tcnt[$tname] ++ ;
	   $schedule[$snumber]["class"] = $class;
	   $schedule[$snumber]["name"] = $sname;
	   $schedule[$snumber]["topic"] = $topic;
	   $schedule[$snumber]["typename"] = $typename;
   }
   $cnt = 0;
while(list($k,$v) = each($schedule)){
	echo "<tr align=center>";
   echo "<td >".$v["teacher"]."</td>";
   echo "<td >".$v["tpos"]."</td>";
   echo "<td>".$v["class"]."</td>".
            "<td>".$k."</td>".
            "<td>".$v["name"]."</td>".
            "<td align=left>".$v["topic"]."</td>".
            "<td>".$v["typename"]."</td>";
    echo "</tr>";
    $cnt ++;
}            
if($cnt<1) echo "<tr><td colspan=7 height=138 align=center>对不起，当前没有符合条件的数据</td></tr>";
      echo    "</table>";
?>

<br>
<table width="90%" class="STYLE1" align=center>
<tr align=left>
<td>提示：</td>
</tr>
<tr align=left>
<td>1. 若教师的“职称”为空，说明该教师尚未填写“教师信息表”，请联系该教师及时填写。</td>
</tr>
<tr align=left>
<td>2. 本表可直接复制，粘贴到EXCEL表中后，即可作为毕业设计基本情况表送呈学校。</td>
</tr>
</tr>
</table>

<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>
