<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "器乐选修";
$YM_ZT2 = "查看器乐选修情况";
$YM_MK = "器乐选修";
$YM_DH = 1; //需要导航条
$YM_QX = 1; //本页访问需要权限：普通学生
include($baseDIR."/bysj/inc_head.php");

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

<?php
   $welcomestr = '&nbsp;&nbsp;&nbsp;欢迎'.$com_from.'<b>'.$com_name. '</b>同学使用艺术系双选系统'."<p>";


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

echo "<tr><td colspan=2 align=left>&nbsp;&nbsp;&nbsp;<font size=+1><b>声乐教师选择：</b></font><br><br></td><td rowspan=5 valign=top>";
echo "</td></tr>";

//$cc = mysql_query("select wish, name,topic,id,verify from ".$TABLE."student_select,".$TABLE."topic ,".$TABLE."teacher_information  where number = '$number' && id = topic_num && ".$TABLE."topic .teacher_id = ".$TABLE."teacher_information.teacher_id order by wish");
$sql= "SELECT * FROM `".$ART_TABLE."vocalmusic_student_select` WHERE `student_number`='$com_online' ";
$query = mysql_query($sql);
$currrows = mysql_num_rows($query);
if($currrows == 0) //需要插入
{
	$sql = "INSERT INTO  `".$ART_TABLE."vocalmusic_student_select` (`id` ,`student_number` )VALUES (NULL ,  '".$com_online."');";
	mysql_query($sql);
	$vocalmusic_result[1] = 0;
	$vocalmusic_result[2] = 0;
	$vocalmusic_result[3] = 0;
	$vocalmusic_finally   = 0;
	$piano_result[1] = 0;
	$piano_result[2] = 0;
	$piano_result[3] = 0;
	$piano_finally   = 0;
}
else
{
	$row=mysql_fetch_array($query);
	$vocalmusic_result[1] = $row["vocalmusic_first"];
	$vocalmusic_result[2] = $row["vocalmusic_second"];
	$vocalmusic_result[3] = $row["vocalmusic_third"];
	$vocalmusic_finally   = $row["vocalmusic_finally"];
	$piano_result[1] = $row["piano_first"];
	$piano_result[2] = $row["piano_second"];
	$piano_result[3] = $row["piano_third"];
	$piano_finally   = $row["piano_finally"];
}
$tmpi = 0;
 echo "<tr>";
 echo "<td>&nbsp;&nbsp;&nbsp;";

 if($vocalmusic_finally) //已经有了选择
 {
 	$sql = "SELECT * FROM  `".$TABLE."teacher_information` WHERE `teacher_id` ='".$vocalmusic_finally."' ";
 	$tquery = mysql_query($sql);
 	if(mysql_num_rows($tquery))
 	{
 		$teacher = mysql_fetch_array($tquery);
 		echo ShowSelectedTopic($teacher,"声乐课程");
 	}
 }
 else
 {
	for($tmpi=1;$tmpi<4;$tmpi++){
	//if($wishn["wish"]!=$tmpi) $dd = array();  //??????
	//else $dd = $wishn;

	  echo "第".$tmpi."志愿：";
	  if($vocalmusic_result[$tmpi])
	  	echo "<a href='javascritp::void(0);'><font color=blue><u><span id='vocalmusic_unselect".$tmpi."' class='vocalmusic_select'>".getteachername($vocalmusic_result[$tmpi])."</span></u></font></a>";
	  else
	  	echo "<a href='javascritp::void(0);'><font color=blue><u><span id='vocalmusic_unselect".$tmpi."' class='vocalmusic_select'>未选择</span></u></font></a>";

	   echo "&nbsp;&nbsp;&nbsp;";
	}
	 echo "</td>";
	 echo "</tr>";
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

	 $sql = "SELECT * FROM  `".$ART_TABLE."vocalmusic` WHERE `vocalmusic` > 0 ";
	 $search = mysql_query($sql);

	 $currrows = mysql_num_rows($search);

	 echo "<tr><td width=100% colspan=2 valign=top>

	 <table width=100% border=1   cellpadding=5 bordercolor=#000000 style='margin-left:25px'>";

	 echo "<tr align=center  bgColor=#5a6e8f  height=38 align=center>
	 	<td width=100><font color=#FFFFFF><b>教师</b></font></td>
	   <td width=100><font color=#FFFFFF><b>职称</b></font></td>
	   <td><font color=#FFFFFF size=+1><b>教师简介</b></font></td>
	  <td width=80><font color=#FFFFFF><b></b></font></td>
	  </tr>";

	if($currrows<=0)   {
	    echo "<tr><td height=88 colspan=5 align=center>";
	    echo "相关记录不存在！";
	   echo "</td></tr>";
	}

	 echo "<form>";

	   for($i=0;$i<$currrows; $i ++){
	   	  $array = mysql_fetch_array($search);
		  $teacher_id = $array['teacher_id'];
		  $sql = "SELECT * FROM `".$TABLE."teacher_information` WHERE `teacher_id` = '".$teacher_id."'";

		  $query = mysql_query($sql);
		  $array2 = mysql_fetch_array($query);
	?>
	  <tr align="center">
	  	<td><a href='javascritp::void(0);'><font color=blue><u><span class='vocalmusic_unselect' id='<?php echo $array2["teacher_id"]; ?>'><?php echo $array2["name"]; ?></span></u></font></a></td>
		<td align="left" height="30px"><?php echo $array2["officepos"]; ?></td>
	    <td align="left" >
	    <?php
	    if($array2["educatelevel"])
	    	echo "<p>◆学历：".$array2["educatelevel"]."</p>";
	    if($array2["graduateschool"])
	    	echo "<p>◆毕业院校：".$array2["graduateschool"]."</p>";
	    if($array2["prise1"])
	    	echo "<p>◆".$array2["year1"]."，参加“".$array2["prise1"]."”获得.".$array2["level1"]."</p>";
	    if($array2["prise2"])
	    	echo "<p>◆".$array2["year2"]."，参加“".$array2["prise2"]."”获得.".$array2["level2"]."</p>";
	    if($array2["prise3"])
	    	echo "<p>◆".$array2["year3"]."，参加“".$array2["prise3"]."”获得.".$array2["level3"]."</p>";
	    ?>
	    </td>
		<td><a href="watch_teacher.php?teacher_id=<? echo $array["teacher_id"];?>" title="查看该教师的个人信息">查看</a></td>
	  </tr>

	<?php
	}
	echo "</form>";
	echo "</table>";
	echo "</td></tr>";
	// echo "<tr><td align=left>$page0 $pagelast $pagenext $pageN</td>
	// <td align=right>第 $page 页，总 $pages 页 / 共 $totalrows 条记录</td></tr>";
 }
