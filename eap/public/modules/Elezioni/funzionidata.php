<?php
// *****************************************************************************************************************************
// Funzioni formattazione data e altro
// *****************************************************************************************************************************


function giorno($min,$max)
{
$giorno='';
if(!$min) $min='1';
if(!$max) $max='31';
$giorni=array();
for($x=$min;$x<=$max;$x++) $giorni[]=$x;
#$giorni= array('01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31');
foreach($giorni as $gi)
	$giorno .= "<option value=$gi>$gi</option>";
$giorno .= "</select>";
echo "$giorno";
}


function mese()
{
$mese='';
$mesi= array('01','02','03','04','05','06','07','08','09','10','11','12');
foreach($mesi as $me)
 	$mese .= "<option value=$me>$me </option>";
$mese .= "</select>";
echo "$mese";
}

function anno()
{
$anno ='';
$curr=date("Y",time());
$curr++;
$anni=array($curr--,$curr--,$curr--,$curr--,$curr--,$curr--,$curr--,$curr--,$curr--);
foreach($anni as $an)
	$anno .= "<option value=$an>$an</option>";
$anno .= "</select>";
echo "$anno";
}

function ore($min,$max)
{
$ora='';
$ore= array('00','01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24');
foreach($ore as $ori)
	$ora .= "<option value=$ori>$ori</option>";
$ora .= "</select>";
echo "$ora";
}


function minuti()
{
$minuto='';
$minuti= array('00','01','02','03','04','05','06','07','08','09','10','11','12','13','14',
'15', '16', '17', '18','19','20','21','22','23','24','25','26','27','28','29','30','31','32','33',
'34','35','36','37','38','39','40','41','42','43','44','45','46','47','48','49','50',
'51','52','53','54','55','56','57','58','59');
foreach($minuti as $minu)
 	$minuto .= "<option value=$minu>$minu </option>";
$minuto .= "</select>";
echo "$minuto";
}

function secondi()
{
$secondo='';
$secondi= array('00','01','02','03','04','05','06','07','08','09','10','11','12','13','14',
'15', '16', '17', '18','19','20','21','22','23','24','25','26','27','28','29','30','31','32','33',
'34','35','36','37','38','39','40','41','42','43','44','45','46','47','48','49','50',
'51','52','53','54','55','56','57','58','59');
foreach($secondi as $sec)
	$secondo .= "<option value=$sec>$sec</option>";
$secondo .= "</select>";
echo "$secondo";
}



function form_data($data)

	{
        list($anno,$mese,$giorno) = explode("-", $data) ;
        if ($giorno>0)
               return("$giorno-$mese-$anno");
        else
               return("&nbsp; ");
        }

	

?>
