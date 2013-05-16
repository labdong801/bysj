<?php
   session_start();
   $_SESSION['com_online'] = "";
   $_SESSION['com_online_crc'] = "";
   $_SESSION['com_name'] = "Î´µÇÂ¼";
   $_SESSION['com_id']  = "";
   $_SESSION['teacher_id'] = "";
   $_SESSION['student_id'] = "";
   $_SESSION['com_type'] = "";
   $_SESSION['com_auth'] = 0;
   unset($com_online);
   unset($com_online_crc);
   session_unregister("com_online");
   session_unregister("com_online_crc");
   session_unregister("com_id");
   session_unregister("teacher_id");
   session_unregister("student_id");
   session_unregister("com_type");
   session_destroy();
   echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=/bysj/index.php'>";
?>
