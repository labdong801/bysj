<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "查看毕设候选课题";
$YM_ZT2 = "查看选择毕业设计（论文）课题";
$YM_MK = "艺术系课程双向选择系统";
$YM_DH = 1; //需要导航条
$YM_QX = 1; //本页访问需要权限：普通学生
include($baseDIR."/bysj/inc_head.php");

$number = $com_id;
 ?>
 <!-- 
<script  type="text/javascript" src="upload_db.js"></script>改成jQuery了
-->
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
function submitTopic(num){
	var count = num;
	var theme = document.getElementsByName("topic_num"); 
	var curr_topic_id;
	var curr_topic_list = ','+form1.wish1.value+',,'+form1.wish2.value+',,'+form1.wish3.value+',';
	var selectone = false;
	for(var i = 0;i<theme.length;i++){
		if(theme[i].checked){
			var str = theme[i].value;
                          if (curr_topic_list.indexOf(','+str+',')!=-1){
                          	 alert('选择无效！您已经选过了该课题，请不要重复选择，谢谢。');
                          	 return false;
                          }
			if(count==1){
				form1.wish1.value = theme[i].value;
			}
			if(count==2){
				form1.wish2.value = theme[i].value;
			}
			if(count==3){
				form1.wish3.value = theme[i].value;
			}
			selectone = true;
			break;
		}
	}
	if(!selectone){
		alert('【错误】您尚未选择某一课题。\r\n\r\n请在以下的候选课题中查阅您需要选择的课题，\r\n并选中该题后，再点击本按钮，谢谢。');
		return false;
	}
	return true;
}
/*显示和藏藏详细信息*/
function change(num){
 div1 = document.getElementById(num);
 var hh = div1.style.display;
 if(hh=="") hh = "none";
 else hh = "";
 div1.style.display = hh;
}

function fill_search(){
  var text = searches.finds.value;
  if(text==""){
    alert('请输入要查询的内容！');
	return false;
  }
}
function noinput(){
 alert("请先在下面选好题目，再点击确认选题按钮来提交题目");
}

//jQuery重新寫Ajax

function upload(objID,v,w){
	$.get("upload_db.php", { topicid: v, wish: w },
  		function(data){
    	//alert("Data Loaded: " + data);
    	$("#"+objID).html(data);
  	});
}
</script>

