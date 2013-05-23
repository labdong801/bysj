<?php
$self= $PHP_SELF;//文件相对地址

$filename = $_SERVER["SCRIPT_FILENAME"];//获取文件绝对地址
$loc= strpos($filename,$self);//自己相对地址在绝对地址中出现的位置
$baseDIR = substr($filename,0,$loc);//根本地址

$YM_ZT = "教师设置";
$YM_ZT2 = "教师指导学生数量设置";
$YM_MK = "毕业设计双向选题系统";
$YM_PT ="全局设定";
$YM_DH = 1; //需要导航条
$YM_QX = 90; //管理员权限
include($baseDIR."/bysj/inc_head.php");

$teacher_id = $com_id;
echo $teacher_id;
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
<table width="800" border="1" align="center" bordercolor=#000000  cellpadding="3">
<tr align="center" bgColor=#5a6e8f  height=38>
<td width=60><font color=#FFFFFF>教师</font></td>
<td><font color=#FFFFFF size=+1>指导学生数量</font></td>
</tr>

<?php
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


/*找出所有专业*/
$sql="SELECT * FROM  `".$TABLE."major`";
$search = mysql_query($sql);
while($row = mysql_fetch_array($search))
	$class[] = array("id"=>$row["id"],"name"=>$row["name"]);


$sql = "SELECT * FROM  `".$TABLE."teacher_information` ";
$search = mysql_query($sql);
if(mysql_num_rows($search))
{
	while($teacher_row = mysql_fetch_array($search))
	{
		?>

		<tr align="center" height=38>
		<td width=60><?php echo $teacher_row['name'];?></td>
		<td align=left>
			<table width=750>
			<tr> <td colspan=2>◆大一：</td> </tr>
			<tr>
			<?php
				$i=0;
				$sql = "SELECT * FROM `".$ART_TABLE."major` WHERE `grade`=1";
				$query = mysql_query($sql);
				while($row   = mysql_fetch_array($query))
				{
					echo "<td align=right>".$row['name'].":</td><td align=left>";
					$j=0;
					while($class[$j]){
						if($j>0)
							echo "-";
						echo "<input style='width:25px;' class='setnum' teacher='".$teacher_row['teacher_id']."' major='".$row['id']."' class_id='".$class[$j]['id']."' year='".$year."'  value='".getnumber($teacher_row['teacher_id'],$row['id'],$class[$j]['id'])."'/>";

						$j++;
					}
					echo "</td>";
					$i++;
					if($i%5 == 0)
						echo "</tr><tr>";
				}
				while($i%5 != 0)
				{
					echo "<td></td><td></td>";
					$i++;
				}
			?>
			</tr>

			<tr> <td colspan=2>◆大二：</td> </tr>
			<tr>
			<?php
				$i=0;
				$sql = "SELECT * FROM `".$ART_TABLE."major` WHERE `grade`=2";
				$query = mysql_query($sql);
				while($row   = mysql_fetch_array($query))
				{
					echo "<td align=right>".$row['name'].":</td><td align=left>";
					$j=0;
					while($class[$j]){
						if($j>0)
							echo "-";
						echo "<input style='width:25px;' class='setnum' teacher='".$teacher_row['teacher_id']."' major='".$row['id']."' class_id='".$class[$j]['id']."' year='".$year."'  value='".getnumber($teacher_row['teacher_id'],$row['id'],$class[$j]['id'])."'/>";

						$j++;
					}
					echo "</td>";
					$i++;
					if($i%5 == 0)
						echo "</tr><tr>";
				}
				while($i%5 > 0)
				{
					echo "<td></td><td></td>";
					$i++;
				}
			?>
			</tr>

			<tr> <td colspan=2>◆大三：</td> </tr>
			<tr>
			<?php
				$i=0;
				$sql = "SELECT * FROM `".$ART_TABLE."major` WHERE `grade`=3";
				$query = mysql_query($sql);
				while($row   = mysql_fetch_array($query))
				{
					echo "<td align=right>".$row['name'].":</td><td align=left>";
					$j=0;
					while($class[$j]){
						if($j>0)
							echo "-";
						echo "<input style='width:25px;' class='setnum' teacher='".$teacher_row['teacher_id']."' major='".$row['id']."' class_id='".$class[$j]['id']."' year='".$year."'  value='".getnumber($teacher_row['teacher_id'],$row['id'],$class[$j]['id'])."'/>";

						$j++;
					}
					echo "</td>";
					$i++;
					if($i%5 == 0)
						echo "</tr><tr>";
				}
				while($i%5 > 0)
				{
					echo "<td></td><td></td>";
					$i++;
				}
			?>
			</tr>

			<tr> <td colspan=2>◆大四：</td> </tr>
			<tr>
			<?php
				$i=0;
				$sql = "SELECT * FROM `".$ART_TABLE."major` WHERE `grade`=4";
				$query = mysql_query($sql);
				while($row   = mysql_fetch_array($query))
				{
					echo "<td align=right>".$row['name'].":</td><td align=left>";
					$j=0;
					while($class[$j]){
						if($j>0)
							echo "-";
						echo "<input style='width:25px;' class='setnum' teacher='".$teacher_row['teacher_id']."' major='".$row['id']."' class_id='".$class[$j]['id']."' year='".$year."' value='".getnumber($teacher_row['teacher_id'],$row['id'],$class[$j]['id'])."'/>";

						$j++;
					}
					echo "</td>";
					$i++;
					if($i%5 == 0)
						echo "</tr><tr>";
				}
				while($i%5 > 0)
				{
					echo "<td></td><td></td>";
					$i++;
				}
			?>
			</tr>

			</table>
		</td>
		</tr>

		<?php
	}
}


?>
</table>
<br>

</td>
</tr>
</table>
<?php
function getnumber($teacher_id,$major_id,$class_id)
{
	global $ART_TABLE;
	global $year;
	$sql= "SELECT * FROM  `".$ART_TABLE."teacher_student` WHERE `teacher_id`='".$teacher_id."' && `year`='".$year."' && `major_id` = '".$major_id."' && class = '".$class_id."'";
	$query = mysql_query($sql);
	if(mysql_num_rows($query))
	{
		while($row = mysql_fetch_array($query))
		{
			return $row["value"];
		}
	}
	else
	{
		return 0;
	}
}


?>

<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>

<script language=JavaScript >

$(document).ready(function(){
	$(".setnum").blur( function () {
		var teacher_id = $(this).attr("teacher");
		var major_id   = $(this).attr("major");
		var class_id   = $(this).attr("class_id");
		var year       = $(this).attr("year");
		var value      = $(this).attr("value");
		$.post("./ajax/set_teacher_student.php", { teacher_id: teacher_id, major_id:major_id ,class_id:class_id,year:year,value:value});
	} );
});
</script>
