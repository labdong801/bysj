<?php
if($HTTP_HOST=="127.0.0.1"){
   $db_user  =  "root";
   $db_password  =  "";
   $db_server  =  "localhost";
} else {
   $db_user  =  "root2";
   $db_password  =  "";
   $db_server  =  "192.168.0.2";
}
$db_name   =  "bysj";
$TABLE = "bysj_";
$YEAR_C = "2013";
$YEAR_S = "2010";
$READONLY = true; //禁止修改成绩
$TMPWRITE = true; //指定日期内，可修改答辩意见

$ART_TABLE = "art_";

?>
