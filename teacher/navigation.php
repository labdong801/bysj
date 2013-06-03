<table width="148" border="1" cellpadding="3" bordercolor=#000000>
<tr align="center">
<td bgColor=#4a5e7f height=28><font color=#FFFFFF>导&nbsp;&nbsp;航</font></td>
</tr>
<tr>
<td><a href="art_teacher_chose_grade1.php">器乐选修</a></td>
</tr>
<tr>
<td><a href="art_teacher_chose_grade2.php">钢琴、声乐选修</a></td>
</tr>
<tr>
<td><a href="art_teacher_chose_grade3.php">专业主修方向选修</a></td>
</tr>
<tr>
<td><a href="select_student.php">毕业设计</a></td>
</tr>
<tr>
<td><a href="check_handon.php">毕业设计题目添加</a></td>
</tr>
<?php
//<tr>
//<td><a href="watch_my_student_all.php">指导学生一览</a></td>
//</tr>

?>
<tr>
<td><a href="suggestion.php">意见和建议</a></td>
</tr>
<tr>
<td><a href="teacher_information.php">教师信息表</a></td>
</tr>
<tr>
<td><a href="teacher_contact.php">联系方式</a></td>
</tr>
<?
if($com_auth>=40){
?>
<tr>
<td align=left bgColor=#5a6e8f height=28><font color=#FFFFFF>&nbsp;→&nbsp;时间设置</font></td>
</tr>
<tr>
<td><a href="art_grade1_set_date.php">乐器选修时间设置</a></td>
</tr>
<tr>
<td><a href="art_grade2_set_date.php">钢琴、声乐时间设置</a></td>
</tr>
<tr>
<td><a href="art_grade3_set_date.php">主修方向时间设置</a></td>
</tr>
<tr>
<td><a href="art_grade4_set_date.php">毕业设计时间设置</a></td>
</tr>

<tr>
<td align=left bgColor=#5a6e8f height=28><font color=#FFFFFF>&nbsp;→&nbsp;管理员功能</font></td>
</tr>
<tr>
<td><a href="all_information.php">审核教师选题</a></td>
</tr>
<tr>
<td><a href="art_admin_chose_grade1.php">乐器选修选择一览</a></td>
</tr>
<tr>
<td><a href="art_admin_chose_grade2.php">声乐、钢琴选择一览</a></td>
</tr>
<tr>
<td><a href="art_admin_chose_grade3.php">专业方向选择一览</a></td>
</tr>
<tr>
<td><a href="view_select.php">毕设课题选择一览</a></td>
</tr>
<tr>
<td><a href="art_teacher_setting.php">教师指导人数管理</a></td>
</tr>
<tr>
<td><a href="authority.php">教师权限管理</a></td>
</tr>
<tr>
<td><a href="teacher_account.php">教师帐号管理</a></td>
</tr>
<tr>
<td><a href="student_account.php">查看学生帐号</a></td>
</tr>
<tr>
<td><a href="student_sheet.php">导入学生帐号</a></td>
</tr>
<?
}
?>
<?
if($com_auth>=40){
?>
<tr>
<td align=left  bgColor=#5a6e8f height=28><font color=#FFFFFF>&nbsp;→&nbsp;统计数据</font></td>
</tr>
<tr>
<td><a href="statistics.php">指导人数统计</a>	</td>
</tr>
 <tr>
  <td><a href="statistics_detail.php">毕设题目一览表</a></td>
 </tr>
 <?
}
?>
<?
if($com_auth>=90){
?>
<tr>
<td align=left bgColor=#5a6e8f height=28><font color=#FFFFFF>&nbsp;→&nbsp;超级管理员功能</font></td>
</tr>
 <tr>
  <td><a href="examine_view.php">最终成绩一览</a></td>
 </tr>
<tr>
<td><a href="teacher_sheet.php">导入教师表</a></td>
</tr>
<tr>
<td><a href="watch_suggestion.php">查看意见和建议</a></td>
</tr>
<tr>
<td><a href="class_manage.php">题目类别管理</a></td>
</tr>
<tr>
<td><a href="major_manage.php">专业名称设置</a></td>
</tr>
<?php
}
?>
</table>
