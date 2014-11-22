<?php
/************************************************************************/
/* Eleonline - Raccolta e diffusione dei dati elettorali                */
/* by Roberto Gigli & Luciano Apolito                                   */
/* http://www.eleonline.it                                              */
/* info@eleonline.it  luciano@aniene.net rgigli@libero.it               */
/************************************************************************/
/* Modulo Consultazioni                                                 */
/* Amministrazione                                                      */
/************************************************************************/
if (!defined('ADMIN_FILE')) {
    die ("You can't access this file directly...");
}

$aid=$_SESSION['aid'];
$dbi=$_SESSION['dbi'];
$prefix=$_SESSION['prefix'];
$param=strtolower($_SERVER['REQUEST_METHOD']) == 'get' ? $_GET : $_POST;
$id_cons_gen=$param['id_cons_gen'];
$perms=ChiSei(0);
//if ($perms<128 or !$id_cons_gen) die("Non hai i permessi per inserire dati, o non hai scelto la consultazione!");
if ($perms!=256) die("Non hai i permessi per inserire dati, o non hai scelto la consultazione!");
$res = mysql_query("SELECT tipo_cons FROM ".$prefix."_ele_consultazione where id_cons_gen=$id_cons_gen " , $dbi);
list($tipo_cons) = mysql_fetch_row($res);

if (isset($param['min'])) $min=intval($param['min']); else $min=0;
if (isset($param['ok'])) $ok=intval($param['ok']); else $ok=0;
if (isset($param['data_in'])) get_magic_quotes_gpc() ? $data_in=$param['data_in']:$data_in=addslashes($param['data_in']); else $data_in='';
if (isset($param['data_fine'])) get_magic_quotes_gpc() ? $data_fine=$param['data_fine']:$data_fine=addslashes($param['data_fine']); else $data_fine='';
if (isset($param['do'])) get_magic_quotes_gpc() ? $do=$param['do']:$do=addslashes($param['do']); else $do='';
if (isset($param['referendum'])) get_magic_quotes_gpc() ? $referendum=$param['referendum']:$referendum=addslashes($param['referendum']); else $referendum='';
if (isset($param['liste'])) get_magic_quotes_gpc() ? $liste=$param['liste']:$liste=addslashes($param['liste']); else $liste='';
if (isset($param['gruppi'])) get_magic_quotes_gpc() ? $gruppi=$param['gruppi']:$gruppi=addslashes($param['gruppi']); else $gruppi='';
if (isset($param['votigruppo'])) get_magic_quotes_gpc() ? $votigruppo=$param['votigruppo']:$votigruppo=addslashes($param['votigruppo']); else $votigruppo='';
if (isset($param['votilista'])) get_magic_quotes_gpc() ? $votilista=$param['votilista']:$votilista=addslashes($param['votilista']); else $votilista='';
if (isset($param['voticandi'])) get_magic_quotes_gpc() ? $voticandi=$param['voticandi']:$voticandi=addslashes($param['voticandi']); else $voticandi='';
if (isset($param['ballo'])) get_magic_quotes_gpc() ? $ballo=$param['ballo']:$ballo=addslashes($param['ballo']); else $ballo='';
if (isset($param['circo'])) get_magic_quotes_gpc() ? $circo=$param['circo']:$circo=addslashes($param['circo']); else $circo='';
if (isset($param['descr_cons2'])) get_magic_quotes_gpc() ? $descr_cons2=$param['descr_cons2']:$descr_cons2=addslashes($param['descr_cons2']); else $descr_cons2='';
if (isset($param['tipocons'])) get_magic_quotes_gpc() ? $tipocons=$param['tipocons']:$tipocons=addslashes($param['tipocons']); else $tipocons=$tipo_cons;
if (isset($param['help'])) $help=intval($param['help']);

$id_comune=$_SESSION['id_comune'];


include("modules/Elezioni/funzionidata.php");
include("modules/Elezioni/ele.php");

	
// Offset - visualizza il numero di elementi per pagina

      $offset=10;
      if (!isset($min)) $min=0;

/******************************************************/
/*Funzione di visualizzazione globale                 */
/*****************************************************/

