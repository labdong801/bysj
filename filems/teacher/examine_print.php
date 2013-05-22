<?php
session_start();
$self= $PHP_SELF;
$sc_name = $_SERVER["SCRIPT_FILENAME"];
$sc_loc= strpos($sc_name,$self);
$baseDIR = substr($sc_name,0,$sc_loc);
include($baseDIR."/bysj/connect_db.php");
include($baseDIR."/bysj/global_fun.php");
include("inc_print.php");

$teacher_id = $_SESSION["com_id"];
$com_online = $_SESSION["com_online"];
if(!$com_online||!$teacher_id){
	mysql_close($link);
	echo "请重新登录";
	echo "</body></html>";
	exit;
}


$sid = $_GET["sid"];
if($_POST["sid"]!="")$sid = $_POST["sid"];
$autoprint = $_GET["autoprint"];

$showit = true;
if($sid=="") $showit = false;
else {
	if($autoprint=="yeah"){
		$asql = "select student_id from ".$TABLE."ok_topic where student_id>".$sid." && year=$CURR_YEAR && student_pro_id = $CURR_PID limit 0,1";
		$asqlquery = mysql_query($asql);
		$auser = mysql_fetch_array($asqlquery);
		$nextnumber = $auser[student_id];
	}
    $sql = "select student.profession as spro,class,type,student_id,
                          student.name as sname,topic,
                          oktopic.teacher_id as teacher_id,
                          oktopic.teacher2_id as teacher2_id,
                          oktopic.fenzu as fenzu,
                          score1_1,score1_2,score1_3,score2_1,score2_2,score2_3,
                          score3_1,score3_2,score3_3,score3_4,
                          comment1,comment2,comment3,comment4,oktopic.year
                  from ".$TABLE."ok_topic as oktopic,".$TABLE."student_sheet as student
                  where oktopic.student_id=student.number && oktopic.student_id='".$sid."'";
    //echo $sql;
    $sqlquery = mysql_query($sql);
    $detail = mysql_fetch_array($sqlquery);
    if($detail["student_id"]=="") $showit = false;
    else {
    	//找出该组的老师
    	$pyi = 0;
    	$pysql = "select teacher_id from ".$TABLE."teacher_information where fenzu='".$detail["fenzu"]."' order by rand()";
    	$pyquery = mysql_query($pysql);
    	while($py = @mysql_fetch_array($pyquery)){
    		 $detail["fenzulist"][$pyi++] = $py["teacher_id"];
    	}
    	//暂时直接给定答辩主任、答辩时间等信息
    	$detail["dbzhuren"]="zjl102"; 
    	$detail["qm1date"]="2011 年 06 月 10 日";
    	$detail["qm2date"]="2011 年 06 月 12 日";
    	$datelist = array(
    							"2011A"=> "2011 年 06 月 17 日",
    							"2011B"=> "2011 年 06 月 15 日",
    							"2011C"=> "2011 年 06 月 17 日",
    							"2011D"=> "2011 年 06 月 16 日",
    							);
    	$detail["qm3date"]= $datelist[$detail["fenzu"]];
    	$detail["qm4date"]="2011年06月21日";
    }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>显示打印考核表：<?php echo $detail["sname"]; ?></title>
</head>
<OBJECT classid="CLSID:8856F961-340A-11D0-A96B-00C04FD705A2" height=0 id=wb name=wb width=0></OBJECT> 

<body>
<?php
    if($showit) examine_show($detail, true);
    else echo "对不起，您无权访问此页！";
?>
 <script language="javascript">
<!-- begin
<?php
if($autoprint=="yeah") {
   echo "window.print();\n";
	 if($nextnumber==""){
		 echo "alert('本专业成绩考核表已经全部打印完毕，请直接关闭本网页！');";
	 } else {
     echo "setTimeout(\"location='".$PHP_SELF."?sid=".$nextnumber."&autoprint=yeah'\",5000);\n";   
   }
} else {
   echo "printpage();\n";   
}
?>

function printpage() {
if (window.print) {
   agree = confirm('打印前请取消浏览器打印设置中的页眉、页脚等信息。\n\n若准备好，点击“确定”，本页将被自动打印。\n\n现在就打印吗?');
      if (agree) window.print(); 
   }
}
//  end -->
</script>	
</body>
</html>

