<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "����ѡ��";
$YM_ZT2 = "�鿴����ѡ�����";
$YM_MK = "����ϵ�γ�˫��ѡ��ϵͳ";
$YM_DH = 1; //��Ҫ������
$YM_QX = 1; //��ҳ������ҪȨ�ޣ���ͨѧ��
include($baseDIR."/bysj/inc_head.php");

 //������ѡ���
 $year = date("Y",mktime(0,0,0,date("m")-8,1,date("Y"))); //
 	/*
 	 * ��ѧ����� ����ǰ��ݼ�8���£�
 	 * eg:
 	 * ������ 2013��6�� ������2012ѧ��ڶ����ڡ����� $art_select_year = 2012
 	 * ������2013��9�£�����2013���һѧ�ڡ�����$art_select_year =2013
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
	font-family: "����", "����_GB2312";
}
.STYLE5 {font-family: "����", "����_GB2312"}
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
//                          	 alert('ѡ����Ч�����Ѿ�ѡ���˸ÿ��⣬�벻Ҫ�ظ�ѡ��лл��');
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
//		alert('����������δѡ��ĳһ���⡣\r\n\r\n�������µĺ�ѡ�����в�������Ҫѡ��Ŀ��⣬\r\n��ѡ�и�����ٵ������ť��лл��');
//		return false;
//	}
//	return true;
//}
///*��ʾ�Ͳز���ϸ��Ϣ*/
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
//    alert('������Ҫ��ѯ�����ݣ�');
//	return false;
//  }
//}
//function noinput(){
// alert("����������ѡ����Ŀ���ٵ��ȷ��ѡ�ⰴť���ύ��Ŀ");
//}
</script>

<?php
   $welcomestr = '&nbsp;&nbsp;&nbsp;��ӭ'.$com_from.'<b>'.$com_name. '</b>ͬѧʹ������ϵ˫ѡϵͳ'."<p>";

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
	//          exit;   //��������ѡ�У������
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
	   		$show_message = "Ŀǰ���ڽ�ʦѡѧ���׶Σ��ݲ��ܸ���ѡ�������";
//		   Show_Message("Ŀǰ���ڽ�ʦѡѧ���׶Σ��ݲ��ܲ鿴ѡ�������<br>
//		           �ý׶ν��� ".date("Y-m-d",$fet_result["teacher_end"])." ������<br>
//		           ����δ��ѡ�е�ѧ����ת����һ��ѡ��<br>�����ĵȺ�лл��");
		   $can_select = false;
	   } else {
//		   Show_Message("�Բ�������û�б�ҵ���ѡ������");
		   $show_message = "�Բ�������û������ѡ������";
		   $can_select = false;
	   }
	   
	   //�꼶����
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
//�����ʲô�õģ�������
   $randseed = ceil(time(0)/7200)+($number+0)%1000;   //��ѧ����ÿ2��Сʱ��������Ӳ�һ��

echo "<tr><td colspan=2 align=left>$welcomestr</td><td rowspan=5 valign=top>";
	 $arr = mysql_query("SELECT * FROM ".$TABLE."title_sort where open = 1 LIMIT 0 , 30");
	 //echo "<table width=98% border=0 align=center>";
	 //echo "<tr><td bgColor=#5a6e8f  height=28 align=center><font color=#FFFFFF>���������ͼ���</font></td></tr>";
	 //while($array = mysql_fetch_array($arr)){
	 //  echo "<tr><td>&nbsp;&nbsp;��&nbsp;<a href=".$PHP_SELF."?fortype=".$array["id"].">".$array["name"]."</a></td></tr>";
	 // }
	 // echo "</table>";
echo "</td></tr>";

