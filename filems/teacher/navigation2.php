<table width="148" border="1" cellpadding="3" bordercolor=#000000>
 <tr align="center">
<td bgColor=#4a5e7f height=28><font color=#FFFFFF>��&nbsp;&nbsp;��</font></td>
 </tr>
 <?
if($com_auth>=10){
?>
 <tr align="center">
  <td><a href="group.php">��ʦ������</a></td>
 </tr>
 <tr align="center">
  <td><a href="group_student.php">�������İ���</a></td>
 </tr>
 <tr align="center">
  <td><a href="studentgrouplist.php">ѧ������һ��</a></td>
 </tr>
 <tr align="center">
  <td><a href="examine1.php">���˱�ָ�����</a></td>
 </tr>
 <tr align="center">
  <td><a href="examine2.php">���˱��������</a></td>
 </tr>
 <tr align="center">
  <td><a href="examine3_tmp.php">¼����ɼ�</a></td>
 </tr>
<tr align="center">
  <td><a href="examine3.php">���˱��ۺϿ���</a></td>
 </tr>
 <tr align="center">
  <td><a href="supplement.php">������Ϣ����</a></td>
 </tr>
<?
}
?>
<?
if($com_auth>=10){
?>
 <tr>
  <td align=left bgColor=#5a6e8f height=28><font color=#FFFFFF>&nbsp;��&nbsp;��������</font></td>
 </tr>
 <tr align="center">
  <td><a href="checktopic.php">��������޸�</a></td>
 </tr>
 <tr align="center">
  <td><a href="examine_view.php">�ɼ��鿴�����飩</a></td>
 </tr>
 <tr align="center">
  <td><a href="examine_show.php">���˱�鿴�����飩</a></td>
 </tr>
 <tr align="center">
  <td><a href="examine_autoprint.php">���˱��ӡ�����Σ�</a></td>
 </tr>
<?php
}
?>
<?
if($com_auth>=80){
?>
 <tr>
  <td align=left bgColor=#5a6e8f height=28><font color=#FFFFFF>&nbsp;��&nbsp;��������Ա����</font></td>
 </tr>
 <tr align="center">
  <td><a href="ok_topic_init.php">�������ʼ��</a></td>
 </tr>
 <tr align="center">
  <td><a href="examine_modify.php">���ճɼ��޸�</a></td>
 </tr>
 <tr align="center">
  <td><a href="view_teachers.php">ָ����ʦһ��</a></td>
 </tr>
 <tr align="center">
  <td><a href="own_m.php">�ĵ���ˣ����ã�</a></td>
 </tr>
<?php
}
?>
</table>
