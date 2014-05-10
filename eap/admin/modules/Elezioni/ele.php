<?php
/************************************************************************/
/* Eleonline - Raccolta e diffusione dei dati elettorali                */
/* by Roberto Gigli & Luciano Apolito                                   */
/* http://www.eleonline.it                                              */
/* info@eleonline.it  luciano@aniene.net rgigli@libero.it               */
/************************************************************************/
/* Modulo menu                                                          */
/* Amministrazione                                                      */
/************************************************************************/

if (!defined('ADMIN_FILE')) {
    die ("You can't access this file directly...");
}
if (!ini_get("register_globals")) {
    $php_ver = phpversion();
    $php_ver = explode(".", $php_ver);
    $phpver = "$php_ver[0]$php_ver[1]";
    if ($phpver >= 41) {
	$PHP_SELF = $_SERVER['PHP_SELF'];
    }
}

$aid=$_SESSION['aid'];
$dbi=$_SESSION['dbi'];
$id_comune=$_SESSION['id_comune'];
$prefix=$_SESSION['prefix'];
$currentlang=$_SESSION['lang'];
$bgcolor1=$_SESSION['bgcolor1'];
$bgcolor2=$_SESSION['bgcolor2'];
$bgcolor1='#e7e7e7';
$param=strtolower($_SERVER['REQUEST_METHOD']) == 'get' ? $_GET : $_POST;

if (!isset($id_cons_gen)) if (isset($param['id_cons_gen'])) $id_cons_gen=$param['id_cons_gen'];else $id_cons_gen='0';
$perms=ChiSei($id_cons_gen);

##modifica
if ($perms>128){
	if (isset($param['id_comune']) && intval($param['id_comune'])>0) {
		$id_comune=intval($param['id_comune']);
		$_SESSION['id_comune']=$id_comune;
	}	
}

if ($id_cons_gen) {
	if ($id_comune and $perms<256)
		$sql = "SELECT t1.tipo_cons,t1.descrizione,t2.id_cons_gen FROM ".$prefix."_ele_consultazione as t1, ".$prefix."_ele_cons_comune as t2 where t1.id_cons_gen=t2.id_cons_gen and t2.id_cons_gen='$id_cons_gen'";
	else
		$sql = "SELECT t1.tipo_cons,t1.descrizione,t1.id_cons_gen FROM ".$prefix."_ele_consultazione as t1 where  t1.id_cons_gen='$id_cons_gen'";
}else{
	if($perms>128)
		$sql = "SELECT tipo_cons,descrizione,id_cons_gen FROM ".$prefix."_ele_consultazione order by data_fine desc limit 0,1 ";
	else
		$sql = "SELECT t1.tipo_cons,t1.descrizione,t2.id_cons_gen FROM ".$prefix."_ele_consultazione as t1, ".$prefix."_ele_cons_comune as t2, ".$prefix."_ele_operatori as t3 where t3.id_comune=$id_comune and t3.id_comune=t2.id_comune and t1.id_cons_gen=t2.id_cons_gen and t2.chiusa='0' and (t3.id_cons=t2.id_cons or t3.id_cons=0) and t3.permessi>0 and t3.aid='$aid' order by t1.data_fine desc limit 0,1 ";
}

	$res = mysql_query("$sql",$dbi);
	$espandi=0;
	if (mysql_num_rows($res))
		list($tipo_cons,$descr_cons,$id_cons_gen) = mysql_fetch_row($res);
	$res = mysql_query("SELECT t2.id_cons FROM ".$prefix."_ele_consultazione as t1, ".$prefix."_ele_cons_comune as t2 where t1.id_cons_gen=t2.id_cons_gen and t2.id_cons_gen='$id_cons_gen' and t2.id_comune='$id_comune'" , $dbi);
        if (mysql_num_rows($res)) list($id_cons) = mysql_fetch_row($res);
	else	$espandi=1;
	if(!isset($tipo_cons))$tipo_cons=0;
	$res = mysql_query("SELECT genere,voto_g,voto_l,voto_c,circo FROM ".$prefix."_ele_tipo where tipo_cons='$tipo_cons' and lingua='$currentlang'" , $dbi);
	list($genere,$votog,$votol,$votoc,$conscirc) = mysql_fetch_row($res);
