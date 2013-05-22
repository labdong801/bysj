<table width="148" border="1" cellpadding="3" bordercolor=#000000>

<?
if($com_auth>=40){
?>

<tr>
<td align=left bgColor=#5a6e8f height=28><font color=#FFFFFF>&nbsp;→&nbsp;时间设置</font></td>
</tr>
<tr>
<td><a href="#">乐器选修时间设置</a></td>
</tr>
<tr>
<td><a href="#">钢琴、声乐时间设置</a></td>
</tr>
<tr>
<td><a href="#">主修方向时间设置</a></td>
</tr>
<tr>
<td><a href="#">毕业设计时间设置</a></td>
</tr>

<tr>
<td align=left bgColor=#5a6e8f height=28><font color=#FFFFFF>&nbsp;→&nbsp;管理员功能</font></td>
</tr>
<tr>
<td><a href="all_information.php">审核教师选题</a></td>
</tr>
<tr>
<td><a href="set_date.php">选题阶段时间设置</a></td>
</tr>
<tr>
<td><a href="view_select.php">毕设课题选择一览</a></td>
</tr>
<tr>
<td><a href="authority.php">指导教师授权</a></td>
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
