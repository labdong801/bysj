<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>文档管理系统</title>
<style type="text/css">
<!--
.STYLE1 {
	font-size: 36px;
	font-family: "黑体", "楷体_GB2312";
}
.STYLE2 {font-size: 16px}
.STYLE3 {color: #FF33CC}
.STYLE4 {color: #3366FF}
.STYLE5 {font-family: "黑体", "楷体_GB2312"}
-->
</style>
<link rel="stylesheet" type="text/css" href="../xeasy.css">
</head>

<body>
<table width="750" height="40" border="0" align="center">
  <tr>
    <td width="360"><img src="images/mmc1.jpg" alt="image" width="343" height="82" /></td>
    <td width="380" background="images/background3.jpg"><span class="STYLE5">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;<span class="STYLE1">毕业文档管理系统</span></span></td>
  </tr>
</table>
<table width="750" border="0" align="center">
  <tr>
    <td height="21" bgcolor="f8f9fc"><div align="center"><span class="STYLE2">｜首页｜&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;｜<a href="teacher/login.php">教师登录</a>｜&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;｜<a href="student/login.php">学生登录</a></span>｜</div></td>
  </tr>
</table>
<p>
<?php
 include("connect_db.php");
 $sql = mysql_query("select * from set_date where id = '1'");
 $row = mysql_fetch_array($sql);
?>
</p>
<table width="750" height="20" border="1" align="center" bordercolor="f8f9fc">
  <tr>
    <td><p class="STYLE3">*系统说明：<a href=http://www.dianxinxi.cn/download/毕业设计标准格式及要求.rar><font size=+2 color=blue><b>毕业设计文档要求</b></font></a></p>
    <p class="STYLE4">I、学生登录帐号为学号，原始密码为学号。</p>
	<p class="STYLE4">II、登录成功后，根据导航栏的任务列表，完成相应的任务</p>
	<p class="STYLE4">III、为了保障您的信息的安全，每次操作完该系统后，再单击退出这个超链接。</p>
	</td>
  </tr>
  <tr>
    <td> <a href=/bysj><span class="STYLE1">点击此处，进入毕业设计选题系统</span></a>
  &nbsp;&nbsp;
 </td>
  </tr>   
</table>
<p>&nbsp;</p>
<table width="750" height="40" border="0" align="center">
  <tr>
    <td width="750" bgcolor="F8F9FC"><div align="center">制作时间：2009年10月</div></td>
  </tr>
  <tr>
    <td bgcolor="F8F9FC"><div align="center">copyright@茂名学院电信工程系</div></td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>