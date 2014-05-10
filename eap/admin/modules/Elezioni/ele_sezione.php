<?php
/************************************************************************/
/* Eleonline - Raccolta e diffusione dei dati elettorali                */
/* by Roberto Gigli & Luciano Apolito                                   */
/* http://www.eleonline.it                                              */
/* info@eleonline.it  luciano@aniene.net rgigli@libero.it               */
/************************************************************************/
/* Modulo sezioni                                                       */
/* Amministrazione                                                      */
/************************************************************************/
if (!defined('ADMIN_FILE')) {
    die ("You can't access this file directly...");
}
$id_comune=$_SESSION['id_comune'];
$id_cons_gen=$_GET['id_cons_gen'];
$perms=ChiSei($id_cons_gen);
if ($perms<32 or !$id_cons_gen) die("Non hai i permessi per inserire dati, o non hai scelto la consultazione!");


$res = mysql_query("SELECT t1.tipo_cons,t2.id_cons FROM ".$prefix."_ele_consultazione as t1, ".$prefix."_ele_cons_comune as t2 where t1.id_cons_gen=t2.id_cons_gen and t2.id_cons_gen='$id_cons_gen' and t2.id_comune='$id_comune'" , $dbi);
list($tipo_cons,$id_cons) = mysql_fetch_row($res);
if (isset($param['do'])) get_magic_quotes_gpc() ? $do=$param['do']:$do=addslashes($param['do']); else $do='';
if (isset($param['id_sede'])) $id_sede=intval($param['id_sede']); else $id_sede='';
if (isset($param['min'])) $min=intval($param['min']); else $min=0;
if (isset($param['ok'])) $ok=intval($param['ok']); else $ok='';
if (isset($param['id_sez'])) $id_sez=intval($param['id_sez']); else $id_sez='';
if (isset($param['aut_m'])) $aut_m=intval($param['aut_m']); else $aut_m='';
if (isset($param['aut_f'])) $aut_f=intval($param['aut_f']); else $aut_f='';
if (isset($param['maschi'])) $maschi=intval($param['maschi']); else $maschi='';
if (isset($param['femmine'])) $femmine=intval($param['femmine']); else $femmine='';
if (isset($param['id_sez2'])) $id_sez2=intval($param['id_sez2']); else $id_sez2='';
if (isset($param['num_sez'])) $num_sez=intval($param['num_sez']); else $num_sez='';

include("modules/Elezioni/funzionidata.php");
include("modules/Elezioni/ele.php");
// Offset - visualizza il numero di elementi per pagina
$offset=10;
$hiddenInfo = "<input type=\"hidden\" name=\"min\" value=\"$min\">";


/******************************************************/
/*Funzione di visualizzazione globale                 */
/*****************************************************/

