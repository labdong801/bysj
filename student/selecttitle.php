<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "�鿴�����ѡ����";
$YM_ZT2 = "�鿴ѡ���ҵ��ƣ����ģ�����";
$YM_MK = "����ϵ�γ�˫��ѡ��ϵͳ";
$YM_DH = 1; //��Ҫ������
$YM_QX = 1; //��ҳ������ҪȨ�ޣ���ͨѧ��
include($baseDIR."/bysj/inc_head.php");

$number = $com_id;
 ?>
 <!-- 
<script  type="text/javascript" src="upload_db.js"></script>�ĳ�jQuery��
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
	font-family: "����", "����_GB2312";
}
.STYLE5 {font-family: "����", "����_GB2312"}
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
                          	 alert('ѡ����Ч�����Ѿ�ѡ���˸ÿ��⣬�벻Ҫ�ظ�ѡ��лл��');
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
		alert('����������δѡ��ĳһ���⡣\r\n\r\n�������µĺ�ѡ�����в�������Ҫѡ��Ŀ��⣬\r\n��ѡ�и�����ٵ������ť��лл��');
		return false;
	}
	return true;
}
/*��ʾ�Ͳز���ϸ��Ϣ*/
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
    alert('������Ҫ��ѯ�����ݣ�');
	return false;
  }
}
function noinput(){
 alert("����������ѡ����Ŀ���ٵ��ȷ��ѡ�ⰴť���ύ��Ŀ");
}

//jQuery����Ajax

function upload(objID,v,w){
	$.get("upload_db.php", { topicid: v, wish: w },
  		function(data){
    	//alert("Data Loaded: " + data);
    	$("#"+objID).html(data);
  	});
}
</script>

