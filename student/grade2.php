<?php
$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);
$YM_ZT = "����ѡ��";
$YM_ZT2 = "�鿴����ѡ�����";
$YM_MK = "����ѡ��";
$YM_DH = 1; //��Ҫ������
$YM_QX = 1; //��ҳ������ҪȨ�ޣ���ͨѧ��
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
	font-family: "����", "����_GB2312";
}
.STYLE5 {font-family: "����", "����_GB2312"}
-->
</style>

<?php
   $welcomestr = '&nbsp;&nbsp;&nbsp;��ӭ'.$com_from.'<b>'.$com_name. '</b>ͬѧʹ������ϵ˫ѡϵͳ'."<p>";


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

echo "<tr><td colspan=2 align=left>&nbsp;&nbsp;&nbsp;<font size=+1><b>���ֽ�ʦѡ��</b></font><br><br></td><td rowspan=5 valign=top>";
echo "</td></tr>";

//$cc = mysql_query("select wish, name,topic,id,verify from ".$TABLE."student_select,".$TABLE."topic ,".$TABLE."teacher_information  where number = '$number' && id = topic_num && ".$TABLE."topic .teacher_id = ".$TABLE."teacher_information.teacher_id order by wish");
$sql= "SELECT * FROM `".$ART_TABLE."vocalmusic_student_select` WHERE `student_number`='$com_online' ";
$query = mysql_query($sql);
$currrows = mysql_num_rows($query);
if($currrows == 0) //��Ҫ����
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

 if($vocalmusic_finally) //�Ѿ�����ѡ��
 {
 	$sql = "SELECT * FROM  `".$TABLE."teacher_information` WHERE `teacher_id` ='".$vocalmusic_finally."' ";
 	$tquery = mysql_query($sql);
 	if(mysql_num_rows($tquery))
 	{
 		$teacher = mysql_fetch_array($tquery);
 		echo ShowSelectedTopic($teacher,"���ֿγ�");
 	}
 }
 else
 {
	for($tmpi=1;$tmpi<4;$tmpi++){
	//if($wishn["wish"]!=$tmpi) $dd = array();  //??????
	//else $dd = $wishn;

	  echo "��".$tmpi."־Ը��";
	  if($vocalmusic_result[$tmpi])
	  	echo "<a href='javascritp::void(0);'><font color=blue><u><span id='vocalmusic_unselect".$tmpi."' class='vocalmusic_select'>".getteachername($vocalmusic_result[$tmpi])."</span></u></font></a>";
	  else
	  	echo "<a href='javascritp::void(0);'><font color=blue><u><span id='vocalmusic_unselect".$tmpi."' class='vocalmusic_select'>δѡ��</span></u></font></a>";

	   echo "&nbsp;&nbsp;&nbsp;";
	}
	 echo "</td>";
	 echo "</tr>";
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

	 $sql = "SELECT * FROM  `".$ART_TABLE."vocalmusic` WHERE `vocalmusic` > 0 ";
	 $search = mysql_query($sql);

	 $currrows = mysql_num_rows($search);

	 echo "<tr><td width=100% colspan=2 valign=top>

	 <table width=100% border=1   cellpadding=5 bordercolor=#000000 style='margin-left:25px'>";

	 echo "<tr align=center  bgColor=#5a6e8f  height=38 align=center>
	 	<td width=100><font color=#FFFFFF><b>��ʦ</b></font></td>
	   <td width=100><font color=#FFFFFF><b>ְ��</b></font></td>
	   <td><font color=#FFFFFF size=+1><b>��ʦ���</b></font></td>
	  <td width=80><font color=#FFFFFF><b></b></font></td>
	  </tr>";

	if($currrows<=0)   {
	    echo "<tr><td height=88 colspan=5 align=center>";
	    echo "��ؼ�¼�����ڣ�";
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
	    	echo "<p>��ѧ����".$array2["educatelevel"]."</p>";
	    if($array2["graduateschool"])
	    	echo "<p>����ҵԺУ��".$array2["graduateschool"]."</p>";
	    if($array2["prise1"])
	    	echo "<p>��".$array2["year1"]."���μӡ�".$array2["prise1"]."�����.".$array2["level1"]."</p>";
	    if($array2["prise2"])
	    	echo "<p>��".$array2["year2"]."���μӡ�".$array2["prise2"]."�����.".$array2["level2"]."</p>";
	    if($array2["prise3"])
	    	echo "<p>��".$array2["year3"]."���μӡ�".$array2["prise3"]."�����.".$array2["level3"]."</p>";
	    ?>
	    </td>
		<td><a href="watch_teacher.php?teacher_id=<? echo $array["teacher_id"];?>" title="�鿴�ý�ʦ�ĸ�����Ϣ">�鿴</a></td>
	  </tr>

	<?php
	}
	echo "</form>";
	echo "</table>";
	echo "</td></tr>";
	// echo "<tr><td align=left>$page0 $pagelast $pagenext $pageN</td>
	// <td align=right>�� $page ҳ���� $pages ҳ / �� $totalrows ����¼</td></tr>";
 }
