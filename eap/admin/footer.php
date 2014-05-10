<?php
/************************************************************************/
/* Eleonline - Raccolta e diffusione dei dati elettorali                */
/* by Roberto Gigli & Luciano Apolito                                   */
/* http://www.eleonline.it                                              */
/* info@eleonline.it  luciano@aniene.net rgigli@libero.it               */
/************************************************************************/

$PHP_SELF=$_SERVER['PHP_SELF'];
if (preg_match("/footer.php/i",$PHP_SELF)) {
    Header("Location: admin.php");
    die();
}
echo "</td></tr><tr><td>";



/************************************************************************/
/*    LE SEGUENTI LINEE DI PROGRAMMA NON DEVONO ESSERE MODIFICATE       */
/************************************************************************/
echo "<table width=\"100%\"  border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
<tr bgcolor=\"#000000\"><td align=\"right\">
<b><font color=\"#ffffff\"><a href=\"http://www.eleonline.it\" target=\"eleonline\">

EAP vers.2.4 @2011 <img src=\"modules/Elezioni/images/ico.jpg\" border=\"0\" alt=\"Eleonline\" align=\"middle\"></a> "._GESTIONE." by ESD - Comune di Cosenza</font></b></td></tr></table>";
echo "</td></tr></table></div>";
echo "</body>\n"

."</html>";
die();
?>
