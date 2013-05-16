<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "查看毕设选题";
$YM_ZT2 = "毕业设计（论文）课题一览表";
$YM_MK = "毕业设计双向选题系统";
$YM_DH = 1; //需要导航条
$YM_QX = 10; //本页访问需要权限
include($baseDIR."/bysj/inc_head.php");

$teacher_id = $com_id;
 ?>

<?php
$op = $_GET["op"];
$id = $_GET["id"];

if($op=="copy"&&$com_auth>80){
	$sql = mysql_query("insert into ".$TABLE."topic (teacher_id,topic,source,student_number,is_select,type,profession,meaning,request,question,time,year) select '$teacher_id',topic,'0','0','0',type,profession,meaning,request,question,time,'$YEAR_C' FROM ".$TABLE."topic where id=$id");
	if($sql){
		echo "<script>alert('复制成功！');history.back();</script>";
		echo "<script>history.back();</script>";
	} else {
		echo "<script>alert('复制失败！');history.back();</script>";
	}
}
?> 
 
<table width="100%" align="center">
<tr class="align_top">
<td align="left">
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<?php
	echo "<a href=".$PHP_SELF."?select_year=".$YEAR_C."><font color=blue><u>查看".$YEAR_C."届(本届)选题</u></font></a>";
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   查看往届选题：";
	for($i=$YEAR_S;$i<$YEAR_C;$i++) echo "<a href=".$PHP_SELF."?select_year=".$i."><font color=blue><u>".$i."届</u></font></a> ";
	if($select_year<$YEAR_S||$select_year>$YEAR_C) $select_year = $YEAR_C;
	?>
	&nbsp;<br>&nbsp;<br>
<table width="760" border="1" align="center" bordercolor=#000000  cellpadding="3">
<tr align="center" bgColor=#5a6e8f  height=38>
<td width=38><font color=#FFFFFF>序号</font></td>
<td><font color=#FFFFFF size=+1>您提交的 <?php echo $select_year;?>届 毕业设计题目</font></td>
<td width=60><font color=#FFFFFF>审核结果</font></td>
<td width=50><font color=#FFFFFF>已选<br>学生</font></td>
<td width=38><font color=#FFFFFF>修改</font></td>
<td width=38><font color=#FFFFFF>删除</font></td>
</tr>
<?php
$sql = mysql_query("select id,topic,source,student_number,is_select,verify,teacher_id from ".$TABLE."topic where (teacher_id = '$teacher_id' or verify = 9) && year=".$select_year." order by id");
if($sql) $currrows=mysql_num_rows($sql);  
else $currrows = 0;
if($currrows<1){
	$currrows = 0;
	echo "<tr><td colspan=6 height=138 align=center>对不起，您还没有为本届提交毕业设计课题</td></tr>";
}
$topic_num = 1;
while($currrows&&$array = mysql_fetch_array($sql)){
?>
<tr align="center">
<td>
<?php 
 if($array["source"]==1){
  echo "自选";
} else if($array["verify"]==9 && $array["teacher_id"]!=$teacher_id){
  echo "<font color=blue>示范</font>";
 }else{
  echo $topic_num++;
 }
?>
</td>
<td align="left"><a href="topic_detail.php?topic_id=<? echo $array["id"];?>&select_year=<?echo $select_year;?>" title="查看该题的详细信息"><? echo $array["topic"];?></a></td>
<td align="center"><?
	$shenhe = array(
	      "-1" => "<font color=red>未通过</font>",
	      "0" => "<font color=green>待审核</font>",
	      "9" => "<font color=blue>示范题</font>",
	      "1" => "已审核"
	      );
	 echo $shenhe[$array["verify"]];
	 ?>
</td>
<td>
<?php 
  if($array["is_select"]==1){
?>
<a href="watch_student.php?student=<? echo $array["student_number"];?>" title="查看该学生的联系方式">
<?php
  $student_number = $array["student_number"];
  $ee = mysql_query("select name from ".$TABLE."student_sheet where number = '$student_number'");
  $ff = mysql_fetch_array($ee);
  echo $ff["name"];
  }else{
   echo "&nbsp;";
  }
?>
</a>
</td>
<td><?php
	   if($array["verify"]==9|| $array["source"]!=0||($array["is_select"]==1&&$select_year!=$YEAR_C)) echo "&nbsp;";
	   else echo "<a href=\"revise.php?id=".$array["id"]."\">修改</a>";
?></td>
<td><?php
	if($array["verify"]==9|| $array["source"]!=0||($array["is_select"]==1&&$select_year!=$YEAR_C)){
		if($com_auth>80&&$array["is_select"]==1&&$select_year!=$YEAR_C){
			echo "<a href=$PHP_SELF?id=".$array["id"]."&select_year=$select_year&op=copy onclick=\"return confirm('您确定要复制本课题吗？')\">复制</a>";
		} else {
			echo "&nbsp;";
		}
	} else {
		echo "<a href=\"delete.php?id=".$array["id"]."\" onclick=\"return confirm('您确定要删除吗？')\">删除</a>";
	}
?></td>
</tr>
<?php
 }
echo "<tr height=38><td colspan=6 align=center><a href=hand_on.php><font color=blue><u>提交新的毕业设计选题</u></font></a></td></tr>";
?>
</table>
<br>
<table width="90%" class="STYLE1" align=center>
<tr align=left>
<td>注意：</td>
</tr>
<tr align=left>
<td>1.“序号”为『数字』的，是教师自己提交的题目，您可以进行修改和删除。</td>
</tr>
<tr align=left>
<td>2.“序号”为『自选』的，是学生自己提交的题目，该题目希望得到您的指导，您可修改，但不可删除。</td>
</tr>
<tr align=left>
<td>3.“序号”为『示范』的，是课题填写合法规范的例子，您可以参考这个示范来修改自己的课题。<br>
	&nbsp;&nbsp;&nbsp;&nbsp;“示范”题由管理员选择，自动出现在此，您不能删除和修改。</td>
</tr>
<tr>
<td align=left>4. 若自己的课题被选为“示范题”，自己也不能修改和删除，除非联系管理员取消“示范”标记。</td>
</tr>
</table>

</td>
</tr>
</table>

<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>
