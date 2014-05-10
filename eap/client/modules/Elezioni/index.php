<?php
/************************************************************************/
/* Eleonline - Raccolta e diffusione dei dati elettorali                */
/* by Luciano Apolito & Roberto Gigli                                   */
/* http://www.eleonline.it                                              */
/* info@eleonline.it  luciano@aniene.net rgigli@libero.it               */
/************************************************************************/
/* Ultima modifica 22 maggio 2009 luc - candidati europee */

if (!defined('MODULE_FILE')) {
    die ("Non puoi accedere al file direttamente...");
}

$param=strtolower($_SERVER['REQUEST_METHOD']) == 'get' ?
	$_GET : $_POST;


if (isset($param['rss'])) $rss=intval($param['rss']); else $rss='0';
if (isset($param['xls'])) $xls=intval($param['xls']); else $xls='0';
if (isset($param['pdf'])) $pdf=intval($param['pdf']); else $pdf='0';
if (isset($param['datipdf'])) get_magic_quotes_gpc() ? $datipdf=$param['datipdf']:$datipdf=addslashes($param['datipdf']); else $datipdf='';
if(isset($param['visgralista'])) $visgralista=1;
if (isset($param['id_comune'])) $id_comune=intval($param['id_comune']); else $id_comune=$siteistat;
if (isset($param['id_cons_gen'])) $id_cons_gen=intval($param['id_cons_gen']); else 
{
        $res = mysql_query("SELECT id_cons_gen FROM ".$prefix."_ele_cons_comune where id_cons='$id_cons_pred' ", $dbi);
        list($id_cons_gen)=mysql_fetch_row($res);
}
if (isset($param['op'])) $op=$param['op']; else $op='';
if (isset($param['minsez'])) $minsez=intval($param['minsez']); else $minsez='';
if (isset($param['id_lista'])) $id_lista=intval($param['id_lista']); else $id_lista='';
if (isset($param['id_circ'])) $id_circ=intval($param['id_circ']); else $id_circ='0';
if (isset($param['csv'])) $csv=intval($param['csv']); else $csv='';
if (isset($param['min'])) $min=intval($param['min']); else $min= 0;
if (isset($param['orvert'])) $orvert=intval($param['orvert']); else $orvert='';
if (isset($param['offset'])) $offset=intval($param['offset']); else $offset='';
if (isset($param['offsetsez'])) $offsetsez=intval($param['offsetsez']); else $offsetsez='';
if (isset($param['perc'])) $perc=$param['perc']; else $perc='';
if (isset($param['info'])) get_magic_quotes_gpc() ? $info=$param['info']:$info=addslashes($param['info']); else $info='';
if (isset($param['files'])) get_magic_quotes_gpc() ? $files=$param['files']:$files=addslashes($param['files']); else $files='';
if (isset($param['voti_lista'])) $voti_lista=intval($param['voti_lista']); else $voti_lista= 0;
if (isset($param['perc_lista'])) $perc_lista=$param['perc_lista']; else $perc_lista= 0;
if (isset($param['lettera'])) get_magic_quotes_gpc() ? $lettera=$param['lettera']:$lettera=addslashes($param['lettera']); else $lettera='';
if (isset($param['ordine'])) get_magic_quotes_gpc() ? $ordine=$param['ordine']:$ordine=addslashes($param['ordine']); else $ordine='';
if (isset($param['id_gruppo'])) $id_gruppo=intval($param['id_gruppo']); else $id_gruppo='';
if (isset($param['tipo_cons'])) $tipo_cons=intval($param['tipo_cons']); else $tipo_cons='';
if (isset($param['descr_circ'])) $descr_circ=intval($param['descr_circ']); else $descr_circ='';


# anti-xss nov. 2009 
$id_comune=htmlentities($id_comune); 
$id_comune=intval($id_comune); 
$perc=htmlentities($perc); 
$perc_lista=floatval($perc_lista); 
#$datipdf= htmlentities($datipdf); 
$op= htmlentities($op); 
$info= htmlentities($info); 
$files=htmlentities($files); 
$lettera=htmlentities($lettera); 
$ordine=htmlentities($ordine); 

$res = mysql_query("SELECT id_conf FROM ".$prefix."_ele_cons_comune where id_cons_gen='$id_cons_gen' and id_comune='$id_comune'" , $dbi);
list($hondt) = mysql_fetch_row($res);

$sql = "SELECT t3.genere,t1.tipo_cons,t1.descrizione,t2.id_cons_gen FROM ".$prefix."_ele_consultazione as t1, ".$prefix."_ele_cons_comune as t2, ".$prefix."_ele_tipo as t3 where t1.tipo_cons=t3.tipo_cons and t2.id_comune=$id_comune and t1.id_cons_gen=t2.id_cons_gen and t2.id_cons_gen='$id_cons_gen' and t2.chiusa!='2' ";
$res = mysql_query("$sql",$dbi);
$tot=mysql_num_rows($res);
if ($tot>0 and $id_cons_gen>0) {
	$sql = "SELECT t3.genere,t1.tipo_cons,t1.descrizione,t2.id_cons_gen FROM ".$prefix."_ele_consultazione as t1, ".$prefix."_ele_cons_comune as t2, ".$prefix."_ele_tipo as t3 where t1.tipo_cons=t3.tipo_cons and t2.id_comune=$id_comune and t1.id_cons_gen=t2.id_cons_gen and t2.id_cons_gen='$id_cons_gen' and t2.chiusa!='2'";
}else{
	$sql = "SELECT t3.genere,t1.tipo_cons,t1.descrizione,t2.id_cons_gen FROM ".$prefix."_ele_consultazione as t1, ".$prefix."_ele_cons_comune as t2, ".$prefix."_ele_tipo as t3 where t1.tipo_cons=t3.tipo_cons and t2.id_comune=$id_comune and t1.id_cons_gen=t2.id_cons_gen and t2.chiusa!='2' order by t1.data_fine desc limit 0,1 ";
}
$res = mysql_query("$sql",$dbi);
if ($res) list($genere,$tipo_cons,$descr_cons,$id_cons_gen) = mysql_fetch_row($res);

if ($tipo_cons!=3) $limite=0;

$res = mysql_query("SELECT t2.id_cons FROM ".$prefix."_ele_consultazione as t1, ".$prefix."_ele_cons_comune as t2 where t1.id_cons_gen=t2.id_cons_gen and t2.id_cons_gen='$id_cons_gen' and t2.id_comune='$id_comune'" , $dbi);
list($id_cons) = mysql_fetch_row($res);

$res = mysql_query("SELECT t1.descrizione, t1.tipo_cons, t2.genere, t2.voto_g, t2.voto_l, t2.voto_c, t2.circo FROM ".$prefix."_ele_consultazione as t1,".$prefix."_ele_tipo as t2 where t1.tipo_cons=t2.tipo_cons and t1.id_cons_gen='$id_cons_gen' ", $dbi);
list($descr_cons,$tipo_cons,$genere,$votog,$votol,$votoc,$circo) = mysql_fetch_row($res);

// esiste consultazione e toglie blocco nel caso non esista
$res = mysql_query("SELECT t1.id_cons_gen,t1.descrizione FROM ".$prefix."_ele_consultazione as t1, ".$prefix."_ele_cons_comune as t2 where t1.id_cons_gen=t2.id_cons_gen and t2.id_comune='$id_comune' and t2.chiusa!='2' order by t1.data_fine desc" , $dbi); 
	$esiste_cons=mysql_num_rows($res);
	if($esiste_cons<='0')$blocco=0;

