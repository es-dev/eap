<?php
/*
Gestione del tema
==================
Files:
header.html = testata
footer.html = piede
bloccogen.html = blocco laterale generale
bloccocons.html = blocco laterale consultazione
bloccoref.html  = blocco laterale referendum

*/

// tema
//$bgcolor="#b0b0b0";
$nometema=$tema;

function testata(){
global $nometema,$file,$bgcolor,$sitename,$dbi,$prefix,$blocco,$lang;
echo "<div id=\"container\" >";
if ($file=="index") menu();






echo "<table class=\"table-main\" cellpadding=\"0\" cellspacing=\"0\"><tr>";
//echo "<div class=\"sx"\>";
if ($blocco=='1') echo "<td><div class=\"sx\">";
//"<td  class=\"td-640\">";
else echo "<td>";

   

}

function piede(){
global $nometema,$blocco,$lang;
$tmpl_file = "temi/language/$lang/footer.html";
$thefile = implode("", file($tmpl_file));
$thefile = addslashes($thefile);
$thefile = "\$r_file=\"".$thefile."\";";
eval($thefile);
print $r_file;
if($blocco==1){
         
	blocco();
	
	echo "</td></tr></table>";
        echo "</div>"; #container
}
}


function blocco(){

global $name,$blocco,$bgcolor, $nometema,$id_comune,$tipo_cons,$id_cons_gen,$id_cons,$prefix,$dbi, $votog,$votol,$votoc,$circo,$genere,$lang,$op,$id_circ;

//echo "</div></td><td valign=\"top\" class=\"td-149\"><div id=\"dx\">";
echo "</div></td><td valign=\"top\" class=\"td-149\"><div class=\"sidebar\">";
echo "<a href=\"modules.php?name=$name&amp;op=$op&amp;id_comune=$id_comune&amp;id_cons=$id_cons&amp;id_cons_gen=$id_cons_gen&amp;block=0\"><img class=\"noblocco\" src=\"modules/Elezioni/images/close.gif\" alt=\"NoBlocco\" title=\"NoBlocco\" /></a>";



// Blocco generale
//if ($id_cons_gen){

$tmpl_file = "temi/language/$lang/bloccogen.html";
$thefile = implode("", file($tmpl_file));
$thefile = addslashes($thefile);
$thefile = "\$r_file=\"".$thefile."\";";
eval($thefile);
print $r_file;

// Blocco consultazioni
if ($genere>2){
$tmpl_file = "temi/language/$lang/bloccocand.html";
$thefile = implode("", file($tmpl_file));
$thefile = addslashes($thefile);
$thefile = "\$r_file=\"".$thefile."\";";
eval($thefile);
print $r_file;
}else{
if ($genere==0){
//Blocco Referendum
$tmpl_file = "temi/language/$lang/bloccoref.html";
$thefile = implode("", file($tmpl_file));
$thefile = addslashes($thefile);
$thefile = "\$r_file=\"".$thefile."\";";
eval($thefile);
print $r_file;
}
}
// Blocco link

$result = mysql_query("select mid, title, preamble, content,editimage from ".$prefix."_ele_link where id_cons='$id_cons' order by mid ", $dbi);
    if (mysql_num_rows($result) == 0) {
	echo "</td></tr></table>";
        echo "</div></td><td>";
	//echo "</td><td valign=\"top\" width=\"640\" bgcolor=\"#ffffff\">";
	return;
    } else {
	echo "<h5>"._LINK."</h5><p>";
	while (list($mid, $title, $preamble,$content,  $editimage) = mysql_fetch_row($result)) {
  		if ($title != "" && $content != "") {
			$content = stripslashes($content);
    			$content = substr($content,0,45);
			echo "<b><a href=\"$preamble\">
			$title</a></b><br />

			$content<br/>";
		}		     
	}
	//echo "</p>";
   }	


echo "</td></tr></table>";

echo "</div></td>";

echo "<td>";


}







?>