?>

</table>
<br><br>
<!-- 钢琴 -->
<table width="838" align="center" border=0>
<tr class="align_top">
<td align="center">
<table width=838 border=0 align=left><tr valign=top><td width=730>

<form id="form1" name="form1" method="post" action="" class="saveHistory">
  <table width="730" border="0">
<?php

echo "<tr><td colspan=2 align=left>&nbsp;&nbsp;&nbsp;<font size=+1><b>钢琴教师选择：</b></font><br><br></td><td rowspan=5 valign=top>";
echo "</td></tr>";
$tmpi = 0;
 echo "<tr>";
 echo "<td colspan=2 align=left>&nbsp;&nbsp;&nbsp;";
 if($piano_finally) //已经有了选择
 {
 	$sql = "SELECT * FROM  `".$TABLE."teacher_information` WHERE `teacher_id` ='".$piano_finally."' ";
 	$tquery = mysql_query($sql);
 	if(mysql_num_rows($tquery))
 	{
 		$teacher = mysql_fetch_array($tquery);
 		echo ShowSelectedTopic($teacher,"钢琴课程");
 	}
 }
 else
 {
	for($tmpi=1;$tmpi<4;$tmpi++){
		//if($wishn["wish"]!=$tmpi) $dd = array();  //??????
		//else $dd = $wishn;

		  echo "第".$tmpi."志愿：";
		  if($piano_result[$tmpi])
		  	echo "<a href='javascritp::void(0);'><font color=blue><u><span class='piano_select' id='piano_unselect".$tmpi."'>".getteachername($piano_result[$tmpi])."</span></u></font></a>";
		  else
		  	echo "<a href='javascritp::void(0);'><font color=blue><u><span class='piano_select' id='piano_unselect".$tmpi."'>未选择</span></u></font></a>";

	   echo "&nbsp;&nbsp;&nbsp;";
	}
	 echo "</td>";
	 echo "</tr>";
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

	 $sql = "SELECT * FROM  `".$ART_TABLE."vocalmusic` WHERE `piano` > 0 ";
	 $search = mysql_query($sql);

	 $currrows = mysql_num_rows($search);

	 echo "<tr><td width=100% colspan=2 valign=top>

	 <table width=100% border=1   cellpadding=5 bordercolor=#000000 style='margin-left:25px'>";

	 echo "<tr align=center  bgColor=#5a6e8f  height=38 align=center>
	 	<td width=100><font color=#FFFFFF><b>教师</b></font></td>
	   <td width=100><font color=#FFFFFF><b>职称</b></font></td>
	   <td><font color=#FFFFFF size=+1><b>教师简介</b></font></td>
	  <td width=80><font color=#FFFFFF><b></b></font></td>
	  </tr>";
	if($currrows<=0)   {
	    echo "<tr><td height=88 colspan=5 align=center>";
	    echo "相关记录不存在！";
	   echo "</td></tr>";
	}

	 echo "<form>";

	   for($i=0;$i<$currrows; $i ++){
	   	  $array = mysql_fetch_array($search);
		  $teacher_id = $array['teacher_id'];
		  $sql = "SELECT * FROM `".$TABLE."teacher_information` WHERE `teacher_id` = '".$teacher_id."'";

		  $query = mysql_query($sql);
		  $array2 = mysql_fetch_array($query);
	?>
	  <tr align="center">
	  	<td><a href='javascritp::void(0);'><font color=blue><u><span class='piano_unselect'  id='<?php echo $array2["teacher_id"]; ?>'><?php echo $array2["name"]; ?></span></u></font></a></td>
		<td align="left" height="30px"><?php echo $array2["officepos"]; ?></td>
	    <td align="left" >
	    <?php
	    if($array2["educatelevel"])
	    	echo "<p>◆学历：".$array2["educatelevel"]."</p>";
	    if($array2["graduateschool"])
	    	echo "<p>◆毕业院校：".$array2["graduateschool"]."</p>";
	    if($array2["prise1"])
	    	echo "<p>◆".$array2["year1"]."，参加“".$array2["prise1"]."”获得.".$array2["level1"]."</p>";
	    if($array2["prise2"])
	    	echo "<p>◆".$array2["year2"]."，参加“".$array2["prise2"]."”获得.".$array2["level2"]."</p>";
	    if($array2["prise3"])
	    	echo "<p>◆".$array2["year3"]."，参加“".$array2["prise3"]."”获得.".$array2["level3"]."</p>";
	    ?>
	    </td>
		<td><a href="watch_teacher.php?teacher_id=<? echo $array["teacher_id"];?>" title="查看该教师的个人信息">查看</a></td>
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
 }
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

function ShowSelectedTopic($row,$class){
?>
   恭喜您，<b><?php echo $row["name"];?></b> 老师已经同意指导您的<?php echo $class; ?>。<br>&nbsp;<br>
   <table width=800 align=center border=1 bordercolor=1 cellpadding=6>
   <tr>
   	   <td align=center bgColor=#5a6e8f><font color=#FFFFFF>指导教师</font></td><td><?php echo $row["name"];?></td>
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
    <tr> <td height=38 align=left><b>注意事项：</b>
    <p>..</p>
    </td></tr>
    </table>
    <br>&nbsp;<br>
<?php
}

function getinstrument($id,$type)
{
	if($id > 0)
	{
		global  $ART_TABLE;
		$sql="SELECT * FROM  `".$ART_TABLE."instrument` WHERE `id`=".$id;
		$query = mysql_query($sql);
		if(mysql_num_rows($query))
		{
			$row = mysql_fetch_array($query);
			return $row[$type];
		}
	}
}


function getteachername($teacher_id)
{
	global $TABLE;
	$sql = "SELECT * FROM `".$TABLE."teacher_information` WHERE `teacher_id` = '".$teacher_id."'";
	$query = mysql_query($sql);
	if(mysql_num_rows($query))
	{
		$row = mysql_fetch_array($query);
		return $row["name"];
	}
}
?>



<?
  @include($baseDIR."/bysj/inc_foot.php");
?>

<script language=JavaScript >
//alert();

<?php
	for($tmpi=1;$tmpi<4;$tmpi++)
		if($vocalmusic_result[$tmpi])
			echo "var vs".$tmpi."= \"".$vocalmusic_result[$tmpi]."\";";
		else
			echo "var vs".$tmpi."=0;";

	for($tmpi=1;$tmpi<4;$tmpi++)
		if($piano_result[$tmpi])
			echo "var ps".$tmpi."=\"".$piano_result[$tmpi]."\";";
		else
			echo "var ps".$tmpi."=0;";
?>

$(document).ready(function(){

	$(".vocalmusic_select").click(function(){
		if($(this).attr("id") == 'vocalmusic_unselect1')
		{
			vs1 = 0;
			$(this).html("未选择");
			$.post("./ajax/update_grade2.php", { select: "vocalmusic_first", value: "0" ,number:"<?php echo $com_online;?>"});
		}
		if($(this).attr("id") == "vocalmusic_unselect2")
		{
			vs2 = 0;
			$(this).html("未选择");
			$.post("./ajax/update_grade2.php", { select: "vocalmusic_second", value: "0" ,number:"<?php echo $com_online;?>"});
		}
		if($(this).attr("id") == "vocalmusic_unselect3")
		{
			vs3 = 0;
			$(this).html("未选择");
			$.post("./ajax/update_grade2.php", { select: "vocalmusic_third", value: "0" ,number:"<?php echo $com_online;?>" });
		}




	});

	$(".piano_select").click(function(){
		if($(this).attr("id") == 'piano_unselect1')
		{
			ps1 = 0;
			$(this).html("未选择");
			$.post("./ajax/update_grade2.php", { select: "piano_first", value: "0" ,number:"<?php echo $com_online;?>"});
		}
		if($(this).attr("id") == "piano_unselect2")
		{
			ps2 = 0;
			$(this).html("未选择");
			$.post("./ajax/update_grade2.php", { select: "piano_second", value: "0" ,number:"<?php echo $com_online;?>"});
		}
		if($(this).attr("id") == "piano_unselect3")
		{
			ps3 = 0;
			$(this).html("未选择");
			$.post("./ajax/update_grade2.php", { select: "piano_third", value: "0" ,number:"<?php echo $com_online;?>" });
		}




	});

	$(".vocalmusic_unselect").click(function(){
		var temp;
		if(vs1==0)
		{
			vs1 = $(this).attr("id");
			if(vs1 == vs2 || vs1 == vs3)
			{
				alert("对不起，您已经选过这个志愿了！");
				vs1 = 0;
			}
			else
			{
				alert(vs1);
				alert(vs2);
				alert(vs3);
				temp = $(this).html();
				$("#vocalmusic_unselect1").html(temp);
				$.post("./ajax/update_grade2.php", { select: "vocalmusic_first", value: vs1 ,number:"<?php echo $com_online;?>"});
			}
		}
		else if(vs2==0)
		{
			vs2 = $(this).attr("id");
			if(vs2 == vs1 || vs2 == vs3)
			{
				alert("对不起，您已经选过这个志愿了！");
				vs2 = 0;
			}
			else
			{
				temp = $(this).html();
				$("#vocalmusic_unselect2").html(temp);
				$.post("./ajax/update_grade2.php", { select: "vocalmusic_second", value: vs2 ,number:"<?php echo $com_online;?>"});
			}
		}
		else if(vs3==0)
		{
			vs3 = $(this).attr("id");
			if(vs3 == vs1 || vs3 == vs2)
			{
				alert("对不起，您已经选过这个志愿了！");
				vs3 = 0;
			}
			else
			{
				temp = $(this).html();
				$("#vocalmusic_unselect3").html(temp);
				$.post("./ajax/update_grade2.php", { select: "vocalmusic_third", value: vs3 ,number:"<?php echo $com_online;?>"});
			}
		}
		else
		{
			alert("对不起，您最多只能选3个志愿！");
		}


	});


	$(".piano_unselect").click(function(){
		var temp;
		if(ps1==0)
		{
			ps1 = $(this).attr("id");
			if(ps1 == ps2 || ps1 == ps3)
			{
				alert("对不起，您已经选过这个志愿了！");
				ps1 = 0;
			}
			else
			{
				temp = $(this).html();
				$("#piano_unselect1").html(temp);
				$.post("./ajax/update_grade2.php", { select: "piano_first", value: ps1 ,number:"<?php echo $com_online;?>"});
			}
		}
		else if(ps2==0)
		{
			ps2 = $(this).attr("id");
			if(ps2 == ps1 || ps2 == ps3)
			{
				alert("对不起，您已经选过这个志愿了！");
				ps2 = 0;
			}
			else
			{
				temp = $(this).html();
				$("#piano_unselect2").html(temp);
				$.post("./ajax/update_grade2.php", { select: "piano_second", value: ps2 ,number:"<?php echo $com_online;?>"});
			}
		}
		else if(ps3==0)
		{
			ps3 = $(this).attr("id");
			if(ps3 == ps1 || ps3 == ps2)
			{
				alert("对不起，您已经选过这个志愿了！");
				ps3 = 0;
			}
			else
			{
				temp = $(this).html();
				$("#piano_unselect3").html(temp);
				$.post("./ajax/update_grade2.php", { select: "piano_third", value: ps3 ,number:"<?php echo $com_online;?>"});
			}
		}
		else
		{
			alert("对不起，您最多只能选3个志愿！");
		}


	});
});
</script>

