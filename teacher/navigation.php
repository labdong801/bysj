<table width="148" border="1" cellpadding="3" bordercolor=#000000>
<tr align="center">
<td bgColor=#4a5e7f height=28><font color=#FFFFFF>��&nbsp;&nbsp;��</font></td>
</tr>
<tr>
<td><a href="art_teacher_chose_grade1.php">����ѡ��</a></td>
</tr>
<tr>
<td><a href="art_teacher_chose_grade2.php">���١�����ѡ��</a></td>
</tr>
<tr>
<td><a href="art_teacher_chose_grade3.php">רҵ���޷���ѡ��</a></td>
</tr>
<tr>
<td><a href="select_student.php">��ҵ���</a></td>
</tr>
<tr>
<td><a href="check_handon.php">��ҵ�����Ŀ���</a></td>
</tr>
<?php
//<tr>
//<td><a href="watch_my_student_all.php">ָ��ѧ��һ��</a></td>
//</tr>

?>
<tr>
<td><a href="suggestion.php">����ͽ���</a></td>
</tr>
<tr>
<td><a href="teacher_information.php">��ʦ��Ϣ��</a></td>
</tr>
<tr>
<td><a href="teacher_contact.php">��ϵ��ʽ</a></td>
</tr>
<?
if($com_auth>=40){
?>
<tr>
<td align=left bgColor=#5a6e8f height=28><font color=#FFFFFF>&nbsp;��&nbsp;ʱ������</font></td>
</tr>
<tr>
<td><a href="art_grade1_set_date.php">����ѡ��ʱ������</a></td>
</tr>
<tr>
<td><a href="art_grade2_set_date.php">���١�����ʱ������</a></td>
</tr>
<tr>
<td><a href="art_grade3_set_date.php">���޷���ʱ������</a></td>
</tr>
<tr>
<td><a href="art_grade4_set_date.php">��ҵ���ʱ������</a></td>
</tr>

<tr>
<td align=left bgColor=#5a6e8f height=28><font color=#FFFFFF>&nbsp;��&nbsp;����Ա����</font></td>
</tr>
<tr>
<td><a href="all_information.php">��˽�ʦѡ��</a></td>
</tr>
<tr>
<td><a href="art_admin_chose_grade1.php">����ѡ��ѡ��һ��</a></td>
</tr>
<tr>
<td><a href="art_admin_chose_grade2.php">���֡�����ѡ��һ��</a></td>
</tr>
<tr>
<td><a href="art_admin_chose_grade3.php">רҵ����ѡ��һ��</a></td>
</tr>
<tr>
<td><a href="view_select.php">�������ѡ��һ��</a></td>
</tr>
<tr>
<td><a href="art_teacher_setting.php">��ʦָ����������</a></td>
</tr>
<tr>
<td><a href="authority.php">��ʦȨ�޹���</a></td>
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
