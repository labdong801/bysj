<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "器乐选修";
$YM_ZT2 = "查看器乐选修情况";
$YM_MK = "艺术系课程双向选择系统";
$YM_DH = 1; //需要导航条
$YM_QX = 1; //本页访问需要权限：普通学生
include($baseDIR."/bysj/inc_head.php");

 //设置所选年份
 $year = date("Y",mktime(0,0,0,date("m")-8,1,date("Y"))); //
 	/*
 	 * 本学期年份 （当前年份减8个月）
 	 * eg:
 	 * 现在是 2013年6月 ，属于2012学年第二个期。所以 $art_select_year = 2012
 	 * 现在是2013年9月，属于2013年第一学期。所以$art_select_year =2013
 	 * */
 

$number = $com_id;
 ?>
<script  type="text/javascript" src="upload_db.js"></script>
<style type="text/css">
<!--
.align_top{vertical-align:top}
.myDiv{
height:auto;
background-color:#ffffcc;
text-align:left;
}
.myDiv1 {height:auto;
background-color:#ffffcc;
text-align:left;
}
.STYLE2 {font-size: 16px}
.STYLE1 {	font-size: 36px;
	font-family: "黑体", "楷体_GB2312";
}
.STYLE5 {font-family: "黑体", "楷体_GB2312"}
-->
</style>
<script language="javascript">
//
//function submitTopic(num){
//	var count = num;
//	var theme = document.getElementsByName("topic_num");
//	var curr_topic_id;
//	var curr_topic_list = ','+form1.wish1.value+',,'+form1.wish2.value+',,'+form1.wish3.value+',';
//	var selectone = false;
//	for(var i = 0;i<theme.length;i++){
//		if(theme[i].checked){
//			var str = theme[i].value;
//                          if (curr_topic_list.indexOf(','+str+',')!=-1){
//                          	 alert('选择无效！您已经选过了该课题，请不要重复选择，谢谢。');
//                          	 return false;
//                          }
//			if(count==1){
//				form1.wish1.value = theme[i].value;
//			}
//			if(count==2){
//				form1.wish2.value = theme[i].value;
//			}
//			if(count==3){
//				form1.wish3.value = theme[i].value;
//			}
//			selectone = true;
//			break;
//		}
//	}
//	if(!selectone){
//		alert('【错误】您尚未选择某一课题。\r\n\r\n请在以下的候选课题中查阅您需要选择的课题，\r\n并选中该题后，再点击本按钮，谢谢。');
//		return false;
//	}
//	return true;
//}
///*显示和藏藏详细信息*/
//function change(num){
// div1 = document.getElementById(num);
// var hh = div1.style.display;
// if(hh=="") hh = "none";
// else hh = "";
// div1.style.display = hh;
//}
//
//function fill_search(){
//  var text = searches.finds.value;
//  if(text==""){
//    alert('请输入要查询的内容！');
//	return false;
//  }
//}
//function noinput(){
// alert("请先在下面选好题目，再点击确认选题按钮来提交题目");
//}
</script>