//carica limite e fascia per il comune
$res = mysql_query("SELECT limite FROM ".$prefix."_ele_conf where id_conf='$hondt'" , $dbi);
list($limite) = mysql_fetch_row($res);
$res = mysql_query("SELECT fascia FROM ".$prefix."_ele_comuni where id_comune='$id_comune' ", $dbi);
list($fascia) = mysql_fetch_row($res);
if(!$id_circ){		
$res = mysql_query("SELECT id_circ FROM ".$prefix."_ele_circoscrizione where id_cons='$id_cons limit 0,1 order num_circ asc' ", $dbi);
list($id_circ) = mysql_fetch_row($res);
}

// rss oppure foglio elettronico
if ($rss!=1   && $xls!=1 && $pdf!=1){ 
    $index = 1;
    include("header.php");
    if($csv!=1){
	include_once("modules/Elezioni/funzioni.php");
	
	$res = mysql_query("SELECT descrizione,simbolo FROM ".$prefix."_ele_comuni where id_comune='$id_comune' ", $dbi);
	list($descr_com,$simbolo) = mysql_fetch_row($res);
        $descr_com =stripslashes($descr_com); 
	echo "<table width=\"100%\"><tr><td>";
	$siteistat=$id_comune;
	if($simbolo!=''){
	echo "<img src=\"modules.php?name=Elezioni&amp;file=foto&amp;id_comune=".$id_comune."\" alt=\"logo\" />";
	}else{
	echo "<img src=\"modules/Elezioni/images/logo.gif\" alt=\"logo\" />";
	}



	//echo "<img src=\"modules.php?name=Elezioni&amp;file=foto&amp;id_comune=".$id_comune."\" alt=\"mappa\" />";
        echo "</td><td> "._COMUNE."<b> $descr_com </b><br />
	"._RISULTA." "._CONSULTA."<h1>$descr_cons</h1>";

			if ($circo){ // elenco per scelta circoscrizione
				echo "</td></tr><tr><td></td><td  class=\"bggray\"><table class=\"table-80\"><tr><td class=\"table-main\"><form id=\"circo\" method=\"post\" action=\"modules.php\">";
				$res_sez = mysql_query("SELECT id_circ,descrizione,num_circ from ".$prefix."_ele_circoscrizione where id_cons=$id_cons",$dbi);
				echo "<input type=\"hidden\" name=\"pagina\" value=\"modules.php?name=Elezioni&amp;op=$op&amp;id_cons_gen=$id_cons_gen&amp;id_comune=$id_comune&amp;info=$info&amp;id_circ=\"></input>";
				echo ""._SCELTA_CIR.":<b> 
				<select name=\"id_circ\" class=\"blu\" onChange=\"top.location.href=this.form.pagina.value+this.form.id_circ.options[this.form.id_circ.selectedIndex].value;return false\">";
				while(list($id_rif,$descrizione,$num_cir)=mysql_fetch_row($res_sez)) {
					if (!$id_circ) $id_circ=$id_rif;
					$sel = ($id_rif == $id_circ) ? "selected=\"selected\"" : "";
					echo "<option value=\"$id_rif\" $sel>";
					for ($j=strlen($num_cir);$j<2;$j++) { echo "&nbsp;&nbsp;";}
					echo "$num_cir) ".$descrizione."</option>";
				}
				echo "</select></b></form></td></tr></table>";
			
			}
	echo ""._DISCLAIMER."";
	echo  "</td></tr></table>";
      }
  }

if (!isset($min)) $min=0;

/************************
Funzione Menu a cascata
*************************/
function menu() {
	global $hondt,$lang,$multicomune, $tema, $op, $prefix, $dbi, $offset, $min,$descr_cons,$info,$dati, $votog,$votol,$votoc,$circo, $id_cons,$tipo_cons,$genere,$descr_cons,$id_cons_gen,$id_comune,$id_circ,$minsez,$offsetsez, $limite,$hondt,$tema_on,$js,$visgralista;

$tema=htmlentities($tema); //xss        
# include menu da tema
if (file_exists("temi/$tema/menu.php")) {
	  include_once("temi/$tema/menu.php");
    }else{
	include_once("modules/Elezioni/menu.php");
}

}



/********************************************
Funzione Come si vota, link, numeri e servizi
visuallizza la stringa dei dati generali
********************************************/

function come($info) {
global  $prefix, $dbi, $offset, $min,$id_cons,$tipo_cons,$descr_cons;

$tab='';
if ($info=="come") $tab="_ele_come";
elseif ($info=="numeri") $tab="_ele_numeri";
elseif ($info=="servizi") $tab="_ele_servizi";
elseif ($info=="link") $tab="_ele_link";
else $tab="_ele_come";


    global  $user, $admin, $cookie, $textcolor2, $prefix, $dbi;
     $result = mysql_query("select mid, title, preamble, content,editimage from ".$prefix."$tab where id_cons='$id_cons' order by mid ", $dbi);
    if (mysql_num_rows($result) == 0) {
	return;
    } else {
	while (list($mid, $title, $preamble,$content,  $editimage) = mysql_fetch_row($result)) {
  	if ($title != "" && $content != "") {
               
                if ($info=="link"){
			
			echo "<div class=\"message\">
			<b><a href=\"$preamble\">$title</a></b>
			$content
			</div>";
			
		}else{
			echo "<div><b>$title</b><br /></div>";
                
		
		echo "<div class=\"message\">$preamble<br /><br /></div>";
		
		echo "<div class=\"message\">$content</div>";
		}
		
		echo "<br />";

	}
    }
 }

}



/****************
Funzione dati Generali
visuallizza la stringa dei dati generali
****************/


