<?php
include_once("modules/Elezioni/funzioni.php");
include_once("temi/inc/button.php");


########## no blocco x grafici e risultati
if (!isset($param['op'])) $param['op']='';
if($blocco!=1 || $param['op']=="graf_gruppo" || $param['op']=="gruppo_circo" || $param['op']=="gruppo_sezione"
|| $param['op']=="lista_circo" || $param['op']=="lista_sezione"  || $param['op']=="candidato_circo" || $param['op']=="candidato_sezione"
)$blocco=''; else $blocco=1;

$nometema=$tema;
####################################
function testata(){
####################################

global $nometema,$file,$bgcolor,$sitename,$dbi,$prefix,$blocco,$lang,$siteistat;
if (isset($param['id_comune'])) $id_comune=intval($param['id_comune']); else $id_comune=$siteistat;

$res = mysql_query("SELECT descrizione FROM ".$prefix."_ele_comuni where id_comune='$id_comune' ", $dbi);
	list($descr_com) = mysql_fetch_row($res);


// logo
echo ' 
<div id="header">
    <div id="logo">
        <h1>';
		echo "$descr_com";
echo '</a></h1>
	<b>consultazioni elettorali on line </b><br /> <a href="http://elezioni.comune.cosenza.it"> <i>by ESD - Comune di Cosenza</i></a>
	<br/><br/><br/>
	<div id="search">&nbsp;';
		language();
		flash();
		noblocco();
echo ' </div>

    </div>
</div>

';

// menu
echo '<div id="menu"><br/>';
	if ($file=="index") menu();

echo "</div>";

echo '
	 <div id="page">'; 
		echo "<table cellpadding=\"0\" cellspacing=\"0\"><tr>";

	 
          	$check=check_block("dx"); // check exist box
		
	if ($blocco=='1' && $check!=0){
		echo "<td valign=\"top\" class=\"sidebar\">";
    		block("dx");
		echo "</td><td>&nbsp;&nbsp;</td><td valign=\"top\">"; 
		
	}else { 
		echo "<td valign=\"top\">";
	}
		
}
function piede(){
	global $blocco;
	$check=check_block("sx"); // check exist box
	if ($blocco=='1' && $check!=0){
		echo "</td><td>&nbsp;&nbsp;</td><td valign=\"top\" class=\"sidebar\">";
    		block("sx");
		
	}
	echo "</td></tr></table>";
        echo "</div>"; #container

}		


?>