<?php
   $welcomestr = '&nbsp;&nbsp;&nbsp;欢迎'.$com_from.'<b>'.$com_name. '</b>同学使用艺术系双选系统'."<p>";

	//   $sql = "select is_select, topic as t_topic, ".$TABLE."title_sort.name as t_type,meaning,request,question,
	//                           ".$TABLE."teacher_information.name as t_name,
	//                           ".$TABLE."teacher_information.officephone,
	//                           ".$TABLE."teacher_information.techpos,
	//                           ".$TABLE."teacher_information.mobilephone,
	//                           ".$TABLE."teacher_information. short_number,
	//                           ".$TABLE."teacher_information.qq_number,
	//                           ".$TABLE."teacher_information.email
	//                  from ".$TABLE."topic,".$TABLE."teacher_information,".$TABLE."title_sort
	//                  where student_number = '$number'&&year='$YEAR_C'&&".$TABLE."teacher_information.teacher_id=".$TABLE."topic.teacher_id
	//                              &&".$TABLE."title_sort.id=".$TABLE."topic.type&&".$TABLE."topic.student_number=student_number&&".$TABLE."topic.verify>0&&is_select=1";
	//   $qur_sql = mysql_query($sql);
	//   $fet_result = mysql_fetch_array($qur_sql);
	//   if($fet_result["is_select"]==1) {
	//   	    ShowSelectedTopic($fet_result);
	//         @include($baseDIR."/bysj/inc_foot.php");
	//          exit;   //若课题已选中，则完成
	//   }
	//
	   $sql = "select topic_start,topic_end,student_start,student_end,teacher_start,teacher_end from ".$ART_TABLE."set_date where grade = '1'";
	   $qur_sql = mysql_query($sql);
	   $fet_result = mysql_fetch_array($qur_sql);
	   $now = time(0);
	   $can_select = true;
	
	   if($now>=$fet_result["student_start"]&&$now<=$fet_result["student_end"]){
	   	   $can_select = true;
	   } else if($now>=$fet_result["teacher_start"]&&$now<=$fet_result["teacher_end"]){
	   		$show_message = "目前处于教师选学生阶段，暂不能更改选题情况。";
//		   Show_Message("目前处于教师选学生阶段，暂不能查看选题情况。<br>
//		           该阶段将于 ".date("Y-m-d",$fet_result["teacher_end"])." 结束。<br>
//		           本次未被选中的学生将转入下一轮选择<br>请耐心等候，谢谢。");
		   $can_select = false;
	   } else {
//		   Show_Message("对不起，现在没有毕业设计选题任务。");
		   $show_message = "对不起，现在没有器乐选修任务。";
		   $can_select = false;
	   }
	   
	   //年级限制
	   if($grade != 1)
	   {
	   		$show_message = "";
			$can_select = false;
	   }

?>

<table width="838" align="center" border=0>
<tr class="align_top">
<td align="center">
<table width=838 border=0 align=left><tr valign=top><td width=730>

<form id="form1" name="form1" method="post" action="" class="saveHistory">
  <table width="730" border="0">
<?php
//这个有什么用的？？？？
   $randseed = ceil(time(0)/7200)+($number+0)%1000;   //按学生，每2个小时的随机种子不一样

echo "<tr><td colspan=2 align=left>$welcomestr</td><td rowspan=5 valign=top>";
	 $arr = mysql_query("SELECT * FROM ".$TABLE."title_sort where open = 1 LIMIT 0 , 30");
	 //echo "<table width=98% border=0 align=center>";
	 //echo "<tr><td bgColor=#5a6e8f  height=28 align=center><font color=#FFFFFF>按课题类型检索</font></td></tr>";
	 //while($array = mysql_fetch_array($arr)){
	 //  echo "<tr><td>&nbsp;&nbsp;→&nbsp;<a href=".$PHP_SELF."?fortype=".$array["id"].">".$array["name"]."</a></td></tr>";
	 // }
	 // echo "</table>";
echo "</td></tr>";

