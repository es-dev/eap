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
$perms=ChiSei(0);
//if ($perms<128 or !$id_cons_gen) die("Non hai i permessi per inserire dati, o non hai scelto la consultazione!");
if ($perms!=256) die("Non hai i permessi per inserire dati, o non hai scelto la consultazione!");
if (isset($param['id_cons_gen'])){
	 $id_cons_gen=intval($param['id_cons_gen']);
$res = mysql_query("SELECT tipo_cons FROM ".$prefix."_ele_consultazione where id_cons_gen=$id_cons_gen " , $dbi);
list($tipo_cons) = mysql_fetch_row($res);
} else {
$id_cons_gen=0;
$tipo_cons=0;
}
if (isset($param['min'])) $min=intval($param['min']); else $min=0;
if (isset($param['ok'])) $ok=intval($param['ok']); else $ok=0;
if (isset($param['data_in'])) get_magic_quotes_gpc() ? $data_in=$param['data_in']:$data_in=addslashes($param['data_in']); else $data_in='';
if (isset($param['data_fine'])) get_magic_quotes_gpc() ? $data_fine=$param['data_fine']:$data_fine=addslashes($param['data_fine']); else $data_fine='';
if (isset($param['do'])) get_magic_quotes_gpc() ? $do=$param['do']:$do=addslashes($param['do']); else $do='';
if (isset($param['dig'])) $dig=intval($param['dig']); else $dig=date("d",time());
if (isset($param['dim'])) $dim=intval($param['dim']); else $dim=date("m",time());
if (isset($param['dia'])) $dia=intval($param['dia']); else $dia=date("Y",time());
if (isset($param['dfg'])) $dfg=intval($param['dfg']); else $dfg=date("d",time());
if (isset($param['dfm'])) $dfm=intval($param['dfm']); else $dfm=date("m",time());
if (isset($param['dfa'])) $dfa=intval($param['dfa']); else $dfa=date("Y",time());
if (isset($param['duplica'])) $duplica=intval($param['duplica']); else $duplica='';
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

//die("dig:$dig dim:$dim dia:$dia");

include("modules/Elezioni/funzionidata.php");
include("modules/Elezioni/ele.php");
	
// Offset - visualizza il numero di elementi per pagina

      $offset=10;
      if (!isset($min)) $min=0;

/******************************************************/
/*Funzione di visualizzazione globale                 */
/*****************************************************/

