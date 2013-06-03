<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "教师选择专业方向选修的学生";
$YM_ZT2 = "专业方向选修学生名单";
$YM_MK = "艺术系课程双向选择系统";
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
		$sql = "SELECT * FROM  `".$TABLE."major` WHERE h_level = 19";
			
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 本学年安排的课程：";
		
		$query = mysql_query($sql);
		if(mysql_num_rows($query))
		{ 
			while($row = mysql_fetch_array($query))
			{ 
				if($major == "")
					$major          = $row['id'];
						
				if( $major == $row['id']  )
				{ 
					echo "<font><u>".$row['name']."</u></font>&nbsp;&nbsp;";
					$class_name = $row['name'];
				}
				else
					echo "<a href='art_admin_chose_grade3.php?select_year=".$year."&class=".$row['id']."' ><font color=blue><u>".$row['name']."</u></font></a>&nbsp;&nbsp;";
				
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


<table width="800" border="1" align="center" cellpadding="3">

<?php

	//$sql = "SELECT * FROM ".$ART_TABLE."instrument_student_select ORDER BY student_number ";
	$sql = "SELECT number, ".$TABLE."student_sheet.name AS student_name,".$TABLE."student_sheet.class AS student_class, vocalmusic_finally,piano_finally, profession FROM ".$ART_TABLE."vocalmusic_student_select  
		LEFT JOIN ".$TABLE."student_sheet ON ".$TABLE."student_sheet.number = ".$ART_TABLE."vocalmusic_student_select.student_number 
		LEFT JOIN ".$TABLE."major ON ".$TABLE."major.name = ".$TABLE."student_sheet.profession
		WHERE ".$ART_TABLE."vocalmusic_student_select.year = '".$year."' AND ".$TABLE."major.id = '".$major."' 
		ORDER BY student_number";
		//echo $sql."<br>";
	$query = mysql_query($sql);
	$unselected = 0;
	if($select_count = mysql_num_rows($query))
	{ 
		
		?>
<tr align=center  bgColor=#5a6e8f  height=38>
	<td>学号</td><td ><font size=+1>学生姓名</font></td><td>班级</td><td>声乐指导老师</td><td>钢琴指导老师</td><td>备注</td>
</tr>
		
		<?php
		while($row = mysql_fetch_array($query))
		{
			$key = $row['number']; //用于最后统计全班有多少个人 将学号最后两位去掉，再查找有学号前面相同的学生，就能够查出同专业的学生
			if($row['finally']==0)
				$unselected++;
			echo "<tr height = 35><td>".$row['number']."</td><td>".$row['student_name']."</td><td>".$row['student_class']."</td><td width='120'><span id='t".$row['number']."'>".teacher($row['vocalmusic_finally'],11,$major,$year)."</span></td><td width='120'><span id='t".$row['number']."'>".teacher($row['piano_finally'],12,$major,$year)."</span></td><td></td></tr>";
		}
	}

?>
</table>
<br>
<?php
	//显示总数
	$key = floor($key /10000 );
	if($key > 0)
	{ 
		$sql = "SELECT * FROM ".$TABLE."student_sheet WHERE number LIKE '%".$key."%' ";
		$query = mysql_query($sql);
		$sum=mysql_num_rows($query);
		echo "&nbsp;&nbsp;&nbsp;&nbsp;<b>".$class_name."共".$sum."名学生，".$select_count."名已填志愿。".$unselected."名还没被老师选上。</b>";
	}

?>
<br>
<br>
</td>
</tr>
</table>


<?php
/*
function major($id,$student)
{
	global $ART_TABLE;
//	$sql = "SELECT *  FROM  `".$ART_TABLE."major` WHERE `id` = '".$id."'";
//	$query = mysql_query($sql);
//	if(mysql_num_rows($query))
//	{
//		$row = mysql_fetch_array($query);
//		$grade = $row['grade'];
		
		$sql = "SELECT *  FROM  `".$ART_TABLE."major` WHERE `grade` = '3' ";
		$query = mysql_query($sql);
		
		if(mysql_num_rows($query))
		{
			$result =  "<select style='width:120px; ' class='major' id='".$student."'>";
			if($id > 0)
				$result .=  "<option value=''></option>";
			else
				$result .=  "<option value='' selected></option>";
			while($row = mysql_fetch_array($query))
			{
				if($id == $row['id'] )
					$result .=  "<option value='".$row['id']."' selected='selected'>".$row['name']."</option>";
				else
					$result .=  "<option value='".$row['id']."'>".$row['name']."</option>";
			}
			$result .=  "</select>";
		}
		
		return $result;
//	}
}
*/

function teacher($teacher,$major,$class,$year)
{
	global $ART_TABLE;
	global $TABLE;
	$sql = "SELECT * FROM  `".$ART_TABLE."teacher_student`  
			LEFT JOIN ".$TABLE."teacher_information ON ".$TABLE."teacher_information.teacher_id = ".$ART_TABLE."teacher_student.teacher_id 
			WHERE year='".$year."' AND value > 0 AND major_id = '".$major."'  AND class = '".$class."'";
	//echo $sql;
	$query = mysql_query($sql);
	if(mysql_num_rows($query))
	{
		$result = "<select style='width:120px; ' class = 'teacher' id='".$major."'>";
		if($teacher!="")
			$result .= "<option value=''></option>";
		else
			$result .= "<option value='' selected></option>";
		while($row=mysql_fetch_array($query))
		{
			if($teacher == $row['teacher_id'])
				$result .="<option value='".$row['teacher_id']."' selected>".$row['name']."</option>";
			else
				$result .= "<option value='".$row['teacher_id']."'>".$row['name']."</option>";
		}
		$result .="</select>";
	}
	return $result;
}


  @include($baseDIR."/bysj/inc_foot.php");
?>

<script language=JavaScript >

$(document).ready(function(){

	$(".teacher").change( function() {
  		//alert($(this).attr("value"));
  		var s = $(this).attr("id");
  		var st = $(this).parent().attr("id");
  		$.post("./ajax/admin_ajust2.php", { teacher: $(this).attr("value"), major: $(this).attr("id") ,  student: $(this).parent().attr("id") , year: "<?php echo $year; ?> " },
		   function(data){
		     //alert("Data Loaded: " + data);
		     //$("#t"+s).html(data);
		   });
	});
	
	// 用来绑定事件(使用unbind避免重复绑定)
	function bindListener(){
 		
	}
});

</script>
