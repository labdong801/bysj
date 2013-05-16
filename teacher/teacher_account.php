<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "修改帐号权限";
$YM_ZT2 = "教师帐号管理、权限设置";
$YM_MK = "毕业设计双向选题系统";
$YM_DH = 1; //需要导航条
$YM_QX = 40; //本页访问需要权限：专业主任
include($baseDIR."/bysj/inc_head.php");

$teacher_id = $com_id;
 ?>
 <?php
	$curr_dept_id = $set_dept_id;
	$majiorlist = get_majior_list(0,3);
	echo "<p align=left>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;请选择操作的单位：";
	$dept_name = "";
	while(list($k,$v)=each($majiorlist)){
		if(!$v[open]) continue;
		if($v["name"]!=$com_from&&$com_auth<80) continue;
		if($curr_dept_id ==0) $curr_dept_id = $k;
  	   if($curr_dept_id == $v["id"]){
  	   	echo "[<b>".$v["name"]."</b>]";
  	   	$dept_name = $v["name"];
  	   } else {
  	   	echo "[<a href=".$PHP_SELF."?set_dept_id=".$k."><font color=blue><u>".$v["name"]."</u></font></a>]";
  	   }
  	   echo "&nbsp;&nbsp;";
 	 }
 	 echo "</p>";
 	if($dept_name==""){
 		echo "<br><br>";
 		Show_Message("对不起，您的访问被拒绝，请求助管理员解决问题。");
 		@include($baseDIR."/bysj/inc_foot.php");
 		exit;
 	}
 	$allleadnum = 0;
 ?>

<?php
if($_POST["submit"]){
	$tname = $_POST["tname"];
 	require $baseDIR."/bysj/global/pinyin.php";
 	$tname = str_replace(" ","",trim($tname));
 	$tid=Pinyin($tname,'gb2312','short'); //转换为拼音首字母
	preg_match_all('/[0-9]+/',$tid,$match);
	$num = $match[0][0];
	preg_match_all('/[^0-9]+/',$tid,$match);
	$tid = $match[0][0];
	$pregstr = "/([".chr(0xb0)."-".chr(0xf7)."][".chr(0xa1)."-".chr(0xfe)."])+/i";
	if(preg_match($pregstr,$tname,$matchArray))$tname = $matchArray[0];
	else {
 		echo "<br><br>";
 		Show_Message("对不起，教师姓名必须为中文。");
 		@include($baseDIR."/bysj/inc_foot.php");
 		exit;
 	}
	$sql = "select teacher_id,name from ".$TABLE."teacher_information where belong='".$set_dept_id."'";
	$que_sql = mysql_query($sql);
	$nums = array();
	while($fet_result = mysql_fetch_array($que_sql)){
		$str = $fet_result["teacher_id"];
		preg_match_all('/[0-9]+/',$str,$match);
		array_push($nums, $match[0][0] );
	}
	asort($nums);
	if(!$nums[0]) $nums[0] = 600;
	$numlist = array();
	if($num<100||$num>999) $num = $nums[0];
	for($cnt=0;$cnt<10;$num++){
		if(!in_array($num,$nums)){
			array_push($numlist, $num);
			$cnt ++;
		}
	}
	for($i=0;$i<$cnt;$i++){
		$newid = $tid.$numlist[$i];
		$sql = "select teacher_id from ".$TABLE."teacher_information where teacher_id='".$newid."'||teacher_alias='$newid'";
		$qsql = mysql_query($sql);
		if($qsql) $currrows=mysql_num_rows($qsql);
		else $currrows = 0;
		if($currrows < 1) break;
	}
	$newpass = makepassword();
	mysql_query("INSERT INTO ".$TABLE."teacher_information (`teacher_id`, `teacher_alias`, `name`, `password`, `open`, `authority`, `belong`) VALUES ('$newid', '$tname', '$tname', '$newpass', '1', '10', '$set_dept_id')");
	echo "已经在 <b>".$dept_name."</b> 添加新教师：".$tname."，登录信息如下，请通知该教师：<br>教师：".$tname."，帐号：".$newid."，密码：".$newpass."。登录网址：http://www.dianxinxi.cn/bysj。";
	
 }
