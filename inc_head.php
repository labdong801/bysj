<?php
/*
$YM_ZT = "毕设选题系统登录";
$YM_ZT2 = "登录毕业设计选题系统";
$YM_MK = "毕业设计双向选题系统";
$YM_QX = 0; //本页访问需要权限


$com_name		姓名
$com_id			ID
$com_from		单位
$com_type		类别（教师、学生）
$com_auth		权限
$com_pro			指导（所属）专业
$com_pro_id		专业ID
$com_pro_num		专业、指导人数清单

$com_online		登录状态
$com_online_crc 登录状态验证
*/

session_start();

$self= $PHP_SELF;
$sc_name = $_SERVER["SCRIPT_FILENAME"];
$sc_loc= strpos($sc_name,$self);
$baseDIR = substr($sc_name,0,$sc_loc);

//$baseDIR = "..";
//链接数据库文件
include($baseDIR."/bysj/connect_db.php");
//全局变量相关文件
include($baseDIR."/bysj/global_fun.php");
//权限分级
$com_level = array(
   "0" => "访客", 	"1"=>"学生",		"2"=>"学委",
   "10" => "指导教师", 	"20"=>"答辩秘书",		"30"=>"答辩组长",
   "40" => "专业主任", 	"50"=>"系主任",		"60"=>"学院院长",
   "70" => "学校处长", 	"90"=>"管理员",
   );
if($YM_PT=="") $YM_PT = "选题系统";

if($_GET["y"])
	$year=$_GET["y"];
else
	$year= date("Y",mktime(0,0,0,date("m")-8,1,date("Y")));
	/*
 	 * 本学期年份 （当前年份减8个月）
 	 * eg:
 	 * 现在是 2013年6月 ，属于2012学年第二个期。所以 $art_select_year = 2012
 	 * 现在是2013年9月，属于2013年第一学期。所以$art_select_year =2013
 	 * */



