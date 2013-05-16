<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "补充统计数据";
$YM_ZT2 = "补充毕业设计论文相关统计数据";
$YM_MK = "毕业设计答辩管理系统";
$YM_PT = "答辩系统";
$YM_DH = 1; //需要导航条
$YM_QX = 10; //本页访问需要权限
include($baseDIR."/bysj/inc_head.php");

$teacher_id = $com_id;
 ?>

<?php
$sid = $_GET["sid"];
if($_POST["sid"]!="")$sid = $_POST["sid"];

if($_POST["submit"]){
	//提交考核表进行的操作
 	$difficulty = $_POST["difficulty"];
 	$new = $_POST["new"];
 	$count1 = $_POST["count1"];
 	$count2 = $_POST["count2"];
 	$count1 += 0;
 	$count2 += 0;
 	$supplement = $count1 + $count2;
 	$source = $_POST["source"];
 	
 	$source = HTMLSpecialChars($source); 	
  	
    $sql = "update ".$TABLE."ok_topic set 
            difficulty = '$difficulty',
            new = '$new',
            source = '$source',
            count1 = $count1,
            count2 = $count2,
            supplement = $supplement
            where student_id = '$sid' && teacher_id = '$teacher_id'";
   //echo $sql;
   $open = mysql_query($sql);
}
?>
<table width="660" border="1" align="center" cellpadding="5" cellspacing="0" bordercolor=#000000>
<tr>
<td colspan=5>
	毕业设计工作尚需要您提供必要的统计信息，请点击学生姓名录入这些信息，谢谢。</td>
</tr>
<?php
 $sql = "select student_id,student.name as sname,supplement  from ".$TABLE."ok_topic as oktopic,".$TABLE."student_sheet as student where oktopic.student_id=student.number&&oktopic.teacher_id='".$teacher_id."'&&oktopic.year=$CURR_YEAR order by student_id";
 //echo $sql;
 $sqlquery = mysql_query($sql);
 if($sqlquery) $currrows=mysql_num_rows($sqlquery);  
  else $currrows = 0;
  if($currrows<1){
	$currrows = 0;
	echo "<tr><td colspan=5 height=68 align=center>对不起，系统中没有您指导 <b>".$CURR_YEAR."届</b> 毕业设计的学生记录</td></tr>";
  }  
  $cnt = 0;
while($row = mysql_fetch_array($sqlquery)){
	if($cnt%5==0) echo "<tr>";
     echo "<td width=130 align=center><a href=".$PHP_SELF."?sid=".$row["student_id"]."><font color=blue><u>".$row["sname"]."</u></font></a>(".($row["supplement"]?"已录":"<font color=red>未录</font>").")</td>";
     if($cnt%5==4)echo "</tr>";
    $cnt++;
}
for(;$cnt%5!=0;$cnt++){
	echo "<td width=130>&nbsp;</td>";
}
?>
</table>

<?php
$showit = true;

if($sid=="") $showit = false;
 $sql = "select student.profession as spro,class,type,student_id,student.name as sname,topic,new,supplement,count1,count2,source,difficulty
   from ".$TABLE."ok_topic as oktopic,".$TABLE."student_sheet as student where oktopic.student_id=student.number&&oktopic.student_id='".$sid."'&&oktopic.teacher_id='".$teacher_id."'";
//echo $sql;
 $sqlquery = mysql_query($sql);
 $detail = mysql_fetch_array($sqlquery);
 if($detail["student_id"]=="") $showit = false;

/////////下方是成绩考核表展示区
if($showit){
?>
<br>
<table border=0 width=660 align=center>
<form id="form1" name="form1" method="post" action="">
  <tr>
	<td valign=top align=center>
<div align="center">
<table width="580" border="1" cellpadding="5" cellspacing="0" bordercolor=#000000>
  <tr>
    <td width="74" height="30">毕设题目</td>
    <td colspan="3">(<strong><?php echo $detail["sname"]; ?></strong>) <?php echo $detail["topic"];?></td>
  </tr>
  <tr>
    <td height="41">本课题是否<br>是新课题</td>
    <td><input type="radio" name="new" value="1" <?php echo $detail["new"]?"  checked=checked":"";?>/>是，本课题是新课题<br>
  <input name="new" type="radio" value="0" <?php echo $detail["new"]?"":"  checked=checked";?> />否，本课题是旧课题
 </td>
    <td><div align="right">论文字数</div></td>
    <td><input name="count1" type="text" id="count1" value="<?php echo $detail["count1"];?>" size="8" maxlength="6" /></td>
  </tr>
  <tr>
    <td height="30">本课题来源</td>
    <td colspan="3" ><input name="source" type="text" id="source" value="<?php echo $detail["source"]?>" size="30" maxlength="28" />（若来自项目，请注明项目级别和日期）</td>
  </tr>
  <tr>
    <td height="30">本课题难度</td>
    <td width="221"><input type="radio" name="difficulty" value="偏难" <?php echo $detail["difficulty"]=="偏难"?"  checked=checked":"";?>/> 偏难
  <input name="difficulty" type="radio" value="适中" <?php echo $detail["difficulty"]=="适中"?"  checked=checked":"";?> />  适中
  <input name="difficulty" type="radio" value="偏易" <?php echo $detail["difficulty"]=="偏易"?"  checked=checked":"";?> />  偏易</td>
    <td><div align="right">译文外文字数</div></td>
    <td><input name="count2" type="text" id="count2" value="<?php echo $detail["count2"];?>" size="8" maxlength="6" /></td>
  </tr>
</table>
<br>
<input type=submit name=submit value=提交该毕业设计课题的补充信息>
<input type=hidden name=sid value=<?php echo $sid; ?>>
</td>
</tr>
</form>
</table>
<?php
}
?>

<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>
