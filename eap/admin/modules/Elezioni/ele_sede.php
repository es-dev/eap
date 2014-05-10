<?php
/************************************************************************/
/* Eleonline - Raccolta e diffusione dei dati elettorali                */
/* by Roberto Gigli & Luciano Apolito                                   */
/* http://www.eleonline.it                                              */
/* info@eleonline.it  luciano@aniene.net rgigli@libero.it               */
/************************************************************************/
/* Modulo sedi                                                          */
/* Amministrazione                                                      */
/************************************************************************/


if (!defined('ADMIN_FILE')) {
    die ("You can't access this file directly...");
}
$id_comune=$_SESSION['id_comune'];

$param=strtolower($_SERVER['REQUEST_METHOD']) == 'get' ? $_GET : $_POST;

if (isset($param['id_cons_gen'])) $id_cons_gen=intval($param['id_cons_gen']); else $id_cons_gen='0';

$perms=ChiSei($id_cons_gen);
if ($perms>16) {

$res = mysql_query("SELECT t1.tipo_cons,t2.id_cons FROM ".$prefix."_ele_consultazione as t1, ".$prefix."_ele_cons_comune as t2 where t1.id_cons_gen=t2.id_cons_gen and t2.id_cons_gen='$id_cons_gen' and t2.id_comune='$id_comune'" , $dbi);
list($tipo_cons,$id_cons) = mysql_fetch_row($res);

include("modules/Elezioni/funzionidata.php");
include("modules/Elezioni/ele.php");
if (isset($param['do'])) get_magic_quotes_gpc() ? $do=$param['do']:$do=addslashes($param['do']); else $do='';
if (isset($param['descr_circ'])) get_magic_quotes_gpc() ? $descr_circ=$param['descr_circ']:$descr_circ=addslashes($param['descr_circ']); else $descr_circ='';
if (isset($param['min'])) $min=intval($param['min']); else $min=0;
if (isset($param['id_sede'])) $id_sede=intval($param['id_sede']); else $id_sede='';
if (isset($param['ok'])) $ok=intval($param['ok']); else $ok='';
if (isset($param['num_circ'])) $num_circ=intval($param['num_circ']); else $num_circ='';
if (isset($param['id_circ'])) $id_circ=intval($param['id_circ']); else $id_circ='';
if (isset($param['id_sede2'])) $id_sede2=intval($param['id_sede2']); else $id_sede2='';
if (isset($param['indir'])) get_magic_quotes_gpc() ? $indir=$param['indir']:$indir=addslashes($param['indir']); else $indir='';
if (isset($param['tel1'])) get_magic_quotes_gpc() ? $tel1=$param['tel1']:$tel1=addslashes($param['tel1']); else $tel1='';
if (isset($param['tel2'])) get_magic_quotes_gpc() ? $tel2=$param['tel2']:$tel2=addslashes($param['tel2']); else $tel2='';
if (isset($param['fax'])) get_magic_quotes_gpc() ? $fax=$param['fax']:$fax=addslashes($param['fax']); else $fax='';
if (isset($param['resp'])) get_magic_quotes_gpc() ? $resp=$param['resp']:$resp=addslashes($param['resp']); else $resp='';
if (isset($param['filemappa'])) get_magic_quotes_gpc() ? $filemappa=$param['filemappa']:$filemappa=addslashes($param['filemappa']); else $filemappa='';
if (isset($param['mappa'])) get_magic_quotes_gpc() ? $mappa=$param['mappa']:$mappa=addslashes($param['mappa']); else $mappa='';



// Offset - visualizza il numero di elementi per pagina

$offset=15;
$hiddenInfo = "<input type=\"hidden\" name=\"min\" value=\"$min\">";


/******************************************************/
/*Funzione di visualizzazione globale                 */
/*****************************************************/

function all() {
   global $bgcolor1, $bgcolor2, $prefix, $dbi, $offset, $min,$id_cons,$id_cons_gen,$do,$id_sede,$id_circ;

   echo "<center><font class=\"title\"><br><b>"._SEDE."</b></font><br><br><table border=\"0\" width=\"100%\" >"
	."<td bgcolor=\"$bgcolor1\" align=\"center\"><b>"._CIRCO."</b></td>"
	."<td bgcolor=\"$bgcolor1\" align=\"center\"><b>"._INDIRIZZO."</b></td>"
	."<td bgcolor=\"$bgcolor1\" align=\"center\"><b>"._MAPPA."</b></td>"
	."<td bgcolor=\"$bgcolor1\" align=\"center\"><b>"._TEL."</b></td>"
	."<td bgcolor=\"$bgcolor1\" align=\"center\"><b>"._FAX."</b></td>"
	."<td bgcolor=\"$bgcolor1\" align=\"center\">&nbsp;<b>"._RESP."</b>&nbsp;</td>"
	."<td bgcolor=\"$bgcolor1\" align=\"center\"><b>"._FUNZIONI."</b></td></tr>";
	
	echo "<form name=\"sede2\" enctype=\"multipart/form-data\"  action=\"admin.php\" method=\"post\">"
	."<input type=\"hidden\" name=\"op\" value=\"sede\">"
	."<input type=\"hidden\" name=\"id_cons_gen\" value=\"$id_cons_gen\">";
	if ($id_sede){
		$res = mysql_query("SELECT * FROM ".$prefix."_ele_sede where id_sede='$id_sede'", $dbi);
		$pro= mysql_fetch_array($res, 3);
	}else{
		$pro['indirizzo']='';$pro['filemappa']='';$pro['telefono1']='';$pro['fax']='';
		$pro['responsabile']='';$pro['id_circ']='';
	}
		echo "<tr><td align=\"right\"><select name=\"id_circ\">";
		$res= mysql_query("SELECT id_circ,descrizione FROM ".$prefix."_ele_circoscrizione where id_cons='$id_cons' order by num_circ", $dbi);
		while(list($id,$descr) = mysql_fetch_row($res)) {
			if ($id == $pro['id_circ']) {
				$sel = "selected";
			} else {
				$sel = "";
			}
			echo "<option value=\"$id\" $sel>$descr";
		}
		echo "</select></td>"; 
		
		echo "<td><input type=\"text\" name=\"indir\" maxlength=\"40\" value=\"".$pro['indirizzo']."\"></td>"
		."<td><input type=\"file\" name=\"mappa\" size=\"12\" value=\"".$pro['filemappa']."\"></td>"
      ."<td><input type=\"text\" name=\"tel1\" size=\"10\" value=\"".$pro['telefono1']."\"></td>"
      ."<td><input type=\"text\" name=\"fax\" maxlength=\"12\" size=\"10\" value=\"".$pro['fax']."\"></td>"

      ."<td><input type=\"text\" name=\"resp\" maxlength=\"60\" value=\"".$pro['responsabile']."\"></td>";
	if ($do == "modify"){
		echo "<input type=\"hidden\" name=\"id_sede\" value=\"$id_sede\">"
		."<input type=\"hidden\" name=\"do\" value=\"update\">";
		echo "<td align=\"center\"><input type=\"submit\" name=\"update\" value=\""._MODIFY."\"></td></tr>";
	} else {
		echo "<input type=\"hidden\" name=\"do\" value=\"add\">";

		
		
		
		echo "<td align=\"center\"><input type=\"submit\" name=\"add\" value=\""._ADD."\"></td></tr>";
	}	
	echo "</form><tr></tr>";	
	
	
	
	
    $res = mysql_query("SELECT * FROM ".$prefix."_ele_sede where id_cons='$id_cons'  ", $dbi);
    $max = mysql_num_rows($res);
    $result = mysql_query("select * from ".$prefix."_ele_sede where id_cons='$id_cons'  ORDER BY id_circ  LIMIT $min,$offset", $dbi);
    while(list($id_cons2,$id_sede,$id_circ,$indir, $tel1, $tel2,  $fax, $resp,$mappabin, $filemappa) = mysql_fetch_row($result)) {
        // dati circoscrizione
		$restemp = mysql_query("select count(0) from ".$prefix."_ele_sezioni where id_sede='$id_sede'", $dbi);
		list($numtemp)=mysql_fetch_row($restemp);
	$bgcolor1=($bgcolor1==$_SESSION['bgcolor1'])?$_SESSION['bgcolor2']:$_SESSION['bgcolor1'];
	$result1 = mysql_query("select descrizione from ".$prefix."_ele_circoscrizione where id_circ='$id_circ'", $dbi);
        list($descr_circ)=mysql_fetch_row($result1);
	echo "<tr bgcolor=\"$bgcolor1\"><td align=\"left\"><b>$descr_circ</b>"
	."</td><td align=\"left\"><b>$indir</b>"
	."</td><td align=\"right\"><b>$filemappa</b>"
	."</td><td align=\"right\"><b>$tel1</b>"
	."</td><td align=\"right\"><b>$fax</b>"
	."</td><td align=\"left\"><b>$resp</b>"
	."</td><td align=\"center\" nowrap>[<a
		href=\"admin.php?op=sede&amp;do=modify&amp;id_sede=$id_sede&amp;id_circ=$id_circ&amp;id_cons_gen=$id_cons_gen\"><img src=\"modules/Elezioni/images/edit.gif\"
                border=\"0\" align=\"center\"> "._EDIT."</a>]";
		if (!$numtemp)
			echo "[<a href=\"admin.php?op=sede&amp;do=delete&amp;id_sede=$id_sede&amp;id_circ=$id_circ&amp;id_cons_gen=$id_cons_gen&amp;indir=$indir\">"._DELETE." <img src=\"modules/Elezioni/images/delete.gif\" border=\"0\" align=\"center\"></a>]";
		else
			echo "["._DELETE." <img src=\"modules/Elezioni/images/delete.gif\" border=\"0\" align=\"center\">]";
	    echo "</td></tr>";
    }
    echo "</table></center>";


      #'Pagina precedente' e 'Pagina Successiva'
      echo"<table align=\"center\" width=\"100%\" ><tr>";
      $prev=$min-$offset;
      if ($prev>=0) {
              echo "<td colspan=\"5\" align=\"center\" bgcolor=\"$bgcolor1\"><a href=\"admin.php?op=sede&amp;id_sede=$id_sede&amp;id_circ=$id_circ&amp;id_cons_gen=$id_cons_gen&amp;min=$prev\">";
              echo "<b>$offset "._PREV_MATCH."</b></a></td>";
      }

      $next=$min+$offset;
      if ($next>=($offset-1)) {
          if($next>=$max) $next = $max;
	  else {

              echo "<td colspan=\"5\" align=\"center\" bgcolor=\"$bgcolor1\"><a href=\"admin.php?op=sede&amp;id_sede=$id_sede&amp;id_circ=$id_circ&amp;id_cons_gen=$id_cons_gen&amp;min=$next\">";
              echo "<b>$offset "._NEXT_MATCH."</b></a></td>";
        }
      }
     echo "</tr></table><br>";

}



//***********************************
// Consultazione
// ricordarsi di aggiungere l'eliminazione di tutti
// i dati della consultazione nelle altre tabelle
//  hai capito?
//***********************************

function sede($ok, $do,$id_circ, $id_sede,$indir, $tel1, $tel2, $fax, $resp, $mappa, $filemappa, $id_sede2) {
global $admin, $bgcolor1, $bgcolor2, $prefix, $dbi, $descr_cons, $id_cons,$id_cons_gen,$id_comune;
$perms=ChiSei(0);

if ($perms>16) {
	if ($do == "delete") {
		if ($ok !="1") {
			ele();
			echo "<center><br><br>"._DOMCANCELLA." $indir ?<br>";
			echo "[ <a href=\"admin.php?op=sede\">"._NO."</a> ] - [<a href=\"admin.php?op=sede&amp;do=delete&amp;id_sede=$id_sede&amp;id_circ=$id_circ&amp;id_cons_gen=$id_cons_gen&amp;ok=1\">"._YES."</a> ]";
			include("footer.php");
			die();
		}else{
			$result = mysql_query("delete from ".$prefix."_ele_sede where id_sede='$id_sede'", $dbi);
			if (!$result)return;
			Header("Location: admin.php?op=sede&id_cons_gen=$id_cons_gen");
		}
	}elseif ($do == "add") {
		if ($indir) {
		
		
			$mappablob='';
			$mappanome='';
			$MAPP=$_FILES['mappa'];
			
			$filesmappa=$MAPP['tmp_name'];
			
			
			$nomemappa=$MAPP['name'];
			$sqlset='';
			if ($filesmappa){
				$fdmappa = fopen ("$filesmappa", "rb");
				$mappacontents = fread ($fdmappa, filesize ("$filesmappa"));
				fclose ($fdmappa);
				$mappablob=addslashes($mappacontents);
				$mappanome=addslashes($nomemappa);
			}
		
		
//		        echo "IDCIRC=$id_circ";
		
		
			$result = mysql_query("insert into ".$prefix."_ele_sede (id_cons,id_circ,indirizzo,telefono1,telefono2,fax,responsabile,mappa,filemappa) values ('$id_cons', '$id_circ','$indir','$tel1','$tel2', '$fax','$resp','$mappablob','$mappanome')", $dbi)|| die(mysql_error());
			if (!$result) return;
			Header("Location: admin.php?op=sede&id_cons_gen=$id_cons_gen");
		} else {
			ele($id_cons);
			OpenTable();
			echo "<center>"._GESTIONE." "._SEDE." ";
			echo "<br><br><a href=\"admin.php?op=sede&amp;id_cons_gen=$id_cons_gen\">"._IMM." "._SEDE."</a></center>";
			CloseTable();
		}
	}elseif ($do == "update") {
			$mappablob='';
			$mappanome='';
			$MAPPA=$_FILES['mappa'];
			$filesmappa=$MAPPA['tmp_name'];
			$nomemappa=$MAPPA['name'];
			$sqlset='';
			if ($filesmappa){
				$fdmappa = fopen ("$filesmappa", "rb");
				$mappacontents = fread ($fdmappa, filesize ("$filesmappa"));
				fclose ($fdmappa);
				$mappablob=addslashes($mappacontents);
				$mappanome=addslashes($nomemappa);
				$cond=", mappa='$mappablob', filemappa='$mappanome'";
			} else {$cond='';}
        	
		$result = mysql_query("update  ".$prefix."_ele_sede set    id_circ='$id_circ',indirizzo='$indir' , telefono1='$tel1', telefono2='$tel2',fax='$fax',responsabile='$resp' $cond where id_sede='$id_sede2' ", $dbi)|| die(mysql_error());
          	 if (!$result) return;
          	 Header("Location: admin.php?op=sede&id_cons_gen=$id_cons_gen&id_comune=$id_comune");
   	}
}
}






	if($do and $do!="modify")
		sede($ok, $do,$id_circ, $id_sede,$indir, $tel1, $tel2, $fax, $resp,$mappa, $filemappa,$id_sede);
	ele();
	all();
	echo"</td></tr></table>";
	include("footer.php");
} else {
	echo "Access Denied";
}

?>