//$cc = mysql_query("select wish, name,topic,id,verify from ".$TABLE."student_select,".$TABLE."topic ,".$TABLE."teacher_information  where number = '$number' && id = topic_num && ".$TABLE."topic .teacher_id = ".$TABLE."teacher_information.teacher_id order by wish");
$sql= "SELECT * FROM `".$ART_TABLE."instrument_student_select` WHERE `student_number`='$com_online' ";
$query = mysql_query($sql);
$currrows = mysql_num_rows($query);
if($currrows == 0) //��Ҫ����
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
$select_flag = false; //�Ƿ�ѡ����
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
      echo "<font color=blue>־Ը".$tmpi."��</font>";
      echo "<span class='select".$tmpi."'>".getinstrument($result[$tmpi],"name")."</span>";
      //echo "<span id=here".$tmpi."><input  type=text size=60 readonly value=\"".$dd["topic"]."--".$dd["name"]."\" onMouseDown=\"noinput()\"> </span>";
      //echo "&nbsp;<input name=button".$tmpi." type=button value='ȷ��ѡ��' onMouseDown='submitTopic(".$tmpi.")' onClick=\"upload('here".$tmpi."',form1.wish".$tmpi.".value,'".$tmpi."')\">
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
      	echo "<span class='select".$tmpi."'>δѡ��</span>";
      }
      echo "</td>";
      echo "</tr>";
   if($wishn["wish"]==$tmpi) $wishn = mysql_fetch_array($cc);
}
//echo "<tr>  <td align=right><font color=blue>��ѡ�⣺</font></td>  <td>";
//if($wishn["wish"]!="��ѡ") {
//	echo "<a href=\"student_handon.php\">�����ѡ��</a> ������<b>ѧ������</b>��ͬѧ�ύ���Ѷȿ��⣩";
//}else{
//	 $dd = $wishn;
//	  echo $dd["topic"]."&nbsp;--&nbsp;".$dd["name"];
//	  if($dd["verify"]==-1) echo "(<font color=red>ѡ����Ч������ѡ����</font>��";
//	  else if($dd["verify"]==0) echo "(<font color=green>������Ա��ˣ�δ�ͳʶ�Ӧ��ʦ</font>��";
//	  else echo "(<font color=green>ѡ����Ч�����һ־Ը��ͬ��ѡ</font>��";
//	  echo "	  &nbsp;<a href=\"student_handon.php?act=modify&id=".$dd["id"]."\">�޸�</a>";
//	  echo "  &nbsp;<a href=\"delete_handon.php?id=".$dd["id"]."\" onClick=\"return confirm('ȷ��Ҫɾ����')\">ɾ��</a>";
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
// 						//���в�ѯ�ı���������δѡ���Ҿ�����˵Ŀ��⣬�����ڱ�רҵ�Ŀ���
// $orderbystr  = "rand($randseed)";										//ȱʡΪ�����ʾ����������¼
// if($forteacher!=""){
// 	 $wherestr .= " && ".$TABLE."topic .teacher_id = '$forteacher'";  			//��ѯָ����ʦ
// 	 $orderbystr  = $TABLE."topic .type"; 									//ָ����ʦ����û��Ҫ�����ʾ��ֱ�Ӱ��������ȫ����ʾ
// }
// if($fortype!=""){
// 	 $wherestr .= " && ".$TABLE."topic .type = '$fortype'";  							//��ѯָ�����ͣ����������ʾ 30 ��
//}
//if($finds!=""){
//	$wherestr .= " && ".$TABLE."topic .topic like '%".$finds."%'";				//����Ŀ��ѯ�ؼ��ʣ����������ʾ 30 ��
//}
//$page += 0;
//if($page < 1) $page = 1;
//$pagenums = 10 ;
//$countsql = "select count(*) as cnt from ".$TABLE."topic ,".$TABLE."teacher_information,".$TABLE."title_sort $wherestr";
//$rs = mysql_query($countsql);
//$myrow = mysql_fetch_array($rs);
//$totalrows=$myrow["cnt"]; //��÷��������ļ�¼��
//$pages = ceil($totalrows/$pagenums);
//if($pages < 1) $pages = 1;
//if($page>$pages) $page = $pages; //���������Χ������ʾ���һҳ
//$pagebegin = ($page - 1) * $pagenums;
//
//$sql = "select topic,".$TABLE."title_sort.name as titlename, ".$TABLE."topic .type as typeid, ".$TABLE."topic .id as topicid, ".$TABLE."teacher_information.teacher_id,".$TABLE."teacher_information.name as teachername, meaning, request, question from ".$TABLE."topic ,".$TABLE."teacher_information,".$TABLE."title_sort   $wherestr order by $orderbystr LIMIT $pagebegin, $pagenums";
////echo $sql;
//$search = mysql_query($sql);
//$currrows = 0;
//if($search) $currrows=mysql_num_rows($search);   //��õ�ǰҳ��¼��
//$urlall = "finds=$finds&forteacher=$forteacher&fortype=$fortype";
//$page0 = "��ҳ";
//if($page>1) $page0 = "<a href=".$PHP_SELF."?".$urlall."&page=".(1)."><font color=blue><u>��ҳ</u></font></a>";
//$pageN = "βҳ";
//if($page<$pages) $pageN = "<a href=".$PHP_SELF."?".$urlall."&page=".($pages)."><font color=blue><u>βҳ</u></font></a>";
//$pagelast = "��һҳ";
//if($page-1>0) $pagelast = "<a href=".$PHP_SELF."?".$urlall."&page=".($page-1)."><font color=blue><u>��һҳ</u></font></a>";
//$pagenext = "��һҳ";
//if($page < $pages) $pagenext = "<a href=".$PHP_SELF."?".$urlall."&page=".($page+1)."><font color=blue><u>��һҳ</u></font></a>";
// echo "<tr><td align=left>$page0 $pagelast $pagenext $pageN</td>
// <td align=right>�� $page ҳ���� $pages ҳ / $totalrows ����¼</td></tr>";


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
   <td><font color=#FFFFFF size=+1><b>���ּ��</b></font></td>
   <td width=180><font color=#FFFFFF><b>�ȶ�</b><br>��һ־Ը/�ڶ�־Ը/����־Ը</font></td>
  <td width=80><font color=#FFFFFF><b>ָ����ʦ</b></font></td>
  </tr>";
