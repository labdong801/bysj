

<table width="800" border="1" align="center" bordercolor=#000000  cellpadding="3">
<tr align="center" bgColor=#5a6e8f  height=38>
<?php
if($_GET[edit_id])
{
	?>
<td><font color=#FFFFFF size=+1>�����޸�</font></td>

	<?
} else if($_GET['Choice']){
	?>
<td width="15%"><font color=#FFFFFF ><?PHP echo $Class?></font></td><td><font color=#FFFFFF size=+1>ָ����ʦ�����´�</font></td>

	<?php
} else if($_GET['content_id'])
{
	?>
	<td><font color=#FFFFFF size=+1>��������</font></td>
	<?
}
?>
</tr>
</table>
<br>
<form name="taskform" method="post"  action="<?php $PHP_SELF?>" onsubmit="return is_empty();">
<?php

$sql1="SELECT id,name from ".$TABLE."major where h_level='19'";
$query1=mysql_query($sql1);
$arr="";
//$pro="<div>";
$i=0;
while($rp=mysql_fetch_array($query1))
{
  $arr[$i][id]=$rp[id];
  $arr[$i][name]=$rp[name];
  $i++;

}


?>

<table  width="800" border="1" align="center" bordercolor=#000000  cellpadding="3">
<?php
if($_GET[Choice])
{
	?>
	<tr>
<td colspan="2"><label> <input type="radio" name="RadioGroup1" value="<?php echo $arr[0][id] ?>" checked="checked" <?php /*if($ZY!=23){?>checked="checked"<?} */?> id="lab1"/><?php echo $arr[0][name] ?></label>
<label> <input type="radio" name="RadioGroup1" value="<?php echo $arr[1][id] ?>" <?php /* if($ZY==23){?>checked="checked"<?}*/?>id="lab2"/><?php echo $arr[1][name] ?></label>
</td>
</tr>
<?
}
?>


<tr>
<td colspan="2" id="pro_id"></td>
</tr>

<tr>
<td>�������:</td><td><input type="text" name="title" value="<?php echo $title ?>"></td>
</tr>

<tr>
<td>��������:</td><td><textarea name="content" rows="6"cols="80"><?php echo $content ?></textarea></td>
</tr>

<tr>
<td>����ʱ��:</td>
<td>
<table width="100%" border="0">
<tr>
<td>��ʼʱ��:<input type="text" name="start_time" value="<?php echo $start_time ?>" onclick="WdatePicker()" onchange="checkInputDate(this)" class="Wdate"></td>
</tr>
<tr>
<td>��ֹʱ��:<input type="text" name="end_time" value="<?php echo $end_time ?>" onclick="WdatePicker()" onchange="checkInputDate(this)" class="Wdate"></td>
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
<?php
if($_GET[edit_id])
{
	?>
	<input type="submit" value="�ύ" name="submit1" id="submit1">

	<?
}else
{
?>
<input type="submit" value="�ύ" name="submit" id="submit">
<?
}
?>

<input type="reset" value="����" name="reset">
</td>
</tr>
	<?
  }
  else
  {
  	?>
<tr>
<td colspan="2">
<input type="button" value="����" onclick="javascript:history.back(1)">
</td>
</tr>
  	<?
  }
?>

</table>
</form>