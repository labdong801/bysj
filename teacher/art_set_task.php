<?php

?>

<table width="800" border="1" align="center" bordercolor=#000000  cellpadding="3">
<tr align="center" bgColor=#5a6e8f  height=38>
<td width="15%"><font color=#FFFFFF ><?PHP echo $Class?></font></td><td><font color=#FFFFFF size=+1>指导老师任务下达</font></td>
</tr>
</table>
<br>
<form name="taskform" method="post"  action="<?php $PHP_SELF?>" onsubmit="return is_empty();">
<table  width="800" border="1" align="center" bordercolor=#000000  cellpadding="3">
<tr>
<td>任务标题:</td><td><input type="text" name="title" value="<?php echo $title ?>"></td>
</tr>

<tr>
<td>任务内容:</td><td><textarea name="content" rows="6"cols="80"><?php echo $content ?></textarea></td>
</tr>

<tr>
<td>任务时间:</td>
<td>
<table width="100%" border="0">
<tr>
<td>起始时间:<input type="text" name="start_time" value="<?php echo $start_time ?>" onclick="WdatePicker()" onchange="checkInputDate(this)" class="Wdate"></td>
</tr>
<tr>
<td>截止时间:<input type="text" name="end_time" value="<?php echo $end_time ?>" onclick="WdatePicker()" onchange="checkInputDate(this)" class="Wdate"></td>
</tr>
</table>
</td>
</tr>

<?php
if(!$_GET['content_id'])
{
	?>
<tr>
<td colspan="2">
<input type="submit" value="提交" name="submit">
<input type="reset" value="重设" name="reset">
</td>
</tr>
	<?
  }
?>

</table>
</form>