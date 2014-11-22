<?php
/************************************************************************/
/* Eleonline - Raccolta e diffusione dei dati elettorali                */
/* by Roberto Gigli & Luciano Apolito                                   */
/* http://www.eleonline.it                                              */
/* info@eleonline.it  luciano@aniene.net rgigli@libero.it               */
/************************************************************************/
/* Modulo Operatori                                                     */
/* Amministrazione                                                      */
/************************************************************************/
if (!defined('ADMIN_FILE')) {
    die ("You can't access this file directly...");
}

$perms=ChiSei($id_cons_gen);
if (($perms<64 or !$id_cons_gen) and $perms!=256) die("(($perms<64 or !$id_cons_gen) and $perms!=256)Non hai i permessi per inserire dati, o non hai scelto la consultazione!");
$res = mysql_query("SELECT t1.tipo_cons,t2.id_cons FROM ".$prefix."_ele_consultazione as t1, ".$prefix."_ele_cons_comune as t2 where t1.id_cons_gen=t2.id_cons_gen and t2.id_cons_gen='$id_cons_gen' and t2.id_comune='$id_comune'" , $dbi);
list($tipo_cons,$id_cons) = mysql_fetch_row($res);
if (isset($_GET['aid2'])) get_magic_quotes_gpc() ? $aid2=$param['aid2']:$aid2=addslashes($param['aid2']); else {if ($perms==256) $aid2='admin'; else $aid2='';}
if (isset($_GET['id_sede'])) $id_sede=intval($_GET['id_sede']); else $id_sede='';
if (isset($_GET['do'])) get_magic_quotes_gpc() ? $do=$param['do']:$do=addslashes($param['do']); else $do='';
if (isset($_GET['name'])) get_magic_quotes_gpc() ? $name=$param['name']:$name=addslashes($param['name']); else $name='';
if (isset($_GET['email'])) get_magic_quotes_gpc() ? $email=$param['email']:$email=addslashes($param['email']); else $email='';
if (isset($_GET['passwd'])) get_magic_quotes_gpc() ? $passwd=$param['passwd']:$passwd=addslashes($param['passwd']); else $passwd='';
if (isset($_GET['passwd2'])) get_magic_quotes_gpc() ? $passwd2=$param['passwd2']:$passwd2=addslashes($param['passwd2']); else $passwd2='';

include("modules/Elezioni/funzionidata.php");
include("modules/Elezioni/ele.php");

/******************************************************/
/*Funzione di visualizzazione globale                 */
/*****************************************************/
//crea la pagina delle affluenze
function all() {
	global $aid, $offset, $prefix, $dbi,$id_cons,$aid2,$id_sede,$id_cons_gen,$mex,$perms;
        //echo $perms;die();
	$bgcolor1=$_SESSION['bgcolor1'];
	$id_comune=$_SESSION['id_comune'];
	$user=$aid;
	$rescom = mysql_query("select descrizione from ".$prefix."_ele_comuni where id_comune=$id_comune",$dbi);
	list($descr_com) = mysql_fetch_row($rescom);
	$resmod = mysql_query("SELECT aid,name,email FROM ".$prefix."_authors where aid='$aid2' and id_comune='$id_comune'", $dbi);
	list ($aid2,$name,$email) = mysql_fetch_row($resmod);
	if (isset($_GET['mex'])){
		echo "<table align=\"center\"><tr><td style=\"background-color: rgb(255, 0, 0)\">";
		echo $_GET['mex'];
		echo "</td></tr></table>";
	}	
#	OpenTable();
	echo "<table>";
	$esiste=0;
	echo "<tr><td>";
	echo "<form name=\"autorizza\" action=\"admin.php\">";
	echo "<table style=\"color: #000000;\"><tr align=\"center\" bgcolor=\"$bgcolor1\">";
	echo "<td><b>"._UTENTE."</b></td>";
	$resins = mysql_query("select aid from ".$prefix."_authors where id_comune='$id_comune' order by aid",$dbi); 
	echo "</tr><tr align=\"center\">";
	echo "<td><input type=\"hidden\" name=\"pag_op\" value=\"admin.php?op=operatori&amp;id_cons_gen=$id_cons_gen&amp;aid2=\">";
	echo "<select name=\"aid2\" onChange=\"top.location.href=this.form.pag_op.value+this.form.aid2.options[this.form.aid2.selectedIndex].value;return false\">";
	echo "<option value=\"\">";
	while(list($utente)=mysql_fetch_row($resins)){
		$sel= ($utente == $aid2) ? "selected":"";
		echo "<option value=\"$utente\" $sel>$utente";
		if($utente=="admin") $esiste=1;
	}
	echo "</select></td>";
	echo "</tr></table></form><br><hr>";
	$resmod = mysql_query("SELECT * FROM ".$prefix."_authors where id_cons='$id_cons' and id_comune='$id_comune'", $dbi);
	echo "<form name=\"modello\" action=\"admin.php\">";
	echo "<table style=\"color: #000000;\">";
	if ($perms==256) echo "<tr><td colspan=\"6\">"._NOTAOP." <b>$descr_com</b><hr></td></tr>";
	echo "<tr align=\"center\" bgcolor=\"$bgcolor1\">";
	echo "<td><b>"._UTENTE."</b></td>"; 
	echo "<td><b>"._PASSWORD."</b></td>";
	echo "<td><b>"._RIPETI."</b></td>";
	echo "<td bgcolor=\"$bgcolor1\"><b>"._NOME."</b></td>"
	."<td bgcolor=\"$bgcolor1\"><b>"._EMAIL."</b></td>";
	echo "<td bgcolor=\"$bgcolor1\"><b>"._FUNZIONI."</b></td></tr>";
	echo "<tr align=\"center\"><td>";
	echo "<input type=\"hidden\" name=\"op\" value=\"operatori\">"
	."<input type=\"hidden\" name=\"id_comune\" value=\"$id_comune\">";
	if ($perms==256 and $aid2==''){
		if($esiste) $supadm=''; else $supadm='admin';
		echo "<input name=\"aid2\" value=\"$supadm\"></td>";
	}else
		echo "<input name=\"aid2\" value=\"$aid2\"></td>";
	echo "<td  align=\"center\"><input type=password name=\"passwd\" size=\"12\"></td>";
	echo "<td  align=\"center\"><input type=password name=\"passwd2\" size=\"12\"></td>";
	echo "<td><input name=\"name\" value=\"$name\"></td>";
	echo "<td><input name=\"email\" value=\"$email\">";
	echo "<input type=\"hidden\" name=\"id_cons_gen\" value=\"$id_cons_gen\">";
	echo "<input type=\"hidden\" name=\"ok\" value=0></td>";
	if ($aid2) {
		echo "<td><input type=\"hidden\" name=\"do\" value=\"update\">";
		echo "<input type=\"submit\" name=\"add\" value=\""._MODIFY."\"></td></tr>";
	}else{
		echo "<td><input type=\"hidden\" name=\"do\" value=\"add\">";
		echo "<input type=\"submit\" name=\"add\" value=\""._NEW." "._UTENTE."\"></td></tr>";
	}
	echo "</table></form><br>";

	CloseTable();
}