function dati() {
/*Funzione di visualizzazione dati generali                  */
	global $admin, $prefix, $dbi, $offset, $votog, $votol, $votoc, $circo, $min,$id_cons,$tipo_cons,$descr_cons,$id_cons_gen,$id_comune,$genere,$id_circ;
	
	$res = mysql_query("select * from ".$prefix."_ele_circoscrizione where id_cons='$id_cons' ",$dbi);
	$ressede = mysql_query("select * from ".$prefix."_ele_sede where id_cons='$id_cons' ",$dbi);
	$res3 = mysql_query("select * from ".$prefix."_ele_sezioni where id_cons='$id_cons' ",$dbi);
	$circo = mysql_num_rows($res);
	$sedi = mysql_num_rows($ressede);
	$sez = mysql_num_rows($res3);
		
	echo "<div><b>"._DATIG."</b></div> ";
	echo "<table class=\"table-80\"><tr class=\"bggray\">";
	echo "<td ><b>"._AVENTI."</b></td>"
	."<td ><b>"._MASCHI."</b></td>"
	."<td ><b>"._FEMMINE."</b></td>";
	if ($circo>1)
		echo "<td ><b><a href=\"modules.php?name=Elezioni&amp;op=circo&amp;id_cons_gen=$id_cons_gen&amp;id_comune=$id_comune\">"._CIRCS."</a></b></td>";
	else	
		echo "<td ><b><a href=\"modules.php?name=Elezioni&amp;op=circo&amp;id_cons_gen=$id_cons_gen&amp;id_comune=$id_comune\">"._SEDI."</a></b></td>";
	echo "<td><b><a href=\"modules.php?name=Elezioni&amp;op=sezione&amp;id_cons_gen=$id_cons_gen&amp;id_comune=$id_comune\">"._SEZIONI."</a></b></td>"
	."<td ><b><a href=\"modules.php?name=Elezioni&amp;op=gruppo&amp;id_cons_gen=$id_cons_gen&amp;id_comune=$id_comune&amp;id_circ=$id_circ\">"._GRUPPI."</a></b></td>";
        
        
	
	
	
	

	$candi=0;
	
	// se non referendum
	if ($genere>0 and !$votoc){
		echo "<td><b><a href=\"modules.php?name=Elezioni&amp;op=candi&amp;id_cons_gen=$id_cons_gen&amp;id_comune=$id_comune\">"._CANDIDATI."</a></b></td>";
		$res1 = mysql_query("select id_cons from ".$prefix."_ele_candidati where id_cons='$id_cons' ",$dbi);
		$candi = mysql_num_rows($res1);
	}
	// se non europee (non liste e candidati)
	if ($genere!=4){
		$res2 = mysql_query("select id_cons from ".$prefix."_ele_gruppo where id_cons='$id_cons' ",$dbi);
	}else{
		$res2 = mysql_query("select id_cons from ".$prefix."_ele_lista where id_cons='$id_cons' ",$dbi);
	}
	
	$gruppo = mysql_num_rows($res2);
        
	// camera e senato con raggruppamenti
	if($votog){
	 echo "<td><b><a href=\"modules.php?name=Elezioni&amp;op=liste&amp;id_cons_gen=$id_cons_gen&amp;id_comune=$id_comune\">"._LISTE."</a></b></td>";
	 $res3 = mysql_query("select * from ".$prefix."_ele_lista where id_cons='$id_cons' ",$dbi);
         $liste = mysql_num_rows($res3);
	}
	
	if($circo==1) $circo=$sedi;
	$res4 = mysql_query("select sum(maschi),sum(femmine), sum(maschi+femmine)  from ".$prefix."_ele_sezioni where id_cons=$id_cons", $dbi);
 	if($res4) list($maschi,$femmine,$tot) = mysql_fetch_row($res4);
 	echo "</tr><tr class=\"bggray2\">"

	."<td><b>$tot</b>"
	."</td><td><b>$maschi</b>"
	."</td><td><b>$femmine</b>"
	."</td><td><b>$circo</b>"
	."</td><td><b>$sez</b>"
	."</td><td><b>$gruppo</b>";

	if ($genere>2 && !$votog) echo"</td><td><b>$candi</b>";
	
//        if ($tipo_cons >9) echo"</td><td><b>$liste</b>";
        if ($votog) echo"</td><td><b>$liste</b>";
	echo "</td></tr></table>";
	//CloseTable();
}
//////////////////////////////////////////////////////////////
// votanti
//////////////////////////////////////////////////////////////



