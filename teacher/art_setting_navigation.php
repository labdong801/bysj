<table width="148" border="1" cellpadding="3" bordercolor=#000000>

<?
if($com_auth>=40){
?>

<tr>
<td align=left bgColor=#5a6e8f height=28><font color=#FFFFFF>&nbsp;��&nbsp;ʱ������</font></td>
</tr>
<tr>
<td><a href="#">����ѡ��ʱ������</a></td>
</tr>
<tr>
<td><a href="#">���١�����ʱ������</a></td>
</tr>
<tr>
<td><a href="#">���޷���ʱ������</a></td>
</tr>
<tr>
<td><a href="#">��ҵ���ʱ������</a></td>
</tr>

<tr>
<td align=left bgColor=#5a6e8f height=28><font color=#FFFFFF>&nbsp;��&nbsp;����Ա����</font></td>
</tr>
<tr>
<td><a href="all_information.php">��˽�ʦѡ��</a></td>
</tr>
<tr>
<td><a href="set_date.php">ѡ��׶�ʱ������</a></td>
</tr>
<tr>
<td><a href="view_select.php">�������ѡ��һ��</a></td>
</tr>
<tr>
<td><a href="authority.php">ָ����ʦ��Ȩ</a></td>
</tr>
<tr>
<td><a href="teacher_account.php">��ʦ�ʺŹ���</a></td>
</tr>
<tr>
<td><a href="student_account.php">�鿴ѧ���ʺ�</a></td>
</tr>
<tr>
<td><a href="student_sheet.php">����ѧ���ʺ�</a></td>
</tr>
<?
}
?>
<?
if($com_auth>=40){
?>
<tr>
<td align=left  bgColor=#5a6e8f height=28><font color=#FFFFFF>&nbsp;��&nbsp;ͳ������</font></td>
</tr>
<tr>
<td><a href="statistics.php">ָ������ͳ��</a>	</td>
</tr>
 <tr>
  <td><a href="statistics_detail.php">������Ŀһ����</a></td>
 </tr>
 <?
}
?>
<?
if($com_auth>=90){
?>
<tr>
<td align=left bgColor=#5a6e8f height=28><font color=#FFFFFF>&nbsp;��&nbsp;��������Ա����</font></td>
</tr>
 <tr>
  <td><a href="examine_view.php">���ճɼ�һ��</a></td>
 </tr>
<tr>
<td><a href="teacher_sheet.php">�����ʦ��</a></td>
</tr>
<tr>
<td><a href="watch_suggestion.php">�鿴����ͽ���</a></td>
</tr>
<tr>
<td><a href="class_manage.php">��Ŀ������</a></td>
</tr>
<tr>
<td><a href="major_manage.php">רҵ��������</a></td>
</tr>
<?php
}
?>
</table>
