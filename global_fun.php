<?php
function showit($str)
{
	global $$str;
	echo "[\$".$str." = \"".$$str."\"]<br>";
}

function show_message($msg)
{
	$url = "javascript:history.go(-1);";
	if($_POST["submit"]){
		$url = "location.href=\"".$_SERVER["HTTP_REFERER"]."\"";
	}
	echo "<table width=430 align=center border=1 bordercolor=#000000>";
	echo "<tr align=center><td height=38 bgcolor=#3A4E6F><font color=#FFFFFF size=+1><b>提示信息</b></font></td></tr>";
	echo "<tr align=center><td height=138><font size=+1><br>&nbsp;&nbsp;$msg</font>
	        <br><br>
	        <span align=center><input type=button name=back value=返回上页 onclick='$url'/></span><br>&nbsp;</td></tr>";
	echo "</table>";
}

function get_majior_list($hislevel = 0, $dept = 4){
	global $TABLE;
	
	$majiorlist = array();
	$sql = "select id, name, shortname,open,h_level from ".$TABLE."major where type=$dept";
	$que_sql = mysql_query($sql);		 
	while($fet_result = mysql_fetch_array($que_sql)){
		$h_level = $fet_result["h_level"];
		if($hislevel&&$hislevel!=$h_level) continue;
		$id = $fet_result["id"];
		$name = $fet_result["name"];
		$shortname = $fet_result["shortname"];
		$open = $fet_result["open"];
		$majiorlist[$id][id]=$id;
		$majiorlist[$id][name]=$name;
		$majiorlist[$id][shortname]=$shortname;
		$majiorlist[$id][open]=$open;
		$majiorlist[$id][h_level]=$h_level;
	}
	return $majiorlist;
}

function makepassword($length = 8){
	$output = '';
	$length /= 2;
	for($i=0;$i<$length;$i++){
		$output .= chr(mt_rand(ord('a'),ord('z')));
		$output .= chr(mt_rand(ord('0'),ord('9')));
	}
	return $output;
}

function TeacherArchiveDown($wdyear,$pro,$teacher,$student,$mission,$obj,$msg,$line=true){
	$crc	= md5("tea".$wdyear.$pro.$teacher.$student.$mission.$obj.date("Ymd")."crc");
	echo "<a href =TeacherArchiveDown.php?wdyear=".$wdyear."&pro=".$pro."&teacher=".$teacher."&student=".$student."&mission=".$mission."&obj=".$obj."&crc=".$crc.">";
	if($line) echo "<font color = blue><u>";
	echo $msg;
	if($line) echo "</u></font>";
	echo "</a>";	
}
?>