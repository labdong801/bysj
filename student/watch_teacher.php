<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "查看教师信息";
$YM_ZT2 = "浏览指导教师详细个人信息";
$YM_MK = "毕业设计双向选题系统";
$YM_DH = 1; //需要导航条
$YM_QX = 1; //本页访问需要权限：普通学生
include($baseDIR."/bysj/inc_head.php");

$number = $com_id;

$teacher_id = $_GET["teacher_id"];

$query = mysql_query("select * from ".$TABLE."teacher_information where teacher_id = '$teacher_id'");
$row = mysql_fetch_array($query);
?>

<table width="730" border="3" align="center" bordercolor="#333333"   cellpadding=6>
    <tr>
      <td><div align="center">姓名：</div></td>
      <td colspan="2"><? echo $row["name"];?></td>
      <td><div align="center" class="STYLE6">技术职称：</div></td>
      <td><? echo $row["techpos"];?></td>
      <td><div align="center">行政职务：</div></td>
      <td colspan="2"><? echo $row["officepos"];?></td>
    </tr>
    <tr>
      <td><div align="center">性别：</div></td>
      <td><? echo $row["sex"];?></td>
      <td><div align="center">出生日期：</div></td>
      <td><? echo $row["birthday"];?></td>
      <td><div align="center">出生地：</div></td>
      <td><? echo $row["hometown"];?></td>
      <td><div align="center">政治面貌：</div></td>
      <td><? echo $row["zhengzhi"];?></td>
    </tr>
    <tr>
      <td><div align="center">民族：</div></td>
      <td><? echo $row["minzhu"];?></td>
      <td><div align="center">文化程度：</div></td>
      <td><? echo $row["educatelevel"];?></td>
      <td><div align="center">学 &nbsp;位：</div></td>
      <td><? echo $row["degree"];?></td>
      <td><div align="center">毕业时间：</div></td>
      <td><? echo $row["graduate"];?></td>
    </tr>
    <tr>
      <td><div align="center">毕业学校：</div></td>
      <td colspan="3"><? echo $row["graduateschool"];?></td>
      <td><div align="center">所学专业：</div></td>
      <td colspan="3"><? echo $row["profession"];?></td>
    </tr>
    <tr>
      <td><div align="center">从事专业：</div></td>
      <td colspan="3"><? echo $row["jobfield"];?></td>
      <td><div align="center">电子邮件：</div></td>
      <td colspan="3"><? echo $row["email"];?></td>
    </tr>
    <tr>
      <td colspan="8">主要课程及研究方向：<p>
	  <? echo $row["research"];?>
	  <p>  
	  </td>
    </tr>
    <tr>
      <td colspan="8"><div align="center">获奖情况</div></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center">奖励种类</div></td>
      <td colspan="3"><div align="center">项目名称</div></td>
      <td><div align="center">等级</div></td>
      <td><div align="center">排名</div></td>
      <td><div align="center">年度</div></td>
    </tr>
    <tr align="center">
      <td colspan="2"><? echo $row["prise1"];?></td>
      <td colspan="3"><? echo $row["prisename1"];?></td>
      <td><? echo $row["level1"];?></td>
      <td><? echo $row["grade1"];?></td>
      <td><? echo $row["year1"];?></td>
    </tr>
    <tr align="center">
      <td colspan="2"><? echo $row["prise2"];?></td>
      <td colspan="3"><? echo $row["prisename2"];?></td>
      <td><? echo $row["level2"];?></td>
      <td><? echo $row["grade2"];?></td>
      <td><? echo $row["year2"];?></td>
    </tr>
    <tr align="center">
      <td colspan="2"><? echo $row["prise3"];?></td>
      <td colspan="3"><? echo $row["prisename3"];?></td>
      <td><? echo $row["level3"];?></td>
      <td><? echo $row["grade3"];?></td>
      <td><? echo $row["year3"];?></td>
    </tr>
    <tr>
      <td colspan="8">代表论文、著作和教材</td>
    </tr>
    <tr>
      <td colspan="4"><div align="center">论文题目、著作和教材名称</div></td>
      <td colspan="4"><div align="center">发表期刊、出版社</div></td>
    </tr>
    <tr align="center">
      <td colspan="4" width="50%"><? echo $row["writing1"];?></td>
      <td colspan="4"><? echo $row["publish1"];?></td>
    </tr>
    <tr align="center">
      <td colspan="4"><? echo $row["writing2"];?></td>
      <td colspan="4"><? echo $row["publish2"];?></td>
    </tr>
    <tr align="center">
      <td colspan="4"><? echo $row["writing3"];?></td>
      <td colspan="4"><? echo $row["publish3"];?></td>
    </tr>
    <tr>
      <td colspan="8">科研成果</td>
    </tr>
    <tr>
      <td colspan="4"><div align="center">名称</div></td>
      <td colspan="4"><div align="center">下达、评定、授予单位：</div></td>
    </tr>
    <tr align="center">
      <td colspan="4" width="50%"><? echo $row["achieve1"];?></td>
      <td colspan="4"><? echo $row["department1"];?></td>
    </tr>
    <tr align="center">
      <td colspan="4"><? echo $row["achieve2"];?></td>
      <td colspan="4"><? echo $row["department2"];?></td>
    </tr>
    <tr align="center">
      <td colspan="4"><? echo $row["achieve3"];?></td>
      <td colspan="4"><? echo $row["department3"];?></td>
    </tr>
</table>
<?
  @include($baseDIR."/bysj/inc_foot.php");
?>
