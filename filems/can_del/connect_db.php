<?php  
  include("global.php");
  $link = mysql_connect($db_server,$db_user,$db_password) or die ("Êý¾Ý¿âÁ´½ÓÊ§°Ü");
  mysql_select_db($db_name,$link);
  mysql_query("set names gb2312");
?>