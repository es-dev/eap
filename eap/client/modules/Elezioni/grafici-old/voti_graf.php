<?php
/************************************************************************/
/* Eleonline - Raccolta e diffusione dei dati elettorali                */
/* by Luciano Apolito & Roberto Gigli                                   */
/* http://www.eleonline.it                                              */
/* info@eleonline.it  luciano@aniene.net rgigli@libero.it               */
/************************************************************************/

include ("jpgraph.php");
include ("jpgraph_pie.php");

$a=$_GET['a'];$b=$_GET['b'];$c=$_GET['c'];$d=$_GET['d'];
$a1=$_GET['a1'];$b1=$_GET['b1'];$c1=$_GET['c1'];$d1=$_GET['d1'];
$titolo=$_GET['titolo'];
$cop=$_GET['cop'];
$logo=$_GET['logo'];
$data = array($a,$b,$c,$d);
$legend = array("$a $a1","$b $b1", "$c $c1", "$d $d1");
$graph = new PieGraph(300,200,"auto");
$graph->SetShadow();



$graph->title->Set($titolo);
$graph->title->SetFont(FF_FONT1,FS_BOLD);
$graph ->legend->Pos( 0.05,0.65,"left" ,"center");
//$graph->SetBackgroundGradient('white','yellow',GRAD_HOR,BGRAD_MARGIN);


$txt =new Text("$cop");
//$txt =new Text("$siteistat");
$txt->Pos( 2,180);
$txt->SetColor( "red");
$graph->AddText( $txt);
if(isset($logo)) $graph->SetBackgroundImage("../images/".$logo.".png",BGIMG_COPY);
else $graph->SetBackgroundImage("../images/vuoto.jpg",BGIMG_COPY);
// black-white
//$graph->AdjBackgroundImage(0.4,0.3,-1);

$p1 = new PiePlot($data);
$p1->SetLabelType(PIE_VALUE_PER);
$p1->value->SetFormat('');
$p1->value->Show();
$p1->SetLegends($legend);
$p1->SetCenter(0.7,0.4);

$graph->Add($p1);
$graph->Stroke();






$graph->Add($p1);
$graph->Stroke();





?>