?>

</table>
<br><br>
<!-- ���� -->
<table width="838" align="center" border=0>
<tr class="align_top">
<td align="center">
<table width=838 border=0 align=left><tr valign=top><td width=730>

<form id="form1" name="form1" method="post" action="" class="saveHistory">
  <table width="730" border="0">
<?php

echo "<tr><td colspan=2 align=left>&nbsp;&nbsp;&nbsp;<font size=+1><b>���ٽ�ʦѡ��</b></font><br><br></td><td rowspan=5 valign=top>";
echo "</td></tr>";
$tmpi = 0;
 echo "<tr>";
 echo "<td colspan=2 align=left>&nbsp;&nbsp;&nbsp;";
 if($piano_finally) //�Ѿ�����ѡ��
 {
 	$sql = "SELECT * FROM  `".$TABLE."teacher_information` WHERE `teacher_id` ='".$piano_finally."' ";
 	$tquery = mysql_query($sql);
 	if(mysql_num_rows($tquery))
 	{
 		$teacher = mysql_fetch_array($tquery);
 		echo ShowSelectedTopic($teacher,"���ٿγ�");
 	}
 }
 else
 {
	for($tmpi=1;$tmpi<4;$tmpi++){
		//if($wishn["wish"]!=$tmpi) $dd = array();  //??????
		//else $dd = $wishn;

		  echo "��".$tmpi."־Ը��";
		  if($piano_result[$tmpi])
		  	echo "<a href='javascritp::void(0);'><font color=blue><u><span class='piano_select' id='piano_unselect".$tmpi."'>".getteachername($piano_result[$tmpi])."</span></u></font></a>";
		  else
		  	echo "<a href='javascritp::void(0);'><font color=blue><u><span class='piano_select' id='piano_unselect".$tmpi."'>δѡ��</span></u></font></a>";

	   echo "&nbsp;&nbsp;&nbsp;";
	}
	 echo "</td>";
	 echo "</tr>";
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

	 $sql = "SELECT * FROM  `".$ART_TABLE."vocalmusic` WHERE `piano` > 0 ";
	 $search = mysql_query($sql);

	 $currrows = mysql_num_rows($search);

	 echo "<tr><td width=100% colspan=2 valign=top>

	 <table width=100% border=1   cellpadding=5 bordercolor=#000000 style='margin-left:25px'>";

	 echo "<tr align=center  bgColor=#5a6e8f  height=38 align=center>
	 	<td width=100><font color=#FFFFFF><b>��ʦ</b></font></td>
	   <td width=100><font color=#FFFFFF><b>ְ��</b></font></td>
	   <td><font color=#FFFFFF size=+1><b>��ʦ���</b></font></td>
	  <td width=80><font color=#FFFFFF><b></b></font></td>
	  </tr>";
	if($currrows<=0)   {
	    echo "<tr><td height=88 colspan=5 align=center>";
	    echo "��ؼ�¼�����ڣ�";
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
	    	echo "<p>��ѧ����".$array2["educatelevel"]."</p>";
	    if($array2["graduateschool"])
	    	echo "<p>����ҵԺУ��".$array2["graduateschool"]."</p>";
	    if($array2["prise1"])
	    	echo "<p>��".$array2["year1"]."���μӡ�".$array2["prise1"]."�����.".$array2["level1"]."</p>";
	    if($array2["prise2"])
	    	echo "<p>��".$array2["year2"]."���μӡ�".$array2["prise2"]."�����.".$array2["level2"]."</p>";
	    if($array2["prise3"])
	    	echo "<p>��".$array2["year3"]."���μӡ�".$array2["prise3"]."�����.".$array2["level3"]."</p>";
	    ?>
	    </td>
		<td><a href="watch_teacher.php?teacher_id=<? echo $array["teacher_id"];?>" title="�鿴�ý�ʦ�ĸ�����Ϣ">�鿴</a></td>
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
   ��ϲ����<b><?php echo $row["name"];?></b> ��ʦ�Ѿ�ͬ��ָ������<?php echo $class; ?>��<br>&nbsp;<br>
   <table width=800 align=center border=1 bordercolor=1 cellpadding=6>
   <tr>
   	   <td align=center bgColor=#5a6e8f><font color=#FFFFFF>ָ����ʦ</font></td><td><?php echo $row["name"];?></td>
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
    <tr> <td height=38 align=left><b>ע�����</b>
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
			$(this).html("δѡ��");
			$.post("./ajax/update_grade2.php", { select: "vocalmusic_first", value: "0" ,number:"<?php echo $com_online;?>"});
		}
		if($(this).attr("id") == "vocalmusic_unselect2")
		{
			vs2 = 0;
			$(this).html("δѡ��");
			$.post("./ajax/update_grade2.php", { select: "vocalmusic_second", value: "0" ,number:"<?php echo $com_online;?>"});
		}
		if($(this).attr("id") == "vocalmusic_unselect3")
		{
			vs3 = 0;
			$(this).html("δѡ��");
			$.post("./ajax/update_grade2.php", { select: "vocalmusic_third", value: "0" ,number:"<?php echo $com_online;?>" });
		}




	});

	$(".piano_select").click(function(){
		if($(this).attr("id") == 'piano_unselect1')
		{
			ps1 = 0;
			$(this).html("δѡ��");
			$.post("./ajax/update_grade2.php", { select: "piano_first", value: "0" ,number:"<?php echo $com_online;?>"});
		}
		if($(this).attr("id") == "piano_unselect2")
		{
			ps2 = 0;
			$(this).html("δѡ��");
			$.post("./ajax/update_grade2.php", { select: "piano_second", value: "0" ,number:"<?php echo $com_online;?>"});
		}
		if($(this).attr("id") == "piano_unselect3")
		{
			ps3 = 0;
			$(this).html("δѡ��");
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
				alert("�Բ������Ѿ�ѡ�����־Ը�ˣ�");
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
				alert("�Բ������Ѿ�ѡ�����־Ը�ˣ�");
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
				alert("�Բ������Ѿ�ѡ�����־Ը�ˣ�");
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
			alert("�Բ��������ֻ��ѡ3��־Ը��");
		}


	});


	$(".piano_unselect").click(function(){
		var temp;
		if(ps1==0)
		{
			ps1 = $(this).attr("id");
			if(ps1 == ps2 || ps1 == ps3)
			{
				alert("�Բ������Ѿ�ѡ�����־Ը�ˣ�");
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
				alert("�Բ������Ѿ�ѡ�����־Ը�ˣ�");
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
				alert("�Բ������Ѿ�ѡ�����־Ը�ˣ�");
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
			alert("�Բ��������ֻ��ѡ3��־Ը��");
		}


	});
});
</script>