function all() {
   global $genere, $bgcolor1, $bgcolor2,  $bgcolor6, $prefix, $dbi, $offset, $min, $id_cons_gen, $perms,$tipo_cons, $tipocons,$do, $help;
$language=$_SESSION['lang'];
if (($perms>64)) {
	if (isset($help)) include("language/$language/ele_consultazionitipi.html");
	echo "<SCRIPT type=\"text/javascript\">\n\n<!--\n"
	."//-->\n";
	echo "function scegli_ref() {\n";
	echo "if (document.consultazione.referendum.checked==true) {\n";
	echo "document.consultazione.gruppi.checked=false \n";
	echo "document.consultazione.votigruppo.checked=false \n";
	echo "document.consultazione.votilista.checked=false \n";
	echo "document.consultazione.voticandi.checked=false \n";
	echo "document.consultazione.circo.checked=false \n";
	echo "document.consultazione.liste.checked=false \n";
	echo "document.consultazione.ballo.checked=false }\n";
	echo "}\n";
	echo "function scegli_cons() {\n";
	echo "if (document.consultazione.gruppi.checked==true || document.consultazione.circo.checked==true || document.consultazione.liste.checked==true || document.consultazione.votilista.checked==true || document.consultazione.voticandi.checked==true) {\n";
	echo "document.consultazione.referendum.checked=false \n";
	echo "document.consultazione.ballo.checked=false }\n";
	echo "if (document.consultazione.gruppi.checked==false) {\n";
	echo "document.consultazione.votigruppo.checked=false }\n";
	echo "}\n";
	echo "function scegli_ballo() {\n";
	echo "if (document.consultazione.ballo.checked==true) {\n";
	echo "document.consultazione.votigruppo.checked=false \n";
	echo "document.consultazione.votilista.checked=false \n";
	echo "document.consultazione.voticandi.checked=false \n";
	echo "document.consultazione.gruppi.checked=false \n";
	echo "document.consultazione.circo.checked=false \n";
	echo "document.consultazione.referendum.checked=false \n";
	echo "document.consultazione.liste.checked=false }\n";
	echo "}\n";
	echo "</script>\n";
	if ($do == "modify") {
		$rest = mysql_query("SELECT * FROM ".$prefix."_ele_tipo where tipo_cons='$tipocons' and lingua='$language'", $dbi);
		$pro_t=mysql_fetch_array($rest, 3);

		echo "<form name=\"consultazione\" method=\"post\" action=\"admin.php\" >"
		."<input type=\"hidden\" name=\"op\" value=\"constipi\">"
		."<input type=\"hidden\" name=\"do\" value=\"update\">"
		."<input type=\"hidden\" name=\"tipocons\" value=\"$tipocons\">"
		."<input type=\"hidden\" name=\"id_cons_gen\" value=\"$id_cons_gen\">"
		."<table  width=\"100%\">"._MODIFY." ".$pro_t['descrizione']." <br><br>";
		switch ($pro_t['genere']) {
			case "0" : $gencons=_GENCONS0;break;
			case "1" : $gencons=_GENCONS1;break;
			case "2" : $gencons=_GENCONS2;break;
			case "3" : $gencons=_GENCONS3;break;
			case "4" : $gencons=_GENCONS4;break;
			case "5" : {
				if (!$pro_t['voto_g'] and !$pro_t['voto_c']) $gencons=_GENCONS5;
				else $gencons=_GENCONS6;	
				break;
				}
				
		default :$gencons="";
		}
		echo "<tr><td>"._TIPO."</td><td>$gencons</td></tr>";
		echo "<tr bgcolor=\"$bgcolor2\"><td>"._DESCR. "</td><td><input  name=\"descr_cons2\" value=\"".$pro_t['descrizione']."\" size=\"15\"></td></tr>";

		echo "<tr><td>"
		."<input type=\"submit\" name=\"update\" value=\""._MODIFY."\">"
		."</form></td></tr></table>";
	} else {
		echo "<form name=\"consultazione\" action=\"admin.php\">"
		."<input type=\"hidden\" name=\"op\" value=\"constipi\">"
		."<input type=\"hidden\" name=\"tipocons\" value=\"$tipocons\">"
		."<input type=\"hidden\" name=\"do\" value=\"add\">"
		."<input type=\"hidden\" name=\"id_cons_gen\" value=\"$id_cons_gen\">"
		."<table whidth=\"100%\"><hr><h6>"._ADD." "._TIPO."<br><br>";
		echo _DEFCONS.":<br>";
		echo "<input type=\"checkbox\" name=\"referendum\" value=\"true\" onClick=\"scegli_ref()\"> "._REFERENDUM." <br>"
		."<input type=\"checkbox\" name=\"gruppi\" value=\"true\" onClick=\"scegli_cons()\"> "._CON_GRUPPI."<br> "
		."&nbsp;&nbsp;<input type=\"checkbox\" name=\"votigruppo\" value=\"true\" onClick=\"scegli_cons()\"> "._NO_VOTO_GRUPPO."<br> "
		."<br><input type=\"checkbox\" name=\"liste\" value=\"true\" onClick=\"scegli_cons()\"> "._LISTE_UNI."<br>"
		."&nbsp;&nbsp;<input type=\"checkbox\" name=\"votilista\" value=\"true\" onClick=\"scegli_cons()\"> "._NO_VOTO_LISTA."<br> "
		."&nbsp;&nbsp;<input type=\"checkbox\" name=\"voticandi\" value=\"true\" onClick=\"scegli_cons()\"> "._NO_VOTO_CANDI."<br> "
		."<input type=\"checkbox\" name=\"circo\" value=\"true\" onClick=\"scegli_cons()\"> "._ELE_CIRCO."<br>"
		."<input type=\"checkbox\" name=\"ballo\" value=\"true\" onClick=\"scegli_ballo()\"> "._BALLO."<br></h6>";

#		echo "<tr><td>";

		echo "<tr><td><b>"._DESCR. "</b></td><td><input type=\"text\" name=\"descr_cons2\" maxlength=\"100\"></td></tr>";
		echo "</td></tr>"
		."</table>"
		."<input type=\"submit\" name=\"add\" value=\""._ADD."\">"
		."</form>";
	}
	echo "<center><font class=\"title\"><b>"._MODIFY." "._TIPO."</b></font><br><br><table border=\"0\" width=\"100%\">"
	."<tr><td bgcolor=\"$bgcolor1\" align=\"center\">&nbsp;<b>"._NUM."</b>&nbsp;</td><td bgcolor=\"$bgcolor1\" align=\"center\">&nbsp;<b>"._DESCR."</b>&nbsp;</td>"
	."<td bgcolor=\"$bgcolor1\" align=\"center\"><b>"._FUNZIONI."</b></td></tr>";

		$result = mysql_query("SELECT tipo_cons,descrizione FROM ".$prefix."_ele_tipo where lingua='$language' LIMIT $min,$offset", $dbi);
		



	while(list($tipocons, $descr_cons) = mysql_fetch_row($result)) {
		
		$bgcolor1=($bgcolor1==$_SESSION['bgcolor1'])?$_SESSION['bgcolor2']:$_SESSION['bgcolor1'];
		echo "<tr ><td align=\"center\" >$tipocons</td><td bgcolor=\"$bgcolor1\" align=\"left\" ><b>$descr_cons</b></a>"
		."</td><td align=\"center\" nowrap bgcolor=\"$bgcolor1\">[<a
		href=\"admin.php?op=constipi&amp;do=modify&amp;id_cons_gen=$id_cons_gen&amp;tipocons=$tipocons\"><img src=\"modules/Elezioni/images/edit.gif\"
		border=\"0\" align=\"middle\"> "._EDIT."</a>]"
		."</td></tr>";
	}
	echo "</table></center>";
#'Pagina precedente' e 'Pagina Successiva'
	echo"<table align=\"center\" width=\"100%\" bgcolor=\"$bgcolor1\"><tr>";
	$prev=$min-$offset;
	if ($prev>=0) {
		echo "<td colspan=\"5\" align=\"center\" bgcolor=\"$bgcolor2\"><a href=\"admin.php?op=constipi&amp;id_cons_gen=$id_cons_gen&amp;min=$prev\">";
		echo "<b>$offset "._PREV_MATCH."</b></a></td>";
	}
	$next=$min+$offset;
	$res = mysql_query("SELECT * FROM ".$prefix."_ele_tipo where lingua='$language' " , $dbi);
	$max = mysql_num_rows($res);
	if ($next>=($offset-1)) {
		if($next>=$max) $next = $max;
		else {
		echo "<td colspan=\"5\" align=\"center\" bgcolor=\"$bgcolor2\"><a href=\"admin.php?op=constipi&amp;id_cons_gen=$id_cons_gen&amp;min=$next\">";
		echo "<b>$offset "._NEXT_MATCH."</b></a></td>";
		}
	}
	echo "</tr></table><br>";
}
}



