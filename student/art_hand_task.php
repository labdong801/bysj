<form name="taskform" method="post" enctype="multipart/form-data">
<?if($status==1)
{
?>

<div style="color:red;" align="center">�����ҵ�Ѿ��Ͻ���������ٴ��Ͻ���ҵ�����Ḳ���ϴ���ҵ --<a href="#" onclick="javascript:history.back(1)">����<a></div>

<?
}?>
<table  width="800" border="1" align="center" bordercolor=#000000  cellpadding="3">

<tr>
<td>�������:</td><td><input type="text" name="title" value="<?php echo $title ?>"></td>
</tr>
<tr>
<td>��ҵ�ϴ�:</td><td><input type="file" name="upfile"></td>
</tr>
<tr>
<td colspan="2">
<input type="submit" value="�ύ" name="submit1" id="submit1">
<input type="reset" value="����" name="reset">
</td>
</tr>
</table>
<input type="hidden" value="<?php echo $t_id ?>" name="task_id">
</form>