?>

<script  type="text/javascript" src="teacher_ajax.js"></script>
<script>
function newpass(e, tid){
	var s = confirm("您确定需要重置该教师的登录密码吗？");
	if(!s) return false;
	rebuildpass('pass'+e, tid);
}
</script>
<form id="form1" name="form1" method="post" action="<?php echo $PHP_SELF; ?>">
 	 请输入新教师名字：
 	 <input type=text name=tname size=10 maxlength=10>
    <input type=hidden name=set_dept_id value=<?php echo $curr_dept_id; ?>>
    <input type=submit name=submit value="添加新教师帐号" /> （注意：只能添加，不能删除）
</form>

<table width="660" border="1" align="center"  cellpadding=5 bordercolor=#000000>
<tr  bgColor=#5a6e8f  height=38 align=center>
<td width="32"><font color=#FFFFFF><b>序号</b></font></td>
<td width="100"><font color=#FFFFFF><b>教师帐号</b></font></td>
<td width="100"><font color=#FFFFFF><b>教师姓名</b></font></td>
<td width="100"><font color=#FFFFFF><b>帐号密码</b></font></td>
<td><font color=#FFFFFF><b>权限设置</b></font></td>
<td><font color=#FFFFFF><b>签名信息</b></font></td>
</tr>
<?php
 $sql = "select teacher_id,name,password,authority,belong from ".$TABLE."teacher_information  where belong=$curr_dept_id order by authority desc,teacher_id";
 //echo $sql;
 $que_sql = mysql_query($sql);
 krsort($com_level);
 $tindex = 0;
 while($row = mysql_fetch_array($que_sql)){
?>
<tr align="center">
<td><?php echo $tindex+1; ?></td>
<td><?php echo "<input type=hidden name=tid".$tindex."[] value=".$row["teacher_id"].">".$row["teacher_id"];?></td>

<td><?php 
	echo $row["name"]; 
	echo "<span id=auth".$tindex.">";
	if($row["authority"]>20) echo "&nbsp;<font color=red>★</font>";
	else if($row["authority"]==20) echo "&nbsp;<font color=green>☆</font>";
	else ;
	echo "</span>";
	?></td>
<td>
<?php 
         echo "<span id=pass".$tindex.">";
	if($showpass=="yeah")echo $row["password"]; else echo "*****";
	echo "</span>";
	if($com_auth>$row["authority"]&&$com_pro==$row["belong"]||$com_auth>80)
		echo " <input type=button value=重置 onClick=\"newpass('".$tindex."','".$row["teacher_id"]."','teacher')\">";
	?></td>
<td>
	<?php
	echo "<select name=level".$tindex."[] size=1 onChange=change_auth('auth".$tindex."','".$row["teacher_id"]."',this.options[this.options.selectedIndex].value)>";
	reset($com_level);
	while(list($k,$v)=each($com_level)){
		if($k<10) continue;
		if($k==$row["authority"]) $s = " selected";
		else $s = "";
		if($k>=$com_auth&&$k!=$row["authority"]) continue;
		if($row["teacher_id"]==$teacher_id&&$k!=$row["authority"])break;
		while(strlen($v)<8) $v .= " ";
		$v = str_replace(" ","&nbsp;",$v);
		echo "<option ".$s." value=".$k.">".$v."</option>";
		if($row["authority"]>$com_auth)break;
	}
	echo "</select>";
?>
</td>
<td>
	<?php
	$imgname = "../filems/teacher/qm/".$row["teacher_id"].".png";	
  if(!file_exists($imgname)) echo "无签名";
  else echo "<img src=$imgname height=40>";
	?>
</td>
</tr>
<?php
   $tindex++;
}
?>
</table>

<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>