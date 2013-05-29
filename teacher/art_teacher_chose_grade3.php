<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "教师选择指导专业方向选修的学生";
$YM_ZT2 = "专业方向选修学生名单";
$YM_MK = "艺术系双选系统";
$YM_PT ="教师选择";
$YM_DH = 1; //需要导航条
$YM_QX = 90; //管理员权限
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
 	
 	
 	
 	
 	
 
 ?>


<table width="100%" align="center">
<tr class="align_top">
<td align="left">
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<?php
	echo "<a href=".$PHP_SELF."?select_year=".$YEAR_C."><font color=blue><u>查看".$YEAR_C."年(本届)选题</u></font></a>";
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   查看往年情况：";
	for($i=$YEAR_S;$i<$YEAR_C;$i++) echo "<a href=".$PHP_SELF."?select_year=".$i."><font color=blue><u>".$i."年</u></font></a> ";
	if($select_year<$YEAR_S||$select_year>$YEAR_C) $select_year = $YEAR_C;
	?>
	&nbsp;<br>&nbsp;<br>
	
	
	<?php
		//$sql = "SELECT * FROM  `art_teacher_student` WHERE `teacher_id`='".$_SESSION['com_id']."' && `year` = '".$year."' ";
		$sql = "SELECT ".$ART_TABLE."teacher_student.id, major_id, teacher_id, class, YEAR, value, ".$TABLE."major.name AS class_name , ".$ART_TABLE."major.name AS art_name,grade
			FROM ".$ART_TABLE."teacher_student
			LEFT JOIN ".$TABLE."major ON ".$ART_TABLE."teacher_student.class = ".$TABLE."major.id 
			LEFT JOIN ".$ART_TABLE."major ON ".$ART_TABLE."teacher_student.major_id = ".$ART_TABLE."major.id
			WHERE teacher_id =  '".$_SESSION['com_id']."' && year =  '".$year."' && value > 0 && grade =3" ;
			
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
					echo "<a href='art_teacher_chose_grade3.php?select_year=".$year."&major_id=".$row['major_id']."&class=".$row['class']."' ><font color=blue><u>".$row['art_name']."[".$row['class_name']."]</u></font></a>&nbsp;&nbsp;";
			}
		}
		else
		{
			echo "暂无";
			@include($baseDIR."/bysj/inc_foot.php");
			exit(0);
		}
		echo "&nbsp;<br>&nbsp;<br>";
	?>
	
	
<?php
	$sql = "SELECT * FROM ".$ART_TABLE."major_student_select WHERE teacher = '".$teacher_id."' AND year = '".$year."'";
 	$select = mysql_num_rows(mysql_query($sql));
 	$sql = "SELECT * FROM  `".$ART_TABLE."teacher_student` WHERE major_id = '".$instrument."' AND teacher_id ='".$teacher_id."' AND class='".$major."' AND year = '".$year."'  ";
 	if(mysql_num_rows(mysql_query($sql)))
 	{ 
 		$row = mysql_fetch_array(mysql_query($sql));
 		$sum = $row['value'];
 	}
 	
//处理post时间
 	if(isset($_POST['add']))
 	{
 		//$TEST['add'][$teacher_id][1241241]=124124;
 		foreach ($_SESSION[$teacher_id] as $key => $value) {
 			if($value == 1) //添加
 			{ 
 				if($select <= $sum)
 				{ 
		 			$sql = "UPDATE  `".$ART_TABLE."major_student_select` SET  `finally` =  '".$instrument."',`teacher` =  '".$teacher_id."' WHERE `student_number` ='".$key."';";
		 			//echo $sql ."<br>";
		 			mysql_query($sql);
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
	 			$sql = "UPDATE  `".$ART_TABLE."major_student_select` SET  `finally` =  '0',`teacher` =  '' WHERE `student_number` ='".$key."';";
	 			//echo $sql ."<br>";
				mysql_query($sql);
 			}
 		}
 	}
 	
 	//每次都要清除所有学生的session
 	unset($_SESSION[$teacher_id]);
 	
 	

?>

<?php
//现在应该选择第几志愿
$sql = "SELECT * FROM  `".$ART_TABLE."major_student_select` 
	 		LEFT JOIN ".$TABLE."student_sheet ON ".$ART_TABLE."major_student_select.student_number = ".$TABLE."student_sheet.number  
	 		LEFT JOIN ".$TABLE."major ON ".$TABLE."student_sheet.profession = bysj_major.name 
	 		WHERE `first`='".$instrument."' AND `finally`='0' AND ".$ART_TABLE."major_student_select.year = '".$year."' AND  ".$TABLE."major.id='".$major."' ";

$first = mysql_num_rows(mysql_query($sql));

$sql = "SELECT * FROM  `".$ART_TABLE."major_student_select` 
	 		LEFT JOIN ".$TABLE."student_sheet ON ".$ART_TABLE."major_student_select.student_number = ".$TABLE."student_sheet.number  
	 		LEFT JOIN ".$TABLE."major ON ".$TABLE."student_sheet.profession = bysj_major.name 
	 		WHERE `second`='".$instrument."' AND `finally`='0' AND ".$ART_TABLE."major_student_select.year = '".$year."' AND  ".$TABLE."major.id='".$major."' ";

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
	<td><iframe width=300 height=600 src="./teacher_had_chose3.php?year=<?php echo $year;?>&instrument=<?php echo $instrument;?>&major=<?php echo $major; ?>&volunteer=<?php echo $volunteer;?>"> </iframe></td>
	<td width=200 align=center>
		<form action="" method="post">
		<input type="submit" name="add" value=""  style="background:url('../images/left.png');width:50px;height:50px;border:0px;cursor:pointer" ><br><br><br><br>
		<input type="submit" name="remove" value=""  style="background:url('../images/right.png');width:50px;height:50px;border:0px;cursor:pointer">
		</form>
	</td>
	<td><iframe width=300 height=600 src="./teacher_chose_volunteer3.php?year=<?php echo $year;?>&instrument=<?php echo $instrument;?>&major=<?php echo $major; ?>&volunteer=<?php echo $volunteer;?>"> </iframe></td>
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
