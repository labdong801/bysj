<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "��˱���ѡ��";
$YM_ZT2 = ($com_auth>40?"���":"���")."��ҵ��ƣ����ģ�����";
$YM_MK = "��ҵ���˫��ѡ��ϵͳ";
$YM_DH = 1; //��Ҫ������
$YM_QX = 10; //��ҳ������ҪȨ��
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
 	Show_Message("�Ѿ�û���¼�¼��");
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
<td width=100>��Ŀ��</td>
<td width=680><table width=100% border=0><tr><td><? echo $row["topic"];?>
	<?php
		$shmsg = array(
	      "-1" => "(<b><font color=red>δͨ��</font></b>)",
	      "0" => "(<b>�����</b>)",
	      "9" => "(<b><font color=blue>ʾ����</font></b>)",
	      "1" => "(<b><font color=green>�����</font></b>)"
	      );
	 echo $shmsg[$row["verify"]];
	 echo "</td><td widht=150 align=right>";
	 if($com_auth>80)echo "<a href=check_handon.php?id=$topic_id&op=copy>����</a> | ";
	 echo "<a href=".$PHP_SELF."?topic_id=$topic_id&see=nextid&orderverify=$orderverify&obj=$obj&select_year=$select_year><font color=blue><u>��һ��</u></font></a>";
	 echo "</td></tr></table>";
	 ?>
	</td>
</tr>
<tr>
<td>���ͣ�</td>
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
<td>��Դ��</td>
<td>
<?php
  $array = array("��ʦ","ѧ��");
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
<td>�ύ��ʦ��</td>
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
<td>�ύѧ����</td>
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
<td>����רҵ��</td>
<td>
<?php
	$q = 0;
	$proarr = explode(",",$row["profession"]); 
	for($i=0;$i<sizeof($proarr);$i++){
		if(!$proarr[$i])continue;
		$ik = mysql_query("select name from ".$TABLE."major where id = '$proarr[$i]'");
		$ki = mysql_fetch_array($ik);
		if($q>0) echo "��";
		echo $ki["name"];
		$q++;
	}
?>
</td>
</tr>
<tr>
<td>���壺</td>
<td>
<?php
  $meaning = $row["meaning"];
  echo dispEnter($meaning);
?>
</td>
</tr>
<tr>
<td>Ҫ��</td>
<td>
<?php
  $request = $row["request"];
  echo dispEnter($request);
?>
</td>
</tr>
<tr>
<td>���⣺</td>
<td>
<?php
  $question = $row["question"];
  echo dispEnter($question);
?>
</td>
</tr>
<tr>
<td>�ύ���ڣ�</td>
<td><? echo $row["time"];?></td>
</tr>
<tr>
<td>��ȣ�</td>
<td><? echo $row["year"];?></td>
</tr>
<?php
 if($com_auth>=40){
   echo "<tr><td colspan=2>";
	$verify = $row["verify"];
	echo "<form name=form1 action=$PHP_SELF method=post>";
	echo "<input type=radio name=shenhe value='-1' ".($verify=='-1'?" CHECKED":"")."><font color=red>��˲�ͨ��</font>&nbsp;&nbsp;";
	echo "<input type=radio name=shenhe value='1'".($verify=='1'?" CHECKED":"").">���ͨ����ѧ����ѡ&nbsp;&nbsp;";
	echo "<input type=radio name=shenhe value='0'".($verify=='0'?" CHECKED":"")."><font color=green>�Ⱥ������</font>&nbsp;&nbsp;";
	echo "<input type=radio name=shenhe value='9'".($verify=='9'?" CHECKED":"")."><font color=blue>���ͨ����ʾ����</font>&nbsp;&nbsp;";
	echo "<input type=hidden name=act value=setit>\n";
	echo "<input type=hidden name=select_year value=$select_year>\n";
	echo "<input type=hidden name=obj value=$obj>\n";
	echo "<input type=hidden name=orderverify value=$orderverify>\n";
	echo "<input type=hidden name=topic_id value=$topic_id>\n";
	echo "<input type=checkbox name=seenext value=ON ".($seenext=="ON"?" checked":"").">�Զ�չʾ��һ��\n";
	echo "&nbsp;&nbsp;";
	echo "<input type=submit value=��˸���>";
	echo "</form>";
	echo "</td></tr>";
}	
?>
</table>
<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>
