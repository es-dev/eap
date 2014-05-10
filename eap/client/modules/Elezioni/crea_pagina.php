<?php

/************************************************************************/
/* Eleonline - Raccolta e diffusione dei dati elettorali                */
/* by Luciano Apolito & Roberto Gigli                                   */
/* http://www.eleonline.it                                              */
/* info@eleonline.it  luciano@aniene.net rgigli@libero.it               */
/************************************************************************/

//testa_riga[contenuto in posizione 0][y]
//testa_colonna[x][contenuto in posizione 0]
//corpo[da 1 a x][da 1 a y]

if (!defined('MODULE_FILE')) {
    die ("You can't access this file directly...");
}


function crea_tabella($ar) {


global $prefix,$dbi,$pdf,$csv,$xls,$lang,$descr_cons,$prefix,$dbi,$id_comune,$descrizione,$siteistat,$pagina,$min,$offset,$minsez,$offsetsez,$datipdf;
$res = mysql_query("SELECT descrizione FROM ".$prefix."_ele_comuni where id_comune='$id_comune' ", $dbi);
	list($descr_com) = mysql_fetch_row($res);

$datipdf=stripslashes($datipdf);
$data=date("d-m-y G:i");

if ($xls==1) {
	
	$nomefile="export.xls";
	header ("Content-Type: application/vnd.ms-excel");
	header ("Content-Disposition: inline; filename=$nomefile");

$datipdf=str_replace("<br/>","\n",$datipdf);

$datipdf=strip_tags($datipdf);
			$cella=str_replace("</b>"," ",$cella);
			$cella=str_replace("<br />"," ",$cella);

echo "$datipdf";

	$y=1;$i='';$e='';
		foreach ($ar as $riga) {
		$e++;
                        if($y) {
				echo "\n";
			}else{
				
				echo "\n";
				
			}

			
			foreach ($riga as $cella) {
			$cella=str_replace("<b>"," ",$cella);
			$cella=str_replace("</b>"," ",$cella);
			$cella=str_replace("<br />"," ",$cella);
			$cella=str_replace("<span class=\"red\"><i>"," - ",$cella);
			$cella=str_replace("</span>%</i>","%",$cella);
			$cella=str_replace("_CIRCOS","Circoscrizione ",$cella);
			$cella=str_replace("_SEZIONI","Sezione ",$cella);
			$cella=str_replace("_TOT","Totale",$cella);
			$cella=str_replace("_COMPLESSIVO","Complessivo",$cella);
			 			
				echo "$cella \t";
					
				
			}
			if ($y) $y=0;
			
		}

	    echo"\n\n\nPowered by Eleonline http://www.eleonline.it \t \n";	
	    echo"by l.apolito & r.gigli - stampato: $data \t \n";
	    die();

}else{

  

	$bg='bgw';
	
	$tmpbg='bggray2'; 
	$tmpbg1='bgw';
	$tmpbg2='bggray';
	$tmpbg3='bggray2';
	
	$html ='';
	if ($pdf!="1" && $csv=="1")
	{
	
	$html .="<table style=\"margin: auto;\" cellspace=0 border=0 cellpadding=0><tr><td border=0>
		<img src=\"modules.php?name=Elezioni&amp;file=foto&amp;id_comune=".$id_comune."\" align=\"left\" alt=\"logo\" /></td> ";
	$html .= "<td border=0>$datipdf</td></tr></table><br/><br/>";
        }


	
	$html .= "<table class=\"table-docs\" cellspacing=\"0\" cellpadding=\"2\" border=\"1\" rules=\"all\">";
	



		$y=1;$i='';$e='';
		foreach ($ar as $riga) {
		$e++;
			if($y) {
				$html .= "<tr class=\"bggray\">";
			}else{
				$bg= ($bg==$tmpbg) ? $tmpbg1:$tmpbg3;				  
				$html .= "<tr class=\"$bg\">";
				$i="class=\"td-130c\"";
			}
			foreach ($riga as $cella) {

			$cella=str_replace("_CIRCOS","Circoscrizione ",$cella);
			$cella=str_replace("_SEZIONI","Sezione ",$cella);
			$cella=str_replace("_TOT","Totale",$cella);
			$cella=str_replace("_COMPLESSIVO","",$cella);

			 if ($e==1){ 
				$t="<td";$f="</td>";
			}else{ 
				$t="<td";$f="</td>";	
			}					
				$html .= "$t $i>$cella $f";
					$i='';
				
			}
			if ($y) $y=0;
			$html .= "</tr>";
		}
		$html .= "</table>";


		if ($pdf!="1" && $csv=="1"){
		      $html .="<br/><span class=\"copy\"><i>Stampato: $data</i></span>";
		      $html .="<br/><span class=\"copy\"><i>Eleonline by l. apolito & r. gigli - www.eleonline.it</i></span>";
		      $html .="</td></tr></table>";
		}

	    # inizio stampa a video o pdf


		if ($pdf!='1'){
		  echo $html;
	        }else{

	      #pdf
	      /*
	      require('inc/pdf/html2fpdf.php');
	      //Istanzio la classe
	      $fpdf=new HTML2FPDF('L','mm','A4');

	      //Creo la pagina
	      $fpdf->AddPage();

	      //Per leggere il file html usare fread
	      $content = "<b>Testo in neretto</b>";
	      $fpdf->Image('modules/Elezioni/images/logo.jpg',10,10,10,0,'','http://www.eleonline.it');
	      //Scrivo l'html nel file pdf
	      $fpdf->WriteHTML($html);
	      //Scrivo il file sample.pdf
	      $fpdf->Output();

	      //include("modules/Elezioni/printpdf.php");
	      //PrintPage($html);
	      */
$style ="     
<style type=\"text/css\">
<!--
.table-docs {
	font-size: 10px;
	padding: 1px;
	color: #000000;
	/* margin: 4px 4px 40px;*/
	border: solid  #666666;
	text-align:center;
}
.bggray 	{
	background: #d2d2d2; 
	FONT-SIZE: 13px; 
	FONT-FAMILY: Helvetica;
	border: 1px;
}

.bggray2 	{
	background: #EFEFEF; 
	FONT-SIZE: 13px; 
	FONT-FAMILY: Helvetica;
	border: 1px;
	}

bggray3 	{
	background: #EFEFEF; 
	FONT-SIZE: 10px; 
	FONT-FAMILY:  Helvetica;
	text-align: left
	}

.bgw	{
	background: #ffffff; 
	FONT-SIZE: 13px; 
	FONT-FAMILY: Helvetica;
	border: 1px;
	
}
.td-130 {
	float: right;
	margin: 0px 0 0 1px;
	width: 130px;	
	border: none;
	background-color: #d2d2d2;
	padding: 0px;
	
}
.td-130c {
	float: right;
	text-align:left;
	margin: 0px 0 0 1px;
	width: 130px;	
	border: none;
	padding: 0px;
}		

td {
    border: .2px;
}
.red 	{
	BACKGROUND: none; 
	COLOR: #ff0000; 
	FONT-SIZE: 12px; 
	FONT-FAMILY:  Helvetica
}
.copy 	{
	background: #d2d2d2; 
	FONT-SIZE: 8px; 
	FONT-FAMILY: Helvetica;
	border: 1px;
}
.cen {
margin: 10px auto 0 auto; 
}
-->
</style>";







	$style .="<table style=\"margin: auto;\" cellspace=0 border=0 cellpadding=0><tr><td border=0><img src=\"modules/Elezioni/images/logo.gif\" align=\"left\" /></td> ";	
	
	$style .= "<td border=0>$datipdf</td></tr></table><br/><br/>";
	$style .=$html;
        $style .= "<table style=\"margin: auto;\" cellspace=0 border=0 cellpadding=0><tr><td border=0>";

	$data=date("d-m-y G:i");
	$style .="<br/><span class=\"copy\"><i>Stampato il $data</i></span>";
	$style .="<br/><span class=\"copy\"><i>Eleonline by lucianoapolito & roberto gigli - www.eleonline.it</i></span>";
	$style .="</td></tr></table>";
	// conversion HTML => PDF
	require_once('inc/hpdf/html2pdf.class.php');
	$html2pdf = new HTML2PDF('L','A4', 'it');
	$html2pdf->WriteHTML($style, isset($_GET['vuehtml']));
	$html2pdf->Output();



	      }

	


   }
}





?>