if (!$perms) $perms=ChiSei($id_cons_gen);
	//include("modules/Elezioni/language/lang-$currentlang.php");
	//**************************************************************************
	//        ELE
	//**************************************************************************
	if(!isset($id_cons))$id_cons=0;

	$res = mysql_query("SELECT t1.limite FROM ".$prefix."_ele_conf as t1 left join ".$prefix."_ele_cons_comune as t2 on t1.id_conf=t2.id_conf where t2.id_cons='$id_cons'" , $dbi);
	list($limite) = mysql_fetch_row($res);

function ele() {

	global $espandi, $aid, $bgcolor1, $bgcolor2,$bgcolor5, $prefix, $dbi, $offset, $min,$descr_cons,$fascia, $id_cons_gen,$tipo_cons,$genere,$op,$id_comune,$perms,$id_cons,$votog,$votol,$votoc,$votocirc,$tema;
	
	include ("header.php");
        //immagine bullet
        $bullet="<img src=\"temi/$tema/images/bullet.gif\" alt =\" \" align=\"left\" border=\"0\">";
	$bgcolor1='#e7e7e7';
	$sqlcomu="select descrizione,fascia from ".$prefix."_ele_comuni where id_comune='$id_comune'";
	$res = mysql_query($sqlcomu);
	list($descr_comu,$fascia)=mysql_fetch_row($res);
	
	$otable= "<table bgcolor=\"$bgcolor1\" width=\"100%\"   cellpadding=\"0\" cellspacing=\"2\"  BORDER=\"0\">\n <tr><td>&nbsp;&nbsp;&nbsp;</td><td valign=\"top\" align=\"left\">";
	$otable1= "<table  width=\"100%\"   cellpadding=\"0\" cellspacing=\"2\"  BORDER=\"0\">\n <tr><td valign=\"top\" width=\"180\">";
        $ctable= "</td></tr></table>";
$currentlang=$_SESSION['lang'];
	
	
	
	echo "<form name=\"scelta\" action=\"admin.php\">";
	echo $otable;
	echo "<input type=\"hidden\" name=\"pag_cons\" value=\"admin.php?id_cons_gen=\">";
	echo "<input type=\"hidden\" name=\"op\" value=\"ele\">";
	
	if ($perms<128) { 
		$res = mysql_query("select t3.id_cons, t2.descrizione,t4.genere, t2.id_cons_gen, t3.chiusa from ".$prefix."_ele_operatori as t1, ".$prefix."_ele_consultazione as t2, ".$prefix."_ele_cons_comune as t3, ".$prefix."_ele_tipo as t4 where t4.lingua='$currentlang' and t2.tipo_cons=t4.tipo_cons and t1.aid='$aid' and t3.id_cons_gen=t2.id_cons_gen and (t1.id_cons=t3.id_cons or t1.permessi=64) and t1.id_comune=t3.id_comune and t1.id_comune=$id_comune and t3.chiusa='0' order by t2.data_inizio desc", $dbi);
	}else{
		$res = mysql_query("SELECT '', t1.descrizione,t2.genere, t1.id_cons_gen,'' FROM ".$prefix."_ele_consultazione as t1,".$prefix."_ele_tipo as t2 where t2.lingua='$currentlang' and t1.tipo_cons=t2.tipo_cons order by t1.data_inizio desc", $dbi);
		$sqlcomu="select id_comune,descrizione from ".$prefix."_ele_comuni order by descrizione asc";
	}
	echo "<font size=-1><b>"._SCELTA_CONS.":</b> </font><select name=\"id_cons_gen\" onChange=\"top.location.href=this.form.pag_cons.value+this.form.id_cons_gen.options[this.form.id_cons_gen.selectedIndex].value;return false\">";
	while(list($id,$descrizione,$gen2,$idgen,$chiusa) = mysql_fetch_row($res)) { 
		if (($chiusa==0) OR ($perms>32)) {
			if (($idgen==$id_cons_gen or !$id_cons_gen)) {
					$sel = "selected";
					$genere=$gen2;
					$id_cons_gen=$idgen;
			} else {
					$sel = "";
			}
			echo "<option value=\"$idgen\" $sel>$descrizione";
		}
	}
	echo "</select>";
	// controllo delle opzioni utilizzabili: sono quelle che hanno genitori in quella precedente
	// esempio si possono inserire i candidati solo se prima sono state inserite le liste
	$resq = mysql_query("select count(0) from ".$prefix."_ele_circoscrizione where id_cons=$id_cons", $dbi);
	if ($resq) list($nrcirco)=mysql_fetch_row($resq); else $nrcirco=0;
	$resq = mysql_query("select count(0) from ".$prefix."_ele_sede where id_cons=$id_cons", $dbi);
	if ($resq) list($nrsede)=mysql_fetch_row($resq); else $nrsede=0;
	$resq = mysql_query("select count(0) from ".$prefix."_ele_gruppo where id_cons=$id_cons", $dbi);
	if ($resq) list($nrgruppo)=mysql_fetch_row($resq); else $nrgruppo=0;
	$resq = mysql_query("select count(0) from ".$prefix."_ele_lista where id_cons=$id_cons", $dbi);
	if ($resq) list($nrlista)=mysql_fetch_row($resq); else $nrlista=0;
	$resq = mysql_query("SELECT sum(voti_complessivi) from ".$prefix."_ele_voti_parziale where id_cons=$id_cons", $dbi);
	if ($resq) list($nraff)=mysql_fetch_row($resq); else $nraff=0;
	if ($genere==0) $tmpval='voti_ref'; else $tmpval='sezioni';
	$resq = mysql_query("SELECT sum(validi) from ".$prefix."_ele_$tmpval where id_cons=$id_cons", $dbi);
	if ($resq) list($nrvoti)=mysql_fetch_row($resq); else $nrvoti=0;
	unset($resq);
	if ($perms==256) // il superuser puo' scegliere il comune su cui lavorare
	{
		$rescomu= mysql_query("$sqlcomu",$dbi);
		echo "<select name=\"id_comune\" onChange=\"top.location.href=this.form.pag_cons.value+$id_cons_gen+'&amp;id_comune='+this.form.id_comune.options[this.form.id_comune.selectedIndex].value;return false\"><option value=\"\">";
		while (list($id,$descrizione)=mysql_fetch_row($rescomu))
		{
		$sel=($id == $id_comune) ? "selected":"";
		echo "<option value=\"$id\" $sel>$descrizione";
		}
	}
	echo "</select>";
	echo $ctable;
	echo "</form>";
	
	
	echo "<br>";
	
	echo $otable1;
	echo "<table width=\"180\" align=\"left\"><tr><td><table>";
	echo "<tr align=\"left\" bgcolor=\"$bgcolor1\"><td valign=\"top\" align=\"left\" width=\"150\" colspan=\"2\">
		<a href=\"admin.php?op=$op&amp;id_cons_gen=$id_cons_gen&amp;help=1\">$bullet"._HELP."</a>
		</td></tr>";

	if ($perms>128) {
	
	
#		<a href=\"admin.php?op=inscollegi&amp;id_cons_gen=$id_cons_gen\">$bullet"._COLLEGI."</a><br>
	
	echo "
		<tr align=\"left\" bgcolor=\"$bgcolor1\">
		<td valign=\"top\" align=\"center\" bgcolor=\"#000000\" rowspan=\"3\"><font face=\"Arial,Helvetica\" size=-1><font color=\"#ffffff\"><b>"._SUPER."

              </b></font></font>
		
		</td>
<td valign=\"top\" align=\"left\" width=\"150\">		
		
		
		<a href=\"admin.php?op=configurazione&amp;id_cons_gen=$id_cons_gen\">$bullet"._CONFIGURAZIONE."</a><br>";
		if($op=="configurazione" || $op=="widget" || $op=="plugin"){ 
		    echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - <a href=\"admin.php?op=widget&amp;id_cons_gen=$id_cons_gen\"> "._WIDGET."</a>";
		    echo "<br/> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - "._PLUGINS."";
		    echo "<hr/>";
		}
		echo "
		<a href=\"admin.php?op=constipi&amp;id_cons_gen=$id_cons_gen\">$bullet"._TIPO_ADM."</a><br>
		<a href=\"admin.php?op=confconsiglio&amp;id_cons_gen=$id_cons_gen\">$bullet"._CONFCONS."</a>
		</td></tr><tr align=\"left\" bgcolor=\"$bgcolor1\"><td>
		<a href=\"admin.php?op=inscomuni&amp;id_cons_gen=$id_cons_gen\">$bullet"._DEFCOMUNE."</a><br>
		<a href=\"admin.php?op=oper_admin&amp;id_cons_gen=$id_cons_gen\">$bullet"._AMMINISTRATORI."</a>
		</td></tr><tr align=\"left\" bgcolor=\"$bgcolor1\"><td>
		<a href=\"admin.php?op=consultazione&amp;id_cons_gen=$id_cons_gen\">$bullet"._CONSULTAZIONE_ADM."</a><br>

		<a href=\"admin.php?op=rec_add_aff&amp;id_cons_gen=$id_cons_gen\">$bullet"._AFFLUENZE."</a><br>
		<a href=\"admin.php?op=associazioni&amp;id_cons_gen=$id_cons_gen\">$bullet"._INSCOMUNE."</a>
		</td></tr>";
#		<a href=\"admin.php?op=backup&amp;id_cons_gen=$id_cons_gen\">$bullet"._BACKUP."</a><br>
#		<a href=\"admin.php?op=restore&amp;id_cons_gen=$id_cons_gen\">$bullet"._RESTORE."</a>
		
	} 
//	Amministrazione locale solo superuser e adminuser
	if ($perms>16 and ! $espandi) {
		echo "
		<tr bgcolor=\"$bgcolor1\">
		<td valign=\"top\" align=\"center\" bgcolor=\"#000000\"><font face=\"Arial,Helvetica\" size=-1><font color=\"#ffffff\"><b>"._ADMIN."

                </b></font></font>
		
		</td>
		<td valign=\"top\">";
		if ($perms>32) {
			echo "<a href=\"admin.php?op=cons_comuni&amp;id_cons_gen=$id_cons_gen\">$bullet"._CONSULTAZIONI."</a><br>
			<a href=\"admin.php?op=scarica&amp;id_cons_gen=$id_cons_gen\">$bullet"._SCARICA."</a><br>";
#			if($nrgruppo==0 and $nrlista==0)
			echo "<a href=\"admin.php?op=importa&amp;id_cons_gen=$id_cons_gen\">$bullet"._IMPORTA."</a><br>";
			echo "<a href=\"admin.php?op=operatori&amp;id_cons_gen=$id_cons_gen\">$bullet"._OPERATORI."</a> <br><a href=\"admin.php?op=permessi&amp;id_cons_gen=$id_cons_gen\">$bullet"._PERMESSI."</a> <br>";
		}
		echo "<a href=\"admin.php?op=come&amp;vai=come&amp;id_cons_gen=$id_cons_gen\">$bullet "._COME."</a> <br>
		<a href=\"admin.php?op=numeri&amp;vai=numeri&amp;id_cons_gen=$id_cons_gen\">$bullet "._NUMERI."</a> <br>
		<a href=\"admin.php?op=servizi&amp;vai=servizi&amp;id_cons_gen=$id_cons_gen\">$bullet "._SERVIZI."</a> <br>
                <a href=\"admin.php?op=link&amp;vai=link&amp;id_cons_gen=$id_cons_gen\">$bullet "._LINK."</a> <br>
		<a href=\"admin.php?op=circo&amp;id_cons_gen=$id_cons_gen\">
		
		$bullet"._CIRCO."</a> <br>";
		if ($nrcirco){
			echo "<a href=\"admin.php?op=sede&amp;id_cons_gen=$id_cons_gen\">$bullet "._SEDE."</a> <br>";
			if ($nrsede){
				echo "<a href=\"admin.php?op=sezione&amp;id_cons_gen=$id_cons_gen\">$bullet "._SEZIONE."</a><br>";
			}
		}
		if ($genere!=4) { //gestisce gruppi  if ($tipo_cons!=8){ $genere!=2 and 
			echo "<a href=\"admin.php?op=gruppo&amp;id_cons_gen=$id_cons_gen\">$bullet "._GRUPPO."</a><br>";
		}

		if ($genere>2 or $genere==1){ ####prova 
			if ($genere==4 or $nrgruppo){ // or $tipo_cons==10 or $tipo_cons==11){
				echo "
				<a href=\"admin.php?op=lista&amp;id_cons_gen=$id_cons_gen\">$bullet "._LISTA."</a> <br>";
			   if ($genere>2){  ####prova
				if ($nrlista){
					echo "<a href=\"admin.php?op=candidato&amp;id_cons_gen=$id_cons_gen\">$bullet"._CANDIDATO."</a> <br>";
				}else{
					echo "$bullet "._CANDIDATO." ";
				}
			   }
			}else{
				echo "
				$bullet"._LISTA." <br>";
				echo "$bullet "._CANDIDATO." <br>";
			
			}
			
		}

	echo "</td></tr>";
	}
	
		
	//Amministrazione normale operatore
	echo "<tr bgcolor=\"$bgcolor1\">
	<td valign=\"top\" align=\"center\" bgcolor=\"#000000\"><font face=\"Arial,Helvetica\" size=-1><font color=\"#ffffff\"><b>"._OPER."

                </b></font></font>
		
		</td>
	<td valign=\"top\" width=\"150\">";
	if ($op!='consultazione' and $perms>0 and $nrcirco and ($nrlista or $nrgruppo)) {
			echo "<a href=\"admin.php?op=voti&amp;id_cons_gen=$id_cons_gen&amp;do=spoglio\">$bullet "._GEST." "._SPOGLIO."</a><br>";
		if ($nraff) {
			echo "<a href=\"admin.php?op=controllo_votanti&amp;id_cons_gen=$id_cons_gen\">$bullet "._STATO." "._AFFLUENZE."</a><br>";
		}else{
			echo "<img src=\"modules/Elezioni/images/site.gif\" alt =\" \" align=\"center\" border=\"0\"> "._STATO." "._AFFLUENZE."<br>";
		}
		if ($nrvoti) {
			echo "<a href=\"admin.php?op=controllo_voti&amp;id_cons_gen=$id_cons_gen\">$bullet "._STATO." "._VOTI."</a><br>";
		}else{
			echo "<img src=\"modules/Elezioni/images/site.gif\" alt =\" \" align=\"middle\" border=\"0\"> "._STATO." "._VOTI."<br>";
		}
	}
		echo "<br><a href=\"admin.php?op=cambiopwd&amp;id_cons_gen=$id_cons_gen\">$bullet"._CAMBIOPWD."</a><br>";
	echo "<a href=\"admin.php?op=logout\">$bullet "._ESCI."</a>";
	echo "</td></tr></table>";
	// continua la tabella su ele.voti con le sezioni
	// altrimenti inizia la tabella centrale
	
	if ($op!="voti")
	echo "</td></tr></table></td><td valign=\"top\" align=left>";

}

	switch ($op){
		case "ele":
		ele();
		global $language;
		include("language/$language/ele.html");
		echo"</td></tr></table>";
		include("footer.php");

		break;
		
	}


?>
