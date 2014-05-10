<?php
/************************************************************************/
/* Eleonline - Raccolta e diffusione dei dati elettorali                */
/* by Luciano Apolito & Roberto Gigli                                   */
/* http://www.eleonline.it                                              */
/* info@eleonline.it  luciano@aniene.net rgigli@libero.it               */
/************************************************************************/

include ("jpgraph.php");
include ("jpgraph_bar.php");


$dati1=$_GET['dati1'];$dati2=$_GET['dati2'];$i=$_GET['i'];$l=$_GET['l'];$w=$_GET['w'];
$titolo=$_GET['titolo'];$descr=$_GET['descr'];$cop=$_GET['cop'];
$logo=$_GET['logo'];
$datay=unserialize(stripslashes($dati1)); // percentuali
$datax=unserialize(stripslashes($dati2)); // candidati


// $i= numero candidati
// $larghezza label
if (!isset($l)) $l=180;
if (!isset($w)) $w=500;
if ($l=='') $l=180;
if ($w=='') $w=500;

//$datay=array(2,3,5,8,12,6,3);
//$datax=array("Jan","Feb","Mar","Apr","May","Jun","Jul");

//$datay=$pro;
//$datax=$pro;
// Size of graph
$width=$w;
$height=$i*30;

// Set the basic parameters of the graph
$graph = new Graph($width,$height,'auto');
$graph->SetScale("textlin");

$top = 50;
$bottom = 80;
$left = $l;
$right = 40;
$graph->Set90AndMargin($left,$right,$top,$bottom);
#if(isset($logo)) $graph->SetBackgroundImage("../images/".$logo.".png",BGIMG_COPY);
#else 
$graph->SetBackgroundImage("../images/vuoto.jpg",BGIMG_COPY);
// Nice shadow
$graph->SetShadow();

// Setup title
$graph->title->Set("$titolo");
$graph->title->SetFont(FF_FONT1,FS_BOLD,10);
$graph->subtitle->Set("$descr");

// Setup X-axis
$graph->xaxis->SetTickLabels($datax);
$graph->xaxis->SetFont(FF_FONT1,FS_BOLD,8);
$graph->xaxis->SetColor("black","darkred");
// Some extra margin looks nicer
$graph->xaxis->SetLabelMargin(5);

// Label align for X-axis
$graph->xaxis->SetLabelAlign('right','center');

// Add some grace to y-axis so the bars doesn't go
// all the way to the end of the plot area
$graph->yaxis->scale->SetGrace(20);

// Setup the Y-axis to be displayed in the bottom of the
// graph. We also finetune the exact layout of the title,
// ticks and labels to make them look nice.
$graph->yaxis->SetPos('max');

// First make the labels look right
$graph->yaxis->SetLabelAlign('center','top');
$graph->yaxis->SetLabelFormat('%d');
$graph->yaxis->SetLabelSide(SIDE_RIGHT);

// The fix the tick marks
$graph->yaxis->SetTickSide(SIDE_LEFT);

// Finally setup the title
$graph->yaxis->SetTitleSide(SIDE_RIGHT);
$graph->yaxis->SetTitleMargin(35);

// To align the title to the right use :
$graph->yaxis->SetTitle("$cop",'high');
$graph->yaxis->title->Align('right');
$graph->yaxis->SetColor("black","darkred");
// To center the title use :
//$graph->yaxis->SetTitle('Turnaround 2002','center');
//$graph->yaxis->title->Align('center');

$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD,12);
$graph->yaxis->title->SetAngle(0);



$graph->yaxis->SetFont(FF_FONT2,FS_NORMAL);
// If you want the labels at an angle other than 0 or 90
// you need to use TTF fonts
//$graph->yaxis->SetLabelAngle(0);

/*
// testo
$txt =new Text("$cop");
$txt->Pos( 100,$i*29);
$txt->SetColor( "red");
$graph->AddText( $txt);
*/








// Now create a bar pot
$bplot = new BarPlot($datay);
$bplot->SetFillColor("orange");
$bplot->SetShadow();

//You can change the width of the bars if you like
$bplot->SetWidth(0.1);

// We want to display the value of each bar at the top
$bplot->value->Show();
$bplot->value->SetFont(FF_FONT1,FS_BOLD,12);
$bplot->value->SetAlign('left','center');
$bplot->value->SetColor("black","darkred");
$bplot->value->SetFormat('%.2f perc');

// Add the bar to the graph
$graph->Add($bplot);


$graph->Stroke();
?>
