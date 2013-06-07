<?php
if($HTTP_HOST=="dianxinxi.cn"||$HTTP_HOST=="210.38.241.2"){
         echo "<META HTTP-EQUIV=REFRESH CONTENT='3;URL=http://www.dianxinxi.cn/bysj'>";
         echo "<br><br><br>";
	echo "<table width=430 align=center border=0 bordercolor=#000000>";
	//echo "<tr align=center><td height=38 bgcolor=#3A4E6F><font color=#FFFFFF  style='FONT: 22px arial, sans-serif bold; HEIGHT: 30px;'><b>提示信息</b></font></td></tr>";
	echo "<tr align=center><td height=138><font style='FONT: 22px arial, sans-serif bold; HEIGHT: 30px;'><br>&nbsp;&nbsp;电信系毕业设计网址<br><a href=http://www.dianxinxi.cn/bysj>http://www.dianxinxi.cn/bysj</a></font>
	        <br><br>
	        <span align=center><input type=button  style='FONT: 22px arial, sans-serif bold; HEIGHT: 30px;' name=back value=立即访问 onclick='location.href=\"http://www.dianxinxi.cn/bysj\"'/></span><br>&nbsp;</td></tr>";
	echo "</table>";
         exit;
}

$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);

$YM_ZT = "艺术系课程双向选择系统登录";
$YM_MK = "艺术系课程双向选择系统";
$YM_DH = 0; //不需要导航条
$YM_QX = 0; //本页访问需要权限

//处理post的相关函数在 inc_head.php 这个文件里面
include($baseDIR."/bysj/inc_head.php");

 ?>
 <!-- 账号检测相关的js脚本[] -->
<script language="javascript">
function isStudent()
{
var patrn=/^[0-9]{1,3}/;
var s = myform.hisid.value;
if (!patrn.exec(s)) myform.histype[0].checked = true;
else myform.histype[1].checked = true;
}

function checkform(){
  if(myform.hisid.value==""){
    alert("请填写您的账号！");
	myform.hisid.focus();
	return false;
  }
  if(myform.hispass.value==""){
    alert("请填写您的密码！");
	myform.hispass.focus();
	return false;
  }
}
</script>

<br>&nbsp;<br>
 <table width="900" height="200" border="0" cellpadding=8 align="center">
  <tr>
    <td>
<?php
/*
    <p><b>电信07、电子07毕业设计答辩日程：[<font color=red>2011年5月25日</font>]</b></p>
    <p><font color=green><u>6月09日</u></font>   确定选题，根据课题方向对教师、学生分组；学生<b><font color=blue>申请论文送评</font></b></p>
    <p><font color=green><u>6月10日</u></font>   各答辩小组通过系统安排评阅教师</p>
    <p><font color=green><u>6月11日</u></font>  学生提交最新论文到<b><font color=blue>论文（初稿）</font></b>栏目中</p>
    <p><font color=green><u>6月11日～12日</u></font>  指导教师对论文进行评价，考核评分（需学生提交评审申请）</p>
  <p><font color=green><u>6月13日～14日</u></font> <font color=red><b>送评论文锁定</b></font>，评阅教师评阅论文、评分（需指导教师先评分）</p>
    <p><font color=green><u>6月15日～17日</u></font> 答辩小组按照本组的具体情况落实答辩地点及时间，安排小组答辩</p>
	  <p><font color=green><u>6月20日</u></font>   各小组答辩成绩大于90的同学，参加公开答辩</p>
*/
?>
	<!-- 登陆说明[登陆框左侧的说明文字] -->
    <p><b>系统使用说明：</b></p>
    <p>I、学生登录帐号为学号，原始密码为123456。</p>
    <p>II、每位学生只能够报当前年级的课程。但能够查到以前选修过的课程。</p>
    <p>III、学生选课后，由老师决定选择学生。</p>
    <p>IV、学生报志愿后，如三个志愿都未能被教师选上，则由管理员调整。</p>
    <p>V、学生和教师的选择过程只能在规定的时间内完成，请注意时间的安排。</p>
	  <p>VI、为了保障您的信息的安全，每次操作完该系统后，请选择安全退出。</p>
	</td>
	<td valign=top align=right>
	<?php
	   /*如果已经登陆，显示登陆后的菜单，否则显示登陆框*/
	   if($com_online) show_menu();
	   else show_login();
	?>
	</td>
  </tr>
