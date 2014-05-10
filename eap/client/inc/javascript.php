<?php
/************************************************************************/
/* Eleonline - Raccolta e diffusione dei dati elettorali                */
/* by Luciano Apolito & Roberto Gigli                                   */
/* http://www.eleonline.it                                              */
/* info@eleonline.it  luciano@aniene.net rgigli@libero.it               */
/************************************************************************/
		
if (stristr(htmlentities($_SERVER['PHP_SELF']), "javascript.php")) {
    Header("Location: ../index.php");
    die();
}

##################################################
# Include funzioni javascript                    #
##################################################
#timer per tema tour
# inizio rotazione
if (isset($_SESSION['ruota'])) 
{ 
?>

		<script type="text/javascript" language="javascript">
<!--
function loadpage() {

thetimer = setTimeout("changepage()", 20000);


}

function changepage() {

newlocation = "<?php echo "modules.php?csv=1&block=0&id_cons_gen=".$_GET['id_cons_gen']."&id_comune=".$_GET['id_comune']; ?>"
location = newlocation
}
// --></script> 

<?php
}
# fine rotazione
# googlemaps per sezioni
# variabili nel config.php 
# gkey= chiave google reperibile per il proprio sito qui 
# http://code.google.com/intl/it/apis/maps/signup.html
# googlemaps 1=attivo 2: disattivo
# funzione by eleonline.it
#########################################################

function googlemaps(){
global $dbi,$prefix,$id_comune,$googlemaps,$op,$gkey,$lang;
# recupera gli inidirizzi
    $id_sede=$_GET['id_sede'];
    $sql = mysql_query("SELECT descrizione FROM ".$prefix."_ele_comuni where id_comune='$id_comune' ", $dbi); 
    list($comune) = mysql_fetch_row($sql);
    $sql = mysql_query("select indirizzo from ".$prefix."_ele_sede where id_sede='$id_sede'", $dbi);
    list($indirizzo)=mysql_fetch_row($sql);
    $indirizzocomune="$indirizzo , $comune , $lang";
# javascript per mappa
$jsmaps ="
    <div id=\"mapsearch\" style=\"margin:0 auto 0;\">
    <span style=\"color:#676767;font-size:11px;margin:10px;padding:4px;\">Loading...</span>
    </div>

  
  <script src=\"http://maps.google.com/maps?file=api&amp;v=2&amp;key=$gkey\"
    type=\"text/javascript\"></script>
  <script src=\"http://www.google.com/uds/api?file=uds.js&v=1.0&source=uds-msw&key=$gkey\"
    type=\"text/javascript\"></script>
  <style type=\"text/css\">
    @import url(\"http://www.google.com/uds/css/gsearch.css\");
  </style>
  <script type=\"text/javascript\">
    window._uds_msw_donotrepair = true;
  </script>
  <script src=\"http://www.google.com/uds/solutions/mapsearch/gsmapsearch.js?mode=new\"
    type=\"text/javascript\"></script>
  <style type=\"text/css\">
    @import url(\"http://www.google.com/uds/solutions/mapsearch/gsmapsearch.css\");
  </style>

  <style type=\"text/css\">
    .gsmsc-mapDiv {
      height : 350px;
    }

    .gsmsc-idleMapDiv {
      height : 350px;
    }

    #mapsearch {
      width : 450px;
      margin: 10px;
      padding: 4px;
    }
  </style>
  <script type=\"text/javascript\">
    function LoadMapSearchControl() {

      var options = {
            zoomControl : GSmapSearchControl.ZOOM_CONTROL_ENABLE_ALL,
            title : \"$indirizzo\",
            url : \"http://www.eleonline.it\",
            idleMapZoom : GSmapSearchControl.ACTIVE_MAP_ZOOM+1,
            activeMapZoom : GSmapSearchControl.ACTIVE_MAP_ZOOM+1
            }

      new GSmapSearchControl(
            document.getElementById(\"mapsearch\"),
            \"$indirizzocomune\",
            options
            );

    }
    
    GSearch.setOnLoadCallback(LoadMapSearchControl);
  </script>

        <center>";    

return $jsmaps;
}


?>
