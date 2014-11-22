<?php
/************************************************************************/
/* Eleonline - Raccolta e diffusione dei dati elettorali                */
/* by Roberto Gigli & Luciano Apolito                                   */
/* http://www.eleonline.it                                              */
/* info@eleonline.it  luciano@aniene.net rgigli@libero.it               */
/************************************************************************/
/* Modulo Come si vota, servizi, numeri e link                          */
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
$perms=ChiSei(0);


if (isset($param['add_title'])) get_magic_quotes_gpc() ? $add_title=$param['add_title']:$add_title=addslashes($param['add_title']); else $add_title='';
if (isset($param['add_preamble'])) get_magic_quotes_gpc() ? $add_preamble=$param['add_preamble']:$add_preamble=addslashes($param['add_preamble']); else $add_preamble='';
if (isset($param['add_content'])) get_magic_quotes_gpc() ? $add_content=$param['add_content']:$add_content=addslashes($param['add_content']); else $add_content='';
if (isset($param['vai'])) get_magic_quotes_gpc() ? $vai=$param['vai']:$vai=addslashes($param['vai']); else $vai='come';
if (isset($param['mid'])) get_magic_quotes_gpc() ? $mid=$param['mid']:$mid=addslashes($param['mid']); else $mid='';
if (isset($param['ok'])) get_magic_quotes_gpc() ? $ok=$param['ok']:$ok=addslashes($param['ok']); else $ok='';
if (isset($param['op'])) get_magic_quotes_gpc() ? $op=$param['op']:$op=addslashes($param['op']); else $op='come';
$tab='_ele_'.$op;

/*********************************************************/
/* come Functions                                    */
/*********************************************************/
$sql="SELECT t1.descrizione,t1.tipo_cons,t2.id_cons FROM ".$prefix."_ele_consultazione as t1, ".$prefix."_ele_cons_comune as t2 where t1.id_cons_gen=t2.id_cons_gen and t2.id_cons_gen='$id_cons_gen' and t2.id_comune='$id_comune'";
$res = mysql_query("$sql", $dbi);
list($descr_cons,$tipo_cons,$id_cons) = mysql_fetch_row($res);

include("modules/Elezioni/ele.php");
include("inc/funzioni.php");

function come() {
    global $admin, $bgcolor1, $bgcolor2, $prefix, $dbi, $id_cons, $tipo_cons, $id_cons,$id_cons_gen, $editimage1,
    $add_content, $add_preamble, $add_title, $vai,$mid,$tab,$op,$editor;

    if ($tab=='_ele_come') echo "<center><font class=\"title\"><b>"._ADMINCOME."</b></font></center><br>";
    elseif ($tab=='_ele_numeri') echo "<center><font class=\"title\"><b>"._ADMINNUMERI."</b></font></center><br>";
    elseif ($tab=='_ele_servizi') echo "<center><font class=\"title\"><b>"._ADMINSERVIZI."</b></font></center><br>";
    elseif ($tab=='_ele_link') echo "<center><font class=\"title\"><b>"._ADMINLINK."</b></font></center><br>";
    
    echo "<br>";

    
    echo "<center><font class=\"title\"><b>"._ALLCOME."</b></font><br><br><table border=\"0\" width=\"70%\" >"
	."<td bgcolor=\"$bgcolor1\" align=\"center\"><b>"._TITOLO."</b></td>"
	."<td bgcolor=\"$bgcolor1\" align=\"center\">&nbsp;<b>"._FUNZIONI."</b>&nbsp;</td></tr>";
    $result = mysql_query("select  mid, title,preamble, content,  editimage from ".$prefix.$tab."  where id_cons='$id_cons'", $dbi);
    while(list($mid2, $title, $preamble, $content,  $editimage) = mysql_fetch_row($result)) {

	echo "<tr>"
	    ."<td align=\"center\" width=\"100%\">$title</td>"
	     ."<td align=\"right\" nowrap bgcolor=\"$bgcolor1\"><a href=\"admin.php?op=$op&amp;vai=editedit&amp;mid=$mid2&amp;id_cons_gen=$id_cons_gen\">
	     <img src=\"modules/Elezioni/images/edit.gif\" border=\"0\" align=\"middle\"> "._EDIT."</a> -
		<a href=\"admin.php?op=$op&amp;vai=deleteedit&amp;mid=$mid2&amp;id_cons_gen=$id_cons_gen\">"._DELETE."
	     <img src=\"modules/Elezioni/images/delete.gif\" border=\"0\" align=\"middle\"></a>"
	    ."</td></tr>";

    }
    echo "</table><br>";
    echo "<table border=\"0\" width=\"70%\"><tr><td>";
    echo "<br>";
    if($vai=='editedit'){
    $result = mysql_query("select title, preamble,content, editimage from ".$prefix.$tab." WHERE mid='$mid' AND id_cons='$id_cons'", $dbi);
    list($add_title,$add_preamble, $add_content, $editimage) = mysql_fetch_row($result);
    }
//25.05.2009
    $sql="SELECT editor,ed_user FROM ".$prefix."_config";
$res = mysql_query("$sql", $dbi);
list($editor,$ed_user) = mysql_fetch_row($res);
//

    echo "<center><font class=\"title\"><b>"._ADDCOME."</b></font></center><br>";
    echo "<form  action=\"admin.php\" method=\"post\">";
    echo "<br><b><h6>"._TITOLO.":</b><br>
         <input class=\"modulo\" type=\"text\" name=\"add_title\" value=\"$add_title\" size=\"50\" maxlength=\"100\"><br><br>";
    if ($op=="link"){
         if ($add_preamble=='')$add_preamble="http://";
	echo "<b>"._LINK.":</b><br>"
	."<input class=\"modulo\" name=\"add_preamble\" size=\"50\" value=\"$add_preamble\"><br><br><b>";
     }else{
	echo "<b>"._PREAMBOLO.":</b><br>";
//25 maggio 2009
	if ($editor)
		js_textarea("add_preamble", "$add_preamble", "$ed_user", "80", "10"); // 25 --> 24 maggio 2009 editor'
	else
		echo "<textarea class=\"modulo\" name=\"add_preamble\" rows=\"7\" wrap=\"virtual\" cols=\"60\">$add_preamble</textarea><br><br><b>";
//
	echo "<br><br><b>";
     }	
	if ($op=='come') echo _CONTENUTO;
	elseif ($op=='numeri') echo _NUMERITEL;
	elseif ($op=='servizi') echo _DESCRAPP;
	elseif ($op=='link') echo _DESCRLINK;
	echo ":</b><br>";
        //( "._HELPHTML." )<br>";
//25 maggio 2009

	if ($editor)
		js_textarea("add_content", "$add_content", "$ed_user", "80", "20"); // 25 -->24 maggio 2009 editor
	else
		echo "<textarea class=\"modulo\" name=\"add_content\" rows=\"15\" wrap=\"virtual\" cols=\"60\">$add_content</textarea><br><br>";
//
	echo "<br/><br/>";
       echo "<input type=\"hidden\" name=\"id_cons_gen\" value=\"$id_cons_gen\">"
       ."<input type=\"hidden\" name=\"mid\" value=\"$mid\">"
       ."<input type=\"hidden\" name=\"tab\" value=\"$tab\">"
	."<input type=\"hidden\" name=\"op\" value=\"$op\">";
	if ($vai=='editedit'){
   	echo "<input type=\"hidden\" name=\"vai\" value=\"saveedit\">"
	."<input class=\"modulo-button\"type=\"submit\" value=\""._OK."\">";
	}else{
        echo "<input type=\"hidden\" name=\"vai\" value=\"addedit\">"
	."<input class=\"modulo-button\" type=\"submit\" value=\""._ADDCOME."\">";
	}
	
	echo "</form>";
        echo "</td></tr></table></center>";
   echo"</td></tr></table>";
     include ("footer.php");
}