<?php
   $welcomestr = '&nbsp;&nbsp;&nbsp;��ӭ'.$com_from.'<b>'.$com_name. '</b>ͬѧʹ�ñ�ҵѡ��ϵͳ'."<p>";

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
          exit;   //��������ѡ�У������
   }
  // ���µ�ʱ�����÷�ʽ
   $sql = "select topic_start,topic_end,student_start,student_end,teacher_start,teacher_end from ".$ART_TABLE."set_date where grade = '4'";
   
   $qur_sql = mysql_query($sql);
   $fet_result = mysql_fetch_array($qur_sql);
   $now = time(0);
   $can_select = true;
   
   
   //�꼶����
   if($grade < 4)
	{
		Show_Message("רҵ����ѡ��ֻ�Դ���ѧ�����š�<br>
		           ��л�ڴ���ҵ��Ƶ�ͬѧ�ǡ�");
		@include($baseDIR."/bysj/inc_foot.php");
		exit;   //����ѡ�⣬�˳�
	}
   
   if($now>=$fet_result["student_start"]&&$now<=$fet_result["student_end"]){
   	   $can_select = true;
   } else if($now>=$fet_result["topic_start"]&&$now<=$fet_result["topic_end"]){
	   Show_Message("Ŀǰ���ڽ�ʦ�ύѡ��׶Σ��ݲ��ܲ鿴ѡ�������<br>
	           �ý׶ν��� ".date("Y-m-d",$fet_result["topic_end"])." ������<br>
	           ���ڴ����ں��ٲ鿴������Ϣ��лл��");
	   $can_select = false;
   } else if($now>=$fet_result["teacher_start"]&&$now<=$fet_result["teacher_end"]){
	   Show_Message("Ŀǰ���ڽ�ʦѡѧ���׶Σ��ݲ��ܲ鿴ѡ�������<br>
	           �ý׶ν��� ".date("Y-m-d",$fet_result["teacher_end"])." ������<br>
	           ����δ��ѡ�е�ѧ����ת����һ��ѡ��<br>�����ĵȺ�лл��");
	   $can_select = false;
   } else {
	   Show_Message("�Բ�������û�б�ҵ���ѡ������");
	   $can_select = false;
   }
   if(!$can_select){
         @include($baseDIR."/bysj/inc_foot.php");
          exit;   //����ѡ�⣬�˳�
  }
  
  
?>

<table width="838" align="center" border=0>
<tr class="align_top">
<td align="center">
<table width=838 border=0 align=left><tr valign=top><td width=730>
	
<form id="form1" name="form1" method="post" action="" class="saveHistory">
  <table width="730" border="0">
<?php
   $randseed = ceil(time(0)/7200)+($number+0)%1000;   //��ѧ����ÿ2��Сʱ��������Ӳ�һ��

echo "<tr><td colspan=2 align=left>$welcomestr</td><td rowspan=5 valign=top>";
	 $arr = mysql_query("SELECT * FROM ".$ART_TABLE."title_sort where open = 1 LIMIT 0 , 30");
	 echo "<table width=98% border=0 align=center>";
	 echo "<tr><td bgColor=#5a6e8f  height=28 align=center><font color=#FFFFFF>���������ͼ���</font></td></tr>";
	 while($array = mysql_fetch_array($arr)){
	   echo "<tr><td>&nbsp;&nbsp;��&nbsp;<a href=".$PHP_SELF."?fortype=".$array["id"].">".$array["name"]."</a></td></tr>";
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
      <td align=right width=60><font color=blue>־Ը".$tmpi."��</font></td>
      <td>
      <input name=wish".$tmpi." type=hidden id=wish".$tmpi." value=".($dd["id"]>0?$dd["id"]:0).">";
      echo "<span id=here".$tmpi."><input  type=text size=40 readonly value=\"".$dd["topic"]."--".$dd["name"]."\" onMouseDown=\"noinput()\"> </span>";
      echo "&nbsp;<input name=button".$tmpi." type=button value='ȷ��ѡ��' onMouseDown='submitTopic(".$tmpi.")' onClick=\"upload('here".$tmpi."',form1.wish".$tmpi.".value,'".$tmpi."')\">
	      </td>
    </tr>";
   if($wishn["wish"]==$tmpi) $wishn = mysql_fetch_array($cc);
}
echo "<tr>  <td align=right><font color=blue>��ѡ�⣺</font></td>  <td>";
if($wishn["wish"]!="��ѡ") {
	echo "<a href=\"student_handon.php\">�����ѡ��</a> ������<b>ѧ������</b>��ͬѧ�ύ���Ѷȿ��⣩";
}else{
	 $dd = $wishn;
	  echo $dd["topic"]."&nbsp;--&nbsp;".$dd["name"];
	  if($dd["verify"]==-1) echo "(<font color=red>ѡ����Ч������ѡ����</font>��";
	  else if($dd["verify"]==0) echo "(<font color=green>������Ա��ˣ�δ�ͳʶ�Ӧ��ʦ</font>��";
	  else echo "(<font color=green>ѡ����Ч�����һ־Ը��ͬ��ѡ</font>��";
	  echo "	  &nbsp;<a href=\"student_handon.php?act=modify&id=".$dd["id"]."\">�޸�</a>";
	  echo "  &nbsp;<a href=\"delete_handon.php?id=".$dd["id"]."\" onClick=\"return confirm('ȷ��Ҫɾ����')\">ɾ��</a>";
}
echo "</td></tr>";
?>

  </table>
</form>
<table width="730" border="0">
	<tr>
  	<form name="searches" action="" method="post">
		<td align=center colspan=2 height=38>��������������ѯ��������ؼ��֣�
     <input type="text" name="finds" value="<?php echo $finds; ?>"'/>
     <input type=hidden name=forteacher>
     <input type=hidden name=fortype>
     <input type="submit" name="gosearch" value="��ѯ" onClick="return fill_search()"/>
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
 						//���в�ѯ�ı���������δѡ���Ҿ�����˵Ŀ��⣬�����ڱ�רҵ�Ŀ���
 $orderbystr  = "rand($randseed)";										//ȱʡΪ�����ʾ����������¼
 if($forteacher!=""){
 	 $wherestr .= " && ".$TABLE."topic .teacher_id = '$forteacher'";  			//��ѯָ����ʦ
 	 $orderbystr  = $TABLE."topic .type"; 									//ָ����ʦ����û��Ҫ�����ʾ��ֱ�Ӱ��������ȫ����ʾ
 }
 if($fortype!=""){
 	 $wherestr .= " && ".$TABLE."topic .type = '$fortype'";  							//��ѯָ�����ͣ����������ʾ 30 ��
}
if($finds!=""){
	$wherestr .= " && ".$TABLE."topic .topic like '%".$finds."%'";				//����Ŀ��ѯ�ؼ��ʣ����������ʾ 30 ��
}
$page += 0;
if($page < 1) $page = 1;
$pagenums = 10 ;
$countsql = "select count(*) as cnt from ".$TABLE."topic ,".$TABLE."teacher_information,".$ART_TABLE."title_sort $wherestr";
$rs = mysql_query($countsql);
$myrow = mysql_fetch_array($rs);
$totalrows=$myrow["cnt"]; //��÷��������ļ�¼��
$pages = ceil($totalrows/$pagenums);
if($pages < 1) $pages = 1;
if($page>$pages) $page = $pages; //���������Χ������ʾ���һҳ
$pagebegin = ($page - 1) * $pagenums;

$sql = "select topic,".$ART_TABLE."title_sort.name as titlename, ".$TABLE."topic .type as typeid, ".$TABLE."topic .id as topicid, ".$TABLE."teacher_information.teacher_id,".$TABLE."teacher_information.name as teachername, meaning, request, question from ".$TABLE."topic ,".$TABLE."teacher_information,".$ART_TABLE."title_sort   $wherestr order by $orderbystr LIMIT $pagebegin, $pagenums";
//echo $sql;
$search = mysql_query($sql);
$currrows = 0;
if($search) $currrows=mysql_num_rows($search);   //��õ�ǰҳ��¼��
$urlall = "finds=$finds&forteacher=$forteacher&fortype=$fortype";
$page0 = "��ҳ";
if($page>1) $page0 = "<a href=".$PHP_SELF."?".$urlall."&page=".(1)."><font color=blue><u>��ҳ</u></font></a>";
$pageN = "βҳ";
if($page<$pages) $pageN = "<a href=".$PHP_SELF."?".$urlall."&page=".($pages)."><font color=blue><u>βҳ</u></font></a>";
$pagelast = "��һҳ";
if($page-1>0) $pagelast = "<a href=".$PHP_SELF."?".$urlall."&page=".($page-1)."><font color=blue><u>��һҳ</u></font></a>";
$pagenext = "��һҳ";
if($page < $pages) $pagenext = "<a href=".$PHP_SELF."?".$urlall."&page=".($page+1)."><font color=blue><u>��һҳ</u></font></a>";
 echo "<tr><td align=left>$page0 $pagelast $pagenext $pageN</td>
 <td align=right>�� $page ҳ���� $pages ҳ / $totalrows ����¼</td></tr>";
 
 echo "<tr><td width=100% colspan=2 valign=top>
 
 <table width=100% border=1   cellpadding=5 bordercolor=#000000>";

 echo "<tr align=center  bgColor=#5a6e8f  height=38 align=center>
   <td><font color=#FFFFFF size=+1><b>��ҵ��ƺ�ѡ���� ��Ŀ</b></font></td>
   <td width=38><font color=#FFFFFF><b>�ȶ�</b></font></td>
  <td width=80><font color=#FFFFFF><b>������</b></font></td>
  <td width=80><font color=#FFFFFF><b>ָ����ʦ</b></font></td>
  <td width=88><font color=#FFFFFF><b>������Ϣ</b></font></td>
  </tr>";
if($currrows<=0)   {
    echo "<tr><td height=88 colspan=5 align=center>";
    if($finds!="") echo "<font color=red size=+1>��Ǹ���Ҳ������� [".$finds."] �ı�ҵ���ѡ�⣡</font><br>";
    if($forteacher!="") {
    	$tmps = mysql_query("select name from ".$TABLE."teacher_information where teacher_id = '".$forteacher."'");
    	$tmpa = mysql_fetch_array($tmps);
    	 echo "[<font color=blue>".$tmpa["name"]."</font>] ��ʦû�� <font color=green><b>".$com_pro."</b></font> רҵ��ص�ѡ�⣡</font><br>";
    }
    echo "��ѡ������ͻ���ؼ�¼�����ڣ���ѡ��������ҵ��ƿ��⣡";
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
        if($cnt==0) $cstr = "<font color=green>��</font>";
        else if($cnt<3) $cstr = "<font color=blue>��</font>";
        else if($cnt<6) $cstr = "<font color=red>��</font>";
        else $cstr = "<font color=red><b>��</b></font>";
        echo $cstr;
        echo "/";
        $numsql = "select count(*) as topicnum from ".$TABLE."student_select where topic_num=".$array["topicid"]."&&wish=1";
        $numquery = mysql_query($numsql);
        $tmparr = mysql_fetch_array($numquery);
        $cnt= $tmparr["topicnum"];
        if($cnt==0) $cstr = "<font color=green>��</font>";
        else if($cnt<3) $cstr = "<font color=blue>��</font>";
        else if($cnt<6) $cstr = "<font color=red>��</font>";
        else $cstr = "<font color=red><b>��</b></font>";
        echo $cstr;
        ?></td>
	<td><?php 
	           echo "<a href=".$PHP_SELF."?fortype=".$array["typeid"].">".$array["titlename"]."</a>";?>
	</td>   
	<td><a href="watch_teacher.php?teacher_id=<? echo $array["teacher_id"];?>" title="�鿴�ý�ʦ�ĸ�����Ϣ"><?php echo $array["teachername"];?></a></td>
	<td><input type="button" name="button"  value="��ϸ��Ϣ" onClick="change('<? echo $array["topicid"];?>')"/>
	  </td>
  </tr>
  <tr>
  <td colspan="5" width=100%><div id = "<? echo $array["topicid"];?>" class="myDiv" style="display: none;">
<? 
echo "<strong>���壺</strong><br>".dispEnter($array["meaning"]). "<hr><strong>Ҫ��</strong><br>".dispEnter($array["request"])."<hr><strong>���⣺</strong><br>".dispEnter($array["question"]);?></div>
  </td>
  </tr>
<?php
}
echo "</form>";
echo "</table>";
echo "</td></tr>";
 echo "<tr><td align=left>$page0 $pagelast $pagenext $pageN</td>
 <td align=right>�� $page ҳ���� $pages ҳ / �� $totalrows ����¼</td></tr>";
?>
<tr><td colspan=2 align=left><font color=red>������ʾ��</font><font color=green>һ��ѡ������ֻ��ѡ��һ��ѧ�����ʲ�Ҫѡ�������ŵ�ѡ�⣡��<b>��רҵ�ȶ� / ����רҵ�ȶ�</b>��<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<font color=green>�䣺0�ˣ�</font><font color=blue>�£�1-2�ˣ�</font><font color=red>�ȣ�3-5�ˣ�</font><font color=red><b>�̣����ࣻ</b></font>��ѡ<font color=red>��</font>��<font color=red><b>��</b></font>ѡ�⡣</font></td></tr>
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
	 echo "<tr><td bgColor=#5a6e8f  height=28 align=center><font color=#FFFFFF>����ʦ��������</font></td></tr>";
	 while($array = mysql_fetch_array($arr)){
	 	 $canleadnum = $array["hisleadnum"]-$array["leadnum"];
	   echo "<tr><td>&nbsp;&nbsp;��&nbsp;<a href=".$PHP_SELF."?forteacher=".$array["teacher_id"]." title='".$array["name"]."��ʦ��ָ����רҵ $canleadnum ��ѧ��'>".$array["name"]."(".$canleadnum.")</a></td></tr>";
	  }
	  echo "<tr><td><font color=#5a6e8f size=-1><b><u>����Ϊ��ָ����</u></b></font></td></tr>";
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
   ��ϲ����<b><?php echo $row["t_name"];?></b> ��ʦ�Ѿ�ͬ��ָ�����ı�ҵ��ơ�����ϵ��ʦ��ʵ��ҵ��ơ�<br>&nbsp;<br>
   <table width=800 align=center border=1 bordercolor=1 cellpadding=6>
   <tr>
   	   <td align=center bgColor=#5a6e8f><font color=#FFFFFF>ָ����ʦ</font></td><td><?php echo $row["t_name"];?></td>
   	   <td align=center bgColor=#5a6e8f><font color=#FFFFFF>�ֻ�����</font></td><td><?php echo $row["mobilephone"];?></td>
   	   <td align=center bgColor=#5a6e8f><font color=#FFFFFF>�ƶ��̺�</font></td><td><?php echo $row["short_number"];?></td>
    </tr>
    <tr>
   	   <td align=center bgColor=#5a6e8f><font color=#FFFFFF>����ְ��</font></td><td><?php echo $row["techpos"];?></td>
   	   <td align=center bgColor=#5a6e8f><font color=#FFFFFF>�칫�绰</td><td><?php echo $row["officephone"];?></td>
   	   <td align=center bgColor=#5a6e8f><font color=#FFFFFF>QQ����</font></td><td><?php echo $row["qq_number"];?></td>
    </tr>
    <tr>
   	   <td align=center bgColor=#5a6e8f><font color=#FFFFFF>��������</font></td><td colspan=5><?php echo $row["email"];?></td>
    </tr>
    </table>
   <br>&nbsp;<br>
   <table width=800 align=center border=1 bordercolor=1 cellpadding=6>
   <tr> <td width=130 height=38 align=right><b>��ҵ�����Ŀ��</b></td> <td width=680><? echo $row["t_topic"];?>
   	         &nbsp;&nbsp;&nbsp;&nbsp;<b>�������ͣ�</b><? echo $row["t_type"];?></td></tr>
   <tr> <td width=130 height=88 align=right><b>����ƿ������壺</b></td> <td width=680><? echo dispEnter($row["meaning"]);?></td></tr>
   <tr> <td width=130 height=88  align=right><b>�Կ����Ҫ��</b></td> <td width=680><? echo dispEnter($row["request"]);?></td></tr>
   <tr> <td width=130 height=68 align=right><b>�������ص�Ҫ��������⣺</b></td> <td width=680><? echo dispEnter($row["question"]);?></td></tr>
    </table>
    <br>&nbsp;<br>
<?php
}
?>
<?
  @include($baseDIR."/bysj/inc_foot.php");
?>
