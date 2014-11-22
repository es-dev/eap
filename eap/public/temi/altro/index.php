<?php
/************************************************************************/
/* Eleonline - Raccolta e diffusione dei dati elettorali                */
/* by Roberto Gigli & Luciano Apolito                                   */
/* http://www.eleonline.it                                              */
/* info@eleonline.it  luciano@aniene.net rgigli@libero.it               */
/************************************************************************/

// tema
$bgcolor="#b0b0b0";
$nometema=$tema;
function testata($tema){
global $nometema,$id_comune,$id_cons_gen,$aid,$dbi,$prefix;
$nometema=$tema;
$res_com = mysql_query("SELECT descrizione FROM ".$prefix."_ele_comuni where id_comune='$id_comune'",$dbi);
$res_cons = mysql_query("SELECT descrizione FROM ".$prefix."_ele_consultazione where id_cons_gen='$id_cons_gen'",$dbi);
list($descr_comune) = mysql_fetch_row($res_com);
list($descr_consultazione) = mysql_fetch_row($res_cons);

echo "<div class=\"container\"><table width=\"95%\"  border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"table-main\">
<tr><td bgcolor=\"#000000\"><font color=\"#ffffff\"><b>"._COMUNE." "._DI." $descr_comune  $descr_consultazione "; 
if ($aid) echo "["._UTENTE.":<font color=\"#ffff00\">$aid</font>]";
echo "</b></font></td></tr></table>";
echo "<table  width=\"95%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"table-main\">
<tr> <td align=\"left\" valign=\"top\" colspan=\"2\">";
    

}

function piede(){


}



// end
?>
