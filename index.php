<?php
if($HTTP_HOST=="dianxinxi.cn"||$HTTP_HOST=="210.38.241.2"){
         echo "<META HTTP-EQUIV=REFRESH CONTENT='3;URL=http://www.dianxinxi.cn/bysj'>";
         echo "<br><br><br>";
	echo "<table width=430 align=center border=0 bordercolor=#000000>";
	//echo "<tr align=center><td height=38 bgcolor=#3A4E6F><font color=#FFFFFF  style='FONT: 22px arial, sans-serif bold; HEIGHT: 30px;'><b>��ʾ��Ϣ</b></font></td></tr>";
	echo "<tr align=center><td height=138><font style='FONT: 22px arial, sans-serif bold; HEIGHT: 30px;'><br>&nbsp;&nbsp;����ϵ��ҵ�����ַ<br><a href=http://www.dianxinxi.cn/bysj>http://www.dianxinxi.cn/bysj</a></font>
	        <br><br>
	        <span align=center><input type=button  style='FONT: 22px arial, sans-serif bold; HEIGHT: 30px;' name=back value=�������� onclick='location.href=\"http://www.dianxinxi.cn/bysj\"'/></span><br>&nbsp;</td></tr>";
	echo "</table>";
         exit;
}

$self= $PHP_SELF;
$filename = $_SERVER["SCRIPT_FILENAME"];
$loc= strpos($filename,$self);
$baseDIR = substr($filename,0,$loc);

$YM_ZT = "����ϵ�γ�˫��ѡ��ϵͳ��¼";
$YM_MK = "����ϵ�γ�˫��ѡ��ϵͳ";
$YM_DH = 0; //����Ҫ������
$YM_QX = 0; //��ҳ������ҪȨ��

//����post����غ����� inc_head.php ����ļ�����
include($baseDIR."/bysj/inc_head.php");

 ?>
 <!-- �˺ż����ص�js�ű�[] -->
<script language="javascript">
function isStudent()
{
var patrn=/^[0-9]{1,3}/;
var s = myform.hisid.value;
if (!patrn.exec(s)) myform.histype[0].checked = true;
else myform.histype[1].checked = true;
}

function checkform(){
  if(myform.hisid.value==""){
    alert("����д�����˺ţ�");
	myform.hisid.focus();
	return false;
  }
  if(myform.hispass.value==""){
    alert("����д�������룡");
	myform.hispass.focus();
	return false;
  }
}
</script>

<br>&nbsp;<br>
 <table width="900" height="200" border="0" cellpadding=8 align="center">
  <tr>
    <td>
<?php
/*
    <p><b>����07������07��ҵ��ƴ���ճ̣�[<font color=red>2011��5��25��</font>]</b></p>
    <p><font color=green><u>6��09��</u></font>   ȷ��ѡ�⣬���ݿ��ⷽ��Խ�ʦ��ѧ�����飻ѧ��<b><font color=blue>������������</font></b></p>
    <p><font color=green><u>6��10��</u></font>   �����С��ͨ��ϵͳ�������Ľ�ʦ</p>
    <p><font color=green><u>6��11��</u></font>  ѧ���ύ�������ĵ�<b><font color=blue>���ģ����壩</font></b>��Ŀ��</p>
    <p><font color=green><u>6��11�ա�12��</u></font>  ָ����ʦ�����Ľ������ۣ��������֣���ѧ���ύ�������룩</p>
  <p><font color=green><u>6��13�ա�14��</u></font> <font color=red><b>������������</b></font>�����Ľ�ʦ�������ġ����֣���ָ����ʦ�����֣�</p>
    <p><font color=green><u>6��15�ա�17��</u></font> ���С�鰴�ձ���ľ��������ʵ���ص㼰ʱ�䣬����С����</p>
	  <p><font color=green><u>6��20��</u></font>   ��С����ɼ�����90��ͬѧ���μӹ������</p>
*/
?>
	<!-- ��½˵��[��½������˵������] -->
    <p><b>ϵͳʹ��˵����</b></p>
    <p>I��ѧ����¼�ʺ�Ϊѧ�ţ�ԭʼ����Ϊ123456��</p>
    <p>II��ÿλѧ��ֻ�ܹ�����ǰ�꼶�Ŀγ̡����ܹ��鵽��ǰѡ�޹��Ŀγ̡�</p>
    <p>III��ѧ��ѡ�κ�����ʦ����ѡ��ѧ����</p>
    <p>IV��ѧ����־Ը��������־Ը��δ�ܱ���ʦѡ�ϣ����ɹ���Ա������</p>
    <p>V��ѧ���ͽ�ʦ��ѡ�����ֻ���ڹ涨��ʱ������ɣ���ע��ʱ��İ��š�</p>
	  <p>VI��Ϊ�˱���������Ϣ�İ�ȫ��ÿ�β������ϵͳ����ѡ��ȫ�˳���</p>
	</td>
	<td valign=top align=right>
	<?php
	   /*����Ѿ���½����ʾ��½��Ĳ˵���������ʾ��½��*/
	   if($com_online) show_menu();
	   else show_login();
	?>
	</td>
  </tr>
