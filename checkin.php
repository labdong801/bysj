<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "学生签到";
$YM_MK = "毕业设计管理系统";
$YM_DH = 0; //需要导航条
$YM_QX = 1; //本页访问需要权限：学生
include($baseDIR."/bysj/inc_head.php");

$number = $com_id;
?>

<?php
$sql = "select student.name,teacher.name as tname,student.tmptime as stmptime,teacher.teacher_id,teacher.mobilephone as phone,techpos  as zhicheng, topic,".$ART_TABLE."title_sort.name as ttype from ".$TABLE."student_sheet as student,".$TABLE."topic as topic ,".$ART_TABLE."title_sort,".$TABLE."teacher_information as teacher where number = '$number' && ".$ART_TABLE."title_sort.id = type && is_select=1 && number = student_number&&teacher.teacher_id=topic.teacher_id";
$sj_que = mysql_query($sql);
$sj_fet = mysql_fetch_array($sj_que);
if(!$sj_fet||$sj_fet["name"]==""){
	Show_Message("对不起，目前只对应届毕业生提供签到功能。");
	@include($baseDIR."/bysj/inc_foot.php");
	exit;
}
$teacher_id = $sj_fet["teacher_id"];


$sql = "select * from ".$TABLE."checkin where student_id = '$number' order by checktime desc";
$que = mysql_query($sql);
$res = @mysql_fetch_array($que);

echo "<br><br><font size=+2 face=黑体><b>毕业设计管理系统 学生签到</b></font><br><br>";

$now = time(0);
if($_POST["submit"]){
	if($res["checktime"]+180>$now){
		Show_Message("三分钟内不能重复签到哦！");
	} else {
		$mobile = $_POST["mobile"];
		$progress = $_POST["progress"];
		$work = $_POST["work"];
		$backtime = $_POST["backtime"];
		$city = $_POST["city"];
		$company = $_POST["company"];
		$memo = $_POST["memo"];
		$sql = "insert into ".$TABLE."checkin(checktime,student_id,teacher_id,work,city,company,mobile,backtime,progress,memo) values ('$now','$number','$teacher_id','$work','$city','$company','$mobile','$backtime','$progress','$memo')";
		$act = mysql_query($sql);
		if($act) Show_Message("您今日已经成功签到。记得每周来签到哦！");
		else Show_Message("签到失败，返回后再试一次吧！");
		@include($baseDIR."/bysj/inc_foot.php");
		exit;
	}
}
?>

<form id="checkinform" name="checkinform" method="post" action="">
<?php
if($res["checktime"]<1000) echo "您尚未在此签到，请现在就签到，谢谢！";
else {
	$cnt = (($now-$now%86400 - $res["checktime"]+$res["checktime"]%86400)/86400);
	if($cnt<0) echo "恭喜您穿越时空，您在未来某个时刻已经签过到了。根据时空管理局规定，您必须回到未来去签到！";
	else if($cnt==0) echo "您今天已经签过到了。如果状态有变化，记得过来签到哦，谢谢！";
	else if($cnt<10) echo "您已于 $cnt 天前签到，如果状态有变化，请签到，谢谢！";
	else echo "您已有 $cnt 天没有签到哦，请及时签到，以便指导教师知道您的当前情况，谢谢！";
}
?>
  <table width="700" height="206" border="1" cellpadding="8" cellspacing="0" bordercolor="#000000">
  	<tr>
  		<td width="700" colspan=2 bgColor=#5a6e8f align=middle>
  			<font color=#FFFFFF>签到说明：建议每周向指导教师签到，以便老师知道你的去向。<br>
  				特别是在电话号码、工作状态、所在地发生变化的情况下，请务必记得签到，谢谢。</font>
  		</td>
  	</tr>  	
    <tr>
      <td width="340">当前使用手机：
        <input name="mobile" type="text" id="mobile" value="<?php echo $res["mobile"];?>"/>
        <br />
        （务必更新为最新号码，以便必要时紧急联系你）      </td>
      <td width="360"><p>毕业设计进度：<br />
        <label>
        <input name="progress" type="radio" value="0" <?php echo $res["progress"]==""||$res["progress"]=="0"?" checked":"";?>/>
        未开始</label>
        <input type="radio" name="progress" value="1"  <?php echo $res["progress"]=="1"?" checked":"";?> />
        完成少量
        <input type="radio" name="progress" value="2" <?php echo $res["progress"]=="2"?" checked":"";?> />
        完成大部分
        <input type="radio" name="progress" value="3" <?php echo $res["progress"]=="3"?" checked":"";?> />
已完成 </p>      </td>
    </tr>
    <tr>
      <td><p>工作状态：<br />
          <input name="work" type="radio" value="0"  <?php echo $res["work"]==""||$res["work"]=="0"?" checked":"";?> />
        在校，未找工作<br />
        <input type="radio" name="work" value="2"<?php echo $res["work"]=="2"?" checked":"";?> />
在校，工作已确定，未签约<br />
      <input type="radio" name="work" value="3"<?php echo $res["work"]=="3"?" checked":"";?> />
在校，工作已确定并签约（或被录取研究生）<br />
      <input type="radio" name="work" value="4"<?php echo $res["work"]=="4"?" checked":"";?> />
工作中，已签约<br />
      <input type="radio" name="work" value="5"<?php echo $res["work"]=="5"?" checked":"";?> />
工作中，未签约<br />
      <input type="radio" name="work" value="1"<?php echo $res["work"]=="1"?" checked":"";?> /> 
      正在找工作<br />      
      </p>      </td>
      <td>何时回校：
        <br />
        <input name="backtime" type="radio" value="0"  <?php echo $res["backtime"]==""||$res["backtime"]=="0"?" checked":"";?> /> 
        已在校<br />
<input type="radio" name="backtime" value="1" <?php echo $res["backtime"]=="1"?" checked":"";?> />
一周内回校<br />
<input type="radio" name="backtime" value="2" <?php echo $res["backtime"]=="2"?" checked":"";?> />
两周内回校<br />
<input type="radio" name="rdlocation" value="3" <?php echo $res["backtime"]=="3"?" checked":"";?> />
一月内回校<br />
<input type="radio" name="backtime" value="4" <?php echo $res["backtime"]=="4"?" checked":"";?> />
回校时间未定<br />
<br />
当前所在地 ：
<input name="city" type="text" id="city" size="16" maxlength="30"  value="<?php echo $res["city"];?>" />（××省××市）
<br /></td>
    </tr>
<tr><td colspan=2>
工作（签约）单位名称、或被录取研究生学校名称：
<input name="company" type="text" id="city" size="40" maxlength="60"  value="<?php echo $res["company"];?>" />（全称）    
</td></tr>
<tr>
      <td colspan="2">需要向指导老师补充说明的话：
        <input name="memo" type="text" id="memo" size="50" maxlength="48"  value="<?php echo $res["memo"];?>" />
        （50字符以内）</td>
    </tr>
  </table>
  <br>
<?php
	if($res["checktime"]+180>$now)  echo "<input type=submit name=submit disabled onclick='return false' value='等三分钟后再签到'/>";
	else echo "<input type=submit name=submit onclick='return checkit()' value='现在就签到'/>";
?>
</form>

<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>
