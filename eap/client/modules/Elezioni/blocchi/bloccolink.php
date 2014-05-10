<?php
# blocco link

global $genere,$id_cons_gen,$id_cons,$id_comune,$prefix,$dbi;
$result = mysql_query("select mid, title, preamble, content,editimage from ".$prefix."_ele_link where id_cons='$id_cons' order by mid ", $dbi);
    if (mysql_num_rows($result) == 0) {
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
	
   }	


?>

