<?php

/************************************************************************/
/* Eleonline - Raccolta e diffusione dei dati elettorali                */
/* by Roberto Gigli & Luciano Apolito                                   */
/* http://www.eleonline.it                                              */
/* info@eleonline.it  luciano@aniene.net rgigli@libero.it               */
/************************************************************************/
/* Modulo cambio password amministrazione                               */
/* Amministrazione                                                      */
/************************************************************************/


if (!defined('ADMIN_FILE')) {
    die ("You can't access this file directly...");
}
$aid=$_SESSION['aid'];
$dbi=$_SESSION['dbi'];
$prefix=$_SESSION['prefix'];
$currentlang=$_SESSION['lang'];
$id_comune=$_SESSION['id_comune'];
$param=strtolower($_SERVER['REQUEST_METHOD']) == 'get' ? $_GET : $_POST;
$id_cons_gen=$param['id_cons_gen'];
$perms=ChiSei($id_cons_gen);


if (isset($param['pwd1'])) get_magic_quotes_gpc() ? $pwd1=$param['pwd1']:$pwd1=addslashes($param['pwd1']); else $pwd1='';
if (isset($param['pwd2'])) get_magic_quotes_gpc() ? $pwd2=$param['pwd2']:$pwd2=addslashes($param['pwd2']); else $pwd2='';
if (isset($param['oldpwd'])) get_magic_quotes_gpc() ? $oldpwd=$param['oldpwd']:$oldpwd=addslashes($param['oldpwd']); else $oldpwd='';
if (isset($param['op'])) get_magic_quotes_gpc() ? $op=$param['op']:$op=addslashes($param['op']); else $op='cambiopwd';
if (isset($param['mex'])) $mex=intval($param['mex']); else $mex='';

/*********************************************************/
/* cambiopwd Functions                                    */
/*********************************************************/

include("modules/Elezioni/ele.php");

function cambiopwd() {
    global $admin, $bgcolor1, $bgcolor2, $prefix, $dbi, $id_cons_gen, $op, $mex;
    if ($mex==1)
        echo "<center><font class=\"title\"><b>"._ERRPWD."</b></font></center><br>";
    else
        echo "<center><font class=\"title\"><b>"._CHGPWD."</b></font></center><br>";
    echo "<br><br><table border=\"0\" width=\"100%\" ><tr>"
	."<td bgcolor=\"$bgcolor1\" align=\"center\"><b>"._OLDPWD."</b></td>"
	."<td bgcolor=\"$bgcolor1\" align=\"center\"><b>"._NEWPWD1."</b></td>"
	."<td bgcolor=\"$bgcolor1\" align=\"center\"><b>"._NEWPWD2."</b></td><td>&nbsp;</td></tr>";
    echo "<form name=\"cngpwd\" action=\"admin.php\" method=\"post\" >";
    echo "<tr>"
	."<td align=\"center\"> <input type=\"password\" name=\"oldpwd\" value=\"\"></td>"
	."<td align=\"center\"> <input type=\"password\" name=\"pwd1\" value=\"\"></td>"
	."<td align=\"center\"> <input type=\"password\" name=\"pwd2\" value=\"\"></td>";
    echo "<input type=\"hidden\" name=\"id_cons_gen\" value=\"$id_cons_gen\">"
	."<input type=\"hidden\" name=\"op\" value=\"$op\">";
    echo "<td align=\"center\"> <input type=\"submit\" value=\""._OK."\"></td>";
    echo "</form>";
    
    echo "</tr></table></center><br>";
}

function savepwd($oldpwd,$pwd1,$pwd2) {
    global $prefix, $dbi,$id_cons_gen,$op;
    $aid=$_SESSION['aid'];
    if ($pwd1==$pwd2 and md5($oldpwd)==$_SESSION['pwd']) {
        $result = mysql_query("update ".$prefix."_authors set pwd='".md5($pwd1)."' WHERE aid='$aid' and pwd='".md5($oldpwd)."'", $dbi) || die("Errore di accesso ai dati!".mysql_error());
        $_SESSION['pwd']=md5($pwd1);
    }else{
	Header("Location: admin.php?op=$op&id_cons_gen=$id_cons_gen&mex=1");die();
    }
    Header("Location: admin.php?id_cons_gen=$id_cons_gen");
}




if ($oldpwd!='' and $pwd1!='') {
	savepwd($oldpwd,$pwd1,$pwd2);
} else {//die($pwdold."!=\'\' and ".$pwd1."!=\'\'");
	ele();
	cambiopwd();
}
echo"</td></tr></table>";
include("footer.php");

?>