if($PHP_SELF != "/bysj/index.php"){
	//如果是在外层的index.php登陆，则跳转到内层的index.php。
	//这个不用管，因为我没做外层的Index。php
     if(   !isset($com_online)  || substr(crypt($com_online,"jp"),2,11) != $com_online_crc){
         echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=/bysj/index.php?referer=".$_SERVER["HTTP_REFERER"]."'>";
         exit;
    }
} else {
    if($_POST){
    	//变量替换一下
         $his_id = $_POST["hisid"];
         $his_type = $_POST["histype"];
         $his_pass = $_POST["hispass"];
         if($his_type=="student") {
         	 //$sql = "select number as his_id,password as his_pass,authority,".$TABLE."student_sheet.name,class as his_from,profession as his_pro, id as his_pro_id,year
         	 //                   from ".$TABLE."student_sheet, ".$TABLE."major WHERE ".$TABLE."student_sheet.profession = ".$TABLE."major.name&&".$TABLE."major.type=4&&`number`='$his_id'";
         	 //好复杂 - -;
         	 //先不限制学院了，我都没那张表格
         	 //$TABLE是那张表格的前缀，我的不用这个
			 $sql = "SELECT number as his_id,password as his_pass,authority,".$TABLE."student_sheet.name,class as his_from,profession as his_pro,year FROM `".$TABLE."student_sheet` WHERE `number` ='$his_id'" ;

         } else {
         	$his_type = "teacher";
         	//$sql = "select teacher_id as his_id, fenzu,password as his_pass, authority,".$TABLE."teacher_information.name, ".$TABLE."major.name as his_from, lead_num as his_pro_id,belong as his_pro
         	//                    from ".$TABLE."teacher_information, ".$TABLE."major where ".$TABLE."teacher_information.belong = ".$TABLE."major.id&&".$TABLE."major.type=3&&(`teacher_id` = '$his_id'||`teacher_alias`!=''&&`teacher_alias`='$his_id')";
			$sql = "SELECT teacher_id as his_id, fenzu,password as his_pass, authority,".$TABLE."teacher_information.name,  lead_num as his_pro_id,belong as his_pro FROM `".$TABLE."teacher_information` WHERE (`teacher_id` = '$his_id'||`teacher_alias`!=''&&`teacher_alias`='$his_id')" ;
			//echo $sql;
		}

         $tmp_query  = mysql_query($sql);
         if($tmp_query)$tmp_fetch = mysql_fetch_array($tmp_query);
		 //$tmp_fetch = $tmp_fetch[0];
		 //print_r($tmp_fetch);

         unset($com_online);  //清除登陆登陆标志位
         unset($com_online_crc);//加密过的一段字符串，还不知道有什么用；
         //清除以前的SESSION,以免发生错误
         $_SESSION['com_online'] = "";
         $_SESSION['com_online_crc'] = "";
         $_SESSION['com_name'] = "未登录";
         $_SESSION['com_id']  = "";
         $_SESSION['com_type'] = "";
         $_SESSION['com_auth'] = 0;

         if($his_pass==$tmp_fetch["his_pass"]){ //密码相等，密码使用明文

             $_SESSION['com_online'] = $tmp_fetch["his_id"]; //id?
             $_SESSION['com_online_crc'] = substr(crypt($tmp_fetch["his_id"],"jp"),2,11); //加密过的一段字符串，还不知道有什么用；
             $_SESSION['com_name'] = $tmp_fetch["name"];    //中文名字
             $_SESSION['com_id']  = $tmp_fetch["his_id"];   //学号
             $_SESSION['com_type'] = $his_type;				//student or teacher
             $_SESSION['com_auth'] = $tmp_fetch["authority"];  //权限
             $_SESSION['com_pro'] = $tmp_fetch["his_pro"];  //专业中文名
	         $_SESSION['com_pro_num'] = $tmp_fetch["his_pro_id"];  //专业id,我没获取
			 $_SESSION['grade']       = (date("Y",mktime(0,0,0,date("m")-8,1,date("Y")))-intval(substr($com_id,0,2))-2000)+1;; //年级

	         /*好麻烦啊，大概是判断专业分组之类的
             if($his_type!="student"){
             	   $get_id_num  = explode(",",$tmp_fetch["his_pro_id"]);
             	   $pro_list = "";
             	   while(list($k,$v)=each($get_id_num)){
             	   	if($v=="") continue;
             	   	$s = explode("-",$v);
             	   	$pro_list .= $s[0].",";
             	   }
            	   $_SESSION['com_pro_id'] = $pro_list;
            	   $_SESSION['com_fenzu'] = $tmp_fetch["fenzu"];
              } else {
            	   $_SESSION['com_pro_id'] = $tmp_fetch["his_pro_id"];
            	   $kk = $tmp_fetch["year"];
            	   if($kk!=$YEAR_C) $kk = "none";
            	   $_SESSION['com_bysj'] = $kk;
              }
             $_SESSION['com_from'] = $tmp_fetch["his_from"];
             $_SESSION['CURR_YEAR'] = $YEAR_C;
             if($referer!=""){
             	echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=$referer'>";
            }
            */
         } else {
         	$err_show = true;
         	$err_msg = "密码错误！".$tmp_fetch["his_pass"];
        }
    }
}
$grade = $_SESSION['grade'];
//再替换一次变量名？？？？
$com_online 		= $_SESSION['com_online'];
$com_online_crc 	= $_SESSION['com_online_crc'];
$com_name 		= $_SESSION['com_name'];
$com_id 			= $_SESSION['com_id'];
$com_type 		= $_SESSION['com_type'];
$com_auth 		= $_SESSION['com_auth'];
$com_from 		= $_SESSION['com_from'];
$com_pro 		= $_SESSION['com_pro'];
$com_pro_id		= $_SESSION['com_pro_id'];
$com_pro_num		= $_SESSION['com_pro_num'];
$CURR_YEAR		= $_SESSION['CURR_YEAR'];
$CURR_PID		= $_SESSION['CURR_PID'];
$com_bysj		= $_SESSION['com_bysj'];
$com_fenzu     =$_SESSION['com_fenzu'];
$grade          = $_SESSION['grade'];
//大地震周年开关 - -;  选题系统这个都有。大地震载入相关CSS
$day512 = date("md");  //四川汶川大地震 2008年5月12日
if($day512==512) $day512 = true;
else $day512 = false;
if($day512) echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
?>
<html>
<head>
<title><?php echo $YM_ZT;if($com_from)echo "－".$com_from; ?></title>
<?php
if($day512) echo "<style>
html { filter:progid:DXImageTransform.Microsoft.BasicImage(grayscale=1); }
</style>\n";
?>
<meta http-equiv="Content-Language" content="zh-cn">
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<meta name="DESCRIPTION"  content="广东石油化工学院,毕业设计管理系统">
<meta name="keywords" content="毕业设计,管理系统,电信系,广东石油化工学院">
<link rel="stylesheet" type="text/css" href="/bysj/images/allbig.css">
<!-- jQuery -->
<script language=JavaScript src=/bysj/js/jquery-1.7.1.js></script>
<!-- 自己写的js都放在这里 -->
<script language=JavaScript src=/bysj/js/myjs.js></script>