function all() {
   global $genere, $bgcolor1, $bgcolor2,  $bgcolor6, $prefix, $dbi, $offset, $min, $id_cons_gen, $perms,$tipo_cons, $tipocons,$do, $dig, $dim, $dia, $dfg, $dfm, $dfa, $help;
$language=$_SESSION['lang'];
if (($perms>64)) {
############# Controllo flag per cancellazione consultazione
	echo "<SCRIPT type=\"text/javascript\">\n\n<!--\n"
	."//-->\n";
	echo "function del_cons() {\n";
	echo "if (document.consultazione.pwd3.checked==false) {\n";
	echo "document.consultazione.update.value=\""._MODIFY."\" \n";
	echo "document.consultazione.do.value=\"update\" \n";
	echo "}else{\n";
	echo "document.consultazione.update.value=\""._DELETE."\" \n";
	echo "document.consultazione.do.value=\"delete\" \n";
	echo "} \n";	
	echo "} \n";
	echo "</script>\n";
#########################
	if (isset($help)) include("language/$language/ele_consultazioni.html");

	if ($do == "modify") {
		$res = mysql_query("SELECT * FROM ".$prefix."_ele_consultazione where id_cons_gen='$id_cons_gen'", $dbi);
		$pro= mysql_fetch_array($res, 3);
$res_tipo = mysql_query("SELECT * FROM ".$prefix."_ele_tipo where tipo_cons='".$pro['tipo_cons']."' and lingua='$language'", $dbi);
$tip=mysql_fetch_array($res_tipo, 3);

		list($dia1,$dim1,$dig1) = explode("-",$pro['data_inizio']=="0000-00-00" ? "    -  -  ": $pro['data_inizio']) ;
		list($dfa1,$dfm1,$dfg1) = explode("-",$pro['data_fine']=="0000-00-00" ? "    -  -  ": $pro['data_fine']) ;
		echo "<form name=\"consultazione\" method=\"post\" action=\"admin.php\" >"
		."<input type=\"hidden\" name=\"op\" value=\"consultazione\">"
		."<input type=\"hidden\" name=\"do\" value=\"update\">"
		."<input type=\"hidden\" name=\"id_cons_gen\" value=\"".$pro['id_cons_gen']."\">"
		."<table  width=\"100%\"><tr><td>"._MODIFY." ".$pro['descrizione']." <br><br>";
		switch ($genere) {
			case "0" : $gencons=_GENCONS0;break;
			case "1" : $gencons=_GENCONS1;break;
			case "2" : $gencons=_GENCONS2;break;
			case "3" : $gencons=_GENCONS3;break;
			case "4" : $gencons=_GENCONS4;break;
			case "5" : if($tip['voto_c'])
					 $gencons=_GENCONS3;
				   else
					 $gencons=_GENCONS5;
				   break;
		default :$gencons="";
		}
		echo "</td></tr><tr><td>"._TIPO."</td><td>$gencons</td></tr>";
		echo "<tr bgcolor=\"$bgcolor2\"><td>"._DESCR. "</td><td><input  name=\"descr_cons2\" value=\"".$pro['descrizione']."\" size=\"15\"></td></tr>";
		echo "<tr><td>"._DATAIN." :</td><td>";
		echo "<select name=\"dig\" >";
		echo "<option value=\"$dig1\" selected>$dig1</option>";giorno(0,0);
		echo "<select name=\"dim\" >";
		echo "<option value= \"$dim1\" selected>$dim1</option>"; mese();
		echo "<select name= \"dia\" >";
		echo "<option value=\"$dia1\" selected>$dia1</option>"; anno();
		echo "</td></tr>";
		echo "<tr><td>"._DATAFINE." :</td><td>";
		echo "<select name=\"dfg\" >";
		echo "<option value=\"$dfg1\" selected>$dfg1</option>";giorno(0,0);
		echo "<select name= \"dfm\" >";
		echo "<option value= \"$dfm1\" selected>$dfm1</option>"; mese();
		echo "<select name= \"dfa\" >";
		echo "<option value=\"$dfa1\" selected>$dfa1</option>"; anno();
		echo "</td></tr><tr>";
		$resdel = mysql_query("SELECT * FROM ".$prefix."_ele_cons_comune where id_cons_gen='$id_cons_gen'", $dbi);
		if(mysql_num_rows($resdel)==0)
			echo "<td><fieldset><legend>Abilita la cancellazione</legend><label id=\"prov\">"._SPUNTAELIMINA." <input type=\"checkbox\" name=\"pwd3\" value=\"\" onchange=\"del_cons()\"></label></fieldset></td>";
		else echo "<td></td>";
		echo "<td><input type=\"submit\" name=\"update\" value=\""._MODIFY."\">"
		."</td></tr></table></form>";
	} else {
		echo "<form name=\"consultazione\" action=\"admin.php\">"
		."<input type=\"hidden\" name=\"op\" value=\"consultazione\">"
		."<input type=\"hidden\" name=\"do\" value=\"add\">"
		."<input type=\"hidden\" name=\"id_cons_gen\" value=\"$id_cons_gen\">"
		."<hr><h6>"
		._ADD." "._CONSULTA."<br><br>";
		echo _DEFCONS.":</h6><br><table width=\"100%\">";

		$res=mysql_query("SELECT * FROM ".$prefix."_ele_tipo where lingua='$language'", $dbi);
		echo "<tr><td><b>"._TIPO." :</b></td><td>";
		echo "<select name=\"tipocons\" >";
		while(list($idtipo,$destipo)= mysql_fetch_row($res)){
			if ($idtipo == $tipo_cons) {
				$sel = "selected";
				} else {
				$sel = "";
				}
		
			echo "<option value=\"$idtipo\" $sel>$destipo";
		}
		echo "</select>";
		echo "<tr><td><b>"._DESCR. "</b></td><td><input type=\"text\" name=\"descr_cons2\" maxlength=\"100\"></td></tr>"
		."<tr><td><b>"._DATAIN. "</b></td><td>";
		echo "<select name= \"dig\" ><option value=\"$dig\" selected>$dig</option>"; giorno(0,0);
		echo "<select name= \"dim\" ><option value=\"$dim\" selected>$dim</option>"; mese();
		echo "<select name= \"dia\" ><option value=\"$dia\" selected>$dia</option>"; anno() ;
		echo "</td></tr>"
	
		."<tr><td><b>"._DATAFINE. "</b></td><td>";
		echo "<select name= \"dfg\" ><option value=\"$dfg\" selected>$dfg</option>"; giorno(0,0);
		echo "<select name= \"dfm\" ><option value=\"$dfm\" selected>$dfm</option>"; mese();
		echo "<select name= \"dfa\" ><option value=\"$dfa\" selected>$dfa</option>"; anno() ;
		echo "</td></tr>"
		."</table>"
		."<input type=\"submit\" name=\"add\" value=\""._ADD."\">"
		."</form>";
	}
	echo "<center><font class=\"title\"><b>"._MODIFY." "._CONSULTA."</b></font><br><br><table border=\"0\" width=\"100%\">"
	."<tr><td bgcolor=\"$bgcolor1\" align=\"center\">&nbsp;<b>"._DESCR."</b>&nbsp;</td>"
	."<td bgcolor=\"$bgcolor1\" align=\"center\">&nbsp;<b>"._DATAIN."</b>&nbsp;</td>"
	."<td bgcolor=\"$bgcolor1\" align=\"center\"><b>"._DATAFINE."</b></td>"
	."<td bgcolor=\"$bgcolor1\" align=\"center\"><b>"._FUNZIONI."</b></td></tr>";
	$res = mysql_query("SELECT * FROM ".$prefix."_ele_consultazione  " , $dbi);
	$max = mysql_num_rows($res);
	$result = mysql_query("select * from ".$prefix."_ele_consultazione   ORDER BY data_fine desc  LIMIT $min,$offset", $dbi);
	while(list($id, $descr_cons, $data_inizio, $data_fine,$tipo) = mysql_fetch_row($result)) {
		$data_inizio=form_data($data_inizio);$data_fine=form_data($data_fine);
		$bgcolor1=($bgcolor1==$_SESSION['bgcolor1'])?$_SESSION['bgcolor2']:$_SESSION['bgcolor1'];
		echo "<tr ><td bgcolor=\"$bgcolor1\" align=\"left\" ><a href=\"admin.php?op=ele&amp;id_cons_gen=$id\"><b>$descr_cons</b></a>"
		."</td><td align=\"center\" >$data_inizio</td>"
		."<td align=\"center\">$data_fine"
		."</td><td align=\"center\" nowrap bgcolor=\"$bgcolor1\">[<a
		href=\"admin.php?op=consultazione&amp;do=modify&amp;id_cons_gen=$id\"><img src=\"modules/Elezioni/images/edit.gif\"
		border=\"0\" align=\"middle\" alt=\"Edit\"> "._EDIT."</a>]"
		."</td></tr>";
	}
	echo "</table></center>";
#'Pagina precedente' e 'Pagina Successiva'
	echo"<table align=\"center\" width=\"100%\" bgcolor=\"$bgcolor1\"><tr>";
	$prev=$min-$offset;
	if ($prev>=0) {
		echo "<td colspan=\"5\" align=\"center\" bgcolor=\"$bgcolor2\"><a href=\"admin.php?op=consultazione&amp;id_cons_gen=$id_cons_gen&amp;min=$prev\">";
		echo "<b>$offset "._PREV_MATCH."</b></a></td>";
	}
	$next=$min+$offset;
	if ($next>=($offset-1)) {
		if($next>=$max) $next = $max;
		else {
		echo "<td colspan=\"5\" align=\"center\" bgcolor=\"$bgcolor2\"><a href=\"admin.php?op=consultazione&amp;id_cons_gen=$id_cons_gen&amp;min=$next\">";
		echo "<b>$offset "._NEXT_MATCH."</b></a></td>";
		}
	}
	echo "</tr></table><br>";
}
}



