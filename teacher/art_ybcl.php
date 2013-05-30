<?php
session_start();
include("../connect_db.php");
//echo $_POST[grade];

if($_POST[value])
{
$sql="SELECT  art_major.name,art_major.id,art_teacher_student.teacher_id FROM `art_major`,`art_teacher_student` WHERE art_major.id=art_teacher_student.major_id && art_teacher_student.year='$_SESSION[years]' && art_teacher_student.value>0 && art_teacher_student.class='$_POST[value]' && art_teacher_student.teacher_id='$_SESSION[com_id]' ";
//echo $sql;
$query=mysql_query($sql);
$kc=="<div>";

while($row=mysql_fetch_array($query))
{
 $kc.="<label> <input type=\"radio\" name=\"RadioGroup2\" value=\"$row[id]\"";
 if($row[id]==$pro_id)
 {
 //	$kc.="checked='checked'";
 }
 $kc.="/> $row[name]</label>";
}
$kc.="</div>";
echo mb_convert_encoding($kc,"UTF-8","GBK");
}

?>
