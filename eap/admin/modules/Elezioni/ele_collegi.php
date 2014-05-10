<?php
/************************************************************************/
/* Eleonline - Raccolta e diffusione dei dati elettorali                */
/* by Roberto Gigli & Luciano Apolito                                   */
/* http://www.eleonline.it                                              */
/* info@eleonline.it  luciano@aniene.net rgigli@libero.it               */
/************************************************************************/
/* Modulo definizione collegi o zone                                    */
/* Amministrazione                                                      */
/************************************************************************/

if (!defined('ADMIN_FILE')) {
    die ("You can't access this file directly...");
}

$aid=$_SESSION['aid'];
$dbi=$_SESSION['dbi'];
$prefix=$_SESSION['prefix'];
$id_cons_gen=$_GET['id_cons_gen'];
$perms=ChiSei(0);
if ($perms<128 or !$id_cons_gen) die("$perms Non hai i permessi per inserire dati, o non hai scelto la consultazione!");
include("modules/Elezioni/funzionidata.php");
include("modules/Elezioni/ele.php");

// Offset - visualizza il numero di elementi per pagina

$offset=15;
if (isset($_GET['desc'])) get_magic_quotes_gpc() ? $desc=$param['desc']:$desc=addslashes($param['desc']);else $desc='';
if (isset($_GET['id_collegio'])) $id_collegio=intval($_GET['id_collegio']);else $id_collegio='';
if (isset($_GET['ok'])) $ok=intval($_GET['ok']); else $ok='';
if (isset($_GET['do'])) get_magic_quotes_gpc() ? $do=$param['do']:$do=addslashes($param['do']);else $do='';
if (isset($_GET['op'])) get_magic_quotes_gpc() ? $op=$param['op']:$op=addslashes($param['op']);else $op='';


	/******************************************************/
	/*Funzione di visualizzazione globale                 */
	/*****************************************************/
	//crea la pagina delle affluenze
function all() {
	global $bgcolor1, $bgcolor2, $prefix, $dbi,$id_cons,$desc,$id_cons_gen,$id_collegio;

	OpenTable();	
	$resmod = mysql_query("SELECT t1.id_collegio, t1.descrizione, t2.descrizione FROM ".$prefix."_ele_collegi as t1, ".$prefix."_ele_consultazione as t2 where t1.id_cons_gen=t2.id_cons_gen and t2.id_cons_gen=$id_cons_gen order by t1.descrizione asc", $dbi);
	echo "<table><tr ALIGN=\"CENTER\">";
	echo "<td bgcolor=\"$bgcolor1\"><b>"._CONSULTA."</b></td>";
	echo "<td bgcolor=\"$bgcolor1\"><b>"._COLLEGI."</b></td>";
	echo "</tr>";
	echo "<form name=\"modello\" action=\"admin.php\">"
		."<input type=\"hidden\" name=\"op\" value=\"inscollegi\">";
	echo "<input type=\"hidden\" name=\"id_collegio\" value=\"$id_collegio\">";
	echo "<tr align=\"center\">";
	$ressede = mysql_query("SELECT descrizione from ".$prefix."_ele_consultazione where id_cons_gen='$id_cons_gen'", $dbi);
	list($descr_cons)=mysql_fetch_row($ressede);
	echo "<td>$descr_cons</td>";
	echo "<td  align=\"center\" width=\"32\"><input name=\"desc\" value=\"$desc\"></td>";
	echo "<input type=\"hidden\" name=\"id_cons_gen\" value=\"$id_cons_gen\">";
	echo "<input type=\"hidden\" name=\"ok\" value=0>";
	if ($desc) {
		echo "<input type=\"hidden\" name=\"do\" value=\"update\">";
		echo "<td><input type=\"submit\" name=\"add\" value=\""._MODIFY."\"></td></tr></form>";
	}else{
		echo "<input type=\"hidden\" name=\"do\" value=\"add\">";
		echo "<td><input type=\"submit\" name=\"add\" value=\""._ADD."\"></td></tr></form>";
	}
	$i=0;
	while (list($id_collegio2,$desc,$descr_cons) = mysql_fetch_row($resmod)){ //elenco dei modelli inseriti
		$i++;
		$bgcolor1=($bgcolor1==$_SESSION['bgcolor1'])?$_SESSION['bgcolor2']:$_SESSION['bgcolor1'];
		echo "<form name=\"modello$i\" action=\"admin.php\">"
			."<input type=\"hidden\" name=\"op\" value=\"inscollegi\">";
		echo "<input type=\"hidden\" name=\"do\" value=\"delete\">";
		echo "<input type=\"hidden\" name=\"desc\" value=\"$desc\">";
		echo "<input type=\"hidden\" name=\"id_collegio\" value=\"$id_collegio2\">";
		echo "<input type=\"hidden\" name=\"id_cons_gen\" value=\"$id_cons_gen\">";
		echo "<tr align=\"center\" bgcolor=\"$bgcolor1\">";
		echo "<td></td>";
		echo "<td  align=\"center\" width=\"32\"><b>$desc</b></td>";
		echo "<input type=\"hidden\" name=\"ok\" value=0>";
		echo "</td><td align=\"center\" nowrap>[<a
		href=\"admin.php?op=inscollegi&amp;desc=$desc&amp;id_cons_gen=$id_cons_gen&amp;id_collegio=$id_collegio2\"><img src=\"modules/Elezioni/images/edit.gif\"
                border=\"0\" align=\"center\"> "._EDIT."</a>]";
		echo "<td><input type=\"submit\" name=\"erase$i\" value=\""._DELETE."\">"
			."</td></tr></form>";
	}
	echo "</table>";
	CloseTable();
	}

