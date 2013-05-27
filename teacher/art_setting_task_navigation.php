<table width="148" border="1" cellpadding="3" bordercolor=#000000>
<?
if($com_auth>=40){
?>

<tr>
<td align=left bgColor=#5a6e8f height=28><font color=#FFFFFF>&nbsp;→&nbsp;任务下达</font></td>
</tr>
<?php

	for($i=$YEAR_S;$i<$YEAR_C;$i++)
	{
		$arr_grade[$YEAR_C-$i]=$i;
	}
	 $arr_grade[0]=$YEAR_C;

?>



<tr>
<td><a href="art_teacher_task.php?Choice=<?php echo $arr_grade[0] ?>">大一任务设置</a></td>
</tr>
<tr>
<td><a href="art_teacher_task.php?Choice=<?php echo $arr_grade[1] ?>">大二任务设置</a></td>
</tr>
<tr>
<td><a href="art_teacher_task.php?Choice=<?php echo $arr_grade[2] ?>">大三任务设置</a></td>
</tr>
<tr>
<td><a href="art_teacher_task.php?Choice=<?php echo $arr_grade[3] ?>">大四任务设置</a></td>
</tr>


<tr>
<td align=left bgColor=#5a6e8f height=28><font color=#FFFFFF>&nbsp;→&nbsp;任务一览表</font></td>
</tr>
<tr>
<td><a href="art_teacher_task.php?Choice_2=<?php echo $arr_grade[0] ?>">大一一览表</a></td>
</tr>
<tr>
<td><a href="art_teacher_task.php?Choice_2=<?php echo $arr_grade[1] ?>">大二一览表</a></td>
</tr>
<tr>
<td><a href="art_teacher_task.php?Choice_2=<?php echo $arr_grade[2] ?>">大三一览表</a></td>
</tr>
<tr>
<td><a href="art_teacher_task.php?Choice_2=<?php echo $arr_grade[3] ?>">大四一览表</a></td>
</tr>


<tr>
<td align=left bgColor=#5a6e8f height=28><font color=#FFFFFF>&nbsp;→&nbsp;任务验收汇总</font></td>
</tr>
<tr>
<td><a href="art_teacher_task.php?Choice_3=<?php echo $arr_grade[0] ?>">大一汇总</a></td>
</tr>
<tr>
<td><a href="art_teacher_task.php?Choice_3=<?php echo $arr_grade[1] ?>">大二汇总</a></td>
</tr>
<tr>
<td><a href="art_teacher_task.php?Choice_3=<?php echo $arr_grade[2] ?>">大三汇总</a></td>
</tr>
<tr>
<td><a href="art_teacher_task.php?Choice_3=<?php echo $arr_grade[3] ?>">大四汇总</a></td>
</tr>
<?
}
?>

</table>