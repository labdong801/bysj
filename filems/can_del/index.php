<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>�ĵ�����ϵͳ</title>
<style type="text/css">
<!--
.STYLE1 {
	font-size: 36px;
	font-family: "����", "����_GB2312";
}
.STYLE2 {font-size: 16px}
.STYLE3 {color: #FF33CC}
.STYLE4 {color: #3366FF}
.STYLE5 {font-family: "����", "����_GB2312"}
-->
</style>
<link rel="stylesheet" type="text/css" href="../xeasy.css">
</head>

<body>
<table width="750" height="40" border="0" align="center">
  <tr>
    <td width="360"><img src="images/mmc1.jpg" alt="image" width="343" height="82" /></td>
    <td width="380" background="images/background3.jpg"><span class="STYLE5">&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;<span class="STYLE1">��ҵ�ĵ�����ϵͳ</span></span></td>
  </tr>
</table>
<table width="750" border="0" align="center">
  <tr>
    <td height="21" bgcolor="f8f9fc"><div align="center"><span class="STYLE2">����ҳ��&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;��<a href="teacher/login.php">��ʦ��¼</a>��&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;��<a href="student/login.php">ѧ����¼</a></span>��</div></td>
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
    <td><p class="STYLE3">*ϵͳ˵����<a href=http://www.dianxinxi.cn/download/��ҵ��Ʊ�׼��ʽ��Ҫ��.rar><font size=+2 color=blue><b>��ҵ����ĵ�Ҫ��</b></font></a></p>
    <p class="STYLE4">I��ѧ����¼�ʺ�Ϊѧ�ţ�ԭʼ����Ϊѧ�š�</p>
	<p class="STYLE4">II����¼�ɹ��󣬸��ݵ������������б������Ӧ������</p>
	<p class="STYLE4">III��Ϊ�˱���������Ϣ�İ�ȫ��ÿ�β������ϵͳ���ٵ����˳���������ӡ�</p>
	</td>
  </tr>
  <tr>
    <td> <a href=/bysj><span class="STYLE1">����˴��������ҵ���ѡ��ϵͳ</span></a>
  &nbsp;&nbsp;
 </td>
  </tr>   
</table>
<p>&nbsp;</p>
<table width="750" height="40" border="0" align="center">
  <tr>
    <td width="750" bgcolor="F8F9FC"><div align="center">����ʱ�䣺2009��10��</div></td>
  </tr>
  <tr>
    <td bgcolor="F8F9FC"><div align="center">copyright@ï��ѧԺ���Ź���ϵ</div></td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>