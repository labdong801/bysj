<?php
function examine_show($detail = array(),$qianming = false)
{
    $items1 = array("���","����");
	$items2 = array(
	     array("����ʵ��<br>���£�8�֣�","���˵��<br>�飨6�֣�","ͼֽ<br>��6�֣�"),
	     array("������֤<br>���£�8�֣�","����˵��<br>�飨6�֣�","�������<br>������6�֣�")
	     );
	$items3 = array(
	     array("���˵��<br>�飨10�֣�","ͼֽ<br>��10�֣�","�������<br>������15�֣�","���<br>��15�֣�"),
	     array("����˵��<br>�飨15�֣�","�������<br>������15�֣�","���<br>��20�֣�")
	     );
	$itemsnum = array(
	     array(10,10,15,15),
	     array(15,15,20)
	     );
     $comment1 = str_replace("\n","<br>&nbsp;&nbsp;&nbsp;&nbsp;",$detail["comment1"]);
     $comment2 = str_replace("\n","<br>&nbsp;&nbsp;&nbsp;&nbsp;",$detail["comment2"]);
     $comment3 = str_replace("\n","<br>&nbsp;&nbsp;&nbsp;&nbsp;",$detail["comment3"]);
     $comment4 = str_replace("\n","<br>&nbsp;&nbsp;&nbsp;&nbsp;",$detail["comment4"]);

	if($detail["type"]=="��ѧ�о�") $typeclass = 1;
	else $typeclass = 0;	 
     
     $class = str_replace("��","",$detail["class"]);
     $spro = str_replace("��ר�ƣ�","",$detail["spro"]);
     
     $score1_1 = $detail["score1_1"]*10.0/100.0;
     $score1_2 = $detail["score1_2"]*10.0/100.0;
     $score1_3 = $detail["score1_3"]*10.0/100.0;
     $score2_1 = $detail["score2_1"]*8.0/100.0;
     $score2_2 = $detail["score2_2"]*6.0/100.0;
     $score2_3 = $detail["score2_3"]*6.0/100.0;
	 if($typeclass==1){
         $score3_1 = $detail["score3_1"]*15.0/100.0;
         $score3_2 = $detail["score3_2"]*15.0/100.0;
         $score3_3 = $detail["score3_3"]*20.0/100.0;
         $score3_4 = 0;
     } else {
         $score3_1 = $detail["score3_1"]*10.0/100.0;
         $score3_2 = $detail["score3_2"]*10.0/100.0;
         $score3_3 = $detail["score3_3"]*15.0/100.0;
         $score3_4 = $detail["score3_4"]*15.0/100.0;
    }
    
    $score1_1 = ceil($score1_1*10)/10.0;
    $score1_2 = ceil($score1_2*10)/10.0;
    $score1_3 = ceil($score1_3*10)/10.0;
    $score2_1 = ceil($score2_1*10)/10.0;
    $score2_2 = ceil($score2_2*10)/10.0;
    $score2_3 = ceil($score2_3*10)/10.0;
    $score3_1 = ceil($score3_1*10)/10.0;
    $score3_2 = ceil($score3_2*10)/10.0;
    $score3_3 = ceil($score3_3*10)/10.0;
    $score3_4 = ceil($score3_4*10)/10.0;
     
	 $score1 = $score1_1+$score1_2+$score1_3;
	 $score2 = $score2_1+$score2_2+$score2_3;
	 $score3 = $score3_1+$score3_2+$score3_3+$score3_4;
	 $totalscore = ceil($score1 + $score2 + $score3);
	 	 
     $dengji = array("������","����","�е�","����","����");
     $ji = ($totalscore-50-$totalscore%10)/10;
     if($ji < 0) $ji = 0;
     if($ji >4) $ji = 4;
?>
<table border=0 width=648 cellpadding="0" cellspacing="0" >
<tr>
<td align=center><br>
	  <font size=+2><strong><?php echo $detail["year"]=="2010"?"ï��ѧԺ":"�㶫ʯ�ͻ���ѧԺ";?>��ҵ<?php echo $items1[$typeclass]; ?>�ɼ����˱�</strong></font><br /><br>
ѧԺ:������������ϢѧԺ&nbsp;רҵ:<?php echo $spro; ?>&nbsp;�༶:<?php echo $class; ?>&nbsp;ѧ��:<?php echo $detail["student_id"]; ?>
</td></tr>
<tr align=left><td>
	<table width="630" height="40" border="1" style='font-size: 12pt;width:475.4pt;border-collapse:collapse;border:none;mso-border-alt:solid windowtext .5pt; mso-padding-alt:0cm 5.4pt 0cm 5.4pt;mso-border-insideh:.5pt solid windowtext;
 mso-border-insidev:.5pt solid windowtext' cellpadding="0" cellspacing="0" bordercolor="#000000">
      <tr align="center">
        <td width="44" height="40" align="center">ѧ<br />
        ��</td>
        <td width="137">&nbsp;<?php echo $detail["sname"]; ?></td>
        <td width="67">����</td>
        <td colspan="3" align="center" >&nbsp; <?php echo $detail["topic"]; ?></td>
        </tr>
	</table>
</td>
</tr>
<tr align=left>
<td>
	<table width="630" height="576" border="1" style='font-size: 12pt;width:475.4pt;border-collapse:collapse;border:none;mso-border-alt:solid windowtext .5pt; mso-padding-alt:0cm 5.4pt 0cm 5.4pt;mso-border-insideh:.5pt solid windowtext;
 mso-border-insidev:.5pt solid windowtext' cellpadding="0" cellspacing="0" bordercolor="#000000">
      <tr align="center">
        <td rowspan="4"  width="44" align="center">ָ<br />
          ��<br />
          ��<br />
          ʦ<br />
          ��<br />
          ��<br />
          30<br />
          %</td>
        <td colspan="3" rowspan="4"><table width="406" height="168" border="0">
          <tr>
            <td height=120 align=left>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $comment1; ?></td>
          </tr>
          <tr>
            <td height="45"><table border=0 width=300><tr><td width=100>&nbsp;</td><td id="qm1" style="position: absolute">ǩ���� ����������<?php echo $detail["qm1date"];?></td></tr></table></td>
          </tr>
        </table></td>
        <td width="98" height="44" colspan="-2">��������<br />
        ��10�֣�</td>
        <td width="71" colspan="-2"><?php echo $score1_1; ?> ��</td>
      </tr>
      <tr align="center">
        <td height="43" colspan="-2">��������<br />
        ��10�֣�</td>
        <td colspan="-2"><?php echo $score1_2; ?> ��</td>
      </tr>
      <tr align="center">
        <td height="40" colspan="-2">����̬��<br />
        ��10�֣�</td>
        <td colspan="-2"><?php echo $score1_3; ?> ��</td>
      </tr>
      <tr align="center">
        <td height="41" colspan="-2"><strong>�ϼƵ÷�<br />
        ��30�֣�</strong></td>
        <td colspan="-2"><strong><?php echo $score1; ?> ��</strong></td>
      </tr>
      <tr align="center">
        <td rowspan="4" align="center">��<br />
          ��<br />
          ��<br />
          ʦ<br />
          ��<br />
          ��<br />
          20<br />
        %</td>
        <td colspan="3" rowspan="4"><table width="406" height="174" border="0">
          <tr>
            <td height="130" align=left>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $comment2; ?></td>
          </tr>
          <tr>
            <td height="45"><table border=0 width=300><tr><td width=100>&nbsp;</td><td id="qm2" style="position: absolute">ǩ���� ����������<?php echo $detail["qm2date"];?></td></tr></table></td>
          </tr>
        </table></td>
        <td height="45" colspan="-2"><?php echo $items2[$typeclass][0]; ?></td>
        <td colspan="-2"><?php echo $score2_1; ?> ��</td>
      </tr>
      <tr align="center">
        <td height="46" colspan="-2"><?php echo $items2[$typeclass][1]; ?></td>
        <td colspan="-2"><?php echo $score2_2; ?> ��</td>
      </tr>
      <tr align="center">
        <td height="38" colspan="-2"><?php echo $items2[$typeclass][2]; ?></td>
        <td colspan="-2"><?php echo $score2_3; ?> ��</td>
      </tr>
      <tr align="center">
        <td height="45" colspan="-2"><strong>�ϼƵ÷�<br />
        ��20�֣�</strong></td>
        <td colspan="-2"><strong><?php echo $score2; ?> ��</strong></td>
      </tr>
      <tr align="center">
        <td rowspan="5" align="center">��<br />
        ��<br />
        ��<br />
        ��<br />
        ��<br />
        ��<br />
        50<br />
        %</td>
        <td colspan="3" rowspan="5"><table width="406" height="222" border="0">
          <tr>
            <td height="130" align=left>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $comment3; ?></td>
          </tr>
          <tr>
          <td height="45">
            	<table width=100% border=0><tr>
            <td height="45" align=right id="qm3" style="position: absolute">���ίԱ�ᣨС�飩ǩ����</td>
               </tr></table>
          </tr>
          <tr>
            <td height="45" align="right"><?php echo $detail["qm3date"];?></td>
          </tr>
        </table></td>
        <td height="43" colspan="-2"><?php echo $items3[$typeclass][0]; ?></td>
        <td colspan="-2"><?php echo $score3_1; ?> ��</td>
      </tr>
      <tr align="center">
        <td height="44" colspan="-2"><?php echo $items3[$typeclass][1]; ?></td>
        <td colspan="-2"><?php echo $score3_2; ?> ��</td>
      </tr>
      <tr align="center">
        <td height="46" colspan="-2"><?php echo $items3[$typeclass][2]; ?></td>
        <td colspan="-2"><?php echo $score3_3; ?> ��</td>
      </tr>
<?php
if($typeclass==0){
?>      
      <tr align="center">
        <td height="44" colspan="-2"><?php echo $items3[$typeclass][3]; ?></td>
        <td colspan="-2"><?php echo $score3_4; ?> ��</td>
      </tr>
<?php
}
?>      
      <tr align="center">
        <td height="45" colspan="-2"><strong>�ϼƵ÷�<br />
        ��50�֣�</strong></td>
        <td colspan="-2"><strong><?php echo $score3; ?> ��</strong></td>
      </tr>
</table>
</td>
</tr>
<tr align=left>
<td height="145">
	<table width="630" height="145" border="1" style='font-size: 12pt;width:475.4pt;border-collapse:collapse;border:none;mso-border-alt:solid windowtext .5pt; mso-padding-alt:0cm 5.4pt 0cm 5.4pt;mso-border-insideh:.5pt solid windowtext;
 mso-border-insidev:.5pt solid windowtext' cellpadding="0" cellspacing="0" bordercolor="#000000">
      <tr align="center">
        <td width="44" height="143" align="center">��<br />
        ��<br />
        ��<br />
        ��</td>
        <td colspan="4"><table width="356" height="141" border="0">
          <tr>
            <td height="96" align=left>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $comment4; ?></td>
          </tr>
          <tr>
            <td height="45">
            	<table width=100% border=0><tr>
            	<td height="45" id="qm4" style="position: absolute">���ίԱ������ǩ���� �������� <?php echo $detail["qm4date"];?></td>
          		</tr></table>
        		</td>
          </tr>
        </table></td>
        <td width="38" align="center">��<br />
        ��<br />
        ��<br />
        ��</td>
        <td width="190" colspan="3">&nbsp;<table width="190" height="143" border="0">
          <tr>
            <td height="50%">&nbsp;�ȼ���<u>&nbsp;&nbsp;<?php echo $dengji[$ji]; ?>&nbsp;&nbsp;</u></td>
          </tr>
          <tr>
            <td height="50%">&nbsp;�ɼ���<u>&nbsp;&nbsp;&nbsp;<font size=+1><?php echo $totalscore; ?></font>&nbsp;&nbsp;&nbsp;</u></td>
          </tr>
        </table></td>
      </tr>
</table>
</td>
</tr>
<tr>
	<td align=center>
		ע��ָ����ʦ��������Ϊ30�֡����Ľ�ʦ��������Ϊ20�֡���������������Ϊ50�֡�
	</td>
</tr>
</table>
<?php
if($qianming){
	$basex = 230; $basey = 255;  //ָ����ʦǩ����
	$shift =  array(
							"py"	=>array(0,190), 	//���Ľ�ʦ��ָ����ʦ��ƫ��
							"db"	=>array(-170,330),//���С���ָ����ʦ��ƫ��
							"zr"	=>array(-20,570)	//������θ�ָ����ʦ��ƫ��
						);
$imgname = "qm/".$detail["teacher_id"].".png";	
if(file_exists($imgname)){	
	echo "<div id=qm1img style='position:absolute;'><img src=".$imgname." width=80> </div>";
	echo "<script language=javascript>
		document.all.qm1img.style.pixelLeft = document.getElementById('qm1').offsetLeft+40;
		document.all.qm1img.style.pixelTop = document.getElementById('qm1').offsetTop-10;
		</script>";
}

$imgname = "qm/".$detail["teacher2_id"].".png";	
if(file_exists($imgname)){
	echo "<div id=qm2img style='position:absolute;'><img src=".$imgname." width=80> </div>";
	echo "<script language=javascript>
		document.all.qm2img.style.pixelLeft = document.getElementById('qm2').offsetLeft+40;
		document.all.qm2img.style.pixelTop = document.getElementById('qm2').offsetTop-10;
		</script>";
}

$fenzulist = $detail["fenzulist"];
for($i=0,$j=1;$i<sizeof($fenzulist);$i++){
	$imgname = "qm/".$fenzulist[$i].".png";		
	if(file_exists($imgname))	{
		$j++;
		echo "<div id=qm3".$i."img style='position:absolute;'><img src=".$imgname." width=80> </div>";
		echo "<script language=javascript>
			document.all.qm3".$i."img.style.pixelLeft = document.getElementById('qm3').offsetLeft+".(0+($j%4)*90).";
			document.all.qm3".$i."img.style.pixelTop = document.getElementById('qm3').offsetTop-20+".((($j-$j%4)/4)*40).";
		</script>";
	}
}

$imgname = "qm/".$detail["dbzhuren"].".png";	
if(file_exists($imgname)){
	echo "<div id=qm4img style='position:absolute;'><img src=".$imgname." width=80> </div>";
	echo "<script language=javascript>
		document.all.qm4img.style.pixelLeft = document.getElementById('qm4').offsetLeft+150;
		document.all.qm4img.style.pixelTop = document.getElementById('qm4').offsetTop-16;
		</script>";
}

}
?>
<?php
}
?>