function circo() {

/******************************************************/
/*Funzione di visualizzazione sede                    */
/*****************************************************/
    global $admin, $prefix, $dbi, $offset, $min,$id_cons,$file,$id_cons_gen,$id_comune ,$prev,$next;
    $res = mysql_query("SELECT * FROM ".$prefix."_ele_circoscrizione where id_cons='$id_cons'  ", $dbi);
    $max = mysql_num_rows($res);
    
    //OpenTable();
    
    dati();
    
    
    $offset=10;
    if (!isset($min)) $min=0;
    $go="circo";
    
    $result = mysql_query("select * from ".$prefix."_ele_circoscrizione where id_cons='$id_cons'  ORDER BY num_circ 
    LIMIT $min,$offset", $dbi);
$numcirc=mysql_num_rows($result);
if ($numcirc>1){
  	echo "<div><b>"._CIRCS."</b></div><br /><br />
	<table class=\"table-80\"><tr class=\"bggray\">"
	."<td ><b>"._NUM."</b></td>"
	."<td ><b>"._CIRCO."</b></td>"
	."<td ><b>"._INDIRIZZO."</b></td>"
	."<td><b>"._TEL."</b></td></tr>";
}else{
  	echo "<div><b></b></div><br /><br />
	<table class=\"table-80\"><tr class=\"bggray\">"
	."<td ><b>"._INDIRIZZO."</b></td>"
	."<td><b>"._TEL."</b></td></tr>";
}
     
	while(list($id_cons2,$id_circ,$num_circ,$descr_circ) = mysql_fetch_row($result)) {
#if($numcirc==1) {$descr_circ=''; $num_circ='';}
     	if (!($num_circ===0)) {
     		
		echo "<tr class=\"bggray3\">";
		if ($numcirc>1) {
		echo "<td><b>$num_circ</b>"
		."</td><td><b>";
		echo "<a href=\"modules.php?name=Elezioni&amp;op=sezione&amp;id_cons_gen=$id_cons_gen&amp;id_comune=$id_comune&amp;id_circ=$id_circ&amp;descr_circ=$descr_circ\">$descr_circ</a></b></td>";
		}
       
       // dati sede
		$result1 = mysql_query("select id_sede,indirizzo,telefono1,telefono2, mappa, filemappa from ".$prefix."_ele_sede where id_cons='$id_cons' and id_circ='$id_circ'", $dbi);
		$righe=mysql_num_rows($result1);$i=0;
        	while(list($id_sede,$indir,$tel1,$tel2,$mappa,$filemappa)=mysql_fetch_row($result1)){
		
        	$i++;
		echo "<td><b><a href=\"modules.php?name=Elezioni&amp;op=sezione&amp;id_cons_gen=$id_cons_gen&amp;id_comune=$id_comune&amp;id_sede=$id_sede\">$indir</a></b>"
		."</td><td><b>$tel1 </b></td><td><b>  $tel2</b></td></tr>";

	      	if ($i<$righe) echo"<tr class=\"bggray3\">";
	      	if ($numcirc>1) echo "<td></td><td></td>";

	}
    }
  }
    echo "</table>";
    
    page($id_cons_gen,$go,$max,$min,$prev,$next,$offset,$file);

//CloseTable();
}

/******************************************************/
/*Funzione di visualizzazione globale sezioni         */
/*****************************************************/

function sezione() {
   global $admin, $prefix, $dbi, $offset, $min,$votog,$circo, $id_cons_gen,$id_circ,$descr_circ,$id_cons,$file,$prev,$next,$id_comune,$googlemaps;

 if(!isset($_GET['id_circ'])) unset($id_circ);
 dati();
 $totali_t=0;$maschi_t=0;$femmine_t=0;
 $param=strtolower($_SERVER['REQUEST_METHOD']) == 'get' ? $_GET : $_POST;
 //mappa
if (isset($param['id_sede'])) $id_sede=intval($param['id_sede']); else $id_sede='0';
 if ($id_sede!='0' && $googlemaps!='1'){
 echo "<br /><div><img src=\"modules.php?name=Elezioni&amp;file=foto&amp;id_sede=".$id_sede."\" alt=\"mappa\" /></div>";
 }elseif($id_sede!='0' && $googlemaps=='1'){
    $mappa=googlemaps(); echo $mappa;
 } 

  $offset=15;
  if (!isset($min)) $min=0;
  if (!isset($id_circ)) $id_circ=0;
 $go="sezione";
 $res2 = mysql_query("SELECT descrizione FROM ".$prefix."_ele_circoscrizione where id_cons='$id_cons'", $dbi);
	$numcirc = mysql_num_rows($res2);
$res2 = mysql_query("SELECT descrizione FROM ".$prefix."_ele_circoscrizione where id_cons='$id_cons' AND id_circ='$id_circ' ", $dbi);
	list($descr_circ) = mysql_fetch_row($res2);
if($numcirc>1){
   echo "<div><b>"._SEZIONI." "; 
   if ($id_circ) echo "di $descr_circ";
   if ($id_sede) echo _SINGOLA;
   echo "</b></div>";
   }
   echo "<br />"
    ."<table class=\"table-80\"><tr class=\"bggray\">"
	."<td class=\"td-5\"><b>"._NUM."</b></td>"
	."<td ><b>"._INDIRIZZO."</b></td>"
	."<td class=\"td-5\"><b>"._MASCHI."</b></td>"
	."<td class=\"td-5\"><b>"._FEMMINE."</b></td>"
	."<td><b>"._TOTS." "._AVENTI."</b></td></tr>";
    // link alle sedi
    
    // link alle circoscrizioni
    
    if ($id_circ) { 
	
    	$res1  = mysql_query("SELECT id_sede FROM ".$prefix."_ele_sede where id_cons='$id_cons' and id_circ='$id_circ' ", $dbi);
    	//$max = mysql_num_rows($res);
        $i=0;// n. sezioni x circo
    	while(list($id_sede) = mysql_fetch_row($res1)){
	
       		$circos=" AND id_sede='$id_sede'";
    		$res = mysql_query("SELECT * FROM ".$prefix."_ele_sezioni where id_cons='$id_cons' $circos ", $dbi);
    		//$tot_sez = mysql_num_rows($res);
   		$result = mysql_query("select id_cons,id_sez,id_sede,num_sez, maschi, femmine  from ".$prefix."_ele_sezioni where id_cons='$id_cons' $circos ORDER BY num_sez  LIMIT $min,$offset", $dbi);
    		
		while(list($id_cons2,$id_sez,$id_sede,$num_sez, $maschi, $femmine) = mysql_fetch_row($result)) {
        		// dati circoscrizione
			$i++;
			$result1 = mysql_query("select indirizzo from ".$prefix."_ele_sede where id_sede='$id_sede'", $dbi);
        		list($indir)=mysql_fetch_row($result1);
        		
			$totali=$maschi+$femmine;
			$totali_t=$totali_t+$totali;
			$maschi_t=$maschi_t+$maschi;
			$femmine_t=$femmine_t+$femmine;
			echo "<tr><td><b>$num_sez</b>"
			."</td><td><b><a href=\"modules.php?name=Elezioni&amp;op=sezione&amp;id_cons_gen=$id_cons_gen&amp;id_comune=$id_comune&amp;id_sede=$id_sede\">$indir</a></b>"
			."</td><td >$maschi"
			."</td><td >$femmine"
			."</td><td ><b>$totali</b></td></tr>";
    		}
    			
	}
	echo "<tr class=\"bggray2\" ><td>"._SEZIONI."<br />n. $i</td>
		<td><b>"._TOT."<br />$descr_circ</b>
		</td><td ><b>"._MASCHI."<br /><span class=\"red\">$maschi_t</span></b>
		</td><td ><b>"._FEMMINE."<br /><span class=\"red\">$femmine_t</span></b></td>
		<td ><b>"._TOTS."<br /><span class=\"red\">$totali_t</span></b></td></tr>";
     echo "</table></center>";
     }else{
    $circos='';
    if ($id_sede) $circos=" AND id_sede='$id_sede'";
     
    $res = mysql_query("SELECT * FROM ".$prefix."_ele_sezioni where id_cons='$id_cons' $circos ", $dbi);
    $max = mysql_num_rows($res);
    $result = mysql_query("select id_cons,id_sez,id_sede,num_sez, maschi, femmine  from ".$prefix."_ele_sezioni where id_cons='$id_cons' $circos ORDER BY num_sez  LIMIT $min,$offset", $dbi);
    
    while(list($id_cons2,$id_sez,$id_sed,$num_sez, $maschi, $femmine) = mysql_fetch_row($result)) {
        
	// dati circoscrizione
	$result1 = mysql_query("select indirizzo from ".$prefix."_ele_sede where id_sede='$id_sed'", $dbi);
        list($indir)=mysql_fetch_row($result1);
        $totali=$maschi+$femmine;
	$totali_t=$totali_t+$totali;
	$maschi_t=$maschi_t+$maschi;
	$femmine_t=$femmine_t+$femmine;
	echo "<tr class=\"bggray2\"><td><b>$num_sez</b>"
	."</td><td><b><a href=\"modules.php?name=Elezioni&amp;op=sezione&amp;id_cons_gen=$id_cons_gen&amp;id_comune=$id_comune&amp;id_sede=$id_sed\"><img class=\"nobordo\" src=\"modules/Elezioni/images/mappa.gif\" align=\"left\">
$indir</a></b>"
	."</td><td>$maschi"
	."</td><td>$femmine"
	."</td><td><b>$totali</b></td></tr>";
    }
    if($id_sede)echo "<tr class=\"bggray\"><td><br /><br /></td>
		<td><b>"._TOTS."<br />$indir</b>
		</td><td ><b>"._MASCHI."<br /><span class=\"red\">$maschi_t</span></b>
		</td><td ><b>"._FEMMINE."<br /><span class=\"red\">$femmine_t</span></b></td>
		<td ><b>"._TOTS."<br /><span class=\"red\">$totali_t</span></b></td></tr>";
    
    echo "</table>";

}
	if(!isset($max)) $max=0; 
     page($id_cons_gen,$go,$max,$min,$prev,$next,$offset,$file);


//CloseTable();
}



/******************************************************/
/*Funzione di visualizzazione globale    gruppo             */
/*****************************************************/

function gruppo() {
   global $fascia, $limite, $admin, $prefix, $dbi, $offset, $min, $id_cons_gen,$genere, $id_cons,$tipo_cons,$file,$prev,$next,$id_circ,$id_comune,$descr_circ,$id_sez,$votog,$votol,$circo,$limite;
   	//dati();
	// definizione variabile per button 'ok' nei form
	$button="<input name=\"vai\" type=\"image\" src=\"modules/Elezioni/images/ok2.jpg\" alt=\"ok\" title=\"ok\" />";

   // numero sezioni scrutinate sul gruppo
	// Verificare per la circoscrizione
	if ($genere==0) {$tab="ref";}else{$tab="gruppo";}
	if ($votog or $genere==4) {$tab="lista";}else{$tab="gruppo";}
	if($circo){
		if(!$id_circ){
		$res = mysql_query("select id_circ from ".$prefix."_ele_circoscrizione where id_cons='$id_cons' limit 0,1", $dbi);
		list($id_circ)=mysql_fetch_row($res);
		}
		 $res = mysql_query("select t1.id_sez,sum(t1.voti)  from ".$prefix."_ele_voti_$tab as t1, ".$prefix."_ele_$tab as t2 where t1.id_$tab=t2.id_$tab and t1.id_cons='$id_cons' and t2.id_circ='$id_circ' group by t1.id_sez", $dbi);	
	}else $res = mysql_query("select *  from ".$prefix."_ele_voti_".$tab." where id_cons='$id_cons'  group by id_sez having sum(voti)>0 ",$dbi);
	$numero=mysql_num_rows($res);
	if($circo) $circos="and id_circ='$id_circ'"; else $circos='';
	
	if($circo) $res = mysql_query("select *  from ".$prefix."_ele_sezioni as t1, ".$prefix."_ele_sede as t2 where t1.id_sede=t2.id_sede and t1.id_cons='$id_cons' and t2.id_circ=$id_circ",$dbi);
	else $res = mysql_query("select *  from ".$prefix."_ele_sezioni where id_cons='$id_cons' $circos ",$dbi);
	$sezioni=mysql_num_rows($res);
	if ($numero!=0) 
	echo "<div><h2>"._SEZSCRU." $numero "._SU." $sezioni</h2></div>";
	

	
	
	
	
		
	$offset=15;
  	if (!isset($min)) $min=0;
  	$go="gruppo";
   if(!$votog and $genere!=4)	echo "<div><h2><b>"._GRUPPO." </b><br /></h2></div>";
/*   
   	if ($circo){ // circoscrizione
   		echo "<form id=\"yesy\" method=\"post\" action=\"modules.php\">";
   		echo "<div><input type=\"hidden\" name=\"pagina\" value=\"modules.php?name=Elezioni&amp;op=gruppo&amp;id_cons_gen=$id_cons_gen&amp;id_comune=$id_comune&amp;id_circ=\" />";
		echo " <input type=\"hidden\" name=\"name\" value=\"Elezioni\" />
      			<input type=\"hidden\" name=\"op\" value=\"gruppo\" />
      			<input type=\"hidden\" name=\"id_cons_gen\" value=\"$id_cons_gen\" />
       			<input type=\"hidden\" name=\"id_comune\" value=\"$id_comune\" />
       			<input type=\"hidden\" name=\"file\" value=\"index\" />";
   		
		$res_sez = mysql_query("SELECT id_circ,descrizione,num_circ from ".$prefix."_ele_circoscrizione where id_cons=$id_cons",$dbi);
		echo "<span class=\"bggray\">"._SCELTA_CIR.":</span> 
			<select name=\"id_circ\">"; 
			while(list($id_rif,$descr_circ,$num_cir)=mysql_fetch_row($res_sez)) {
					if (!$id_circ) $id_circ=$id_rif;
					$sel = ($id_rif == $id_circ) ? "selected=\"selected\"" : "";
					echo "<option value=\"$id_rif\" $sel>";
					for ($j=strlen($num_cir);$j<2;$j++) { echo "&nbsp;&nbsp;";}
					echo $num_cir.") ".$descr_circ."</option>";
				}
				echo "</select> $button </div></form>";
			
		
			
	}
*/   
	if ($genere!=4){
	    $circos='';
	    $circol='';    
		// numero sezioni scrutinate per lista
  		if ($circo){$circos="and id_circ='$id_circ'";$circol="and t2.id_circ='$id_circ'";}


	      
		$res_num_list = mysql_query("select t1.id_sez,sum(t1.voti)  from ".$prefix."_ele_voti_lista as t1, ".$prefix."_ele_lista as t2 where t1.id_lista=t2.id_lista and t1.id_cons='$id_cons' $circol group by t1.id_sez",$dbi);
        	//$res_num_list = mysql_query("select *  from ".$prefix."_ele_voti_lista where id_cons='$id_cons' group by id_sez ",$dbi);
		$numero_l=mysql_num_rows($res_num_list);
		// verifica delle sezioni in relazione ai candidati (comuni >=15000)  non c'e' il voto di lista e quindi ci metto se scrutinate le preferenze sulla lista [$numero_c] - 5/5/2009
		$res_num_list = mysql_query("select *  from ".$prefix."_ele_voti_candidati where id_cons='$id_cons' group by id_sez ",$dbi);
		$numero_c=mysql_num_rows($res_num_list);
      
		$sezioni_l=$sezioni;
		
		
		$res = mysql_query("SELECT * FROM ".$prefix."_ele_gruppo where id_cons='$id_cons' $circos ", $dbi);
    		$max = mysql_num_rows($res);
		
		
		if (!$votog){
                if ($circo) $t_circos=" and t2.id_circ='$id_circ'"; else $t_circos=''; 
		$res_pres_tutti = mysql_query("select sum(t1.voti)  from ".$prefix."_ele_voti_gruppo as t1 , ".$prefix."_ele_gruppo as t2 where t1.id_gruppo=t2.id_gruppo and t1.id_cons='$id_cons' $t_circos ", $dbi);
		// sommatoria dei voti di lista per camera e senato dal 2006 per coalizioni-->byluc 
		}else{ 
		$res_pres_tutti = mysql_query("select sum(voti)  from ".$prefix."_ele_voti_lista where id_cons='$id_cons'", $dbi);
		}
		
		list($voti_pres_tutti) = mysql_fetch_row($res_pres_tutti);
######gestione percentuali
		$arval=array();$arperc=array();
			if ($genere>0){ // no referendum 
				if (!$votog){ // no camere e senato per coalizioni 
					$res_presidente = mysql_query("select sum(voti),id_gruppo from ".$prefix."_ele_voti_gruppo where id_cons='$id_cons' group by id_gruppo", $dbi);
				
				}else{ // sommatoria voti lista per coalizione per camere e senato
					$res_presidente = mysql_query("select sum(t1.voti),t2.id_gruppo  from ".$prefix."_ele_voti_lista as t1 , ".$prefix."_ele_lista as t2 where t1.id_lista=t2.id_lista and t1.id_cons='$id_cons' group by t2.id_gruppo", $dbi);
				}
    			while(list($voti_pres,$id_gruppo2) = mysql_fetch_row($res_presidente)) {
    				$arval[$id_gruppo2]=$voti_pres;
    			}
    			$arperc=arrayperc($arval,$voti_pres_tutti);
    		}
#######		
		$result = mysql_query("select id_cons ,id_gruppo ,num_gruppo, descrizione from ".$prefix."_ele_gruppo where id_cons='$id_cons' $circos ORDER BY num_gruppo  LIMIT $min,$offset", $dbi);
		while(list($id_cons2,$id_gruppo2,$num_gruppo, $descr_gruppo) = mysql_fetch_row($result)) {
  		   if ($num_gruppo!=0) {
	           echo "<table  class=\"table-80\">
				<tr>"
				."<td class=\"td-5\"><b>"._NUM."</b></td>"
				."<td class=\"bggray\"><b>"._DESCR."</b></td>"
				."<td class=\"td-5\"><b>"._SIMBOLO."</b></td>
				</tr>";
			
			
			if ($genere>0){ // no referendum 
				if (!$votog){ // no camere e senato per coalizioni 
					$res_presidente = mysql_query("select sum(voti)  from ".$prefix."_ele_voti_gruppo  where id_cons='$id_cons' and id_gruppo='$id_gruppo2'", $dbi);
				
				}else{ // sommatoria voti lista per coalizione per camere e senato
					$res_presidente = mysql_query("select sum(t1.voti)  from ".$prefix."_ele_voti_lista as t1 , ".$prefix."_ele_lista as t2 where t1.id_lista=t2.id_lista and t1.id_cons='$id_cons' and t2.id_gruppo='$id_gruppo2'", $dbi);
				}
				list($voti_pres) = mysql_fetch_row($res_presidente);
				
				
				if ($voti_pres_tutti!=0){
					$perc_pres=number_format($arperc[$id_gruppo2],2); 
					$var1="<h2>voti: $voti_pres <span class=\"redbig\"> $perc_pres </span>%</h2>";	
				}else {$var1="";}
				
			
			
			}else{ //referendum
				$res_ref = mysql_query("select sum(si),sum(no),sum(validi),sum(bianchi),sum(nulli),sum(contestati)   from ".$prefix."_ele_voti_ref where id_cons='$id_cons' and id_gruppo='$id_gruppo2'", $dbi);
		 		list($voti_si,$voti_no,$validi,$bianchi,$nulli,$conte) = mysql_fetch_row($res_ref);
				
				
				$aff=mysql_query("select orario,data from ".$prefix."_ele_rilaff where id_cons_gen='$id_cons_gen' order by data desc ", $dbi);
				list($ora,$data) = mysql_fetch_row($aff);
				
				
				$tot_rel =mysql_query("select sum(voti_uomini+voti_donne) from ".$prefix."_ele_voti_parziale where id_cons='$id_cons' and orario='$ora' and data='$data' and id_gruppo='$id_gruppo2'", $dbi);
				list($tot_relativo) = mysql_fetch_row($tot_rel);
				
				
				// totale assoluto
				$tot_ass =mysql_query("select sum(maschi+femmine) from ".$prefix."_ele_sezioni where id_cons='$id_cons'", $dbi);
				list($tot_assoluto) = mysql_fetch_row($tot_ass);
				  // controlli del 15 giugno 2009 
				if($tot_assoluto)
				      $perc_tot=number_format(($tot_relativo*100)/$tot_assoluto,2);
				      else $perc_tot=0;
				
				$tot_ref=0;$tot_ref=$voti_si+$voti_no;
				if($tot_ref){
				$perc_si=number_format(($voti_si*100)/$tot_ref,2);
				$perc_no=number_format(($voti_no*100)/$tot_ref,2);
				}else{ $perc_si=0;$perc_no=0;}

				
				
				
				$var1="<table class=\"table-80\">
					<tr>
					<td class=\"redbig\">
				<h2>percentuale affluenze:<span class=\"redbig\"> $perc_tot% </span></h2></td>
					</tr>";
				
				
				$var1 .="<tr>
					<td><h1>SI: $voti_si <span class=\"redbig\"> $perc_si </span>%</h1></td>
					</tr>
					<tr>
					<td><h1>NO: $voti_no<span class=\"redbig\"> $perc_no </span>% 
				</h1></td>
					</tr>
				</table>";
				
			}
			
			
			
			
			
			echo "<tr>
			<td class=\"bggray\"><h1><b>$num_gruppo</b></h1></td>
			<td class=\"table-main\"><h1>$descr_gruppo</h1> $var1</td>
			<td><b><img class=\"stemma\" src=\"modules.php?name=Elezioni&amp;file=foto&amp;id_gruppo=$id_gruppo2\"   alt=\"immagine $descr_gruppo\" /></b></td>";
			echo "</tr>
			</table>";
			
			
			//Liste collegate
			if ($numero!=0 and !$votol and $genere>1) 
			// verifica delle sezioni in relazione ai candidati (comuni >=15000  $LIMIT>=4 non c'e' il voto di lista 5/5/2009

			if ($genere!=2 && $fascia>$limite)
			      echo "<div><h6>Liste:"._SEZSCRU." $numero_l "._SU." $sezioni_l</h6></div>";
			else
			    if(!$circo and $votog) // non per le circoscrizionali, senato e camera
			      echo "<div><h6>"._SEZSCRU." $numero_c "._SU." $sezioni_l</h6></div>";
			
			
			echo "<table class=\"table-80\"><tr>";
			$result2 = mysql_query("select id_cons ,id_lista ,num_lista, descrizione  from ".$prefix."_ele_lista where id_cons='$id_cons' and id_gruppo='$id_gruppo2'  ORDER BY num_lista " , $dbi);
			$i=0;
			while(list($id_cons2,$id_lista2,$num_lista, $descr_lista) = mysql_fetch_row($result2)) {
  				if ($num_lista!=0) {
			
				$res_lista = mysql_query("select sum(voti)  from ".$prefix."_ele_voti_lista where id_cons='$id_cons' and id_lista='$id_lista2'", $dbi);
		 		list($voti_lista) = mysql_fetch_row($res_lista);
			
				
			        // calcolo della percentuale
				if ($circo){ // circoscrizioni
					$voti_lista_tutti='';
					
					$res_circ = mysql_query("select id_lista from ".$prefix."_ele_lista where id_circ='$id_circ'", $dbi);
		 			while(list($lista_id) = mysql_fetch_row($res_circ)){
					
					  $res_circ_voti = mysql_query("select sum(voti)  from ".$prefix."_ele_voti_lista where id_lista='$lista_id'", $dbi);
					  list($voti) = mysql_fetch_row($res_circ_voti);
					 $voti_lista_tutti=$voti_lista_tutti+$voti;
					  //	
					}
					
				}else{
				
				// tutti 
					$res_lista_tutti = mysql_query("select sum(voti)  from ".$prefix."_ele_voti_lista where id_cons='$id_cons'", $dbi);
					list($voti_lista_tutti) = mysql_fetch_row($res_lista_tutti);
				}
				
				
				
				if($voti_lista_tutti!=0){
					$perc_lista=number_format(($voti_lista*100)/$voti_lista_tutti,5); 
					$perc_lista=number_format($perc_lista,3);// add luc 11 feb 2007
				}else{ 
					$perc_lista='';
				}
				
				
				
					
				$i++;
				echo "<td class=\"table-main\"><a href=\"modules.php?name=Elezioni&amp;id_gruppo=$id_gruppo2&amp;id_circ=$id_circ&amp;id_cons_gen=$id_cons_gen&amp;id_lista=$id_lista2&amp;op=partiti&amp;voti_lista=$voti_lista&amp;perc_lista=$perc_lista&amp;id_comune=$id_comune\">
				<img class=\"stemma\" src=\"modules.php?name=Elezioni&amp;file=foto&amp;id_lista=$id_lista2\"  alt=\"\" /><br />N. $num_lista  $descr_lista";
				
				if ($voti_lista) echo "<br />voti: $voti_lista ";
				// tolta momentaneamnete per le circ
				if ($perc_lista) echo "<span class=\"red\"> $perc_lista </span>%";
				
				echo "</a></td>";
				}
				if (($i%3) ==0) echo "</tr><tr>";
			}
			
			if (($i%3) !=0)echo "</tr></table>";else echo "<td></td></tr></table>";
					
		    }
	    }	
	echo "";
	
	
	
	
	
	
	}else{
		// tot liste
		$res = mysql_query("SELECT *  FROM ".$prefix."_ele_lista where id_cons='$id_cons' $circos ", $dbi);
    		$max = mysql_num_rows($res);
		
		// tot voti liste
		if($circo)$res_lista_tutti = mysql_query("select sum(t1.voti)  from ".$prefix."_ele_voti_lista as t1, ".$prefix."_ele_lista as t2 where t1.id_lista=t2.id_lista and t1.id_cons='$id_cons' and t2.id_circ='$id_circ'", $dbi);
		else $res_lista_tutti = mysql_query("select sum(voti)  from ".$prefix."_ele_voti_lista where id_cons='$id_cons'", $dbi);
		
		list($voti_lista_tutti) = mysql_fetch_row($res_lista_tutti);
		
    		$result = mysql_query("select id_cons ,id_lista ,num_lista, descrizione  from ".$prefix."_ele_lista where id_cons='$id_cons' $circos ORDER BY num_lista  LIMIT $min,$offset", $dbi);
		while(list($id_cons2,$id_lista,$num_lista, $descr_lista) = mysql_fetch_row($result)) {
  		if ($num_lista!=0) {
		// voti lista
		$res_lista = mysql_query("select sum(voti)  from ".$prefix."_ele_voti_lista where id_cons='$id_cons' and id_lista='$id_lista'", $dbi);
		list($voti_lista) = mysql_fetch_row($res_lista);
		if($voti_lista_tutti)
			$perc_lista=number_format(($voti_lista*100)/$voti_lista_tutti,5);
		else $perc_lista=0;
		$perc_lista=number_format($perc_lista,2);
		echo "<table  class=\"table-80\">
				<tr>"
				."<td class=\"td-5\"><b>"._NUM."</b></td>"
				."<td class=\"bggray\"><b>"._DESCR."</b></td>"
				."<td class=\"td-5\"><b>"._SIMBOLO."</b></td>
				</tr>";
			echo "<tr><td class=\"bggray\"><h1><b>$num_lista</b></h1></td>
			<td class=\"table-main\"><h1>$descr_lista<br />
			voti: $voti_lista <span class=\"redbig\">$perc_lista %</span></h1>";
			echo "</td><td><a href=\"modules.php?name=Elezioni&amp;id_cons_gen=$id_cons_gen&amp;id_lista=$id_lista&amp;op=partiti&amp;voti_lista=$voti_lista&amp;perc_lista=$perc_lista&amp;id_comune=$id_comune\">
			<img class=\"stemma\" src=\"modules.php?name=Elezioni&amp;file=foto&amp;id_lista=$id_lista\"  alt=\"$descr_lista\" /></a>";
			echo "</td></tr></table>";
		}
	}
    //echo "</table>";
    }
    
    

      page($id_cons_gen,$go,$max,$min,$prev,$next,$offset,$file);

//CloseTable();
}

function partiti(){
// visualizza i dati di lista con i candidati

global $genere,$admin, $prefix, $dbi, $offset, $min, $id_cons_gen,$votog,$votol,$circo, $id_cons,$tipo_cons,$file,$prev,$next,$id_circ,$id_comune,$id_lista,$id_gruppo,$voti_lista,$perc_lista;
 


 
  //dati();
  
  		if ($circo==1){
		 $res_circ = mysql_query("select descrizione,num_circ  from ".$prefix."_ele_circoscrizione where id_circ='$id_circ'", $dbi);
		 list($descr_circ,$num_circ)=mysql_fetch_row($res_circ);
		 if($num_circ) echo "<center><h1>"._CIRC_N." $num_circ: $descr_circ</h1>";
		 # numero sezioni
		 
		 }
		 
		 if ($genere!=4){
		  $res_gruppo = mysql_query("select descrizione  from ".$prefix."_ele_gruppo where id_gruppo='$id_gruppo'", $dbi);
		 list($descr_gruppo)=mysql_fetch_row($res_gruppo);
		
		 }
  
  // numero sezioni scrutinate, escluse circorscrizioni (da aggiungere)
                if ($circo!=1){
  			if ($votog) {$tab="lista";}else{$tab="candidati";}
			$res1 = mysql_query("select *  from ".$prefix."_ele_voti_".$tab." where id_cons='$id_cons' group by id_sez ",$dbi);
			$numero=mysql_num_rows($res1);
			$res2 = mysql_query("select *  from ".$prefix."_ele_sezioni where id_cons='$id_cons'",$dbi);
			$sezioni=mysql_num_rows($res2);
		}
  
  
  
    	         
		 
		 
		 
		 //$result = mysql_query("select id_cons ,id_lista ,num_lista, descrizione  from ".$prefix."_ele_lista where id_lista='$id_lista'", $dbi);
		 	
    		$result = mysql_query("select id_cons ,id_lista ,num_lista, descrizione  from ".$prefix."_ele_lista where id_lista='$id_lista'", $dbi);
		
		list($id_cons2,$id_lista,$num_lista, $descr_lista) = mysql_fetch_row($result);
		
		
	#	if ($numero!=0) echo "<center><h2>"._SEZSCRU." $numero "._SU." $sezioni</h2></center>";
		echo " <center><h5>"._LISTA." Numero : <font color=\"red\">$num_lista</font><br /></h5>";
		
		
		echo "<img src=\"modules.php?name=Elezioni&amp;file=foto&amp;id_lista=$id_lista\" width=\"50\" heigth=\"50\" align=\"middle\"><h2> $descr_lista</h2><br />";
		if ($voti_lista OR $perc_lista){ echo "<h5>
		Voti: <font color=\"red\">$voti_lista</font> "._PERC.": <font color=\"red\">$perc_lista %</font><br /></h5>";
		}
		echo "<center>"._GRUPPO."<h1> $descr_gruppo</h1>";
		 
		 
			
  		
		
		echo "<table width=\"60%\">";
  		// candidati con voti ottenuti
		
		$res_candi = mysql_query("SELECT t1.id_cand , t1.cognome, t1.nome, t1.num_cand, t2.id_cand, sum(t2.voti) as somma  FROM ".$prefix."_ele_candidati as t1 , ".$prefix."_ele_voti_candidati as t2
		where t1.id_lista='$id_lista' and  t1.id_cand=t2.id_cand  group by t1.id_cand order by somma desc" , $dbi);
  		//$res_candi = mysql_query("SELECT id_cand , cognome, nome, num_cand  FROM ".$prefix."_ele_candidati 
		//where id_lista='$id_lista'  and id_cons='$id_cons order by num_cand" , $dbi);
		$num_candi=mysql_num_rows($res_candi);
	        if (!$num_candi) {
		$res_candi = mysql_query("SELECT id_cand , cognome, nome, num_cand  FROM ".$prefix."_ele_candidati 
		where id_lista='$id_lista'  and id_cons='$id_cons' order by num_cand" , $dbi);
		echo "<tr bgcolor=\"#EAEAEA\"><td >Numero</td><td>Candidato</td></tr>";
		while(list($id_cand,$cognome,$nome, $num) = mysql_fetch_row($res_candi)) {
			
			echo "<tr><td>[ $num ]</td><td> $cognome $nome</td>";
		}
		}else{	
		echo "<tr bgcolor=\"#EAEAEA\"><td >Numero</td><td>"._CANDIDATO."</td><td>"._PREFERENZE."</td></tr>";
		while(list($id_cand,$cognome,$nome, $num,$id_cand, $somma) = mysql_fetch_row($res_candi)) {
			
			echo "<tr><td>[ $num ]</td><td>
			<a href=\"modules.php?name=Elezioni&amp;id_cons_gen=$id_cons_gen&amp;id_comune=$id_comune&amp;op=candidato_sezione&amp;min=$num&amp;offset=$num&amp;id_lista=$id_lista&amp;orvert=1&amp;offsetsez=$sezioni&id_circ=$id_circ\">
			$cognome $nome</a></td><td> $somma</td>";
		}
			
			
			
			
			
			echo "</tr>";
			}
		echo "</table>";
	}

	
// funzione visualizzazione delle liste per camera e senato con raggruppamenti/coalizioni
function liste(){
global $id_cons,$id_cons_gen,$prefix,$dbi,$min,$offset,$op,$tipo_cons,$prev,$next,$votog,$votol,$circo;
//dati();
$offset=10;
if (!isset($min)) $min=0;

// numero sezioni scrutinate sul gruppo
	if ($circo) $circos = "and id_circ=$id_circ" ; else $circos='';
	if ($genere==0) $tab="ref"; else $tab="gruppo";
	$res = mysql_query("select *  from ".$prefix."_ele_voti_".$tab." where id_cons='$id_cons'  $circos group by id_sez ",$dbi);
	$numero=mysql_num_rows($res);
	$res = mysql_query("select *  from ".$prefix."_ele_sezioni where id_cons='$id_cons' $circos ",$dbi);
	$sezioni=mysql_num_rows($res);
	if ($numero!=0) 
	echo "<div><h2>"._SEZSCRU." $numero "._SU." $sezioni</h2></div>";
	
	echo "<div><h1>"._LISTE."</h1></div><br /><br />";
	


	
	// tot liste
		$res = mysql_query("SELECT *  FROM ".$prefix."_ele_lista where id_cons='$id_cons'  ", $dbi);
    		$max = mysql_num_rows($res);
		
		// tot voti liste
		$res_lista_tutti = mysql_query("select sum(voti)  from ".$prefix."_ele_voti_lista where id_cons='$id_cons'", $dbi);
		list($voti_lista_tutti) = mysql_fetch_row($res_lista_tutti);
		
    		$result = mysql_query("select id_cons ,id_lista ,id_gruppo, num_lista, descrizione  from ".$prefix."_ele_lista where id_cons='$id_cons'  ORDER BY num_lista  LIMIT $min,$offset", $dbi);
		while(list($id_cons2,$id_lista,$id_gruppo, $num_lista, $descr_lista) = mysql_fetch_row($result)) {
  			if ($num_lista!=0) {
			// voti lista
			$res_lista = mysql_query("select sum(voti)  from ".$prefix."_ele_voti_lista where id_cons='$id_cons' and id_lista='$id_lista'", $dbi);
			list($voti_lista) = mysql_fetch_row($res_lista);
			if ($voti_lista_tutti!=0)
			$perc_lista=number_format(($voti_lista*100)/$voti_lista_tutti,2);
		        else $perc_lista='';
			// gruppo
			$res_gruppo = mysql_query("select descrizione  from ".$prefix."_ele_gruppo where id_gruppo='$id_gruppo'", $dbi);
			list($descr_gruppo) = mysql_fetch_row($res_gruppo);


		 	echo "<table class=\"table-80\"><tr class=\"bggray\">"
			."<td class=\"td-5\"><b>"._NUM."</b></td>"
			."<td ><b>"._DESCR."</b></td>"
			."<td class=\"td-5\"><b>"._SIMBOLO."</b></td>"
			."<td class=\"td-5\"><b>"._GRUPPO."</b></td></tr>";



			echo "<tr><td class=\"bggray\"><h1>$num_lista</h1>"
			."</td>
			<td class=\"table-main\"><h1>$descr_lista<br />
			voti: $voti_lista <span class=\"redbig\"> $perc_lista</span> %</h1>";
			echo "</td>
			<td><a href=\"modules.php?name=Elezioni&amp;id_gruppo=$id_gruppo&amp;id_cons_gen=$id_cons_gen&amp;id_lista=$id_lista&amp;op=partiti&amp;voti_lista=$voti_lista&amp;perc_lista=$perc_lista&amp;id_comune=$id_comune\">
			<img class=\"stemma\" src=\"modules.php?name=Elezioni&amp;file=foto&amp;id_lista=$id_lista\" alt=\"$descr_lista\" />";
			echo "</a></td>
			<td>
			<img class=\"stemma\" src=\"modules.php?name=Elezioni&amp;file=foto&amp;id_gruppo=$id_gruppo\" alt=\"$descr_gruppo\" />
			<br />$descr_gruppo</td>
			</tr></table>";
			}
		}
  
    $file="index";
    $go=$op;
    page($id_cons_gen,$go,$max,$min,$prev,$next,$offset,$file);
    }
	
	
	
function grafici($id_cons) {

//graf_votanti();
graf_gruppo();
//graf_candidato();

}

//visualizzaione a seconda dello stato della consultazione
// finita si basa sui gruppi o liste per tutte le sezioni
if (!$op){

        $circos=''; // definizione provvisoria
	if ($genere==0) {$tab="ref";}else{$tab="gruppo";}
	if ($votog) {$tab="lista";}else{$tab="gruppo";}
	$res = mysql_query("select *  from ".$prefix."_ele_voti_".$tab." where id_cons='$id_cons'  $circos group by id_sez ",$dbi);
	$numero=mysql_num_rows($res);
	$res = mysql_query("select *  from ".$prefix."_ele_sezioni where id_cons='$id_cons' $circos ",$dbi);
	$sezioni=mysql_num_rows($res);
	if ($numero==0) $op="gruppo";
	if ($numero==$sezioni) $op="graf_gruppo";
	 
}

switch ($op){


    case "circo":
    	circo();
    break;

    case "sezione":
    	sezione();
    break;

    case "candi":
      include("candidato.php");
      candidato();
    	//candi();
    break;

    case "gruppo":
    	gruppo();
    break;
    
    case "partiti":
    	partiti();
    BREAK;
    
    case "liste":
    	liste();
    break;
    
    case "come":
  	switch ($info){
		case 'dati':
			circo();
    		break;
	   case "confronti":
   		include("confronti.php");
   		break;
	
		case "affluenze_sez":
			include("affluenze.php");
		break;
		case "votanti":
			include("votanti.php");
		break;
		default:
    		come($info);
	}
   break;

// esterni

   case "consiglieri":
   include("consiglieri.php");
   consiglio();
   break;

   case "gruppo_circo":
   include("gruppo.php");
   gruppo_circo();
   break;

   case "gruppo_sezione":
   include("gruppo.php");
   gruppo_circo();
   break;

   case "lista_circo":
   include("gruppo.php");
   gruppo_circo();
   break;

   case "lista_sezione":
   include("gruppo.php");
   gruppo_circo();
   break;

   case "candidato_circo":
   include("gruppo.php");
   gruppo_circo();
   break;



   case "candidato_sezione":
   include("gruppo.php");
   gruppo_circo();
   break;

   case "affluenze_graf":
   include("grafici.php");
   affluenze_graf();
   break;

   case "graf_votanti":
   include("grafici.php");
   graf_votanti();
   break;

   case "graf_candidato":
   include("grafici.php");
   if (!$circo)graf_candidato();
   break;

   case "graf_gruppo":
   include("grafici.php");
   graf_gruppo();
   break;

   

   case "tema":
   	include("theme.php");
   break;

   case "top":
   	include("top.php");
   break;
   
   case "contatti":
   	include("contatti.php");
   break;

   case "rss":
   	include("rss.php");
   break;
   
}

if ($csv!=1 && $rss!=1){
########## icona rss da sistemare in un altra parte con calma...
global $circo;
if($genere!=0 && $id_circ==''){ // no referendum ne circoscrizioni
	echo "<div align=\"right\"><a href=\"modules.php?id_cons_gen=$id_cons_gen&amp;name=Elezioni&amp;id_comune=$id_comune&amp;file=index&amp;op=rss&amp;rss=1\"><img class =\"nobordo\" width=\"60\" src=\"modules/Elezioni/images/valid-rss.png\" /></a></div>";
}

include("footer.php");
}
?>
