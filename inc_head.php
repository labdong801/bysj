<?php
/*
$YM_ZT = "����ѡ��ϵͳ��¼";
$YM_ZT2 = "��¼��ҵ���ѡ��ϵͳ";
$YM_MK = "��ҵ���˫��ѡ��ϵͳ";
$YM_QX = 0; //��ҳ������ҪȨ��


$com_name		����
$com_id			ID
$com_from		��λ
$com_type		��𣨽�ʦ��ѧ����
$com_auth		Ȩ��
$com_pro			ָ����������רҵ
$com_pro_id		רҵID
$com_pro_num		רҵ��ָ�������嵥

$com_online		��¼״̬
$com_online_crc ��¼״̬��֤
*/

session_start();

$self= $PHP_SELF;
$sc_name = $_SERVER["SCRIPT_FILENAME"];
$sc_loc= strpos($sc_name,$self);
$baseDIR = substr($sc_name,0,$sc_loc);

//$baseDIR = "..";
//�������ݿ��ļ�
include($baseDIR."/bysj/connect_db.php");
//ȫ�ֱ�������ļ�
include($baseDIR."/bysj/global_fun.php");
//Ȩ�޷ּ�
$com_level = array(
   "0" => "�ÿ�", 	"1"=>"ѧ��",		"2"=>"ѧί",
   "10" => "ָ����ʦ", 	"20"=>"�������",		"30"=>"����鳤",
   "40" => "רҵ����", 	"50"=>"ϵ����",		"60"=>"ѧԺԺ��",
   "70" => "ѧУ����", 	"90"=>"����Ա",
   );
if($YM_PT=="") $YM_PT = "ѡ��ϵͳ";

if($_GET["y"])
	$year=$_GET["y"];
else
	$year= date("Y",mktime(0,0,0,date("m")-8,1,date("Y")));
	/*
 	 * ��ѧ����� ����ǰ��ݼ�8���£�
 	 * eg:
 	 * ������ 2013��6�� ������2012ѧ��ڶ����ڡ����� $art_select_year = 2012
 	 * ������2013��9�£�����2013���һѧ�ڡ�����$art_select_year =2013
 	 * */