</table>
<?php
function show_login(){
	global $referer;
	global $err_show, $err_msg;
	?>
        <form name="myform" method="post" action="<?php echo $PHP_SELF; //这里应该是Bug，这样写应该是无效的?>" onSubmit="return checkform();">
          <table width="320" border="0" align="right" cellpadding=4>
            <tr align="center">
        	  <td colspan="2" height=38><font color=red><b><?php echo $err_show?$err_msg:""; ?></b></font></font></td>
        	</tr>
        	<tr>
              <td height=38 align=right><font size=+1><b>帐号：</b></font></td>
              <td><input name="hisid" type="text" size="15" maxlength="15" onChange=isStudent()  style="FONT: 20px arial, sans-serif bold; HEIGHT: 30px;"/></td>
            </tr>
            <tr>
              <td align=right><font size=+1><b>密码：</b></font></td>
              <td><input name="hispass" type="password" size="15"  maxlength="20" style="FONT: 20px arial, sans-serif bold; HEIGHT: 30px;"/></td>
            </tr>
            <tr>
              <td height=38>&nbsp;</td>
              <td>
              	<input name="histype" type="radio" value="teacher" checked style="border:0; HEIGHT: 30px;"/><font size=+1><b>教师</b></font>
              	&nbsp;&nbsp;&nbsp;&nbsp;
              	<input name="histype" type="radio" value="student" style="border:0; HEIGHT: 30px;"/><font size=+1><b>学生</b></font>
              	</td>
            </tr>            <tr>
              <td colspan="2" height=38>
        	    <div align="center">
        	    	  <input type=hidden name=referer value="<?php echo $referer; ?>">
        	      <input type="submit" name="submit" value="登录系统" style="BACKGROUND-COLOR: #333D66; COLOR: #ffffff; HEIGHT: 36px; FONT-SIZE: 16px"/>
        	    </div></td>
            </tr>
          </table>
        </form>
	<?php
}   //function show_login();

function show_menu(){
	 global $com_name;
	 global $com_type;
	 global $com_id;
	 global $com_from;
	 global $com_auth;
	 global $com_pro;
	 global $com_pro_id;
	 global $com_pro_num;
	 global $com_level;

          if($com_type=="student") {
               $cylj = array(
                     "查看选题"=>"/bysj/student/selecttitle.php",
                     "意见建议"=>"/bysj/student/suggestion.php",
                     "联系方式"=>"/bysj/student/student_contact.php",
                     "修改密码"=>"/bysj/change_password.php",
                     );
            }else if($com_auth>=90){  //管理员
            	$cylj = array(
                     "文档系统"=>"#",
                     "时间设置"=>"/bysj/teacher/art_grade1_set_date.php",
                     "选课一览"=>"/bysj/teacher/art_admin_chose_grade1.php",
                     "审核题目"=>"/bysj/teacher/all_information.php",
                     "个人信息"=>"/bysj/teacher/teacher_information.php",
                     "联系方式"=>"/bysj/teacher/teacher_contact.php",
                     );
            }
            else{ 
               $cylj = array(
                     "文档系统"=>"#",
                     "学生一览"=>"/bysj/teacher/watch_my_student_all.php",
                     "个人信息"=>"/bysj/teacher/teacher_information.php",
                     "联系方式"=>"/bysj/teacher/teacher_contact.php",
                     );
            }
            
            
            if($com_type=="student")
            { 
            ?>
            <table width="200" border="0" align="center">
	            <tr align="center">
	        	  <td colspan="2" height=38><strong>您已经登录</strong></td>
	        	</tr>
	        	<tr><td align=right>姓名：</td> <td><?php echo $com_name; ?></td></tr>
	        	<tr><td align=right>单位：</td> <td><?php echo $com_from; ?></td></tr>
	        	<tr><td align=right>权限：</td> <td><?php echo $com_level[$com_auth]; ?></td></tr>
	            <tr><td height=20>&nbsp;</td><td>&nbsp;</td></tr>
	          </table>
	          
          
        	
        	<table width="200" border="0" align="center">
        	<?php
            
	            $i = 0;
	            while(list($k,$v) = @each($cylj)){
	            	   if($i%2==0) echo "<tr height=36 align=center>";
	                echo "<td>[<a href=".$v."><font color=blue><u>".$k."</u></font></a>]</td>";
	                if($i%2==1) echo "</tr>\n";
	                $i ++;
	            }
	            
	            if($i%2==1) echo "<td>&nbsp;</td></tr>";
	             //if($com_type=="teacher"){
	            	echo "<tr><td colspan=2><input type=button  style='FONT: 22px arial, sans-serif bold; HEIGHT: 30px;' name=back value=进入系室工作管理系统 onclick='location.href=\"/dept\"'/></td></tr>";
	            //}
            }
            else
            {
            	?>
            	<table style="margin:20px;" border="0" align="center">
            		<tr height=130>
            			<td width=130 style="cursor:pointer" align="center"  id="link1"><img id="grade1" src="./images/grade1.png"/></td><td width=5></td><td width=130 style="cursor:pointer" align="center"  id="link2"><img id="grade2" src="./images/grade2.png"/></td>
            		</tr>
            		<tr height=20>
            			<td width=130 align="center">器乐选修</td><td width=5></td><td width=130 align="center">声乐、钢琴</td>
            		</tr>
            		<tr height=130>
            			<td width=130 style="cursor:pointer" align="center"  id="link3"><img id="grade3" src="./images/grade3.png"/></td><td width=5></td><td width=130 style="cursor:pointer" align="center"  id="link4"><img id="grade4" src="./images/grade4.png"/></td>
            		</tr>
            		<tr height=20>
            			<td width=130 align="center">主修方向</td><td width=5></td><td width=130 align="center">毕业设计</td>
            		</tr>
            	</table>
            	<?php
            }
            ?>

          </table>
	<?php
}   //function show_menu();