<?php
   $welcomestr = '&nbsp;&nbsp;&nbsp;欢迎'.$com_from.'<b>'.$com_name. '</b>同学使用毕业选题系统'."<p>";

   $sql = "select is_select, topic as t_topic, ".$ART_TABLE."title_sort.name as t_type,meaning,request,question,
                           ".$TABLE."teacher_information.name as t_name, 
                           ".$TABLE."teacher_information.officephone,
                           ".$TABLE."teacher_information.techpos,
                           ".$TABLE."teacher_information.mobilephone,
                           ".$TABLE."teacher_information. short_number,
                           ".$TABLE."teacher_information.qq_number,
                           ".$TABLE."teacher_information.email
                  from ".$TABLE."topic,".$TABLE."teacher_information,".$ART_TABLE."title_sort 
                  where student_number = '$number'&&year='$YEAR_C'&&".$TABLE."teacher_information.teacher_id=".$TABLE."topic.teacher_id
                              &&".$ART_TABLE."title_sort.id=".$TABLE."topic.type&&".$TABLE."topic.student_number=student_number&&".$TABLE."topic.verify>0&&is_select=1"; 
   $qur_sql = mysql_query($sql);
   $fet_result = mysql_fetch_array($qur_sql);
   if($fet_result["is_select"]==1) {
   	    ShowSelectedTopic($fet_result);
         @include($baseDIR."/bysj/inc_foot.php");
          exit;   //若课题已选中，则完成
   }
  // 按新的时间设置方式
   $sql = "select topic_start,topic_end,student_start,student_end,teacher_start,teacher_end from ".$ART_TABLE."set_date where grade = '4'";
   
   $qur_sql = mysql_query($sql);
   $fet_result = mysql_fetch_array($qur_sql);
   $now = time(0);
   $can_select = true;
   
   
   //年级限制
   if($grade < 4)
	{
		Show_Message("专业方向选修只对大四学生开放。<br>
		           感谢期待毕业设计的同学们。");
		@include($baseDIR."/bysj/inc_foot.php");
		exit;   //不能选题，退出
	}
   
   if($now>=$fet_result["student_start"]&&$now<=$fet_result["student_end"]){
   	   $can_select = true;
   } else if($now>=$fet_result["topic_start"]&&$now<=$fet_result["topic_end"]){
	   Show_Message("目前处于教师提交选题阶段，暂不能查看选题情况。<br>
	           该阶段将于 ".date("Y-m-d",$fet_result["topic_end"])." 结束。<br>
	           请在此日期后再查看最新消息，谢谢。");
	   $can_select = false;
   } else if($now>=$fet_result["teacher_start"]&&$now<=$fet_result["teacher_end"]){
	   Show_Message("目前处于教师选学生阶段，暂不能查看选题情况。<br>
	           该阶段将于 ".date("Y-m-d",$fet_result["teacher_end"])." 结束。<br>
	           本次未被选中的学生将转入下一轮选择<br>请耐心等候，谢谢。");
	   $can_select = false;
   } else {
	   Show_Message("对不起，现在没有毕业设计选题任务。");
	   $can_select = false;
   }
   if(!$can_select){
         @include($baseDIR."/bysj/inc_foot.php");
          exit;   //不能选题，退出
  }
  
  
?>

<table width="838" align="center" border=0>
<tr class="align_top">
<td align="center">
<table width=838 border=0 align=left><tr valign=top><td width=730>
	
<form id="form1" name="form1" method="post" action="" class="saveHistory">
  <table width="730" border="0">
<?php
   $randseed = ceil(time(0)/7200)+($number+0)%1000;   //按学生，每2个小时的随机种子不一样

echo "<tr><td colspan=2 align=left>$welcomestr</td><td rowspan=5 valign=top>";
	 $arr = mysql_query("SELECT * FROM ".$ART_TABLE."title_sort where open = 1 LIMIT 0 , 30");
	 echo "<table width=98% border=0 align=center>";
	 echo "<tr><td bgColor=#5a6e8f  height=28 align=center><font color=#FFFFFF>按课题类型检索</font></td></tr>";
	 while($array = mysql_fetch_array($arr)){
	   echo "<tr><td>&nbsp;&nbsp;→&nbsp;<a href=".$PHP_SELF."?fortype=".$array["id"].">".$array["name"]."</a></td></tr>";
	  }	  
	  echo "</table>";
echo "</td></tr>";

$cc = mysql_query("select wish, name,topic,id,verify from ".$TABLE."student_select,".$TABLE."topic ,".$TABLE."teacher_information  where number = '$number' && id = topic_num && ".$TABLE."topic .teacher_id = ".$TABLE."teacher_information.teacher_id order by wish");
$tmpi = 0;
$wishn = mysql_fetch_array($cc);
for($tmpi=1;$tmpi<4;$tmpi++){
	if($wishn["wish"]!=$tmpi) $dd = array();
	else $dd = $wishn;
	    echo "<tr>
      <td align=right width=60><font color=blue>志愿".$tmpi."：</font></td>
      <td>
      <input name=wish".$tmpi." type=hidden id=wish".$tmpi." value=".($dd["id"]>0?$dd["id"]:0).">";
      echo "<span id=here".$tmpi."><input  type=text size=40 readonly value=\"".$dd["topic"]."--".$dd["name"]."\" onMouseDown=\"noinput()\"> </span>";
      echo "&nbsp;<input name=button".$tmpi." type=button value='确认选题' onMouseDown='submitTopic(".$tmpi.")' onClick=\"upload('here".$tmpi."',form1.wish".$tmpi.".value,'".$tmpi."')\">
	      </td>
    </tr>";
   if($wishn["wish"]==$tmpi) $wishn = mysql_fetch_array($cc);
}
echo "<tr>  <td align=right><font color=blue>自选题：</font></td>  <td>";
if($wishn["wish"]!="自选") {
	echo "<a href=\"student_handon.php\">添加自选题</a> （仅供<b>学有余力</b>的同学提交高难度课题）";
}else{
	 $dd = $wishn;
	  echo $dd["topic"]."&nbsp;--&nbsp;".$dd["name"];
	  if($dd["verify"]==-1) echo "(<font color=red>选题无效，请另选课题</font>）";
	  else if($dd["verify"]==0) echo "(<font color=green>待管理员审核，未送呈对应教师</font>）";
	  else echo "(<font color=green>选题有效，与第一志愿等同候选</font>）";
	  echo "	  &nbsp;<a href=\"student_handon.php?act=modify&id=".$dd["id"]."\">修改</a>";
	  echo "  &nbsp;<a href=\"delete_handon.php?id=".$dd["id"]."\" onClick=\"return confirm('确定要删除吗？')\">删除</a>";
}
echo "</td></tr>";
?>

  </table>
</form>
<table width="730" border="0">
	<tr>
  	<form name="searches" action="" method="post">
		<td align=center colspan=2 height=38>按课题名称来查询，请输入关键字：
     <input type="text" name="finds" value="<?php echo $finds; ?>"'/>
     <input type=hidden name=forteacher>
     <input type=hidden name=fortype>
     <input type="submit" name="gosearch" value="查询" onClick="return fill_search()"/>
     </td>
     </form>
   </tr>
     

<?php
 $finds  = trim($finds);
 
//SELECT 0+mid(lead_num,instr(lead_num,',2-')+3,2) FROM `bysj_teacher_information` WHERE 1 
$hisleadnum = "(0+mid(lead_num,instr(lead_num,',".$com_pro_id."-')+".strlen(",".$com_pro_id."-").",2))";
$canleadflag = "instr(lead_num,',".$com_pro_id."-')";

/*
 $wherestr = ", (
	SELECT teacher_id, sum(is_select) AS selectednum
	FROM ".$TABLE."topic 
	WHERE year='$YEAR_C'&&student_pro_id='$com_pro_id'
	GROUP BY teacher_id
) AS selecttable 
where ".$TABLE."teacher_information.teacher_id = selecttable.teacher_id && ".$hisleadnum." > selecttable.selectednum && ";
*/

 $wherestr = ", (
	SELECT teacher_id, sum(student_pro_id ='$com_pro_id' and is_select='1') AS selectednum
	FROM ".$TABLE."topic 
	WHERE year='$YEAR_C'
	GROUP BY teacher_id
) AS selecttable 
where ".$TABLE."teacher_information.teacher_id = selecttable.teacher_id && ".$hisleadnum." > selecttable.selectednum && ".$canleadflag." &&";


 $wherestr .= $TABLE."teacher_information.teacher_id = ".$TABLE."topic .teacher_id && ".$ART_TABLE."title_sort.id = ".$TABLE."topic .type && student_number = '0'   && verify>0 &&".$TABLE."topic.year='$YEAR_C' && ".$TABLE."topic .profession REGEXP '^".$com_pro_id.",|,".$com_pro_id.",|,".$com_pro_id."$|^".$com_pro_id."$'";
 						//所有查询的必须条件，未选定且经过审核的课题，且属于本专业的课题
 $orderbystr  = "rand($randseed)";										//缺省为随机显示符合条件记录
 if($forteacher!=""){
 	 $wherestr .= " && ".$TABLE."topic .teacher_id = '$forteacher'";  			//查询指定老师
 	 $orderbystr  = $TABLE."topic .type"; 									//指定教师，则没必要随机显示，直接按类别排序全部显示
 }
 if($fortype!=""){
 	 $wherestr .= " && ".$TABLE."topic .type = '$fortype'";  							//查询指定类型，保持随机显示 30 条
}
if($finds!=""){
	$wherestr .= " && ".$TABLE."topic .topic like '%".$finds."%'";				//按题目查询关键词，保持随机显示 30 条
}
$page += 0;
if($page < 1) $page = 1;
$pagenums = 10 ;
$countsql = "select count(*) as cnt from ".$TABLE."topic ,".$TABLE."teacher_information,".$ART_TABLE."title_sort $wherestr";
$rs = mysql_query($countsql);
$myrow = mysql_fetch_array($rs);
$totalrows=$myrow["cnt"]; //获得符合条件的记录数
$pages = ceil($totalrows/$pagenums);
if($pages < 1) $pages = 1;
if($page>$pages) $page = $pages; //如果超过范围，则显示最后一页
$pagebegin = ($page - 1) * $pagenums;

$sql = "select topic,".$ART_TABLE."title_sort.name as titlename, ".$TABLE."topic .type as typeid, ".$TABLE."topic .id as topicid, ".$TABLE."teacher_information.teacher_id,".$TABLE."teacher_information.name as teachername, meaning, request, question from ".$TABLE."topic ,".$TABLE."teacher_information,".$ART_TABLE."title_sort   $wherestr order by $orderbystr LIMIT $pagebegin, $pagenums";
//echo $sql;
$search = mysql_query($sql);
$currrows = 0;
if($search) $currrows=mysql_num_rows($search);   //获得当前页记录数
$urlall = "finds=$finds&forteacher=$forteacher&fortype=$fortype";
$page0 = "首页";
if($page>1) $page0 = "<a href=".$PHP_SELF."?".$urlall."&page=".(1)."><font color=blue><u>首页</u></font></a>";
$pageN = "尾页";
if($page<$pages) $pageN = "<a href=".$PHP_SELF."?".$urlall."&page=".($pages)."><font color=blue><u>尾页</u></font></a>";
$pagelast = "上一页";
if($page-1>0) $pagelast = "<a href=".$PHP_SELF."?".$urlall."&page=".($page-1)."><font color=blue><u>上一页</u></font></a>";
$pagenext = "下一页";
if($page < $pages) $pagenext = "<a href=".$PHP_SELF."?".$urlall."&page=".($page+1)."><font color=blue><u>下一页</u></font></a>";
 echo "<tr><td align=left>$page0 $pagelast $pagenext $pageN</td>
 <td align=right>第 $page 页，总 $pages 页 / $totalrows 条记录</td></tr>";
 
 echo "<tr><td width=100% colspan=2 valign=top>
 
 <table width=100% border=1   cellpadding=5 bordercolor=#000000>";

 echo "<tr align=center  bgColor=#5a6e8f  height=38 align=center>
   <td><font color=#FFFFFF size=+1><b>毕业设计候选课题 题目</b></font></td>
   <td width=38><font color=#FFFFFF><b>热度</b></font></td>
  <td width=80><font color=#FFFFFF><b>设计类别</b></font></td>
  <td width=80><font color=#FFFFFF><b>指导老师</b></font></td>
  <td width=88><font color=#FFFFFF><b>课题信息</b></font></td>
  </tr>";
if($currrows<=0)   {
    echo "<tr><td height=88 colspan=5 align=center>";
    if($finds!="") echo "<font color=red size=+1>抱歉，找不到含有 [".$finds."] 的毕业设计选题！</font><br>";
    if($forteacher!="") {
    	$tmps = mysql_query("select name from ".$TABLE."teacher_information where teacher_id = '".$forteacher."'");
    	$tmpa = mysql_fetch_array($tmps);
    	 echo "[<font color=blue>".$tmpa["name"]."</font>] 老师没有 <font color=green><b>".$com_pro."</b></font> 专业相关的选题！</font><br>";
    }
    echo "您选择的类型或相关记录不存在，请选择其他毕业设计课题！";
   echo "</td></tr>";
}
 
 echo "<form>";
 
   for($i=0;$i<$currrows; $i ++){
   	  $array = mysql_fetch_array($search)

?>
  <tr align="center">
	<td align="left"><input type="radio" name="topic_num" value="<?php echo $array["topicid"];?>" />
        <?php
        echo $array["topic"];
        ?>
        </td>
        <td>
        <?php
        $numsql = "select count(*) as topicnum from ".$TABLE."student_select where topic_num=".$array["topicid"]."&&wish=1&&pro_id=$com_pro_id";
        $numquery = mysql_query($numsql);
        $tmparr = mysql_fetch_array($numquery);
        $cnt= $tmparr["topicnum"];
        if($cnt==0) $cstr = "<font color=green>冷</font>";
        else if($cnt<3) $cstr = "<font color=blue>温</font>";
        else if($cnt<6) $cstr = "<font color=red>热</font>";
        else $cstr = "<font color=red><b>烫</b></font>";
        echo $cstr;
        echo "/";
        $numsql = "select count(*) as topicnum from ".$TABLE."student_select where topic_num=".$array["topicid"]."&&wish=1";
        $numquery = mysql_query($numsql);
        $tmparr = mysql_fetch_array($numquery);
        $cnt= $tmparr["topicnum"];
        if($cnt==0) $cstr = "<font color=green>冷</font>";
        else if($cnt<3) $cstr = "<font color=blue>温</font>";
        else if($cnt<6) $cstr = "<font color=red>热</font>";
        else $cstr = "<font color=red><b>烫</b></font>";
        echo $cstr;
        ?></td>
	<td><?php 
	           echo "<a href=".$PHP_SELF."?fortype=".$array["typeid"].">".$array["titlename"]."</a>";?>
	</td>   
	<td><a href="watch_teacher.php?teacher_id=<? echo $array["teacher_id"];?>" title="查看该教师的个人信息"><?php echo $array["teachername"];?></a></td>
	<td><input type="button" name="button"  value="详细信息" onClick="change('<? echo $array["topicid"];?>')"/>
	  </td>
  </tr>
  <tr>
  <td colspan="5" width=100%><div id = "<? echo $array["topicid"];?>" class="myDiv" style="display: none;">
<? 
echo "<strong>意义：</strong><br>".dispEnter($array["meaning"]). "<hr><strong>要求：</strong><br>".dispEnter($array["request"])."<hr><strong>问题：</strong><br>".dispEnter($array["question"]);?></div>
  </td>
  </tr>
<?php
}
echo "</form>";
echo "</table>";
echo "</td></tr>";
 echo "<tr><td align=left>$page0 $pagelast $pagenext $pageN</td>
 <td align=right>第 $page 页，总 $pages 页 / 共 $totalrows 条记录</td></tr>";
?>
<tr><td colspan=2 align=left><font color=red>友情提示：</font><font color=green>一个选题最终只能选中一个学生，故不要选过于热门的选题！（<b>本专业热度 / 所有专业热度</b>）<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<font color=green>冷：0人；</font><font color=blue>温：1-2人；</font><font color=red>热：3-5人；</font><font color=red><b>烫：更多；</b></font>忌选<font color=red>热</font>、<font color=red><b>烫</b></font>选题。</font></td></tr>
</table>

</td><td>
	<?php
	 $sql = ("SELECT ".$TABLE."teacher_information.teacher_id, name, selecttable.selectednum as leadnum, ".$hisleadnum." as hisleadnum
FROM ".$TABLE."teacher_information, (
	SELECT teacher_id, sum(student_pro_id ='$com_pro_id' and is_select='1') AS selectednum
	FROM ".$TABLE."topic 
	WHERE year='$YEAR_C'
	GROUP BY teacher_id
) AS selecttable 
where ".$TABLE."teacher_information.teacher_id = selecttable.teacher_id and ".$hisleadnum." > selecttable.selectednum and ".$canleadflag."
ORDER BY rand($randseed)");
      //echo $sql;
      $arr = @mysql_query($sql);
	 echo "<table width=108 border=0 align=center>";
	 echo "<tr><td bgColor=#5a6e8f  height=28 align=center><font color=#FFFFFF>按教师检索课题</font></td></tr>";
	 while($array = mysql_fetch_array($arr)){
	 	 $canleadnum = $array["hisleadnum"]-$array["leadnum"];
	   echo "<tr><td>&nbsp;&nbsp;→&nbsp;<a href=".$PHP_SELF."?forteacher=".$array["teacher_id"]." title='".$array["name"]."老师可指导本专业 $canleadnum 名学生'>".$array["name"]."(".$canleadnum.")</a></td></tr>";
	  }
	  echo "<tr><td><font color=#5a6e8f size=-1><b><u>括号为可指导数</u></b></font></td></tr>";
	  echo "</table>";
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

function ShowSelectedTopic($row){
?>
   恭喜您，<b><?php echo $row["t_name"];?></b> 老师已经同意指导您的毕业设计。请联系老师落实毕业设计。<br>&nbsp;<br>
   <table width=800 align=center border=1 bordercolor=1 cellpadding=6>
   <tr>
   	   <td align=center bgColor=#5a6e8f><font color=#FFFFFF>指导教师</font></td><td><?php echo $row["t_name"];?></td>
   	   <td align=center bgColor=#5a6e8f><font color=#FFFFFF>手机号码</font></td><td><?php echo $row["mobilephone"];?></td>
   	   <td align=center bgColor=#5a6e8f><font color=#FFFFFF>移动短号</font></td><td><?php echo $row["short_number"];?></td>
    </tr>
    <tr>
   	   <td align=center bgColor=#5a6e8f><font color=#FFFFFF>技术职称</font></td><td><?php echo $row["techpos"];?></td>
   	   <td align=center bgColor=#5a6e8f><font color=#FFFFFF>办公电话</td><td><?php echo $row["officephone"];?></td>
   	   <td align=center bgColor=#5a6e8f><font color=#FFFFFF>QQ号码</font></td><td><?php echo $row["qq_number"];?></td>
    </tr>
    <tr>
   	   <td align=center bgColor=#5a6e8f><font color=#FFFFFF>电子邮箱</font></td><td colspan=5><?php echo $row["email"];?></td>
    </tr>
    </table>
   <br>&nbsp;<br>
   <table width=800 align=center border=1 bordercolor=1 cellpadding=6>
   <tr> <td width=130 height=38 align=right><b>毕业设计题目：</b></td> <td width=680><? echo $row["t_topic"];?>
   	         &nbsp;&nbsp;&nbsp;&nbsp;<b>课题类型：</b><? echo $row["t_type"];?></td></tr>
   <tr> <td width=130 height=88 align=right><b>本设计课题意义：</b></td> <td width=680><? echo dispEnter($row["meaning"]);?></td></tr>
   <tr> <td width=130 height=88  align=right><b>对课题的要求：</b></td> <td width=680><? echo dispEnter($row["request"]);?></td></tr>
   <tr> <td width=130 height=68 align=right><b>本课题重点要解决的问题：</b></td> <td width=680><? echo dispEnter($row["question"]);?></td></tr>
    </table>
    <br>&nbsp;<br>
<?php
}
?>
<?
  @include($baseDIR."/bysj/inc_foot.php");
?>