//$cc = mysql_query("select wish, name,topic,id,verify from ".$TABLE."student_select,".$TABLE."topic ,".$TABLE."teacher_information  where number = '$number' && id = topic_num && ".$TABLE."topic .teacher_id = ".$TABLE."teacher_information.teacher_id order by wish");
$sql= "SELECT * FROM `".$ART_TABLE."instrument_student_select` WHERE `student_number`='$com_online' ";
$query = mysql_query($sql);
$currrows = mysql_num_rows($query);
if($currrows == 0) //需要插入
{
	if($can_select)
	{ 
		$sql = "INSERT INTO  `".$ART_TABLE."instrument_student_select` (`id` ,`student_number`,`year` )VALUES (NULL ,  '".$com_online."','".$year."');";
		mysql_query($sql);
		$result[1] = 0;
		$result[2] = 0;
		$result[3] = 0;
		$finally   = 0;
	}
}
else
{
	$row=mysql_fetch_array($query);
	$result[1] = $row['first'];
	$result[2] = $row['second'];
	$result[3] = $row['third'];
	$finally   = $row['finally'];
	$finally_teacher = $row['teacher'];
}
$tmpi = 0;
$select_flag = false; //是否被选择了
//$wishn = mysql_fetch_array($cc);
for($tmpi=1;$tmpi<4;$tmpi++){
	//if($wishn["wish"]!=$tmpi) $dd = array();  //??????
	//else $dd = $wishn;
	  echo "<tr>";
	  //echo "<td><div style='width:100px;height:100px;background:#f0f; '>1</div></td>";
	  echo "<td align=right rowspan=2 width='130px'><div style='width:100px;height:100px;background:url(../images/instrument/nochose.png); '>";
	  if($result[$tmpi] > 0)
      {
      	echo "<img id='".$tmpi."' class='select' style='width:100px;height:100px;' src='..".getinstrument($result[$tmpi],"icon")."'/>";
      }
      else
      {
      	echo "<img id='".$tmpi."' class='select' style='width:100px;height:100px;display:none;'/>";
      }
	  echo "</div></td>";
      //echo "<td><input name=wish".$tmpi." type=hidden id=wish".$tmpi." value=".($dd["id"]>0?$dd["id"]:0).">";
      echo "<td width=550 align=left style='padding-left:20px;";
      if(($finally == $result[$tmpi] ) && ($finally > 0))
      {
      	echo "background:url(../images/instrument/finally.png) right top  no-repeat";
      }
      echo "'>";
      echo "<font color=blue>志愿".$tmpi."：</font>";
      echo "<span class='select".$tmpi."'>".getinstrument($result[$tmpi],"name")."</span>";
      //echo "<span id=here".$tmpi."><input  type=text size=60 readonly value=\"".$dd["topic"]."--".$dd["name"]."\" onMouseDown=\"noinput()\"> </span>";
      //echo "&nbsp;<input name=button".$tmpi." type=button value='确认选题' onMouseDown='submitTopic(".$tmpi.")' onClick=\"upload('here".$tmpi."',form1.wish".$tmpi.".value,'".$tmpi."')\">
	  echo "</td>";
      echo "</tr>";
      echo "<tr>";
      echo "<td style='padding-left:20px;";
      if(($finally == $result[$tmpi] ) && ($finally > 0))
      {
      	echo "background:url(../images/instrument/finally.png) right bottom  no-repeat";
      	$select_flag = true;
      }
      echo "'>";
      if($result[$tmpi] > 0)
      {
      	echo "<span class='select".$tmpi."'>".getinstrument($result[$tmpi],"detail")."</span>";
      }
      else
      {
      	echo "<span class='select".$tmpi."'>未选择</span>";
      }
      echo "</td>";
      echo "</tr>";
   if($wishn["wish"]==$tmpi) $wishn = mysql_fetch_array($cc);
}
//echo "<tr>  <td align=right><font color=blue>自选题：</font></td>  <td>";
//if($wishn["wish"]!="自选") {
//	echo "<a href=\"student_handon.php\">添加自选题</a> （仅供<b>学有余力</b>的同学提交高难度课题）";
//}else{
//	 $dd = $wishn;
//	  echo $dd["topic"]."&nbsp;--&nbsp;".$dd["name"];
//	  if($dd["verify"]==-1) echo "(<font color=red>选题无效，请另选课题</font>）";
//	  else if($dd["verify"]==0) echo "(<font color=green>待管理员审核，未送呈对应教师</font>）";
//	  else echo "(<font color=green>选题有效，与第一志愿等同候选</font>）";
//	  echo "	  &nbsp;<a href=\"student_handon.php?act=modify&id=".$dd["id"]."\">修改</a>";
//	  echo "  &nbsp;<a href=\"delete_handon.php?id=".$dd["id"]."\" onClick=\"return confirm('确定要删除吗？')\">删除</a>";
//}
//echo "</td></tr>";
?>

  </table>
</form>
<table width="730" border="0">


<?php
// $finds  = trim($finds);
//
////SELECT 0+mid(lead_num,instr(lead_num,',2-')+3,2) FROM `bysj_teacher_information` WHERE 1
//$hisleadnum = "(0+mid(lead_num,instr(lead_num,',".$com_pro_id."-')+".strlen(",".$com_pro_id."-").",2))";
//$canleadflag = "instr(lead_num,',".$com_pro_id."-')";

/*
 $wherestr = ", (
	SELECT teacher_id, sum(is_select) AS selectednum
	FROM ".$TABLE."topic
	WHERE year='$YEAR_C'&&student_pro_id='$com_pro_id'
	GROUP BY teacher_id
) AS selecttable
where ".$TABLE."teacher_information.teacher_id = selecttable.teacher_id && ".$hisleadnum." > selecttable.selectednum && ";
*/

