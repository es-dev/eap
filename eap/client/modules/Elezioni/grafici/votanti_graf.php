<?php
/************************************************************************/
/* Eleonline - Raccolta e diffusione dei dati elettorali                */
/* by Luciano Apolito & Roberto Gigli                                   */
/* http://www.eleonline.it                                              */
/* info@eleonline.it  luciano@aniene.net rgigli@libero.it               */
/************************************************************************/

include ("jpgraph.php");
include ("jpgraph_pie.php");

$e=$_GET['e'];$f=$_GET['f'];$e1=$_GET['e1'];$f1=$_GET['f1'];
$titolo=$_GET['titolo'];
if (isset($_GET['cop'])) $cop=$_GET['cop'];else $cop='';
if (isset($_GET['x'])) $dim_x=$_GET['x']; else $dim_x='350';
if (isset($_GET['y'])) $dim_y=$_GET['y']; else $dim_y='200';
if (isset($_GET['logo'])) $logo=$_GET['logo'];else $logo='';
$data = array($e,$f);
$legend = array("$e $e1","$f $f1");
$graph = new PieGraph($dim_x,$dim_y,"auto");
$graph->SetShadow();

$graph->title->Set($titolo);
$graph->title->SetFont(FF_FONT1,FS_BOLD);
$graph ->legend->Pos( 0.05,0.75,"left" ,"center");
/*
if(isset($logo)){
      if (file_exists("../images/".$logo.".png")) {
	  $graph->SetBackgroundImage("../images/".$logo.".png",BGIMG_COPY);
      }else{
	  else $graph->SetBackgroundImage("../images/vuoto.jpg",BGIMG_COPY);
}
*/
// testo
/*
$txt =new Text("$cop");
$txt->SetFont(FF_FONT1,FS_BOLD);
//$txt->Pos(0.5,0.97,'center','bottom');
$txt->SetBox('yellow','black'); 
$txt->Pos( 2,2,'center');
$txt->SetColor( "black");

$graph->AddText( $txt);

*/
$graph->SetBackgroundGradient('white','yellow',GRAD_HOR,BGRAD_MARGIN);

$p1 = new PiePlot($data);
$p1->value->SetFormat('');
$p1->value->Show();
$p1->SetLegends($legend);
$p1->SetCenter(0.4,0.5);

$graph->Add($p1);
$graph->Stroke();

?>


