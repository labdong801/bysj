
<table  width="800" border="1" align="center" bordercolor=#000000  cellpadding="3">
<tr>
<td>�γ�����:</td><td><input type="text" name="title" disabled="disabled" value="<?php echo $P_title ?>"></td>
</tr>
<tr>
<td>��������:</td><td><input type="text" name="title" disabled="disabled" value="<?php echo $title ?>"></td>
</tr>
<tr>
<td>��������:</td><td><textarea name="content" rows="6"cols="80" disabled="disabled"><?php echo $content ?></textarea></td>
</tr>
<tr>
<td>����ʱ��:</td>
<td>
<table width="100%" border="0">
<tr>
<td>��ʼʱ��:<input type="text" name="start_time" disabled="disabled" value="<?php echo $start_time ?>" onclick="WdatePicker()" onchange="checkInputDate(this)" class="Wdate"></td>
</tr>
<tr>
<td>��ֹʱ��:<input type="text" name="end_time" disabled="disabled" value="<?php echo $end_time ?>" onclick="WdatePicker()" onchange="checkInputDate(this)" class="Wdate"></td>
</tr>
</table>
</td>
</tr>
<tr>
<td colspan="2">
<input type="button" value="����" onclick="javascript:history.back(1)">
</td>
</tr>
</table>
