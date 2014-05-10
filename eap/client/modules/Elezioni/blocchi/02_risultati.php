<?php
/************************************************************************/
/* Eleonline - Raccolta e diffusione dei dati elettorali                */
/* by Luciano Apolito & Roberto Gigli                                   */
/* http://www.eleonline.it                                              */
/* info@eleonline.it  luciano@aniene.net rgigli@libero.it               */
/************************************************************************/
# lettura feed rss interno

if (!defined('MODULE_FILE')) {
    //die ("You can't access this file dirrectly...");
}

global $descr_cons,$circo,$genere;


if($genere!='0' && !$circo){ // referendum e circoscrizionali
    list ($gruppo,$pro)=grupporss();
    if ($gruppo!='')echo "<h5>Risultati </h5>";
    //$content .="<div style=\"text-align:left;\"><strong>$descr_cons</strong></div><br/>";
    echo "<table>";
    for($x=0;$x<count($gruppo);$x++){
	echo "<tr><td><strong><big>&middot;</big></strong></td><td>".$gruppo[$x]." </td><td  align=\"right\"><b><span style=\"color:#ff0000;\">".$pro[$x] ."%</span></b></td></tr>\n";
    }
    echo "</table>";

  //echo $content;
}




?>
