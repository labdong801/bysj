<table width="148" border="1" cellpadding="3" bordercolor=#000000>
<?
if($com_auth>=40){
?>

<tr>
<td align=left bgColor=#5a6e8f height=28><font color=#FFFFFF>&nbsp;��&nbsp;�����´�</font></td>
</tr>
<?php

	for($i=$YEAR_S;$i<$YEAR_C;$i++)
	{
		$arr_grade[$YEAR_C-$i]=$i;
	}
	 $arr_grade[0]=$YEAR_C;

?>



<tr>
<td><a href="art_teacher_task.php?Choice=<?php echo $arr_grade[0] ?>">��һ��������</a></td>
</tr>
<tr>
<td><a href="art_teacher_task.php?Choice=<?php echo $arr_grade[1] ?>">�����������</a></td>
</tr>
<tr>
<td><a href="art_teacher_task.php?Choice=<?php echo $arr_grade[2] ?>">������������</a></td>
</tr>
<tr>
<td><a href="art_teacher_task.php?Choice=<?php echo $arr_grade[3] ?>">������������</a></td>
</tr>


<tr>
<td align=left bgColor=#5a6e8f height=28><font color=#FFFFFF>&nbsp;��&nbsp;����һ����</font></td>
</tr>
<tr>
<td><a href="art_teacher_task.php?Choice_2=<?php echo $arr_grade[0] ?>">��һһ����</a></td>
</tr>
<tr>
<td><a href="art_teacher_task.php?Choice_2=<?php echo $arr_grade[1] ?>">���һ����</a></td>
</tr>
<tr>
<td><a href="art_teacher_task.php?Choice_2=<?php echo $arr_grade[2] ?>">����һ����</a></td>
</tr>
<tr>
<td><a href="art_teacher_task.php?Choice_2=<?php echo $arr_grade[3] ?>">����һ����</a></td>
</tr>


<tr>
<td align=left bgColor=#5a6e8f height=28><font color=#FFFFFF>&nbsp;��&nbsp;�������ջ���</font></td>
</tr>
<tr>
<td><a href="art_teacher_task.php?Choice_3=<?php echo $arr_grade[0] ?>">��һ����</a></td>
</tr>
<tr>
<td><a href="art_teacher_task.php?Choice_3=<?php echo $arr_grade[1] ?>">�������</a></td>
</tr>
<tr>
<td><a href="art_teacher_task.php?Choice_3=<?php echo $arr_grade[2] ?>">��������</a></td>
</tr>
<tr>
<td><a href="art_teacher_task.php?Choice_3=<?php echo $arr_grade[3] ?>">���Ļ���</a></td>
</tr>
<?
}
?>

</table>