// $wherestr = ", (
//	SELECT teacher_id, sum(student_pro_id ='$com_pro_id' and is_select='1') AS selectednum
//	FROM ".$TABLE."topic
//	WHERE year='$YEAR_C'
//	GROUP BY teacher_id
//) AS selecttable
//where ".$TABLE."teacher_information.teacher_id = selecttable.teacher_id && ".$hisleadnum." > selecttable.selectednum && ".$canleadflag." &&";
//
//
// $wherestr .= $TABLE."teacher_information.teacher_id = ".$TABLE."topic .teacher_id && ".$TABLE."title_sort.id = ".$TABLE."topic .type && student_number = '0'   && verify>0 &&".$TABLE."topic.year='$YEAR_C' && ".$TABLE."topic .profession REGEXP '^".$com_pro_id.",|,".$com_pro_id.",|,".$com_pro_id."$|^".$com_pro_id."$'";
// 						//所有查询的必须条件，未选定且经过审核的课题，且属于本专业的课题
// $orderbystr  = "rand($randseed)";										//缺省为随机显示符合条件记录
// if($forteacher!=""){
// 	 $wherestr .= " && ".$TABLE."topic .teacher_id = '$forteacher'";  			//查询指定老师
// 	 $orderbystr  = $TABLE."topic .type"; 									//指定教师，则没必要随机显示，直接按类别排序全部显示
// }
// if($fortype!=""){
// 	 $wherestr .= " && ".$TABLE."topic .type = '$fortype'";  							//查询指定类型，保持随机显示 30 条
//}
//if($finds!=""){
//	$wherestr .= " && ".$TABLE."topic .topic like '%".$finds."%'";				//按题目查询关键词，保持随机显示 30 条
//}
//$page += 0;
//if($page < 1) $page = 1;
//$pagenums = 10 ;
//$countsql = "select count(*) as cnt from ".$TABLE."topic ,".$TABLE."teacher_information,".$TABLE."title_sort $wherestr";
//$rs = mysql_query($countsql);
//$myrow = mysql_fetch_array($rs);
//$totalrows=$myrow["cnt"]; //获得符合条件的记录数
//$pages = ceil($totalrows/$pagenums);
//if($pages < 1) $pages = 1;
//if($page>$pages) $page = $pages; //如果超过范围，则显示最后一页
//$pagebegin = ($page - 1) * $pagenums;
//
//$sql = "select topic,".$TABLE."title_sort.name as titlename, ".$TABLE."topic .type as typeid, ".$TABLE."topic .id as topicid, ".$TABLE."teacher_information.teacher_id,".$TABLE."teacher_information.name as teachername, meaning, request, question from ".$TABLE."topic ,".$TABLE."teacher_information,".$TABLE."title_sort   $wherestr order by $orderbystr LIMIT $pagebegin, $pagenums";
////echo $sql;
//$search = mysql_query($sql);
//$currrows = 0;
//if($search) $currrows=mysql_num_rows($search);   //获得当前页记录数
//$urlall = "finds=$finds&forteacher=$forteacher&fortype=$fortype";
//$page0 = "首页";
//if($page>1) $page0 = "<a href=".$PHP_SELF."?".$urlall."&page=".(1)."><font color=blue><u>首页</u></font></a>";
//$pageN = "尾页";
//if($page<$pages) $pageN = "<a href=".$PHP_SELF."?".$urlall."&page=".($pages)."><font color=blue><u>尾页</u></font></a>";
//$pagelast = "上一页";
//if($page-1>0) $pagelast = "<a href=".$PHP_SELF."?".$urlall."&page=".($page-1)."><font color=blue><u>上一页</u></font></a>";
//$pagenext = "下一页";
//if($page < $pages) $pagenext = "<a href=".$PHP_SELF."?".$urlall."&page=".($page+1)."><font color=blue><u>下一页</u></font></a>";
// echo "<tr><td align=left>$page0 $pagelast $pagenext $pageN</td>
// <td align=right>第 $page 页，总 $pages 页 / $totalrows 条记录</td></tr>";