</table>
<?php
function show_login(){
	global $referer;
	global $err_show, $err_msg;
	?>
        <form name="myform" method="post" action="<?php echo $PHP_SELF; //����Ӧ����Bug������дӦ������Ч��?>" onSubmit="return checkform();">
          <table width="320" border="0" align="right" cellpadding=4>
            <tr align="center">
        	  <td colspan="2" height=38><font color=red><b><?php echo $err_show?$err_msg:""; ?></b></font></font></td>
        	</tr>
        	<tr>
              <td height=38 align=right><font size=+1><b>�ʺţ�</b></font></td>
              <td><input name="hisid" type="text" size="15" maxlength="15" onChange=isStudent()  style="FONT: 20px arial, sans-serif bold; HEIGHT: 30px;"/></td>
            </tr>
            <tr>
              <td align=right><font size=+1><b>���룺</b></font></td>
              <td><input name="hispass" type="password" size="15"  maxlength="20" style="FONT: 20px arial, sans-serif bold; HEIGHT: 30px;"/></td>
            </tr>
            <tr>
              <td height=38>&nbsp;</td>
              <td>
              	<input name="histype" type="radio" value="teacher" checked style="border:0; HEIGHT: 30px;"/><font size=+1><b>��ʦ</b></font>
              	&nbsp;&nbsp;&nbsp;&nbsp;
              	<input name="histype" type="radio" value="student" style="border:0; HEIGHT: 30px;"/><font size=+1><b>ѧ��</b></font>
              	</td>
            </tr>            <tr>
              <td colspan="2" height=38>
        	    <div align="center">
        	    	  <input type=hidden name=referer value="<?php echo $referer; ?>">
        	      <input type="submit" name="submit" value="��¼ϵͳ" style="BACKGROUND-COLOR: #333D66; COLOR: #ffffff; HEIGHT: 36px; FONT-SIZE: 16px"/>
        	    </div></td>
            </tr>
          </table>
        </form>
	<?php
}   //function show_login();

function show_menu(){
	 global $com_name;
	 global $com_type;
	 global $com_id;
	 global $com_from;
	 global $com_auth;
	 global $com_pro;
	 global $com_pro_id;
	 global $com_pro_num;
	 global $com_level;

          if($com_type=="student") {
               $cylj = array(
                     "�鿴ѡ��"=>"/bysj/student/selecttitle.php",
                     "�������"=>"/bysj/student/suggestion.php",
                     "��ϵ��ʽ"=>"/bysj/student/student_contact.php",
                     "�޸�����"=>"/bysj/change_password.php",
                     );
            }else if($com_auth>=90){  //����Ա
            	$cylj = array(
                     "�ĵ�ϵͳ"=>"#",
                     "ʱ������"=>"/bysj/teacher/art_grade1_set_date.php",
                     "ѡ��һ��"=>"/bysj/teacher/art_admin_chose_grade1.php",
                     "�����Ŀ"=>"/bysj/teacher/all_information.php",
                     "������Ϣ"=>"/bysj/teacher/teacher_information.php",
                     "��ϵ��ʽ"=>"/bysj/teacher/teacher_contact.php",
                     );
            }
            else{ 
               $cylj = array(
                     "�ĵ�ϵͳ"=>"#",
                     "ѧ��һ��"=>"/bysj/teacher/watch_my_student_all.php",
                     "������Ϣ"=>"/bysj/teacher/teacher_information.php",
                     "��ϵ��ʽ"=>"/bysj/teacher/teacher_contact.php",
                     );
            }
            
            
            if($com_type=="student")
            { 
            ?>
            <table width="200" border="0" align="center">
	            <tr align="center">
	        	  <td colspan="2" height=38><strong>���Ѿ���¼</strong></td>
	        	</tr>
	        	<tr><td align=right>������</td> <td><?php echo $com_name; ?></td></tr>
	        	<tr><td align=right>��λ��</td> <td><?php echo $com_from; ?></td></tr>
	        	<tr><td align=right>Ȩ�ޣ�</td> <td><?php echo $com_level[$com_auth]; ?></td></tr>
	            <tr><td height=20>&nbsp;</td><td>&nbsp;</td></tr>
	          </table>
	          
          
        	
        	<table width="200" border="0" align="center">
        	<?php
            
	            $i = 0;
	            while(list($k,$v) = @each($cylj)){
	            	   if($i%2==0) echo "<tr height=36 align=center>";
	                echo "<td>[<a href=".$v."><font color=blue><u>".$k."</u></font></a>]</td>";
	                if($i%2==1) echo "</tr>\n";
	                $i ++;
	            }
	            
	            if($i%2==1) echo "<td>&nbsp;</td></tr>";
	             //if($com_type=="teacher"){
	            	echo "<tr><td colspan=2><input type=button  style='FONT: 22px arial, sans-serif bold; HEIGHT: 30px;' name=back value=����ϵ�ҹ�������ϵͳ onclick='location.href=\"/dept\"'/></td></tr>";
	            //}
            }
            else
            {
            	?>
            	<table style="margin:20px;" border="0" align="center">
            		<tr height=130>
            			<td width=130 style="cursor:pointer" align="center"  id="link1"><img id="grade1" src="./images/grade1.png"/></td><td width=5></td><td width=130 style="cursor:pointer" align="center"  id="link2"><img id="grade2" src="./images/grade2.png"/></td>
            		</tr>
            		<tr height=20>
            			<td width=130 align="center">����ѡ��</td><td width=5></td><td width=130 align="center">���֡�����</td>
            		</tr>
            		<tr height=130>
            			<td width=130 style="cursor:pointer" align="center"  id="link3"><img id="grade3" src="./images/grade3.png"/></td><td width=5></td><td width=130 style="cursor:pointer" align="center"  id="link4"><img id="grade4" src="./images/grade4.png"/></td>
            		</tr>
            		<tr height=20>
            			<td width=130 align="center">���޷���</td><td width=5></td><td width=130 align="center">��ҵ���</td>
            		</tr>
            	</table>
            	<?php
            }
            ?>

          </table>
	<?php
}   //function show_menu();


