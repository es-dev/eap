<?php

###########################
# FCKeditor
###########################

function js_textarea($name, $value, $config, $cols = 50, $rows = 10)
{
   global $editor,$ed_user;
#    $config=$ed_user;
   # Don't waste bandwidth by loading WYSIWYG editor for crawlers
   if ($editor == 0 or !isset($_COOKIE))
   {
       echo "<textarea name=\"$name\" cols=\"$cols\" rows=\"$rows\">$value</textarea>";
   } else {
	@include_once(INCLUDE_PATH."../../inc/FCKeditor/fckeditor.php");
	$oFCKeditor = new FCKeditor($name) ;
	$oFCKheight = $rows * 20;
	$oFCKeditor->Height = "$oFCKheight";
	$oFCKeditor->ToolbarSet   = "$config" ;
	$oFCKeditor->InstanceName = "$name" ;
	$oFCKeditor->Value = "$value" ;
	$oFCKeditor->Create() ;   
   }
}


function js_textarea_html($name, $value, $config, $cols = 50, $rows = 10)
{
   global $editor,$ed_user;
#   $config=$ed_user;
   
   # Don't waste bandwidth by loading WYSIWYG editor for crawlers
   if ($editor == 0 or !isset($_COOKIE))
   {
       echo "<textarea name=\"$name\" cols=\"$cols\" rows=\"$rows\">$value</textarea>";
   } else {
	@include_once(INCLUDE_PATH."../../inc/FCKeditor/fckeditor.php");
	$oFCKeditor = new FCKeditor($name) ;
	$oFCKheight = $rows * 20;
	$oFCKeditor->Height = "$oFCKheight";
	$oFCKeditor->ToolbarSet	= "$config" ;
	$oFCKeditor->InstanceName = "$name" ;
	$oFCKeditor->Value = "$value" ;
	$wysiwygHTML = $oFCKeditor->CreateHtml() ;
	return $wysiwygHTML;
   }
}

?>