if($select_flag)
{
	ShowSelectedTopic($finally_teacher);
	@include($baseDIR."/bysj/inc_foot.php");
	exit;
}


 $sql = "SELECT * FROM  `".$ART_TABLE."major` WHERE `grade`='1' ";
 $search = mysql_query($sql);

 $currrows = mysql_num_rows($search);

 echo "<tr><td width=100% colspan=2 valign=top>

 <table width=95% border=1   cellpadding=5 bordercolor=#000000 style='margin-left:25px'>";

 echo "<tr align=center  bgColor=#5a6e8f  height=38 align=center>
 	<td width=100></td>
   <td><font color=#FFFFFF size=+1><b>器乐简介</b></font></td>
   <td width=180><font color=#FFFFFF><b>热度</b><br>第一志愿/第二志愿/第三志愿</font></td>
  <td width=80><font color=#FFFFFF><b>指导老师</b></font></td>
  </tr>";
if($currrows<=0)   {
    echo "<tr><td height=88 colspan=5 align=center>";
    if($finds!="") echo "<font color=red size=+1>抱歉，找不到含有 [".$finds."] 的毕业设计选题！</font><br>";
    if($forteacher!="") {
    	$tmps = mysql_query("select name from ".$TABLE."teacher_information where teacher_id = '".$forteacher."'");
    	$tmpa = mysql_fetch_array($tmps);
    	 echo "[<font color=blue>".$tmpa["name"]."</font>] 老师没有 <font color=green><b>".$com_pro."</b></font> 专业相关的选题！</font><br>";
    }
    echo "相关记录不存在！";
   echo "</td></tr>";
}

 echo "<form>";

   for($i=0;$i<$currrows; $i ++){
   	  $array = mysql_fetch_array($search);
   	  $instrument[$array['id']]["name"]= $array["name"];
   	  $instrument[$array['id']]["detail"] = $array["detail"];
	
	$sql = "SELECT * FROM `".$ART_TABLE."instrument_student_select` WHERE	`student_number` = '".$com_online."'  ";
	$year_query = mysql_query($sql);
	$year=mysql_fetch_array($year_query);
	$year = $year['year'];
	//echo $sql;
	$sql = "SELECT * FROM `".$ART_TABLE."instrument_student_select` WHERE first = '".$array['id']."' AND year = '".$year."' ";
	$hot_query=mysql_query($sql);
	$hot_first = mysql_num_rows($hot_query);
	$sql = "SELECT * FROM `".$ART_TABLE."instrument_student_select` WHERE second = '".$array['id']."' AND year = '".$year."' ";
	$hot_query=mysql_query($sql);
	$hot_second = mysql_num_rows($hot_query);
	$sql = "SELECT * FROM `".$ART_TABLE."instrument_student_select` WHERE third = '".$array['id']."' AND year = '".$year."' ";
	$hot_query=mysql_query($sql);
	$hot_third = mysql_num_rows($hot_query);
	
	//指导老师
	$sql = "SELECT *  FROM  `".$ART_TABLE."teacher_student`  " .
			"LEFT JOIN ".$TABLE."teacher_information ON ".$TABLE."teacher_information.teacher_id = ".$ART_TABLE."teacher_student.teacher_id " .
			"WHERE `major_id`='".$array['id']."'  AND `class` = '".$com_pro_id."' AND value > 0 ";
	$teacher_query = mysql_query($sql);
	$teacher= "";
	if(mysql_num_rows($teacher_query))
	{
		while($teacher_result =  mysql_fetch_array($teacher_query))
			//$teacher .="<p>".$teacher_result['name'] . "</p>";
			$teacher.="<p><a href='watch_teacher.php?teacher_id=".$teacher_result["teacher_id"]."' title='查看该教师的个人信息' >". $teacher_result["name"]."</a></p>";
	}
//	echo $sql;
	
	
?>
  <tr align="center">
  	<td rowspan=2><img id="<?php echo $array['id']; ?>" class="point" style="width:100px;height:100px" src="<?php echo "..".$array['icon'];?>" /></td>
	<td align="left" height="30px"><span id="name<?php echo $array['id']; ?>"><?php echo $array["name"]; ?></span></td>
    <td rowspan=2><?php echo hot($hot_first)."/".hot($hot_second)."/".hot($hot_third)."/"; ?></td>
	<td rowspan=2><?php echo $teacher;?></td>
  </tr>
  <tr>
  <td align="left"><span id="detail<?php echo $array['id']; ?>"><?php echo $array["detail"]; ?><span></td>
  </tr>

<?php
}
echo "</form>";
echo "</table>";
echo "</td></tr>";
// echo "<tr><td align=left>$page0 $pagelast $pagenext $pageN</td>
// <td align=right>第 $page 页，总 $pages 页 / 共 $totalrows 条记录</td></tr>";
?>
<tr><td colspan=2 align=left style='padding-left:20px;'><br><font color=red>友情提示：</font><font color=green>每种器乐所指导的学生人数有限，故不要选过于热门的器乐！<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</td></tr>
</table>