function consultazione($ok, $id_cons_gen,$tipocons, $data_in, $data_fine,$do, $dig, $dim, $dia, $dfg, $dfm, $dfa, $duplica,$referendum,$liste,$gruppi,$ballo,$votigruppo) {
 global $bgcolor1, $bgcolor2, $prefix, $dbi, $descr_cons2,$tipo_cons,$perms,$do,$votilista,$voticandi,$circo;


if ($perms>=128) {
		if ($do == "delete") { 
				$result = mysql_query("delete from ".$prefix."_ele_consultazione where id_cons_gen='$id_cons_gen'", $dbi);
				if (!$result) return;
				Header("Location: admin.php?op=consultazione");
		}
		if ($do == "add") {
			if ($descr_cons2) {
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
				$data_inizio="$dia-$dim-$dig";
				$data_fine="$dfa-$dfm-$dfg";
				$id_consulta=$id_cons_gen;
				$result = mysql_query("insert into ".$prefix."_ele_consultazione (descrizione,data_inizio,data_fine,tipo_cons) values ('$descr_cons2','$data_inizio','$data_fine','$tipocons')", $dbi) || die("Errore di inserimento: ".mysql_error());
/*				$y=$result;
				$res=mysql_query("select id_cons_gen from ".$prefix."_ele_consultazione where descrizione='$descr_cons2'
				and data_inizio='$data_inizio' and data_fine='$data_fine' and tipo_cons='$tipocons'", $dbi);
				list($idc)=mysql_fetch_row($res);
				mkdir("images/consultazioni/$idc",0750);
				copy("images/consultazioni/nulla.jpg","images/consultazioni/$idc/nulla.jpg");*/
			} else {
		        OpenTable();
			echo "<center>"._GESTIONE." "._CONSULTAZIONE."";
			echo "<br><br><a href=\"admin.php?op=consultazione&amp;id_cons_gen=$id_cons_gen\">"._IMMCONS."</a></center>";
			CloseTable();
			}
		}else if ($do == "update") {
			$data_inizio="$dia-$dim-$dig";
			$data_fine="$dfa-$dfm-$dfg";
			$result = mysql_query("update  ".$prefix."_ele_consultazione set  descrizione='$descr_cons2',data_inizio='$data_inizio',
			data_fine='$data_fine' WHERE id_cons_gen='$id_cons_gen'", $dbi);
			if (!$result) return;
			Header("Location: admin.php?op=consultazione&id_cons_gen=$id_cons_gen");
   		}
	}
}

function help_cons()
{
//da mettere
}
if ($op=="consultazione")
 if (isset($param['do']) and $do!='modify')
    consultazione($ok, $id_cons_gen,$tipocons, $data_in, $data_fine,$do, $dig, $dim, $dia, $dfg, $dfm, $dfa, $duplica,$referendum,$liste,$gruppi,$ballo,$votigruppo);
#    else consultazione('', $id_cons_gen,'','','','','','','','','','','','','','','','','');
ele();
all();
echo"</td></tr></table></div>";
include("footer.php");



?>

