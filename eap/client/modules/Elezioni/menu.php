<?php
/************************************************************************/
/* Eleonline - Raccolta e diffusione dei dati elettorali                */
/* by Luciano Apolito & Roberto Gigli                                   */
/* http://www.eleonline.it                                              */
/* info@eleonline.it  luciano@aniene.net rgigli@libero.it               */
/************************************************************************/

if (!defined('MODULE_FILE')) {
    die ("You can't access this file directly...");
}

/************************
Funzione Menu a cascata
*************************/

        
        // definizione variabile per button 'ok' nei form per il noscript
	$button="<br /><object><noscript><div><input name=\"vai\" type=\"image\" src=\"modules/Elezioni/images/ok2.jpg\" alt=\"ok\" title=\"ok\" /></div></noscript></object>";
	
	$sqlcomu="select descrizione,fascia from ".$prefix."_ele_comuni where id_comune=$id_comune";
	$rescomu= mysql_query("$sqlcomu",$dbi);
	list($descr_com,$fascia)=mysql_fetch_row($rescomu);
        
	
       
        // inizio tabella
	echo "<table  class=\"table-main\"> <tr>";
	
	/*********************************** 
		Scelta Comune
	***********************************/
	
	if ($multicomune=='1')
	{
	      $sqlcomu="select t1.id_comune,t1.descrizione,count(0) from ".$prefix."_ele_comuni as t1, ".$prefix."_ele_cons_comune as t2 where t1.id_comune=t2.id_comune and t2.chiusa<2 group by t1.id_comune,t1.descrizione order by t1.descrizione asc";
	      $rescomu= mysql_query("$sqlcomu",$dbi);
	      $esiste_multi=mysql_num_rows($rescomu);
	      if ($esiste_multi>=1) {
		echo "	<td>
			    <form id=\"comuni\" method=\"post\" action=\"modules.php\">
			    <div><label class=\"blu\" for=\"comuni\">
			    <input type=\"hidden\" name=\"name\" value=\"Elezioni\" />
			    <input type=\"hidden\" name=\"op\" value=\"gruppo\" />
			    <input type=\"hidden\" name=\"id_cons_gen\" value=\"$id_cons_gen\" />
			    <input type=\"hidden\" name=\"info\" value=\"$info\" />
			    <input type=\"hidden\" name=\"pag\" value=\"/modules.php?id_cons_gen=\" />
			    <input type=\"hidden\" name=\"file\" value=\"index\" />
			    <select name=\"op\" class=\"moduloform\" onchange=\"javascript:top.location.href='modules.php?id_cons_gen=$id_cons_gen&amp;name=Elezioni&amp;op=gruppo&amp;file=index&amp;id_comune='+this.options[this.options.selectedIndex].value\">
			";
			
		while (list($id,$descrizione,)=mysql_fetch_row($rescomu)){
			    $sel=($id == $id_comune) ? "selected=\"selected\"":"";
			    echo "<option value=\"$id\" $sel >$descrizione</option>";
			}
	
			    echo "</select>$button</label></div></form></td>";
	  }
	} // fine scelta comune
	
	
	
	/*********************************** 
		Scelta Consultazione
	***********************************/
	
	
        echo "<td  >";
	$res = mysql_query("SELECT t1.id_cons_gen,t1.descrizione FROM ".$prefix."_ele_consultazione as t1, ".$prefix."_ele_cons_comune as t2 where t1.id_cons_gen=t2.id_cons_gen and t2.id_comune='$id_comune' and t2.chiusa!='2' order by t1.data_fine desc" , $dbi); 
	$esiste=mysql_num_rows($res);
	//se esiste consultazione fa vedere i dati
	if ($esiste>=1) {	
	    echo "
		<form id=\"consultazione\" method=\"post\" action=\"modules.php\">
		<div><label for=\"consultazione\" class=\"blu\">
		<input id=\"modulo\" type=\"hidden\" name=\"name\" value=\"Elezioni\" />
      		<input type=\"hidden\" name=\"op\" value=\"gruppo\" />
		<input type=\"hidden\" name=\"minsez\" value=\"$minsez\" />
		<input type=\"hidden\" name=\"offsetsez\" value=\"$offsetsez\" />
		<input type=\"hidden\" name=\"id_comune\" value=\"$id_comune\" />
      		<input type=\"hidden\" name=\"prima\" value=\"1\" />
		<select name=\"id_cons_gen\" class=\"moduloform\" onchange=\"javascript:top.location.href='modules.php?op=gruppo&amp;name=Elezioni&amp;id_comune=$id_comune&amp;file=index&amp;id_cons_gen='+this.options[this.options.selectedIndex].value\">";
	
	    while(list($id,$descrizione) = mysql_fetch_row($res)) {
		
     		$sel = ($id == $id_cons_gen) ? "selected=\"selected\"":"";		
	        echo "<option value=\"$id\" $sel >$descrizione</option>";
	    }
 
	    echo "</select>$button</label></div></form></td>";
	





	/*********************************** 
		Scelta Info
	***********************************/
        
        echo "<td>";
	
	
	echo "
		<form id=\"info\" method=\"post\" action=\"modules.php\">
		<div><label class=\"blu\" for=\"info\">
     		<input type=\"hidden\" name=\"name\" value=\"Elezioni\" />
      		<input type=\"hidden\" name=\"op\" value=\"come\" />
      		<input type=\"hidden\" name=\"id_cons_gen\" value=\"$id_cons_gen\" />
       		<input type=\"hidden\" name=\"id_comune\" value=\"$id_comune\" />
       		<input type=\"hidden\" name=\"file\" value=\"index\" />
		<select name=\"op\" class=\"moduloform\" onchange=\"javascript:top.location.href='modules.php?id_cons_gen=$id_cons_gen&amp;name=Elezioni&amp;op=come&amp;id_comune=$id_comune&amp;file=index&amp;info='+this.options[this.options.selectedIndex].value\">";		

		echo "<option value=\"\" >----- "._INFO."</option>";
	
		$temp = array('confronti'=>'','come'=>'','numeri'=>'','servizi'=>'','link'=>'','dati'=>'','affluenze_sez'=>'','votanti'=>'');
		$temp[$info]='selected="selected"';
	 	echo "<option value=\"confronti\" ".$temp['confronti']." >"._CONFRONTI."</option>";  
	 	echo "<option value=\"come\" ".$temp['come']." >"._COME."</option>";  
	 	echo "<option value=\"numeri\" ".$temp['numeri']." >"._NUMERI."</option>";  
	 	echo "<option value=\"servizi\" ".$temp['servizi']." >"._SERVIZI."</option>"; 
		echo "<option value=\"link\" ".$temp['link']." >"._LINK."</option>";
	 	echo "<option value=\"dati\" ".$temp['dati']." >"._DATI."</option>";
	 	 // tolte per circo da mettere bene
		 echo "<option value=\"affluenze_sez\" ".$temp['affluenze_sez']." >"._AFFLUENZE."</option>";
		echo "<option value=\"votanti\" ".$temp['votanti']." >"._VOTANTI."</option>";
      		
                echo "</select>$button
			</label></div></form></td>";
		unset ($temp);
		/*********************************** 
		Scelta Dati
		***********************************/
 	$res = mysql_query("SELECT count(0) FROM ".$prefix."_ele_circoscrizione where id_cons='$id_cons' ", $dbi);
	list($num_circ) = mysql_fetch_row($res);
       	 
        	echo "<td>";
	
		echo "<form id=\"risultati\" method=\"post\" action=\"modules.php\">
		<div><label class=\"blu\" for=\"risultati\">";   //._RISULTATI;
      		echo "<input type=\"hidden\" name=\"name\" value=\"Elezioni\" />
      			<input type=\"hidden\" name=\"id_cons_gen\" value=\"$id_cons_gen\" />
       			<input type=\"hidden\" name=\"id_comune\" value=\"$id_comune\" />
       			<input type=\"hidden\" name=\"file\" value=\"index\" />
			<select name=\"op\" class=\"moduloform\" onchange=\"javascript:top.location.href='modules.php?id_cons_gen=$id_cons_gen&amp;name=Elezioni&amp;id_comune=$id_comune&amp;file=index&amp;op='+this.options[this.options.selectedIndex].value\">";	

		echo "<option value=\"\" >----- "._RISULTATI."</option>"; 
		$temp = array('gruppo_circo'=>'','gruppo_sezione'=>'','lista_circo'=>'','lista_sezione'=>'','candidato_circo'=>'','candidato_sezione'=>'','consiglieri'=>'');
		$temp[$op]='selected="selected"';
		
		if ($genere!=4) {
			if (!$circo and $num_circ>1)
	 			echo "<option value=\"gruppo_circo\" ".$temp['gruppo_circo'].">".substr(_GRUPPO." "._PER." "._CIRCO,0,33)."</option>";
	 		echo "<option value=\"gruppo_sezione\" ".$temp['gruppo_sezione'].">".substr(_GRUPPO." "._PER." "._SEZIONI,0,33)."</option>";
		}
		if (!$votol and $fascia>$limite){ // si vota per la lista
			if ($genere>2) {
				if (!$circo and $num_circ>1)
			              echo "<option value=\"lista_circo\" ".$temp['lista_circo']." >".substr(_LISTA." "._PER." "._CIRCO,0,33)."</option>";
			        echo "<option value=\"lista_sezione\" ".$temp['lista_sezione']." >".substr(_LISTA." "._PER." "._SEZIONI,0,33)."</option>";
			      }
		    	  
		}
		
		if ($genere>3 and !$votoc) {
				if (!$votoc){
			      		if(!$circo and $num_circ>1)
					echo "<option value=\"candidato_circo\" ".$temp['candidato_circo']." >".substr(_CONSI." "._PER." "._CIRCO,0,33)."</option>";
				echo "<option value=\"candidato_sezione\" ".$temp['candidato_sezione']." >".substr(_CONSI." "._PER." "._SEZIONI,0,33)."</option>";
				
			}
      		}
		if ($hondt>=1) {
					echo "<option value=\"consiglieri\" ".$temp['consiglieri']." >"._CALCONS."</option>";
				
			
      		}		
		echo "</select>$button
			</label></div></form></td>";
		unset ($temp);


	/*********************************** 
		Scelta Grafici
	***********************************/
        
        echo "<td >";

		$temp = array('affluenze_graf'=>'','graf_votanti'=>'','graf_gruppo'=>'','graf_lista'=>'','graf_candidato'=>'');
		if(!isset($visgralista))
			$temp[$op]='selected="selected"';
		else $temp['graf_lista']='selected="selected"';
		#	<div><label class=\"blu\" for=\"grafici\">"._GRAFICI."
		
		echo "<form id=\"grafici\" method=\"post\" action=\"modules.php\">
			<div><label class=\"blu\" for=\"grafici\">
      			<input type=\"hidden\" name=\"name\" value=\"Elezioni\" />
      			<input type=\"hidden\" name=\"id_cons_gen\" value=\"$id_cons_gen\" />
       			<input type=\"hidden\" name=\"id_comune\" value=\"$id_comune\" />
       			<input type=\"hidden\" name=\"file\" value=\"index\" />
			<select name=\"op\" class=\"moduloform\" onchange=\"javascript:top.location.href='modules.php?id_cons_gen=$id_cons_gen&amp;name=Elezioni&amp;id_comune=$id_comune&amp;file=index&amp;op='+this.options[this.options.selectedIndex].value\">";
		echo "<option value=\"\" >----- "._GRAFICI."</option>";
	 
	 	echo "<option value=\"affluenze_graf\" ".$temp['affluenze_graf']." >"._AFFLUENZE."</option>";
		echo "<option value=\"graf_votanti\" ".$temp['graf_votanti']." >"._VOTI."</option>";
#inutile	 	if($genere!=4 || $tipo_cons==8)
	 		echo "<option value=\"graf_gruppo\" ".$temp['graf_gruppo']." >"._GRUPPO."</option>";
	 		if($genere==5)
	 		echo "<option value=\"graf_gruppo&amp;visgralista=1\" ".$temp['graf_lista'].">"._LISTA."</option>";
		if ($genere>3){
			if (!$circo && !$votog)	 
	 		echo "<option value=\"graf_candidato\" ".$temp['graf_candidato']." >"._CONSI."</option>";
		}
		unset ($temp);
	 
   		echo "</select>$button
			</label></div></form></td>";

	} // fine verifica esistenza consultazione : variabile $esiste
	  


           ################ tema ##### 
            if ($tema_on=="1"){
	   	echo "<td>";
           	include("modules/Elezioni/tema.php");		
	   	echo "</td>";	
	   }	


      		echo "</tr></table>";


	
?>
