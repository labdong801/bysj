<table width="148" border="1" cellpadding="3" bordercolor=#000000>
<tr align="center">
<td bgColor=#4a5e7f height=28><font color=#FFFFFF>导&nbsp;&nbsp;航</font></td>
</tr>
<tr>
<td><div align="left"><a href="grade1.php">乐器选修</a></div></td>
</tr>
<tr>
<td><div align="left"><a href="grade2.php">声乐、钢琴选修</a></div></td>
</tr>
<tr>
<td><div align="left"><a href="grade3.php">专业方向选修</a></div></td>
</tr>
<tr>
<td><div align="left"><a href="selecttitle.php">毕业设计选题</a></div></td>
</tr>
<tr>
<td><div align="left"><a href="student_contact.php">填写联系方式</a></div></td>
</tr>
<tr>
<td><div align="left"><a href="suggestion.php">意见和建议</a></div></td>
</tr>
<?
if($com_auth>=2){
?>
<tr>
<td align=left bgColor=#5a6e8f height=28><font color=#FFFFFF>&nbsp;→&nbsp;学委专用</font></td>
</tr>
<tr>
<td><div align="left"><a href="viewmyclass.php">选题提交情况</a></div></td>
</tr>
<?
}
?>
</table>

<br>
<br>
<table width="148" border="1" cellpadding="3" bordercolor=#000000>
	<tr>
		<td>
			<b>特别注意：</b>
			<br>&nbsp;&nbsp;&nbsp;&nbsp;
			自选课题与三个志愿同步有效，若第一志愿被老师排除，则第二志愿生效，依次类推。学生的联系方式会展示给教师，但教师的电话信息需教师授权学生才能看见。
			<br>&nbsp;&nbsp;&nbsp;&nbsp;
			同一个题目可被多名同学选择，但同一个题目最终只能确认一名学生。教师选择某学生后，选择该题的其他学生将自动被排除。若学生选择志愿既没有被教师确认、也没有排除，则只能等候下一轮选择。
			<br>&nbsp;&nbsp;&nbsp;&nbsp;
			若某课题已确定学生，则该选题不再显示；若某教师选择的学生人数已达到上限，则该教师的所有课题均不再显示；课题确认后，对应学生将看到详细教师、课题信息，看不见表示未确定。
			<br>&nbsp;&nbsp;&nbsp;&nbsp;
		</td>
	</tr>
</table>