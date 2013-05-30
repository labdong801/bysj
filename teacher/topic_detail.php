<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "审核毕设选题";
$YM_ZT2 = ($com_auth>40?"审核":"浏览")."毕业设计（论文）课题";
$YM_MK = "毕业设计双向选题系统";
$YM_DH = 1; //需要导航条
$YM_QX = 10; //本页访问需要权限
include($baseDIR."/bysj/inc_head.php");

$teacher_id = $com_id;
 ?>
 <?php
 if($select_year=="")$select_year = $CURR_YEAR;
 
 if($_POST["act"]=="setit" && $com_auth>=40){
    $topic_id = $_POST["topic_id"];
    $shenhe = $_POST["shenhe"];
    $setsql = mysql_query("update ".$TABLE."topic set verify = '$shenhe' where id = '$topic_id'");    
     //echo ("update ".$TABLE."topic set verify = '$shenhe' where id = '$topic_id'");    
} else {
 $topic_id = $_GET["topic_id"];
}
$orderverify = $_POST["orderverify"];
if($orderverify=="") $orderverify = $_GET["orderverify"];
if($orderverify=="") $vvv = "";
else $vvv = " verify='$orderverify' &&";
if($seenext=="ON") $see = "nextid";
if($obj=="dept"&&$com_auth>30) $seewho = "";
else if($see=="") $seewho = "(teacher_id = '$teacher_id'||verify=9) && ";
else $seewho = "teacher_id = '$teacher_id' && ";
if($see=="nextid"){
	if($obj!="dept") {
		$sql="select * from ".$TABLE."topic where ".$vvv.$seewho." id >$topic_id &&year='$select_year' order by id asc LIMIT 1";
	} else {
		$pro_list = explode(",", $com_pro_id);
		$checkit = join(",|",$pro_list);
		$checkit = substr($checkit,0,strlen($checkit)-1);
		$sql = "select *,topic.profession from ".$TABLE."topic as topic,".$TABLE."teacher_information as teacher where ".$vvv.$seewho."topic.id >$topic_id &&topic.year=$select_year&&topic.profession REGEXP '$checkit'&&teacher.teacher_id=topic.teacher_id  order by topic.id asc";
	}
} else if($see=="lastid"){
	$sql="select * from ".$TABLE."topic where ".$vvv.$seewho." id <$topic_id &&year='$select_year' order by id desc LIMIT 1";
}else {
 	$sql = "select * from ".$TABLE."topic where ".$seewho." id = $topic_id&&year='$select_year' order by id asc"; 
}
	//echo $sql."<br>";
	$sql = mysql_query($sql);
	$currrows=mysql_num_rows($sql);
	//echo $currrows;
	$row = mysql_fetch_array($sql);
 if(!$row){
 	Show_Message("已经没有新记录了");
  	@include($baseDIR."/bysj/inc_foot.php");
 	exit;
}
   $topic_id = $row["id"];
 function dispEnter($str){
   $content = str_replace("\n","<br>",$str);
   return $content;
 }
 ?>
 <table width="780" align="center" border="1"    cellpadding=5 bordercolor=#000000>
<tr>
<td width=100>题目：</td>
<td width=680><table width=100% border=0><tr><td><? echo $row["topic"];?>
	<?php
		$shmsg = array(
	      "-1" => "(<b><font color=red>未通过</font></b>)",
	      "0" => "(<b>待审核</b>)",
	      "9" => "(<b><font color=blue>示范题</font></b>)",
	      "1" => "(<b><font color=green>已审核</font></b>)"
	      );
	 echo $shmsg[$row["verify"]];
	 echo "</td><td widht=150 align=right>";
	 if($com_auth>80)echo "<a href=check_handon.php?id=$topic_id&op=copy>复制</a> | ";
	 echo "<a href=".$PHP_SELF."?topic_id=$topic_id&see=nextid&orderverify=$orderverify&obj=$obj&select_year=$select_year><font color=blue><u>下一题</u></font></a>";
	 echo "</td></tr></table>";
	 ?>
	</td>
