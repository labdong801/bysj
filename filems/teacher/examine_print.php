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
	echo "�����µ�¼";
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
    	//�ҳ��������ʦ
    	$pyi = 0;
    	$pysql = "select teacher_id from ".$TABLE."teacher_information where fenzu='".$detail["fenzu"]."' order by rand()";
    	$pyquery = mysql_query($pysql);
    	while($py = @mysql_fetch_array($pyquery)){
    		 $detail["fenzulist"][$pyi++] = $py["teacher_id"];
    	}
    	//��ʱֱ�Ӹ���������Ρ����ʱ�����Ϣ
    	$detail["dbzhuren"]="zjl102"; 
    	$detail["qm1date"]="2011 �� 06 �� 10 ��";
    	$detail["qm2date"]="2011 �� 06 �� 12 ��";
    	$datelist = array(
    							"2011A"=> "2011 �� 06 �� 17 ��",
    							"2011B"=> "2011 �� 06 �� 15 ��",
    							"2011C"=> "2011 �� 06 �� 17 ��",
    							"2011D"=> "2011 �� 06 �� 16 ��",
    							);
    	$detail["qm3date"]= $datelist[$detail["fenzu"]];
    	$detail["qm4date"]="2011��06��21��";
    }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>��ʾ��ӡ���˱�<?php echo $detail["sname"]; ?></title>
</head>
<OBJECT classid="CLSID:8856F961-340A-11D0-A96B-00C04FD705A2" height=0 id=wb name=wb width=0></OBJECT> 

<body>
<?php
    if($showit) examine_show($detail, true);
    else echo "�Բ�������Ȩ���ʴ�ҳ��";
?>
 <script language="javascript">
<!-- begin
<?php
if($autoprint=="yeah") {
   echo "window.print();\n";
	 if($nextnumber==""){
		 echo "alert('��רҵ�ɼ����˱��Ѿ�ȫ����ӡ��ϣ���ֱ�ӹرձ���ҳ��');";
	 } else {
     echo "setTimeout(\"location='".$PHP_SELF."?sid=".$nextnumber."&autoprint=yeah'\",5000);\n";   
   }
} else {
   echo "printpage();\n";   
}
?>

function printpage() {
if (window.print) {
   agree = confirm('��ӡǰ��ȡ���������ӡ�����е�ҳü��ҳ�ŵ���Ϣ��\n\n��׼���ã������ȷ��������ҳ�����Զ���ӡ��\n\n���ھʹ�ӡ��?');
      if (agree) window.print(); 
   }
}
//  end -->
</script>	
</body>
</html>

