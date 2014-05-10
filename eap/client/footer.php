<?php
/************************************************************************/
/* Eleonline - Raccolta e diffusione dei dati elettorali                */
/* by Luciano Apolito & Roberto Gigli                                   */
/* http://www.eleonline.it                                              */
/* info@eleonline.it  luciano@aniene.net rgigli@libero.it               */
/************************************************************************/
global $csv;
if (!$csv)
piede();
$PHP_SELF=$_SERVER['PHP_SELF'];
if (stristr($PHP_SELF,"footer.php")) {
    Header("Location: index.php");
    die();
}

echo "<table><tr align=\"center\"><td>
<div> "._INVIOSEGN." <a href=\"modules.php?name=Elezioni&amp;file=index&amp;op=contatti\"> "._CLICCAQUI."</a> "; 


/************************************************************************/
/*    LE SEGUENTI LINEE DI PROGRAMMA NON DEVONO ESSERE MODIFICATE       */
/************************************************************************/

 echo "<br />[<a href=\"http://elezioni.comune.cosenza.it\"><b>EAP-2.4</b></a> - "._GESRIS." ]
";
echo '</div>

<!-- w3c -->
	<div class="w3cbutton3">
  		<a href="http://www.w3.org/WAI/WCAG1AA-Conformance" title="pagina di spiegazione degli standard">
    		<span class="w3c">W3C</span>
    		<span class="spec">WAI-<span class="specRed">AA</span></span>
  		</a>
	</div>
	<div class="w3cbutton3">
  		<a href="http://jigsaw.w3.org/css-validator/" title="Validatore css">
		<span class="w3c">W3C</span>
    		<span class="spec">CSS</span>
  		</a>
	</div>
	<div class="w3cbutton3">
  		<a href="http://validator.w3.org/" title="Validatore XHTML ">
    		<span class="w3c">W3C</span>
    		<span class="spec">XHTML 1.0</span>
		</a>
	</div>
</td></tr></table>';
echo "</body>\n"
."</html>";
die();
?>