<!-- 后来添加进去的CSS -->
<link rel="stylesheet" type="text/css" href="/bysj/css/mycss.css">
<link rel="stylesheet" type="text/css" href="/bysj/css/art.css">
</head>

<script language=JavaScript src=/bysj/images/rsTipBox.js></script>
<body leftMargin=0 topMargin=0 marginwidth=0 marginheight=0>
<div align="center">
<table width="992" height="39" border=0 cellpadding="0" cellspacing="0">
<tr>
  <td height="90">
  <table width="992" height="100%" border=0 cellpadding=0 cellspacing=0 align=center>
  <tr>
     <td align=right background="/bysj/images/mmc1.jpg" valign=bottom>
     <font face=黑体 size=7 color=#0A2856><b><?php echo $YM_MK; ?>&nbsp;&nbsp;&nbsp;&nbsp;</b></font>
     </td>
  </tr>
  </table>
  </td>
</tr>
<?php
if($com_online){
?>
<tr>
  <td height="5">
  <div align="center">
    <table border="0" cellpadding="8" cellspacing="0" width="992" height="17">
    <tr>
      <td height="16" background="/bysj/images/di.gif" valign="top" align=left>
&nbsp;登录
<?php
	//称谓，是学生还是教师
	echo ($com_type=="student"?"学生":"教师")."：".$com_name."(".$com_from.")"; //专业被我屏蔽了，所以看到括号里面是空的

	/*
	if($com_type=="student")
		//签到有什么用？？？
		echo " 【 <a href=/bysj/checkin.php><font color=blue><u><b>学生签到</b></u></font></a> 】";
	else
		echo " 【 <a href=/bysj/viewcheckin.php><font color=blue><u><b>查看签到情况</b></u></font></a> 】";
	*/

	if($day512)
		echo "</td><td align=center>【“<b>２００８·０５·１２</b>”汶川大地震】"; //就这样而已 ⊙﹏⊙汗
?>
      </td>
      <td height="16" background="/bysj/images/di.gif" valign="top" align=right>
      	<?php
      	if($com_online){

      		//学生看到的菜单
      		if($com_type=="student") {
      			echo "<span id='hide_menu'><<</span>&nbsp;";
      			$xtlist = array(
      				"乐器选修", //大一
      				"教师选择", //大二
      				"主修方向", //大三
      				"毕业选题", //大四
      				//"答辩系统",
      				);
      			$xturl = array(
      				"/bysj/student/grade1.php",
      				"/bysj/student/grade2.php",
      				"/bysj/student/grade3.php",
      				"#",
      				//"/bysj/filems/student/mygroup.php",
      				);
      		} else {//教师看到的菜单
      			$xtlist = array(
      				//"选题系统",
      				//"文档系统",
      				//"答辩系统",
      				"器乐选修",
      				"钢琴、声乐教师选择",
      				"专业主修方向",
      				"毕业设计",
      				);
      			$xturl = array(
      				//"/bysj/teacher/check_handon.php",
      				//"/bysj/filems/teacher/teacher_m.php",
      				//"/bysj/filems/teacher/examine1.php",
      				);
      		}
      		for($i=0;$i<sizeof($xtlist);$i++){
      			if($YM_DH&&$YM_PT==$xtlist[$i]) {

      				echo "[<b>".$xtlist[$i]."</b>]&nbsp;";
      				$XT_URL = $xturl[$i];
      			} else
      			{
      				if($com_type=="teacher")
      					echo "[<a href=".$xturl[$i]."><font color=blue><u>".$xtlist[$i]."</u></font></a>]&nbsp;";
      				elseif($grade > $i+1)
      					echo "<span class='grade_hide'>[<a href=".$xturl[$i]."><font color=blue><u>".$xtlist[$i]."</u></font></a>]&nbsp;</span>";
      				else
      				{
	      				if($grade <= $i )
	      					echo "<span class='high_grade'>[<b>".$xtlist[$i]."</b>]&nbsp;</span>";
	      				else
	      					echo "[<a href=".$xturl[$i]."><font color=blue><u>".$xtlist[$i]."</u></font></a>]&nbsp;";
      				}
      			}
      		}
      		//放下面了
             //echo "[<a href=/bysj/change_password.php><font color=blue><u>修改密码</u></font></a>]&nbsp;";
             echo "[<a href=/bysj/index.php><font color=blue><u>个人中心</u></font></a>]&nbsp;";
             echo "[<a href=/bysj/logout.php><font color=blue><u>安全退出</u></font></a>]&nbsp;";
         }
         ?>
      &nbsp;
      </td>
    </tr>
<?php
//教师界面
if(($YM_PT=="文档系统"||$YM_PT=="答辩系统")&&$com_type=="teacher"){
    echo "<tr><td colspan=2>";
  	$syear = $_GET["select_year"];
  	if($syear=="") $syear= $_SESSION["CURR_YEAR"];
	if($syear<$YEAR_S||$syear>$YEAR_C) $syear = $YEAR_C;
  	$_SESSION["CURR_YEAR"] = $syear;
  	echo "&nbsp;毕业年份：";
  	$sql = "select year from ".$TABLE."topic where teacher_id='$com_id' group by year order by year desc";
  	//echo $sql;
  	$qsql = mysql_query($sql);
  	$years = array();
  	array_push($years,$YEAR_C);
  	while($ys=mysql_fetch_array($qsql)){
  		$i = $ys["year"];
  		if($i!=$YEAR_C)array_push($years,$i);
  	}
  	for($j=0;$j<sizeof($years);$j++){
  		$i = $years[$j];
  		if($j&&abs($CURR_YEAR-$i)>1)continue;
		$ystr = $i."届";
		if($i==$CURR_YEAR) echo "[<b>".$ystr."</b>]";
		else echo "[<a href=".$PHP_SELF."?select_year=".$i."><font color=blue><u>".$ystr."</u></font></a>]";
	}

	$pro_list = explode(",", $com_pro_id);
  	$spid = $_GET["select_pid"];
  	if($spid=="") $spid= $_SESSION["CURR_PID"];
	if(!in_array($spid,$pro_list)) $spid = $pro_list[0];
  	$_SESSION["CURR_PID"] = $spid;

         $majiorlist = get_majior_list();
         echo "&nbsp;&nbsp;";
	 echo "当前专业：";
	 $pro_name = "";
	 while(list($k,$v)=each($majiorlist)){
	 	   if(in_array($k,$pro_list)&&$v[open]){
	 	   	   if($CURR_PID ==0) $CURR_PID = $k;
	 	   	   if($CURR_PID == $v["id"]){
	 	   	   	    echo "[<b>".$CURR_YEAR."届".$v["name"]."</b>]";
			 	    $pro_name = $v["name"];
	 	   	   } else echo "[<a href=".$PHP_SELF."?select_pid=".$k."><font color=blue><u>".$CURR_YEAR."届".$v["name"]."</u></font></a>]";
	 	   	   echo "&nbsp;&nbsp;";
	 	   }
 	 }

    echo "</td></tr>";
}
?>
    </table>
  </div>
  </td>
</tr>
<?php
}  //登录后，显示登录信息和修改密码等栏目
?>
<tr>
  <td height=2 align=center bgcolor=#233D66></td>