function collegi($ok, $do,$desc,$id_collegio) {
	global $bgcolor1, $bgcolor2, $prefix, $dbi, $descr_cons, $id_cons_gen,$genere;
	if ($do !="") {
       	if ($do == "delete") {
     			if ($ok !="1") {
				ele();
				echo "<center><br><br>"._DOMCANCELLA." "._COLLEGIO." $desc ?<br>";
				echo "[ <a href=\"admin.php?op=inscollegi&amp;id_cons_gen=$id_cons_gen&amp;id_collegio=$id_collegio&amp;desc=$desc\">"._NO."</a> ] - [<a href=\"admin.php?op=inscollegi&amp;do=delete&amp;id_cons_gen=$id_cons_gen&amp;desc=$desc&amp;id_collegio=$id_collegio&amp;ok=1\">"._YES."</a> ]";
				die();
  	   		}else{
			  	$result = mysql_query("delete from ".$prefix."_ele_collegi where id_collegio='$id_collegio'", $dbi);
    		      		if (!$result) return;
			  	Header("Location: admin.php?op=inscollegi&id_cons_gen=$id_cons_gen");
			}
     	 	}
   	  	if ($do == "add") {
   	   		$result = mysql_query("insert into ".$prefix."_ele_collegi(id_cons_gen,descrizione) values ('$id_cons_gen','$desc')", $dbi) || die("Impossibile inserire il collegio! ".mysql_error());
   		}
    	 	if ($do == "update") {
    		    	$result = mysql_query("update  ".$prefix."_ele_collegi set descrizione='$desc' , id_cons_gen='$id_cons_gen' where id_collegio='$id_collegio'", $dbi);
    	       	if (!$result) return;
#			echo "update  ".$prefix."_ele_collegi set descrizione='$desc' , id_cons_gen='$id_cons_gen' where id_collegio='$id_collegio'";
   	        	Header("Location: admin.php?op=inscollegi&id_cons_gen=$id_cons_gen&id_collegio=$id_collegio");
   		}
	} 
}

//****************************
	switch ($op){
		case "inscollegi":
			if ($desc){
				collegi($ok, $do,$desc,$id_collegio);
			}else collegi('','','','');
    		break;
	}
	ele();
	all();
	include("footer.php");

?>