function operatori($do,$aid2,$name,$email,$passwd,$passwd2,$id_comune) {
	global $aid, $prefix, $dbi, $id_cons,$id_cons_gen,$currentlang;
	$perms=ChiSei($id_cons_gen);
       
	if ($perms!=256) $id_comune=$_SESSION['id_comune'];
	if ($perms>32 and $aid2) {
		if ($do == "add") {
			$sql="select * from ".$prefix."_authors where aid='$aid2' and id_comune=$id_comune";
			$res=mysql_query($sql,$dbi);
			$max=mysql_num_rows($res);
			if ($passwd==$passwd2 and $max==0){
				if ($aid2=='admin') $super='1,0,0,'; else $super = '0,1,0,';
				$sql="insert into ".$prefix."_authors (aid,name,id_comune,email,pwd,counter,adminop,admincomune,adminsuper,admlanguage) values ('$aid2','$name','$id_comune' , '$email','".md5($passwd)."',0,$super'$currentlang')";
				$result = mysql_query($sql, $dbi)||die("Errore 1301: Non e' stato possibile inserire l'utente!<br>$sql<br>".mysql_error());
				if ($perms==256 and $aid2=='admin'){
					$result = mysql_query("insert into ".$prefix."_ele_operatori (id_cons,id_sede,id_comune,permessi,aid) values ('0','0','$id_comune','64','$aid2')", $dbi) || die("<br><br>Errore di inserimento: ".mysql_error());
				}
			Header("Location: admin.php?op=operatori&id_cons_gen=$id_cons_gen");
			}else{
				$mex='';
				if($passwd!=$passwd2) $mex="- Le password non coincidono! -<br>";
				if($max>0) $mex.=" - Utente <b>$aid2</b> presente in archivio! - ";
				header("location:admin.php?op=operatori&id_cons_gen=$id_cons_gen&aid2=$aid2&name=$name&email=$email&mex=$mex");
			}
		} elseif ($do == "update") {
			$result = mysql_query("update  ".$prefix."_authors set name='$name',pwd='".md5($passwd)."', email='$email' where id_comune='$id_comune' and aid='$aid2' ", $dbi);
			if (!$result) return;
			if ($aid2==$aid) $_SESSION['pwd']=md5($passwd);
			Header("Location: admin.php?op=operatori&id_cons_gen=$id_cons_gen");
		}
	} 
}

	
//****************************
// switch
//****************************
	if ($do) operatori($do,$aid2,$name,$email,$passwd,$passwd2,$id_comune);
	ele();
	all();
	echo"</td></tr></table>";
	include("footer.php");
?>