?>

<script language=JavaScript >
var angle=new Array (1,1,1,-1,-1,-1,-1,-1,-1,1,1,1);
$(window).load(function(){
	//$("#grade1").rotate(-5);
	
	<?php
		$now = time(0);
		$sql = "select topic_start,topic_end,student_start,student_end,teacher_start,teacher_end ,grade from ".$ART_TABLE."set_date";
	    //echo "alert(".$sql." );" ;
	    $qur_sql = mysql_query($sql);
	    while($fet_result = mysql_fetch_array($qur_sql))
	    {
	    	if(($now>=$fet_result["teacher_start"]&&$now<=$fet_result["teacher_end"])  ||  ($now>=$fet_result["topic_start"]&&$now<=$fet_result["topic_end"]) )
	    	{
	    	?>
	    	rotate_grade<?php echo $fet_result['grade'];?>();
	    	<?php
	    	}
	    }
	?>
	
	$("#link1").click( function () { window.location.href="./teacher/art_teacher_chose_grade1.php"  });
	$("#link2").click( function () { window.location.href="./teacher/art_teacher_chose_grade2.php" });
	$("#link3").click( function () { window.location.href="./teacher/art_teacher_chose_grade3.php" });
	$("#link4").click( function () { window.location.href="./teacher/select_student.php" });
});



function r1(i)
{
	setTimeout(function() {
		//alert(i);
		$("#grade1").rotate(angle[i]);
		if(i<11)
			r1(i+1);
	}, 30);
}

function r2(i)
{
	setTimeout(function() {
		//alert(i);
		$("#grade2").rotate(angle[i]);
		if(i<11)
			r2(i+1);
	}, 30);
}

function r3(i)
{
	setTimeout(function() {
		//alert(i);
		$("#grade3").rotate(angle[i]);
		if(i<11)
			r3(i+1);
	}, 30);
}

function r4(i)
{
	setTimeout(function() {
		//alert(i);
		$("#grade4").rotate(angle[i]);
		if(i<11)
			r4(i+1);
	}, 30);
}

function rotate_grade1()
{
	r1(0);
	setTimeout(function() {	
		rotate_grade1();
	}, 3000);
}
function rotate_grade2()
{
	r2(0);
	setTimeout(function() {
		rotate_grade2();
	}, 3000);
}
function rotate_grade3()
{
	r3(0);
	setTimeout(function() {
		rotate_grade3();
	}, 3000);
}
function rotate_grade4()
{
	r4(0);
	setTimeout(function() {
		rotate_grade4();
	}, 3000);
}
</script>

<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>

