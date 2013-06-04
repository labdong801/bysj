<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "教师选择指导钢琴、声乐选修的学生";
$YM_ZT2 = "钢琴、声乐选修学生名单";
$YM_MK = "艺术系课程双向选择系统";
$YM_PT ="教师选择";
$YM_DH = 1; //需要导航条
$YM_QX = 10; //管理员权限
include($baseDIR."/bysj/inc_head.php");


$teacher_id = $com_id;



 //设置所选年份
 if($_GET['select_year']) 
 {
 	$year = $_GET['select_year'];
 }
 else
 {
 	$year = date("Y",mktime(0,0,0,date("m")-8,1,date("Y"))); //
 	/*
 	 * 本学期年份 （当前年份减8个月）
 	 * eg:
 	 * 现在是 2013年6月 ，属于2012学年第二个期。所以 $art_select_year = 2012
 	 * 现在是2013年9月，属于2013年第一学期。所以$art_select_year =2013
 	 * */
 }
 
 if($_GET['major_id'])
 	$instrument = $_GET['major_id'];
 else
 	$instrument = "";
 	
 if($_GET['class'])
 	$major = $_GET['class'];
 else
 	$major = "";
 	
 	
	//时间限制
	   $sql = "select topic_start,topic_end,student_start,student_end,teacher_start,teacher_end from ".$ART_TABLE."set_date where grade = '2'";
	   $qur_sql = mysql_query($sql);
	   $fet_result = mysql_fetch_array($qur_sql);
	   $now = time(0);
	   $can_select = true;
	
	   if($now>=$fet_result["teacher_start"]&&$now<=$fet_result["teacher_end"]){
	   	  // 本学年的才可以修改
	   	  if($year == date("Y",mktime(0,0,0,date("m")-8,1,date("Y"))) )
		   	$can_select = true;
		  else
		  	$can_select = false;
	   } else if($now>=$fet_result["student_start"]&&$now<=$fet_result["student_end"]){
	   	   $can_select = false;
	   	   //$show_message = "目前处于学生报志愿阶段。";
	   	   Show_Message("目前处于学生报志愿阶段。<br>
	           该阶段将于 ".date("Y-m-d",$fet_result["student_end"])." 结束。<br>
	           请在此日期后再查看最新消息，谢谢。");
	       @include($baseDIR."/bysj/inc_foot.php");
	       exit;
	   }else {
		   $show_message = "对不起，现在没有选修任务。";
		   $can_select = false;
	   }
 	
 	
 
 ?>


<table width="100%" align="center">
<tr class="align_top">
<td align="left">
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<?php
	//年份
	echo "<a href=".$PHP_SELF."?select_year=".$YEAR_C."><font color=blue><u>查看".$YEAR_C."年(本届)选题</u></font></a>";
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   查看往年情况：";
	for($i=$YEAR_S;$i<$YEAR_C;$i++) echo "<a href=".$PHP_SELF."?select_year=".$i."><font color=blue><u>".$i."年</u></font></a> ";
	if($select_year<$YEAR_S||$select_year>$YEAR_C) $select_year = $YEAR_C;
	?>
	&nbsp;<br>&nbsp;<br>
	
	
	<?php
	//这个学期应该带哪几门课
		//$sql = "SELECT * FROM  `art_teacher_student` WHERE `teacher_id`='".$_SESSION['com_id']."' && `year` = '".$year."' ";
		$sql = "SELECT ".$ART_TABLE."teacher_student.id, major_id, teacher_id, class, YEAR, value, ".$TABLE."major.name AS class_name , ".$ART_TABLE."major.name AS art_name,grade
			FROM ".$ART_TABLE."teacher_student
			LEFT JOIN ".$TABLE."major ON ".$ART_TABLE."teacher_student.class = ".$TABLE."major.id 
			LEFT JOIN ".$ART_TABLE."major ON ".$ART_TABLE."teacher_student.major_id = ".$ART_TABLE."major.id
			WHERE teacher_id =  '".$_SESSION['com_id']."' && year =  '".$year."' && value > 0 && grade =2" ;
			
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 本学年安排的课程：";
		
		$query = mysql_query($sql);
		if(mysql_num_rows($query))
		{ 
			while($row = mysql_fetch_array($query))
			{ 
				if($instrument == "")
					$instrument = $row['major_id'];
				if($major == "")
					$major          = $row['class'];
					
				if( ($instrument == $row['major_id'])  && ($major == $row['class']) )
					echo "<font><u>".$row['art_name']."[".$row['class_name']."]</u></font>&nbsp;&nbsp;";
				else
					echo "<a href='art_teacher_chose_grade2.php?select_year=".$year."&major_id=".$row['major_id']."&class=".$row['class']."' ><font color=blue><u>".$row['art_name']."[".$row['class_name']."]</u></font></a>&nbsp;&nbsp;";
			}
		}
		else
		{
			echo "暂无";
			echo "</td></tr>";
			echo "</table>";
 			@include($baseDIR."/bysj/inc_foot.php");
 			exit(0);

		}
		echo "&nbsp;<br>&nbsp;<br>";
	?>
	
	
<?php
	//计算当前已经带了多少个学生和一共可以带多少个学生
 	$sql = "SELECT * FROM  `".$ART_TABLE."teacher_student` WHERE major_id = '".$instrument."' AND teacher_id ='".$teacher_id."' AND class='".$major."' AND year = '".$year."'  ";
 	if(mysql_num_rows(mysql_query($sql)))
 	{ 
 		$row = mysql_fetch_array(mysql_query($sql));
 		$sum = $row['value'];
 	}
 	else
 	{
 		$sum=0;
 	}
 	
 	if($_GET['major_id'] ==11)
		$instrument = "vocalmusic";
	if($_GET['major_id'] ==12 )
		$instrument = "piano";
	
	$sql = "SELECT * FROM ".$ART_TABLE."vocalmusic_student_select 
			LEFT JOIN ".$TABLE."student_sheet ON  ".$ART_TABLE."vocalmusic_student_select.student_number = ".$TABLE."student_sheet.number 
			LEFT JOIN ".$TABLE."major ON ".$TABLE."student_sheet.profession = ".$TABLE."major.name  
			WHERE ".$instrument."_finally = '".$teacher_id."' AND ".$ART_TABLE."vocalmusic_student_select.year = '".$year."' AND  ".$TABLE."major.id= '".$major."'  ";
 	$select = mysql_num_rows(mysql_query($sql));
 	//echo $sql;
 	
 	if($_POST)
 	{
 		if(!$can_select)
 		{
 			Show_Message("非选题阶段。<br>
	           如要修改，请联系管理员，谢谢。");
	           echo "</table>";
	       @include($baseDIR."/bysj/inc_foot.php");
	       exit;
 		}
 	}
 	
	//处理post时间
 	if(isset($_POST['add']))
 	{
 		//$TEST['add'][$teacher_id][1241241]=124124;
 		foreach ($_SESSION[$teacher_id] as $key => $value) {
 			if($value == 1) //添加
 			{ 
 				if($select < $sum)
 				{ 
		 			$sql = "UPDATE  `".$ART_TABLE."vocalmusic_student_select` SET  `".$instrument."_finally` =  '".$teacher_id."'  WHERE `student_number` ='".$key."';";
		 			//echo $sql ."<br>";
		 			mysql_query($sql);
		 			$select++;
 				}
 				else
 				{
 					echo "<script>alert('您已经超过了指导学生数量的上限！')</script>";
 					break;
 				}
 			}
 		}
 	}
 	if(isset($_POST['remove']))
 	{

 		foreach ($_SESSION[$teacher_id] as $key => $value) {
 		if($value == 2) //清除
 			{ 
	 			$sql = "UPDATE  `".$ART_TABLE."vocalmusic_student_select` SET  `".$instrument."_finally` =  '0'  WHERE `student_number` ='".$key."';";
	 			//echo $sql ."<br>";
				mysql_query($sql);
				$select--;
 			}
 		}
 	}
 	
 	//每次都要清除所有学生的session
 	unset($_SESSION[$teacher_id]);
 	
 	

?>

<?php
//现在应该选择第几志愿
$sql = "SELECT * FROM  `".$ART_TABLE."vocalmusic_student_select` 
	 		LEFT JOIN ".$TABLE."student_sheet ON ".$ART_TABLE."vocalmusic_student_select.student_number = ".$TABLE."student_sheet.number  
	 		LEFT JOIN ".$TABLE."major ON ".$TABLE."student_sheet.profession = bysj_major.name 
	 		WHERE `".$instrument."_first`='".$teacher_id."' AND `".$instrument."_finally`='0' AND ".$ART_TABLE."vocalmusic_student_select.year = '".$year."' AND  ".$TABLE."major.id='".$major."' ";
	 //		echo $sql;
$first = mysql_num_rows(mysql_query($sql));

$sql = "SELECT * FROM  `".$ART_TABLE."vocalmusic_student_select` 
	 		LEFT JOIN ".$TABLE."student_sheet ON ".$ART_TABLE."vocalmusic_student_select.student_number = ".$TABLE."student_sheet.number  
	 		LEFT JOIN ".$TABLE."major ON ".$TABLE."student_sheet.profession = bysj_major.name 
	 		WHERE `".$instrument."_second`='".$teacher_id."' AND `".$instrument."_finally`='0' AND ".$ART_TABLE."vocalmusic_student_select.year = '".$year."' AND  ".$TABLE."major.id='".$major."' ";
	 //		echo $sql;
$second = mysql_num_rows(mysql_query($sql));

//$sql = "SELECT * FROM  `".$ART_TABLE."instrument_student_select` 
//	 		LEFT JOIN ".$TABLE."student_sheet ON ".$ART_TABLE."instrument_student_select.student_number = ".$TABLE."student_sheet.number  
//	 		LEFT JOIN ".$TABLE."major ON ".$TABLE."student_sheet.profession = bysj_major.name 
//	 		WHERE `third`='".$instrument."' AND `finally`='0' AND ".$ART_TABLE."instrument_student_select.year = '".$year."' AND  ".$TABLE."major.id='".$major."' ";
//$third = mysql_num_rows(mysql_query($sql));

if($first > 0)
	$volunteer = 1;
else if($second > 0)
	$volunteer = 2;
else
	$volunteer = 3;

?>
<table width="800" border="0" align="center" cellpadding="3">
</tr>
<tr>
	<td align=center><font size=+1>已选择的学生(<?php echo $select;?>/<?php echo $sum;?>)</font></td><td></td><td  align=center><font size=+1>第<?php echo $volunteer;?>志愿学生名单</font></td>
</tr>
<tr>
	<td><iframe width=300 height=600 src="./teacher_had_chose2.php?year=<?php echo $year;?>&instrument=<?php echo $instrument;?>&major=<?php echo $major; ?>&volunteer=<?php echo $volunteer;?>"> </iframe></td>
	<td width=200 align=center>
		<form action="" method="post">
		<input type="submit" name="add" value=""  style="background:url('../images/left.png');width:50px;height:50px;border:0px;cursor:pointer" ><br><br><br><br>
		<input type="submit" name="remove" value=""  style="background:url('../images/right.png');width:50px;height:50px;border:0px;cursor:pointer">
		</form>
	</td>
	<td><iframe width=300 height=600 src="./teacher_chose_volunteer2.php?year=<?php echo $year;?>&instrument=<?php echo $instrument;?>&major=<?php echo $major; ?>&volunteer=<?php echo $volunteer;?>"> </iframe></td>
</tr>
</table>
<br>

</td>
</tr>
</table>


<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>

<script language=JavaScript >

$(document).ready(function(){
)};

</script>
