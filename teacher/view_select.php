<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "学生选题一览";
$YM_ZT2 = "浏览本专业全体学生的选题情况";
$YM_MK = "毕业设计双向选题系统";
$YM_DH = 1; //需要导航条
$YM_QX = 40; //本页访问需要权限:专业主任
include($baseDIR."/bysj/inc_head.php");

$teacher_id = $com_id;
?>
		<?php
	 $curr_pro_id = $set_pro_id;

	if($select_year==$YEAR_C) echo  "[<b>".$YEAR_C."届(本届)</b>]";
	else echo "[<a href=".$PHP_SELF."?select_year=".$YEAR_C."&set_pro_id=$curr_pro_id><font color=blue><u>".$YEAR_C."届(本届)</u></font></a>]";
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   往届：";
	for($i=$YEAR_S;$i<$YEAR_C;$i++) {
		if($i==$select_year) echo "[<b>".$i."届</b>] ";
		else echo "[<a href=".$PHP_SELF."?select_year=".$i."&set_pro_id=$curr_pro_id><font color=blue><u>".$i."届</u></font></a>] ";
	}
	if($select_year<$YEAR_S||$select_year>$YEAR_C) $select_year = $YEAR_C;
	
         $majiorlist = get_majior_list();
         $pro_list = explode(",", $com_pro_id);  
	 echo "<p align=left>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;请选择操作的专业：";
	 $pro_name = "";
	 while(list($k,$v)=each($majiorlist)){
	 	   if(in_array($k,$pro_list)&&$v[open]){
	 	   	   if($curr_pro_id ==0) $curr_pro_id = $k;
	 	   	   if($curr_pro_id == $v["id"]){
	 	   	   	    echo "[<b>".$select_year."届 ".$v["name"]."</b>]";
			 	    $pro_name = $v["name"];
	 	   	   } else echo "[<a href=".$PHP_SELF."?set_pro_id=".$k."&select_year=$select_year><font color=blue><u>".$select_year."届 ".$v["name"]."</u></font></a>]";
	 	   	   echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	 	   }
 	 }
 	 echo "</p>";
 	if($pro_name==""){
 		echo "<br><br>";
 		Show_Message("对不起，您的访问被拒绝，请求助管理员解决问题。");
 		@include($baseDIR."/bysj/inc_foot.php");
 		exit;
 	}
	
	?>	
<table width="780" border="1"  bordercolor=#000000  cellpadding="3">
<tr align="center" bgColor=#5a6e8f  height=38>
<td><font color=#FFFFFF>教师</font></td>
<td><font color=#FFFFFF><?php echo "<b>".$select_year."届 ".$pro_name." 专业</b>"; ?> 题目</font></td>
<td><font color=#FFFFFF>第一志愿选该题的同学</font></td>
</tr>
<?php
$lastname = "";
$sql = mysql_query("select id,topic,source,student_number,is_select,verify,name from ".$TABLE."topic as topic ,".$TABLE."teacher_information as teacher where teacher.teacher_id = topic.teacher_id&&topic.year=$select_year&&topic.profession REGEXP '^".$curr_pro_id.",|,".$curr_pro_id.",|,".$curr_pro_id."$|^".$curr_pro_id."$'&&(is_select!=1||student_pro_id=".$curr_pro_id.") order by topic.teacher_id");
if($sql) $currrows=mysql_num_rows($sql);  
else $currrows = 0;
if($currrows<1){
	$currrows = 0;
	echo "<tr><td colspan=3 height=138 align=center>对不起，当前没有 <b>".$select_year."届 ".$pro_name."专业</b> 的毕业设计课题</td></tr>";
}
$i = 0;
while($row = mysql_fetch_array($sql)){
$id = $row["id"];
$pupil = "pupil".$i;
$query = mysql_query("select * from ".$TABLE."student_select where topic_num = '$id'");
if($lastname != $row["name"]){
	$lastname = $row["name"];
	$kk = !$kk;
	if($kk) $newcolor="#FFFFFF";
	else $newcolor="#DDDDDD";
} 
?>
<tr align="left" bgcolor=<?php echo $newcolor;?>>
	<td width="80"><? echo $row["name"];?></td>
<td width="360"><? echo $row["topic"];?></td>
<td >
<?php
if($row["student_number"]!=0&&$row["is_select"]==1){
?>
 &nbsp;<input type="radio" name="<? echo $pupil;?>" value="<? echo $row["student_number"];?>" checked="checked"/>
<?php
$ik = mysql_query("select name from ".$TABLE."student_sheet where number = '$row[student_number]'");
$ki = mysql_fetch_array($ik);
echo $ki["name"]."(<font color=blue>选定</font>)";
}
?>
<?php
while($student = mysql_fetch_array($query)){
   $aa = mysql_query("select name,class,profession from ".$TABLE."student_sheet where number = '$student[number]'");
   $bb = mysql_fetch_array($aa);
   $hisname =  $bb["name"]."(".$student["wish"].")"." ";
   $hisname = "<span title=".$bb["class"].">".$hisname."</span>";
   if($bb["profession"]!=$pro_name)continue;
   if($student["wish"]==1 || $student["wish"]=="自选"){   	  
      echo "&nbsp;<input type=radio name=".$pupil." value=".$student["number"]." /> $hisname ";
    }
}
echo "&nbsp;";
?>
</td>
</tr>
<?php
}
?>
</table>

<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>