function saveedit($mid, $title, $preamble, $content) {
    global $prefix, $dbi,$id_cons,$id_cons_gen,$tab,$op;

$temp=$title.$preamble.$content;
	if (preg_match("/script/i",$temp)) die("La parola script e' proibita, devi toglierla dal testo.");
    $result = mysql_query("update ".$prefix.$tab." set title='$title', preamble='$preamble', content='$content' WHERE mid='$mid' AND id_cons='$id_cons'", $dbi);
    Header("Location: admin.php?op=$op&vai=come&id_cons_gen=$id_cons_gen");
}

function addedit($add_title, $add_preamble, $add_content) {
    global $prefix, $dbi,$id_cons, $id_cons_gen,$tab,$op;

    $result = mysql_query("insert into ".$prefix.$tab." (id_cons,title,preamble,content) values ('$id_cons', '$add_title', '$add_preamble','$add_content')", $dbi);
    if (!$result) {
	exit();
    }
    Header("Location: admin.php?op=$op&vai=come&id_cons_gen=$id_cons_gen");
}


function deleteedit($mid, $ok=0) {
    global $prefix, $dbi, $id_cons,$id_cons_gen,$tab,$op;
    if($ok) {
	$result = mysql_query("delete from ".$prefix.$tab." where mid=$mid and id_cons='$id_cons'", $dbi);
    	if (!$result) {
	    return;
    	}
	Header("Location: admin.php?op=$op&vai=come&id_cons_gen=$id_cons_gen");
    } else {
    	ele();
	OpenTable();
	echo "<center><font size=\"4\"><b>"._ADMINCOME."</b></font></center>";
	CloseTable();
	echo "<br>";
	OpenTable();
	echo "<center>"._REMOVEINFO."";
	echo "<br><br>[ <a href=\"admin.php?op=$op&amp;vai=come&amp;id_cons_gen=$id_cons_gen\">"._NO."</a> | <a href=\"admin.php?op=$op&amp;vai=deleteedit&amp;mid=$mid&amp;ok=1&amp;id_cons_gen=$id_cons_gen\">"._YES."</a> ]</center>";
    	CloseTable();
	echo"</td></tr></table>";
	include("footer.php");
    }



}
switch ($vai){

// or "come" or "servizi" or "editedit"
    case "come":
	ele();
    come();
    break;
    case "editedit":
	ele();
    come();
    break;

    case "saveedit":
    saveedit($mid, $add_title, $add_preamble,$add_content);
    break;

    case "numeri":
	ele();
    come();
    break;

    case "servizi":
	ele();
    come();
    break;
    
     case "link":
	ele();
    come();
    break;



    case "addedit":
    addedit($add_title, $add_preamble,$add_content);
    break;

    case "deleteedit":
    deleteedit($mid, $ok);
    break;

    

}

?>
