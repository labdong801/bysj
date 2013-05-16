<table width="148" border="1" cellpadding="3" bordercolor=#000000>
 <tr align="center">
<td bgColor=#4a5e7f height=28><font color=#FFFFFF>导&nbsp;&nbsp;航</font></td>
 </tr>
 <?
if($com_auth>=10){
?>
 <tr align="center">
  <td><a href="group.php">教师答辩分组</a></td>
 </tr>
 <tr align="center">
  <td><a href="group_student.php">论文评阅安排</a></td>
 </tr>
 <tr align="center">
  <td><a href="studentgrouplist.php">学生分组一览</a></td>
 </tr>
 <tr align="center">
  <td><a href="examine1.php">考核表：指导意见</a></td>
 </tr>
 <tr align="center">
  <td><a href="examine2.php">考核表：评阅意见</a></td>
 </tr>
 <tr align="center">
  <td><a href="examine3_tmp.php">录入答辩成绩</a></td>
 </tr>
<tr align="center">
  <td><a href="examine3.php">考核表：综合考核</a></td>
 </tr>
 <tr align="center">
  <td><a href="supplement.php">论文信息补充</a></td>
 </tr>
<?
}
?>
<?
if($com_auth>=10){
?>
 <tr>
  <td align=left bgColor=#5a6e8f height=28><font color=#FFFFFF>&nbsp;→&nbsp;其他功能</font></td>
 </tr>
 <tr align="center">
  <td><a href="checktopic.php">毕设课题修改</a></td>
 </tr>
 <tr align="center">
  <td><a href="examine_view.php">成绩查看（秘书）</a></td>
 </tr>
 <tr align="center">
  <td><a href="examine_show.php">考核表查看（秘书）</a></td>
 </tr>
 <tr align="center">
  <td><a href="examine_autoprint.php">考核表打印（主任）</a></td>
 </tr>
<?php
}
?>
<?
if($com_auth>=80){
?>
 <tr>
  <td align=left bgColor=#5a6e8f height=28><font color=#FFFFFF>&nbsp;→&nbsp;超级管理员功能</font></td>
 </tr>
 <tr align="center">
  <td><a href="ok_topic_init.php">毕设答辩初始化</a></td>
 </tr>
 <tr align="center">
  <td><a href="examine_modify.php">最终成绩修改</a></td>
 </tr>
 <tr align="center">
  <td><a href="view_teachers.php">指导教师一览</a></td>
 </tr>
 <tr align="center">
  <td><a href="own_m.php">文档审核（不用）</a></td>
 </tr>
<?php
}
?>
</table>