</tr>
<tr>
  <td height=8 align=center bgcolor=#FFFFFF></td>
</tr>
<tr>
  <td height="388">
  <div align="center">
    <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" width="992" height="100%">
    <tr>

<?php
if($YM_DH){
   echo "<td height=31 width=148 valign=top>";
   if($YM_PT=="答辩系统")   @include("navigation2.php");
   else if($YM_PT=="全局设定") @include("art_setting_navigation.php");
   else if($YM_PT=="教师任务下达") @include("art_setting_task_navigation.php");
   else if($YM_PT=="任务查询")  @include("art_student_task_navigation.php");
   else    @include("navigation.php");

   echo "</td>";
   echo "<td width=2 bgcolor=#FFFFFF></td>";
   echo "<td width=2 bgcolor=#233D66></td>";
   echo "<td width=2 bgcolor=#FFFFFF></td>";
   echo "<td align=center valign=top>";
   echo  "<p align=left>&nbsp;&nbsp;当前位置： <a href=/bysj><font color=blue><u>首页</u></font></a> > <a href=".$XT_URL."><font color=blue><u>".$YM_PT;
   if($pro_name) echo "(<b>".$CURR_YEAR."届".$pro_name."专业</b>)";
   echo "</u></font></a> > ".$YM_ZT.($mission_name?"《".$mission_name."》":"")."</p>";
   echo "<font size=+2 face=黑体><b>".$YM_ZT2."</b></font><br><br>";
} else {
      echo "<td height=31 align=center valign=top>";
}