</td><td>
	<?php
//	 $sql = ("SELECT ".$TABLE."teacher_information.teacher_id, name, selecttable.selectednum as leadnum, ".$hisleadnum." as hisleadnum
//FROM ".$TABLE."teacher_information, (
//	SELECT teacher_id, sum(student_pro_id ='$com_pro_id' and is_select='1') AS selectednum
//	FROM ".$TABLE."topic
//	WHERE year='$YEAR_C'
//	GROUP BY teacher_id
//) AS selecttable
//where ".$TABLE."teacher_information.teacher_id = selecttable.teacher_id and ".$hisleadnum." > selecttable.selectednum and ".$canleadflag."
//ORDER BY rand($randseed)");
//      //echo $sql;
//      $arr = @mysql_query($sql);
//	 echo "<table width=108 border=0 align=center>";
//	 echo "<tr><td bgColor=#5a6e8f  height=28 align=center><font color=#FFFFFF>按教师检索课题</font></td></tr>";
//	 while($array = mysql_fetch_array($arr)){
//	 	 $canleadnum = $array["hisleadnum"]-$array["leadnum"];
//	   echo "<tr><td>&nbsp;&nbsp;→&nbsp;<a href=".$PHP_SELF."?forteacher=".$array["teacher_id"]." title='".$array["name"]."老师可指导本专业 $canleadnum 名学生'>".$array["name"]."(".$canleadnum.")</a></td></tr>";
//	  }
//	  echo "<tr><td><font color=#5a6e8f size=-1><b><u>括号为可指导数</u></b></font></td></tr>";
//	  echo "</table>";
	  ?>
</td>
</tr></table>


</td>
</tr>
<?php
if($debug=="yeah")
   echo "<tr><td colspan=2><br>".$sql."</td></tr>";
?>
</table>

<?php
 function dispEnter($str){
   $content = str_replace("\n","<br>",$str);
   return $content;
 }

function ShowSelectedTopic($id){
	global $TABLE;
	$sql = "SELECT * FROM `".$TABLE."teacher_information` WHERE teacher_id = '".$id."'";
	$query = mysql_query($sql);
	$row = mysql_fetch_array($query);;
?>
	<br>&nbsp;<br>&nbsp;&nbsp;&nbsp;&nbsp;
   恭喜您，<b><?php echo $row["name"];?></b> 老师已经同意指导您的器乐选修。以下是老师的联系方式。<br>&nbsp;<br>
   <table width=800 align=center border=1 bordercolor=1 cellpadding=6>
   <tr height=40>
   	   <td align=center bgColor=#5a6e8f><font color=#FFFFFF>指导教师</font></td><td><?php echo $row["name"];?></td>
   	   <td align=center bgColor=#5a6e8f><font color=#FFFFFF>手机号码</font></td><td><?php echo $row["mobilephone"];?></td>
   	   <td align=center bgColor=#5a6e8f><font color=#FFFFFF>移动短号</font></td><td><?php echo $row["short_number"];?></td>
    </tr>
    <tr height=40>
   	   <td align=center bgColor=#5a6e8f><font color=#FFFFFF>技术职称</font></td><td><?php echo $row["techpos"];?></td>
   	   <td align=center bgColor=#5a6e8f><font color=#FFFFFF>办公电话</td><td><?php echo $row["officephone"];?></td>
   	   <td align=center bgColor=#5a6e8f><font color=#FFFFFF>QQ号码</font></td><td><?php echo $row["qq_number"];?></td>
    </tr>
    <tr height=40>
   	   <td align=center bgColor=#5a6e8f><font color=#FFFFFF>电子邮箱</font></td><td colspan=5><?php echo $row["email"];?></td>
    </tr>
    </table>

 </table>
 </table>
    <br>&nbsp;<br>
   
<?php
}

