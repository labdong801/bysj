<?php
$self= $PHP_SELF;//�ļ���Ե�ַ

$filename = $_SERVER["SCRIPT_FILENAME"];//��ȡ�ļ����Ե�ַ
$loc= strpos($filename,$self);//�Լ���Ե�ַ�ھ��Ե�ַ�г��ֵ�λ��
$baseDIR = substr($filename,0,$loc);//������ַ

$YM_ZT = "��ʦ����";
$YM_ZT2 = "��ʦָ��ѧ����������";
$YM_MK = "��ҵ���˫��ѡ��ϵͳ";
$YM_PT ="ȫ���趨";
$YM_DH = 1; //��Ҫ������
$YM_QX = 90; //����ԱȨ��
include($baseDIR."/bysj/inc_head.php");

$teacher_id = $com_id;
echo $teacher_id;
 ?>


<table width="100%" align="center">
<tr class="align_top">
<td align="left">
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<?php
	echo "<a href=".$PHP_SELF."?select_year=".$YEAR_C."><font color=blue><u>�鿴".$YEAR_C."��(����)ѡ��</u></font></a>";
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   �鿴���������";
	for($i=$YEAR_S;$i<$YEAR_C;$i++) echo "<a href=".$PHP_SELF."?select_year=".$i."><font color=blue><u>".$i."��</u></font></a> ";
	if($select_year<$YEAR_S||$select_year>$YEAR_C) $select_year = $YEAR_C;
	?>
	&nbsp;<br>&nbsp;<br>
<table width="800" border="1" align="center" bordercolor=#000000  cellpadding="3">
<tr align="center" bgColor=#5a6e8f  height=38>
<td width=60><font color=#FFFFFF>��ʦ</font></td>
<td><font color=#FFFFFF size=+1>ָ��ѧ������</font></td>
</tr>

<?php
 //������ѡ���
 if($_GET['select_year'])
 {
 	$year = $_GET['select_year'];
 }
 else
 {
 	$year = date("Y",mktime(0,0,0,date("m")-8,1,date("Y"))); //
 	/*
 	 * ��ѧ����� ����ǰ��ݼ�8���£�
 	 * eg:
 	 * ������ 2013��6�� ������2012ѧ��ڶ����ڡ����� $art_select_year = 2012
 	 * ������2013��9�£�����2013���һѧ�ڡ�����$art_select_year =2013
 	 * */
 }


/*�ҳ�����רҵ*/
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
			<tr> <td colspan=2>����һ��</td> </tr>
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

			<tr> <td colspan=2>�������</td> </tr>
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

			<tr> <td colspan=2>��������</td> </tr>
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

			<tr> <td colspan=2>�����ģ�</td> </tr>
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