function all() {
   global $admin, $bgcolor1, $bgcolor2, $prefix, $dbi, $offset, $min, $id_cons,$id_cons_gen;
	OpenTable();
	$y=0;
   echo "<center><font class=\"title\"><a NAME=riga><b>"._SEZIONE."</b></a></font><br><br><table border=\"0\" width=\"95%\">"
	."<td bgcolor=\"$bgcolor1\" align=\"center\"><b>"._NUM."</b></td>"
	."<td bgcolor=\"$bgcolor1\" align=\"center\"><b>"._INDIRIZZO."</b></td>"
	."<td bgcolor=\"$bgcolor1\" align=\"center\" ><b>"._MASCHI."</b></td>"
	."<td bgcolor=\"$bgcolor1\" align=\"center\" ><b>"._FEMMINE."</b></td>"
	."<td bgcolor=\"$bgcolor1\" align=\"center\" ><b>"._TOTS." "._VOTANTI."</b></td>"
	."<td bgcolor=\"$bgcolor1\" align=\"center\"><b>"._FUNZIONI."</b></td></tr>";
    $res = mysql_query("SELECT * FROM ".$prefix."_ele_sezioni where id_cons='$id_cons'  ", $dbi);
    $max = mysql_num_rows($res);
    
	$nuova= $max+1;
	$res = mysql_query("SELECT id_sede FROM ".$prefix."_ele_sezioni where id_cons='$id_cons' and num_sez='$max'  ", $dbi);
	list($id_sede_old) = mysql_fetch_row($res);
	echo "<form name=\"sezi\" action=\"admin.php\">"
	."<input type=\"hidden\" name=\"op\" value=\"sezione\">"
	."<input type=\"hidden\" name=\"do\" value=\"add\">";

	echo "<tr align=\"center\"><td><input type=\"text\" name=\"num_sez\" value=\"$nuova\" size=\"5\"></td>";

	echo "<td><select name=\"id_sede\">";
	$res= mysql_query("SELECT id_sede,indirizzo FROM ".$prefix."_ele_sede where id_cons='$id_cons' order by indirizzo", $dbi);
	while(list($id,$indir) = mysql_fetch_row($res)) {
		if ($id == $id_sede_old) {
			$sel = "selected";
		} else {
			$sel = "";
		}
		echo "<option value=\"$id\" $sel>$indir";
	}
	echo "</select></td>";
	//*************************************

	echo "<td><input type=\"text\" name=\"maschi\" size=\"4\"></td>";
	

	echo "<td><input type=\"text\" name=\"femmine\" size=\"4\"></td>";

	echo "<input type=\"hidden\" name=\"id_cons_gen\" value=\"$id_cons_gen\">";
	echo "<input type=\"hidden\" name=\"min\" value=\"$min\">"
	."<td></td><td><input type=\"submit\" name=\"add\" value=\""._ADD."\"></td></tr>"
	."</form>";
    
    
    
    
    
    $result = mysql_query("select id_cons, id_sez, id_sede, num_sez, maschi, femmine, autorizzati_m, autorizzati_f from ".$prefix."_ele_sezioni where id_cons='$id_cons'  ORDER BY num_sez  LIMIT $min,$offset", $dbi);
    while(list($id_cons2,$id_sez,$id_sede,$num_sez, $maschi, $femmine,$aut_m,$aut_f) = mysql_fetch_row($result)) {
	$bgcolor1=($bgcolor1==$_SESSION['bgcolor1'])?$_SESSION['bgcolor2']:$_SESSION['bgcolor1'];
        // dati circoscrizione
	$result1 = mysql_query("select indirizzo from ".$prefix."_ele_sede where id_sede='$id_sede'", $dbi);
        list($indir)=mysql_fetch_row($result1);
        $totali=$maschi+$femmine+$aut_m+$aut_f;
	$y++;
 echo "<form name=\"sez$y\" action=\"admin.php\">"
        ."<input type=\"hidden\" name=\"op\" value=\"sezione\">"
      ."<input type=\"hidden\" name=\"do\" value=\"update\">"
    ."<input type=\"hidden\" name=\"id_cons_gen\" value=\"$id_cons_gen\">"
    ."<input type=\"hidden\" name=\"min\" value=\"$min\">"
    ."<input type=\"hidden\" name=\"id_sez2\" value=\"$id_sez\">"
    ."<input type=\"hidden\" name=\"num_sez\" value=\"$num_sez\">";

	echo "<tr bgcolor=\"$bgcolor1\"><td align=\"right\"><b>$num_sez</b></td>";
	echo "<td align=\"right\"><select name=\"id_sede\">";
	$res= mysql_query("SELECT id_sede,indirizzo FROM ".$prefix."_ele_sede where id_cons='$id_cons' order by indirizzo", $dbi);
	while(list($id,$indir) = mysql_fetch_row($res)) {
		if ($id == $id_sede) {
			$sel = "selected";
		} else {
			$sel = "";
		}
		echo "<option value=\"$id\" $sel>$indir";
	}
	echo "</select></td>";

	echo "<td align=\"center\"><b><input type=\"text\" size=\"4\" name=\"maschi\" value=\"$maschi\"></b>";
	echo "</td><td align=\"center\"><b><input type=\"text\" size=\"4\" name=\"femmine\" value=\"$femmine\"></b>";
	echo "</td><td align=\"center\"><b>$totali</b>"
	."</td><td align=\"center\" nowrap><table><tr><td align=\"center\" width=\"50%\">" 
	."<input type=\"submit\" name=\"update$y\" value=\""._OK."\">"	;
	echo "</td><td align=\"center\" nowrap width=\"50%\">"
		  ."[<a href=\"admin.php?op=sezione&amp;do=delete&amp;id_sede=$id_sede&amp;id_sez=$id_sez&amp;id_cons_gen=$id_cons_gen&amp;num_sez=$num_sez&amp;min=$min\">"._DELETE."<img src=\"modules/Elezioni/images/delete.gif\"
                border=\"0\" align=\"center\"></a>]</td></tr></table>";
	    echo "</td></tr></form>\n";
    }
    echo "</table></center>";
	echo "<SCRIPT type=\"text/javascript\">\n\n<!--\n"
	."document.sez2.maschi.focus()\n"
	."document.sez2.maschi.select()\n"
	."//-->\n"
	."</script>\n";

      #'Pagina precedente' e 'Pagina Successiva'
      echo"<table align=\"center\" width=\"100%\"><tr>";
	  if ($min<$offset and $min!=0) $min=$offset;
      $prev=$min-$offset;
	  
      if ($prev>=0) {
              echo "<td colspan=\"5\" align=\"center\" bgcolor=\"$bgcolor1\"><a href=\"admin.php?op=sezione&amp;id_sede=$id_sede&amp;id_sez=$id_sez&amp;id_cons_gen=$id_cons_gen&amp;min=$prev\">";
              echo "<b>"._PREV_MATCH."</b></a></td>";
      }

      $next=$min+$offset;
      if ($next>=($offset-1)) {
          if($next>=$max) $next = $max;
	  else {

              echo "<td colspan=\"5\" align=\"center\" bgcolor=\"$bgcolor1\"><a href=\"admin.php?op=sezione&amp;id_sede=$id_sede&amp;id_sez=$id_sez&amp;id_cons_gen=$id_cons_gen&amp;min=$next\">";
              echo "<b>"._NEXT_MATCH."</b></a></td>";
        }
      }
     echo "</tr></table><br>";
CloseTable();
include("footer.php");
}