function getinstrument($id,$type)
{
	if($id > 0)
	{
		global  $ART_TABLE;
		$sql="SELECT * FROM  `".$ART_TABLE."major` WHERE `grade`=1 && `id`=".$id;
		$query = mysql_query($sql);
		if(mysql_num_rows($query))
		{
			$row = mysql_fetch_array($query);
			return $row[$type];
		}
	}
}

function hot($v)
{
	if($v <= 0)
		return "<font color=blue>冷</font>";
	else if ($v <=30)
		return "<font color=orange>温</font>";
	else
		return "<font color=red >热</font>";
}
?>



<?
  @include($baseDIR."/bysj/inc_foot.php");
?>

<script language=JavaScript >
//alert();

<?php
	for($tmpi=1;$tmpi<4;$tmpi++)
		if($result[$tmpi] > 0)
			echo "var s".$tmpi."=".$result[$tmpi].";";
		else
			echo "var s".$tmpi."=0;";
?>


$(document).ready(function(){
	
<?php
if($can_select) 
{ 
?>

	$(".select").click(function(){
		if($(this).attr("id") == 1)
		{
			s1 = 0;
			$(".select1").html("");
			$.post("./ajax/update_grade1.php", { select: "first", value: "0" ,number:"<?php echo $com_online;?>"});
		}
		if($(this).attr("id") == 2)
		{
			s2 = 0;
			$(".select2").html("");
			$.post("./ajax/update_grade1.php", { select: "second", value: "0" ,number:"<?php echo $com_online;?>"});
		}
		if($(this).attr("id") == 3)
		{
			s3 = 0;
			$(".select3").html("");
			$.post("./ajax/update_grade1.php", { select: "third", value: "0" ,number:"<?php echo $com_online;?>" });
		}

		$(this).hide();


	});

	$(".point").click(function(){
		var temp;
		if(s1==0)
		{
			s1 = $(this).attr("id");
			if(s1 == s2 || s1 == s3)
			{
				alert("对不起，您已经选过这个乐器了！");
				s1 = 0;
			}
			else
			{
				temp = $("#name"+s1).html();
				$(".select1:first").html(temp);
				temp = $("#detail"+s1).html();
				$(".select1:last").html(temp);
				$("#1").show();
				temp = $(this).attr("src");
				$("#1").attr("src",temp);
				$.post("./ajax/update_grade1.php", { select: "first", value: s1 ,number:"<?php echo $com_online;?>"});
			}
		}
		else if(s2 == 0)
		{
			s2 = $(this).attr("id");
			if(s2 == s1 || s2 == s3)
			{
				alert("对不起，您已经选过这个乐器了！");
				s2 = 0;
			}
			else
			{
				temp = $("#name"+s2).html();
				$(".select2:first").html(temp);
				temp = $("#detail"+s2).html();
				$(".select2:last").html(temp);
				$("#2").show();
				temp = $(this).attr("src");
				$("#2").attr("src",temp);
				$.post("./ajax/update_grade1.php", { select: "second", value: s2 ,number:"<?php echo $com_online;?>"});
			}
		}
		else if(s3 == 0)
		{
			s3 = $(this).attr("id");
			if(s3 == s1 || s3 == s2)
			{
				alert("对不起，您已经选过这个乐器了！");
				s3 = 0;
			}
			else
			{
				temp = $("#name"+s3).html();
				$(".select3:first").html(temp);
				temp = $("#detail"+s3).html();
				$(".select3:last").html(temp);
				$("#3").show();
				temp = $(this).attr("src");
				$("#3").attr("src",temp);
				$.post("./ajax/update_grade1.php", { select: "third", value: s3 ,number:"<?php echo $com_online;?>"});
			}
		}
		else
		{
			alert("对不起，您最多只能选3个志愿！");
		}


	});
<?php
}
else if($show_message != "")
{
?>
	
	$(".select").click(function(){
		alert("<?php echo $show_message; ?>");
	});
	
	$(".point").click(function(){
		alert("<?php echo $show_message; ?>");
	});

	
		
<?php
}
?>
});
</script>