function tipo() {
 global $id_cons_gen,$bgcolor1, $bgcolor2, $prefix, $dbi, $descr_cons2,$tipocons,$perms,$do,$votigruppo,$votilista,$voticandi,$circo, $referendum,$ballo,$liste,$gruppi;
$language=$_SESSION['lang'];

if ($perms==256) {
		if ($do == "add") {
			if ($tipocons) {
				if($referendum=='true') {
					$genere=0;
				} elseif ($ballo=='true') {
					$genere=1;
				}else{
	  	 			$genere=2;
	  	  			if($liste!='true') {$genere+=2;}
		  			if($gruppi=='true') {$genere+=1;}
	    			}
				$votigruppo=$votigruppo=='true'? 1:0;
				$votilista=$votilista=='true'? 1:0;
				$voticandi=$voticandi=='true'? 1:0;
				$circo=$circo=='true'? 1:0;
				$result = mysql_query("select max(tipo_cons) from ".$prefix."_ele_tipo where lingua='$language'", $dbi);
				list($max)=mysql_fetch_row($result);
				$max++;

				$result = mysql_query("insert into ".$prefix."_ele_tipo (tipo_cons,descrizione,lingua,genere,voto_g,voto_l,voto_c,circo) values ('$max','$descr_cons2','$language','$genere','$votigruppo','$votilista','$voticandi','$circo')", $dbi) || die("Errore di inserimento: ".mysql_error());


			}
		}else if ($do == "update") {
			$result = mysql_query("update  ".$prefix."_ele_tipo set descrizione='$descr_cons2' WHERE tipo_cons='$tipocons' and lingua='$language'", $dbi);
			if (!$result) return;
			Header("Location: admin.php?op=constipi&id_cons_gen=$id_cons_gen");
   		}
	}
}

function help_cons()
{
//da mettere
}

 if (isset($do))
    tipo();
ele();
all();
echo"</td></tr></table>";
include("footer.php");



?>