function sezione($ok, $do,$id_sede,$id_sez, $num_sez, $aut_ma, $aut_fe, $maschi, $femmine, $id_sez2,$min) {
global $admin, $bgcolor1, $bgcolor2, $prefix, $dbi, $descr_cons, $id_cons,$id_cons_gen;
$perms=ChiSei($id_cons_gen);
if ($perms>16) {
	$aut_m=intval($aut_ma);
	$aut_f=intval($aut_fe);
	if ($do == "delete") {
		if ($ok !="1") {
			ele();
			echo "<center><br><br>"._DOMCANCELLA." "._NUM." "._SEZIONE." $num_sez ?<br>";
			echo "[ <a href=\"admin.php?op=sezione&amp;id_cons_gen=$id_cons_gen&amp;min=$min\">"._NO."</a> ] - [<a href=\"admin.php?op=sezione&amp;do=delete&amp;id_sede=$id_sede&amp;id_sez=$id_sez&amp;id_cons_gen=$id_cons_gen&amp;ok=1&amp;min=$min\">"._YES."</a> ]";
			include("footer.php");
			die();
		}else{
			$result = mysql_query("delete from ".$prefix."_ele_sezioni where id_sez='$id_sez'", $dbi)|| die("(1104) Non e' stato possibile eliminare i dati dal database! contattare l'amministratore".mysql_error());
			Header("Location: admin.php?op=sezione&id_cons_gen=$id_cons_gen&min=$min");
		}
	}elseif ($do == "add") {
		if ($num_sez) {
			$result = mysql_query("insert into ".$prefix."_ele_sezioni (id_cons,id_sede,num_sez,maschi,femmine, autorizzati_m,autorizzati_f) values ('$id_cons', '$id_sede', '$num_sez','$maschi','$femmine','$aut_m', '$aut_f')", $dbi)|| die("(1104) Non e' stato possibile inserire i dati nel database! contattare l'amministratore".mysql_error());
			Header("Location: admin.php?op=sezione&id_cons_gen=$id_cons_gen&min=$min");
		} else {
			ele();
			OpenTable();
			echo "<center>"._GESTIONE." "._SEZIONE." ";
			echo "<br><br><a href=\"admin.php?op=sezione&amp;id_cons_gen=$id_cons_gen&amp;min=$min\">"._IMM." "._SEZIONE."</a></center>";
			CloseTable();
		}
	}elseif ($do == "update") {
		$result = mysql_query("update  ".$prefix."_ele_sezioni set id_sede='$id_sede', maschi='$maschi', femmine='$femmine', autorizzati_m='$aut_m', autorizzati_f='$aut_f' where id_sez='$id_sez2' ", $dbi)|| die("(1104) Non e' stato possibile aggiornare i dati nel database! contattare l'amministratore".mysql_error());
		$num_sez--;
		Header("Location: admin.php?op=sezione&id_cons_gen=$id_cons_gen&min=$num_sez");
	}
	
}
}





if ($op=="sezione")
    sezione($ok, $do,$id_sede,$id_sez, $num_sez, $aut_m, $aut_f, $maschi, $femmine, $id_sez2, $min);
ele();
all();
include ("footer.php");

?>

