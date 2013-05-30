<form name="taskform" method="post" enctype="multipart/form-data">
<?if($status==1)
{
?>

<div style="color:red;" align="center">你的作业已经上交，如果你再次上交作业，将会覆盖上次作业 --<a href="#" onclick="javascript:history.back(1)">返回<a></div>

<?
}?>
<table  width="800" border="1" align="center" bordercolor=#000000  cellpadding="3">

<tr>
<td>任务标题:</td><td><input type="text" name="title" value="<?php echo $title ?>"></td>
</tr>
<tr>
<td>作业上传:</td><td><input type="file" name="upfile"></td>
</tr>
<tr>
<td colspan="2">
<input type="submit" value="提交" name="submit1" id="submit1">
<input type="reset" value="重设" name="reset">
</td>
</tr>
</table>
<input type="hidden" value="<?php echo $major ?>" name="major_id">
<input type="hidden" value="<?php echo $classes ?>" name="classes">
<input type="hidden" value="<?php echo $t_id ?>" name="task_id">
<input type="hidden" value="<?php echo $years ?>" name="years">
<input type="hidden" value="<?php echo $teacher ?>" name="teacher_id">
<input type="hidden" value="<?php echo $grade_id ?>" name="grade_id">
</form>