if($PHP_SELF != "/bysj/index.php"){
	//�����������index.php��½������ת���ڲ��index.php��
	//������ùܣ���Ϊ��û������Index��php
     if(   !isset($com_online)  || substr(crypt($com_online,"jp"),2,11) != $com_online_crc){
         echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=/bysj/index.php?referer=".$_SERVER["HTTP_REFERER"]."'>";
         exit;
    }
} else {
    if($_POST){
    	//�����滻һ��
         $his_id = $_POST["hisid"];
         $his_type = $_POST["histype"];
         $his_pass = $_POST["hispass"];
         if($his_type=="student") {
         	 //$sql = "select number as his_id,password as his_pass,authority,".$TABLE."student_sheet.name,class as his_from,profession as his_pro, id as his_pro_id,year
         	 //                   from ".$TABLE."student_sheet, ".$TABLE."major WHERE ".$TABLE."student_sheet.profession = ".$TABLE."major.name&&".$TABLE."major.type=4&&`number`='$his_id'";
         	 //�ø��� - -;
         	 //�Ȳ�����ѧԺ�ˣ��Ҷ�û���ű��
         	 //$TABLE�����ű���ǰ׺���ҵĲ������
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

         unset($com_online);  //�����½��½��־λ
         unset($com_online_crc);//���ܹ���һ���ַ���������֪����ʲô�ã�
         //�����ǰ��SESSION,���ⷢ������
         $_SESSION['com_online'] = "";
         $_SESSION['com_online_crc'] = "";
         $_SESSION['com_name'] = "δ��¼";
         $_SESSION['com_id']  = "";
         $_SESSION['com_type'] = "";
         $_SESSION['com_auth'] = 0;

         if($his_pass==$tmp_fetch["his_pass"]){ //������ȣ�����ʹ������

             $_SESSION['com_online'] = $tmp_fetch["his_id"]; //id?
             $_SESSION['com_online_crc'] = substr(crypt($tmp_fetch["his_id"],"jp"),2,11); //���ܹ���һ���ַ���������֪����ʲô�ã�
             $_SESSION['com_name'] = $tmp_fetch["name"];    //��������
             $_SESSION['com_id']  = $tmp_fetch["his_id"];   //ѧ��
             $_SESSION['com_type'] = $his_type;				//student or teacher
             $_SESSION['com_auth'] = $tmp_fetch["authority"];  //Ȩ��
             $_SESSION['com_pro'] = $tmp_fetch["his_pro"];  //רҵ������
	         $_SESSION['com_pro_num'] = $tmp_fetch["his_pro_id"];  //רҵid,��û��ȡ
			 $_SESSION['grade']       = (date("Y",mktime(0,0,0,date("m")-8,1,date("Y")))-intval(substr($com_id,0,2))-2000)+1;; //�꼶

	         /*���鷳����������ж�רҵ����֮���
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
         	$err_msg = "�������".$tmp_fetch["his_pass"];
        }
    }
}
$grade = $_SESSION['grade'];
//���滻һ�α�������������
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
//��������꿪�� - -;  ѡ��ϵͳ������С�������������CSS
$day512 = date("md");  //�Ĵ��봨����� 2008��5��12��
if($day512==512) $day512 = true;
else $day512 = false;
if($day512) echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
?>
<html>
<head>
<title><?php echo $YM_ZT;if($com_from)echo "��".$com_from; ?></title>
<?php
if($day512) echo "<style>
html { filter:progid:DXImageTransform.Microsoft.BasicImage(grayscale=1); }
</style>\n";
?>
<meta http-equiv="Content-Language" content="zh-cn">
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<meta name="DESCRIPTION"  content="�㶫ʯ�ͻ���ѧԺ,��ҵ��ƹ���ϵͳ">
<meta name="keywords" content="��ҵ���,����ϵͳ,����ϵ,�㶫ʯ�ͻ���ѧԺ">
<link rel="stylesheet" type="text/css" href="/bysj/images/allbig.css">
<!-- jQuery -->
<script language=JavaScript src=/bysj/js/jquery-1.7.1.js></script>
<!-- �Լ�д��js���������� -->
<script language=JavaScript src=/bysj/js/myjs.js></script>

<!-- ������ӽ�ȥ��CSS -->
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
     <font face=���� size=7 color=#0A2856><b><?php echo $YM_MK; ?>&nbsp;&nbsp;&nbsp;&nbsp;</b></font>
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
&nbsp;��¼
<?php
	//��ν����ѧ�����ǽ�ʦ
	echo ($com_type=="student"?"ѧ��":"��ʦ")."��".$com_name."(".$com_from.")"; //רҵ���������ˣ����Կ������������ǿյ�

	/*
	if($com_type=="student")
		//ǩ����ʲô�ã�����
		echo " �� <a href=/bysj/checkin.php><font color=blue><u><b>ѧ��ǩ��</b></u></font></a> ��";
	else
		echo " �� <a href=/bysj/viewcheckin.php><font color=blue><u><b>�鿴ǩ�����</b></u></font></a> ��";
	*/

	if($day512)
		echo "</td><td align=center>����<b>��������������������</b>���봨�����"; //���������� �ѩn�Ѻ�
?>
      </td>
      <td height="16" background="/bysj/images/di.gif" valign="top" align=right>
      	<?php
      	if($com_online){

      		//ѧ�������Ĳ˵�
      		if($com_type=="student") {
      			echo "<span id='hide_menu'><<</span>&nbsp;";
      			$xtlist = array(
      				"����ѡ��", //��һ
      				"��ʦѡ��", //���
      				"���޷���", //����
      				"��ҵѡ��", //����
      				//"���ϵͳ",
      				);
      			$xturl = array(
      				"/bysj/student/grade1.php",
      				"/bysj/student/grade2.php",
      				"/bysj/student/grade3.php",
      				"#",
      				//"/bysj/filems/student/mygroup.php",
      				);
      		} else {//��ʦ�����Ĳ˵�
      			$xtlist = array(
      				//"ѡ��ϵͳ",
      				//"�ĵ�ϵͳ",
      				//"���ϵͳ",
      				"����ѡ��",
      				"���١����ֽ�ʦѡ��",
      				"רҵ���޷���",
      				"��ҵ���",
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
      		//��������
             //echo "[<a href=/bysj/change_password.php><font color=blue><u>�޸�����</u></font></a>]&nbsp;";
             echo "[<a href=/bysj/index.php><font color=blue><u>��������</u></font></a>]&nbsp;";
             echo "[<a href=/bysj/logout.php><font color=blue><u>��ȫ�˳�</u></font></a>]&nbsp;";
         }
         ?>
      &nbsp;
      </td>
    </tr>
<?php
//��ʦ����
if(($YM_PT=="�ĵ�ϵͳ"||$YM_PT=="���ϵͳ")&&$com_type=="teacher"){
    echo "<tr><td colspan=2>";
  	$syear = $_GET["select_year"];
  	if($syear=="") $syear= $_SESSION["CURR_YEAR"];
	if($syear<$YEAR_S||$syear>$YEAR_C) $syear = $YEAR_C;
  	$_SESSION["CURR_YEAR"] = $syear;
  	echo "&nbsp;��ҵ��ݣ�";
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
		$ystr = $i."��";
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
	 echo "��ǰרҵ��";
	 $pro_name = "";
	 while(list($k,$v)=each($majiorlist)){
	 	   if(in_array($k,$pro_list)&&$v[open]){
	 	   	   if($CURR_PID ==0) $CURR_PID = $k;
	 	   	   if($CURR_PID == $v["id"]){
	 	   	   	    echo "[<b>".$CURR_YEAR."��".$v["name"]."</b>]";
			 	    $pro_name = $v["name"];
	 	   	   } else echo "[<a href=".$PHP_SELF."?select_pid=".$k."><font color=blue><u>".$CURR_YEAR."��".$v["name"]."</u></font></a>]";
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
}  //��¼����ʾ��¼��Ϣ���޸��������Ŀ
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
   if($YM_PT=="���ϵͳ")   @include("navigation2.php");
   else if($YM_PT=="ȫ���趨") @include("art_setting_navigation.php");
   else if($YM_PT=="��ʦ�����´�") @include("art_setting_task_navigation.php");
   else if($YM_PT=="�����ѯ")  @include("art_student_task_navigation.php");
   else    @include("navigation.php");

   echo "</td>";
   echo "<td width=2 bgcolor=#FFFFFF></td>";
   echo "<td width=2 bgcolor=#233D66></td>";
   echo "<td width=2 bgcolor=#FFFFFF></td>";
   echo "<td align=center valign=top>";
   echo  "<p align=left>&nbsp;&nbsp;��ǰλ�ã� <a href=/bysj><font color=blue><u>��ҳ</u></font></a> > <a href=".$XT_URL."><font color=blue><u>".$YM_PT;
   if($pro_name) echo "(<b>".$CURR_YEAR."��".$pro_name."רҵ</b>)";
   echo "</u></font></a> > ".$YM_ZT.($mission_name?"��".$mission_name."��":"")."</p>";
   echo "<font size=+2 face=����><b>".$YM_ZT2."</b></font><br><br>";
} else {
      echo "<td height=31 align=center valign=top>";
}

if($com_auth<$YM_QX){
	echo "<br>";
	Show_message("�Բ�����û�з��ʱ�ҳ���Ȩ�ޣ�");
	@include($baseDIR."/bysj/inc_foot.php");
	exit;

}
/*//������ÿ�춼��
else if($YM_QX &&$com_type=="student"&&$com_bysj!=$YEAR_C){
	echo "<br>";
	Show_message("�Բ�����û�� [".$YEAR_C."��]��ҵ�������");
	@include($baseDIR."/bysj/inc_foot.php");
	exit;
} */
else  if($YM_QX&&$YM_QX<10&&$com_type!="student") {
	echo "<br>";
	Show_message("�Բ��������ܷ���ѧ������ҳ�棡");
	@include($baseDIR."/bysj/inc_foot.php");
	exit;
} else {
	;
}
	//һЩ��Ϣ
 	$gooddabian = array(   //�������
	     "2010" => array("2010��6��19�� ����8��","���̰�¥����ʵ����"),
  	   "2011"=> array("2011��6��20�գ���һ������2��","���̰�¥����ʵ����"),
  	   "2012"=> array("2012��6��12�գ��ܶ�������8��","���̰�¥����ʵ����"),
    );
	$dabian = array(  //С����
	   "2010A" => array("2010��6��9�գ���������7��30��10�գ����ģ���7��30","���̰�¥����ʵ����"),
	   "2010B" => array("2010��6��8�գ��ܶ�������8�㣬ȫ��","���̰�¥����ʵ����"),
	   "2010C" => array("2010��6��9�գ�����������8�㣬ȫ��","���̰�¥����ʵ����"),
	   "2010D" => array("2010��6��11�գ����壩����8�㣬ȫ��","���̰�¥����ʵ����"),
	   //"2010E" => array("2010��6��7�գ���һ������8�㣬����","���̰�¥����ʵ����"),
	   //"2010F" => array("2010��6��7�գ���һ������2��30������","���̰�¥����ʵ����"),
	   "2011A"=> array("2011��6��17�գ����壩����8�㣬ȫ��","������¥�繤����ʵ����"),
	   "2011B"=> array("2011��6��15�գ�����������8�㣬ȫ��","���̰�¥����ʵ����"),
	   "2011C"=> array("2011��6��17�գ����壩����8�㣬ȫ��","���̰�¥����ʵ����"),
	   "2011D"=> array("2011��6��16�գ����ģ�����8�㣬ȫ��","���̰�¥����ʵ����"),
	   "2012A"=> array("2012��6��8�գ����壩����8�㣬ȫ��","���̰�¥���ϼ��ʵ����"),
	   "2012B"=> array("2012��6��7�գ����ģ�����8�㣬ȫ��","����һ¥��������"),
	   "2012C"=> array("2012��6��8�գ����壩����8�㣬ȫ��","���̰�¥����ʵ����"),
	   "2012D"=> array("2012��6��7�գ����ģ�����8�㣬ȫ��","���̰�¥����ʵ����"),
	   );
?>