if($currrows<=0)   {
    echo "<tr><td height=88 colspan=5 align=center>";
    if($finds!="") echo "<font color=red size=+1>��Ǹ���Ҳ������� [".$finds."] �ı�ҵ���ѡ�⣡</font><br>";
    if($forteacher!="") {
    	$tmps = mysql_query("select name from ".$TABLE."teacher_information where teacher_id = '".$forteacher."'");
    	$tmpa = mysql_fetch_array($tmps);
    	 echo "[<font color=blue>".$tmpa["name"]."</font>] ��ʦû�� <font color=green><b>".$com_pro."</b></font> רҵ��ص�ѡ�⣡</font><br>";
    }
    echo "��ؼ�¼�����ڣ�";
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
	
	//ָ����ʦ
	$sql = "SELECT *  FROM  `".$ART_TABLE."teacher_student`  " .
			"LEFT JOIN ".$TABLE."teacher_information ON ".$TABLE."teacher_information.teacher_id = ".$ART_TABLE."teacher_student.teacher_id " .
			"WHERE `major_id`='".$array['id']."'  AND `class` = '".$com_pro_id."' AND value > 0 ";
	$teacher_query = mysql_query($sql);
	$teacher= "";
	if(mysql_num_rows($teacher_query))
	{
		while($teacher_result =  mysql_fetch_array($teacher_query))
			//$teacher .="<p>".$teacher_result['name'] . "</p>";
			$teacher.="<p><a href='watch_teacher.php?teacher_id=".$teacher_result["teacher_id"]."' title='�鿴�ý�ʦ�ĸ�����Ϣ' >". $teacher_result["name"]."</a></p>";
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
// <td align=right>�� $page ҳ���� $pages ҳ / �� $totalrows ����¼</td></tr>";
?>
<tr><td colspan=2 align=left style='padding-left:20px;'><br><font color=red>������ʾ��</font><font color=green>ÿ��������ָ����ѧ���������ޣ��ʲ�Ҫѡ�������ŵ����֣�<br>
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
//	 echo "<tr><td bgColor=#5a6e8f  height=28 align=center><font color=#FFFFFF>����ʦ��������</font></td></tr>";
//	 while($array = mysql_fetch_array($arr)){
//	 	 $canleadnum = $array["hisleadnum"]-$array["leadnum"];
//	   echo "<tr><td>&nbsp;&nbsp;��&nbsp;<a href=".$PHP_SELF."?forteacher=".$array["teacher_id"]." title='".$array["name"]."��ʦ��ָ����רҵ $canleadnum ��ѧ��'>".$array["name"]."(".$canleadnum.")</a></td></tr>";
//	  }
//	  echo "<tr><td><font color=#5a6e8f size=-1><b><u>����Ϊ��ָ����</u></b></font></td></tr>";
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
   ��ϲ����<b><?php echo $row["name"];?></b> ��ʦ�Ѿ�ͬ��ָ����������ѡ�ޡ���������ʦ����ϵ��ʽ��<br>&nbsp;<br>
   <table width=800 align=center border=1 bordercolor=1 cellpadding=6>
   <tr height=40>
   	   <td align=center bgColor=#5a6e8f><font color=#FFFFFF>ָ����ʦ</font></td><td><?php echo $row["name"];?></td>
   	   <td align=center bgColor=#5a6e8f><font color=#FFFFFF>�ֻ�����</font></td><td><?php echo $row["mobilephone"];?></td>
   	   <td align=center bgColor=#5a6e8f><font color=#FFFFFF>�ƶ��̺�</font></td><td><?php echo $row["short_number"];?></td>
    </tr>
    <tr height=40>
   	   <td align=center bgColor=#5a6e8f><font color=#FFFFFF>����ְ��</font></td><td><?php echo $row["techpos"];?></td>
   	   <td align=center bgColor=#5a6e8f><font color=#FFFFFF>�칫�绰</td><td><?php echo $row["officephone"];?></td>
   	   <td align=center bgColor=#5a6e8f><font color=#FFFFFF>QQ����</font></td><td><?php echo $row["qq_number"];?></td>
    </tr>
    <tr height=40>
   	   <td align=center bgColor=#5a6e8f><font color=#FFFFFF>��������</font></td><td colspan=5><?php echo $row["email"];?></td>
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
		return "<font color=blue>��</font>";
	else if ($v <=30)
		return "<font color=orange>��</font>";
	else
		return "<font color=red >��</font>";
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
				alert("�Բ������Ѿ�ѡ����������ˣ�");
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
				alert("�Բ������Ѿ�ѡ����������ˣ�");
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
				alert("�Բ������Ѿ�ѡ����������ˣ�");
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
			alert("�Բ��������ֻ��ѡ3��־Ը��");
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