</tr>
<tr>
<td>类型：</td>
<td>
<?php 
 $type_id = $row["type"]; 
 $aa = mysql_query("select name from ".$ART_TABLE."title_sort where id = '$type_id'");
 $bb = mysql_fetch_array($aa);
 echo $bb[name];
?>
</td>
</tr>
<tr>
<td>来源：</td>
<td>
<?php
  $array = array("教师","学生");
  $source = $row["source"];
  echo $array["$source"];
?>
</td>
</tr>
<?php
if($com_auth>=40){
 if($row["source"]==0){
?>
<tr>
<td>提交教师：</td>
<td>
<?php
  $id = $row["teacher_id"];
  $gg = mysql_query("select name from ".$TABLE."teacher_information where teacher_id = '$id'");
  $hh = mysql_fetch_array($gg);
  echo $hh[name];
?>
</td>
</tr>
<?
}
}
?>
<?
  if($row["source"]==1){
?>
<tr>
<td>提交学生：</td>
<td>
<?php
  $student_number = $row["student_number"];
  $cc = mysql_query("select name from ".$TABLE."student_sheet where number = '$student_number'");
  $dd = mysql_fetch_array($cc);
  echo $dd[name];
?>
</td>
</tr>
<?php
}
?>
<tr>
<td>适用专业：</td>
<td>
<?php
	$q = 0;
	$proarr = explode(",",$row["profession"]); 
	for($i=0;$i<sizeof($proarr);$i++){
		if(!$proarr[$i])continue;
		$ik = mysql_query("select name from ".$TABLE."major where id = '$proarr[$i]'");
		$ki = mysql_fetch_array($ik);
		if($q>0) echo "、";
		echo $ki["name"];
		$q++;
	}
?>
</td>
</tr>
<tr>
<td>意义：</td>
<td>
<?php
  $meaning = $row["meaning"];
  echo dispEnter($meaning);
?>
</td>
</tr>
<tr>
<td>要求：</td>
<td>
<?php
  $request = $row["request"];
  echo dispEnter($request);
?>
</td>
</tr>
<tr>
<td>问题：</td>
<td>
<?php
  $question = $row["question"];
  echo dispEnter($question);
?>
</td>
</tr>
<tr>
<td>提交日期：</td>
<td><? echo $row["time"];?></td>
</tr>
<tr>
<td>年度：</td>
<td><? echo $row["year"];?></td>
</tr>
<?php
 if($com_auth>=40){
   echo "<tr><td colspan=2>";
	$verify = $row["verify"];
	echo "<form name=form1 action=$PHP_SELF method=post>";
	echo "<input type=radio name=shenhe value='-1' ".($verify=='-1'?" CHECKED":"")."><font color=red>审核不通过</font>&nbsp;&nbsp;";
	echo "<input type=radio name=shenhe value='1'".($verify=='1'?" CHECKED":"").">审核通过，学生可选&nbsp;&nbsp;";
	echo "<input type=radio name=shenhe value='0'".($verify=='0'?" CHECKED":"")."><font color=green>等候再审核</font>&nbsp;&nbsp;";
	echo "<input type=radio name=shenhe value='9'".($verify=='9'?" CHECKED":"")."><font color=blue>审核通过，示范题</font>&nbsp;&nbsp;";
	echo "<input type=hidden name=act value=setit>\n";
	echo "<input type=hidden name=select_year value=$select_year>\n";
	echo "<input type=hidden name=obj value=$obj>\n";
	echo "<input type=hidden name=orderverify value=$orderverify>\n";
	echo "<input type=hidden name=topic_id value=$topic_id>\n";
	echo "<input type=checkbox name=seenext value=ON ".($seenext=="ON"?" checked":"").">自动展示下一题\n";
	echo "&nbsp;&nbsp;";
	echo "<input type=submit value=审核该题>";
	echo "</form>";
	echo "</td></tr>";
}	
?>
</table>
<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>