?>

<script language=JavaScript >
var angle=new Array (1,1,1,-1,-1,-1,-1,-1,-1,1,1,1);
$(window).load(function(){
	//$("#grade1").rotate(-5);
	
	<?php
		$now = time(0);
		$sql = "select topic_start,topic_end,student_start,student_end,teacher_start,teacher_end ,grade from ".$ART_TABLE."set_date";
	    //echo "alert(".$sql." );" ;
	    $qur_sql = mysql_query($sql);
	    while($fet_result = mysql_fetch_array($qur_sql))
	    {
	    	if(($now>=$fet_result["teacher_start"]&&$now<=$fet_result["teacher_end"])  ||  ($now>=$fet_result["topic_start"]&&$now<=$fet_result["topic_end"]) )
	    	{
	    	?>
	    	rotate_grade<?php echo $fet_result['grade'];?>();
	    	<?php
	    	}
	    }
	?>
	
	$("#link1").click( function () { window.location.href="./teacher/art_teacher_chose_grade1.php"  });
	$("#link2").click( function () { window.location.href="./teacher/art_teacher_chose_grade2.php" });
	$("#link3").click( function () { window.location.href="./teacher/art_teacher_chose_grade3.php" });
	$("#link4").click( function () { window.location.href="./teacher/select_student.php" });
});



function r1(i)
{
	setTimeout(function() {
		//alert(i);
		$("#grade1").rotate(angle[i]);
		if(i<11)
			r1(i+1);
	}, 30);
}

function r2(i)
{
	setTimeout(function() {
		//alert(i);
		$("#grade2").rotate(angle[i]);
		if(i<11)
			r2(i+1);
	}, 30);
}

function r3(i)
{
	setTimeout(function() {
		//alert(i);
		$("#grade3").rotate(angle[i]);
		if(i<11)
			r3(i+1);
	}, 30);
}

function r4(i)
{
	setTimeout(function() {
		//alert(i);
		$("#grade4").rotate(angle[i]);
		if(i<11)
			r4(i+1);
	}, 30);
}

function rotate_grade1()
{
	r1(0);
	setTimeout(function() {	
		rotate_grade1();
	}, 3000);
}
function rotate_grade2()
{
	r2(0);
	setTimeout(function() {
		rotate_grade2();
	}, 3000);
}
function rotate_grade3()
{
	r3(0);
	setTimeout(function() {
		rotate_grade3();
	}, 3000);
}
function rotate_grade4()
{
	r4(0);
	setTimeout(function() {
		rotate_grade4();
	}, 3000);
}
</script>

<?php
  @include($baseDIR."/bysj/inc_foot.php");
?>