if($com_auth<$YM_QX){
	echo "<br>";
	Show_message("对不起，您没有访问本页面的权限！");
	@include($baseDIR."/bysj/inc_foot.php");
	exit;

}
/*//理论上每届都有
else if($YM_QX &&$com_type=="student"&&$com_bysj!=$YEAR_C){
	echo "<br>";
	Show_message("对不起，您没有 [".$YEAR_C."届]毕业设计任务！");
	@include($baseDIR."/bysj/inc_foot.php");
	exit;
} */
else  if($YM_QX&&$YM_QX<10&&$com_type!="student") {
	echo "<br>";
	Show_message("对不起，您不能访问学生管理页面！");
	@include($baseDIR."/bysj/inc_foot.php");
	exit;
} else {
	;
}
	//一些信息
 	$gooddabian = array(   //公开答辩
	     "2010" => array("2010年6月19日 上午8点","主教八楼电信实验室"),
  	   "2011"=> array("2011年6月20日（周一）下午2点","主教八楼电信实验室"),
  	   "2012"=> array("2012年6月12日（周二）上午8点","主教八楼电信实验室"),
    );
	$dabian = array(  //小组答辩
	   "2010A" => array("2010年6月9日（周三）晚7：30；10日（周四）晚7：30","主教八楼电信实验室"),
	   "2010B" => array("2010年6月8日（周二）上午8点，全天","主教八楼电信实验室"),
	   "2010C" => array("2010年6月9日（周三）上午8点，全天","主教八楼电信实验室"),
	   "2010D" => array("2010年6月11日（周五）上午8点，全天","主教八楼电信实验室"),
	   //"2010E" => array("2010年6月7日（周一）上午8点，半天","主教八楼电信实验室"),
	   //"2010F" => array("2010年6月7日（周一）下午2：30，半天","主教八楼电信实验室"),
	   "2011A"=> array("2011年6月17日（周五）上午8点，全天","主教六楼电工电子实验室"),
	   "2011B"=> array("2011年6月15日（周三）上午8点，全天","主教八楼电信实验室"),
	   "2011C"=> array("2011年6月17日（周五）上午8点，全天","主教八楼电信实验室"),
	   "2011D"=> array("2011年6月16日（周四）上午8点，全天","主教八楼电信实验室"),
	   "2012A"=> array("2012年6月8日（周五）上午8点，全天","主教八楼故障检测实验室"),
	   "2012B"=> array("2012年6月7日（周四）上午8点，全天","主教一楼工程中心"),
	   "2012C"=> array("2012年6月8日（周五）上午8点，全天","主教八楼电信实验室"),
	   "2012D"=> array("2012年6月7日（周四）上午8点，全天","主教八楼电信实验室"),
	   );
?>
