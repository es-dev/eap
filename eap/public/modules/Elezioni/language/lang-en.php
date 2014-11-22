<?php
/************************************************************************/
/* Eleonline - Raccolta e diffusione dei dati elettorali                */
/* by Roberto Gigli & Luciano Apolito                                   */
/* http://www.eleonline.it                                              */
/* info@eleonline.it  luciano@aniene.net rgigli@libero.it               */
/* lang_it.php Linguaggio Italiano                                      */
/************************************************************************/
global $tipo_cons;
switch ($tipo_cons){
	case '':
		define("_CONSULTAZIONE","Elections");
		break;
	case 1:
		define("_CONSULTAZIONE","Provincial Elections"); 
		define("_GRUPPO","Candidate for Presidente");
		define("_GRUPPOLOGO","Presidente Logo");
		define("_PRESI","President");
		define("_CONSI","Councilman");
		define("_DESCRCONS","PROVINCIAL");
		break;
	case 2:
		define("_CONSULTAZIONE","Referendum"); 
		define("_GRUPPO","Referendum Question");
		define("_GRUPPOLOGO","Logo");
		define("_PRESI","Question");
		define("_DESCRCONS","REFERENDUM");
		break;
	case 3:
		define("_CONSULTAZIONE","Communal Elections"); 
		define("_GRUPPO","Candidate City Mayor");
		define("_GRUPPOLOGO","Mayor Logo");
		define("_PRESI","Mayor");
		define("_CONSI","Councilman");
		define("_SOLO_GRUPPO","Ballots for candidate Mayor only");
		define("_VOTI_LISTA","Ballots for the list");
		break;
	case 4:
		define("_GRUPPO","Candidate President");
		break;
	case 5: 
		define("_CONSULTAZIONE","Second Round"); 
		define("_GRUPPO","Candidate Mayor");
		define("_GRUPPOLOGO","Mayor Logo");
		define("_PRESI","Mayor");
		define("_DESCRCONS","SECOND ROUND");
		break;
	case 6:
		define("_CONSULTAZIONE","Consultazione Camera"); 
		define("_GRUPPO","Lista");
		define("_GRUPPOLOGO","Logo della Lista");
		break;
	case 7:
		define("_CONSULTAZIONE","Consultazione Senato"); 
		define("_GRUPPO","Lista");
		define("_GRUPPOLOGO","Logo della Lista");
		break;
	case 8:
		define("_CONSULTAZIONE","European Parliament Election"); 
		define("_GRUPPO","List");
		define("_GRUPPOLOGO","List Logo");
		define("_CONSI","List Candidate");
		break;
	case 9: 
		define("_CONSULTAZIONE","Regional Parliament Election"); 
		define("_GRUPPO","Candidate for President");
		define("_CONSI","List Candidate");
		break;
	case 10: //dal 2006 per senato e camera si ha un raggruppamento delle liste ma senza possibilità di voto per il gruppo (solo in italia!)
		define("_CONSULTAZIONE","Senato Election"); 
		define("_GRUPPO","Groupings");
		break;
	case 11:
		define("_CONSULTAZIONE","Camera Election"); 
		define("_GRUPPO","Groupings");
		break;
	case 12:
		define("_CONSULTAZIONE","Provincial Elections"); 
		define("_GRUPPO","Candidate for Presidente");
		define("_GRUPPOLOGO","Presidente Logo");
		define("_PRESI","President");
		define("_CONSI","Councilman");
		define("_DESCRCONS","PROVINCIAL");
		break;
	case 13: 
		define("_CONSULTAZIONE","Second Round"); 
		define("_GRUPPO","Candidate President");
		define("_GRUPPOLOGO","President Logo");
		define("_PRESI","President");
		define("_DESCRCONS","SECOND ROUND");
		break;
	case 14:
		define("_CONSULTAZIONE","European Parliament Election"); 
		define("_GRUPPO","List");
		define("_GRUPPOLOGO","List Logo");
		define("_CONSI","List Candidate");
		break;
	case 15:
		define("_CONSULTAZIONE","Camera Election"); 
		define("_GRUPPO","Groupings");
		break;
	case 16: 
		define("_CONSULTAZIONE","Senato Election"); 
		define("_GRUPPO","Groupings");
		break;
	case 17: 
		define("_CONSULTAZIONE","Regional Parliament Election"); 
		define("_GRUPPO","Candidate for President");
		break;

}


if($tipo_cons==12 or $tipo_cons==14 or $tipo_cons==15 or $tipo_cons==16 or $tipo_cons==17){
define("_SCEGLI_CIRCO","Choose Borough");
define("_ELE_CIRCO","Borough Election");
define("_CIRCO","Borough");
define("_CIRCOS","Boroughs");
define("_IDCIRC","Id Borough ");
define("_CIRCS","Boroughs");
}else{
define("_SCEGLI_CIRCO","Choose Constituency");
define("_ELE_CIRCO","Constituency Election");
define("_CIRCO","Constituency");
define("_CIRCOS","Constituencies");
define("_IDCIRC","Id circos. ");
define("_CIRCS","Constituencies");
}
define("_ELIMINA","DELETE");
define("_SPUNTAELIMINA","Check to enable deletion:");
define("_HELP","Help On Line");
define("_NOTAOP","");
define("_SISTEMA_MAGGIORITARIO","Majority Rules");
define("_SISTEMA_PROPORZIONALE","Proportional");
define("_INDIRIZZOWEB1","URL of the server");
define("_SCARICACONS","Choose consultation");
define("_SCELTACOMUNE","Choose the zone");
define("_SCARICA","Download lists");
define("_IMPORTA","Import lists");
define("_CONFIGDEFAULT","General configuration");
define("_CONFIGURAZIONE","Site configuration");
define("_TEMA","Theme");
define("_TESTATA","Header imagine");
define("_BLOCCO","Show lateral block?");
define("_MULTICOMUNE","Managing more towns?");
define("_PREFIX","Table prefix");
define("_ADMINMAIL","administrator mail");
define("_SITEURL","Site URL or IP");
define("_SITENAME","Site name");
define("_SITEISTAT","Default<br>town to show");
define("_LANGUAGE","Default language (it, en...");
define("_FLASH","Show flash animations?");
define("_DISPLAYERRORS","debug on/off");
define("_FILEOUT","sql file to store input data");

define("_LIMITE","Majority/proportional");
define("_CONSPRED","Set default election");
define("_STEMMA","Stemma");
define("_CONSIN","Mayor not elected will be councilman?");
define("_INFPREMIO","Majority premium %");
define("_LISTINFSBAR","Sbarramento %");
define("_INFMINPREMIO","Premio di maggioranza<br>solo oltre %");
define("_LISTINFCONTA","I voti di lista sotto lo sbarramento<br>vengono conteggiati per il gruppo?");
define("_SUPPREMIO","Premio di maggiornaza %");
define("_SUPSBAR","Sbarramento %");
define("_SUPMINPREMIO","Premio di maggioranza<br>solo oltre %");
define("_LISTSUPCONTA","I voti di lista sotto lo sbarramento<br>vengono conteggiati per il gruppo?");
define("_NOFASCIA","Solo maggioritario");
define("_RESTORE","Restore");
define("_CONFCONS","Tipi Consiglio");
define("_CONF","Legge elettorale");


define("_MEX_RESTORE_FAILED","WARNING! Restore has failed.");
define("_MEX_RESTORE_OK","DATA RESTORE IS OK");
define("_RESTORE","Restore");
define("_BACKUP","Backup");
define("_SEL_DATA_FILE","Warning! you can restore data only if it came from the same database! (or database replica)<br> Choose file to restore");
define("_SEL_DATA_FILE2","Warning! your data in current consultation will be overwritten!<br> Choose file to import");
define("_TEST","If you wont to test Eleonline start inserting username \"suser\" and password \"test\"");
define("_GESTIONE","managing vote counting and publishing results");
define("_TIPO_ADM","Managing Types");
define("_LINGUA","Language");
define("_FASCIA","Citizens");
define("_TUTTESEDI","All electoral centers");
define("_ATT_VOTI","Warning! ballots");
define("_ATT_VOTANTI","Warning! voters");
define("_NO_TOT_VOTI","is not equal to the total ballots");
define("_NO_VAL_VOTI","is not equal to the valid ballots");
define("_ATT_VOTI_REF","Warning! Inserted ballots for the Referendum n.");
define("_ATT_VOTANTI_REF","Warning! Inserted final ballots for the Referendum n.");
define("_NO_SOMMA","is not equal to the total ballots:");
define("_COD_NV","Not valid code ");
define("_REFERENDUM","Referendum");
define("_CON_GRUPPI","With groupings");
define("_NO_VOTO_GRUPPO","Not to vote for the Group");
define("_LISTE_UNI","One candidate for list");
define("_NO_VOTO_LISTA","Not to vote for the list");
define("_NO_VOTO_CANDI","Not to vote for the candidates");
define("_BALLO","Second round");
define("_DEFCONS","Define the characteristics of the election");
define("_SOLO_GRUPPO","Ballots to groups only");
define("_VOTI_LISTA","Ballots to lists");
define("_GENCONS0","Referendum");
define("_GENCONS1","Second round");
define("_GENCONS2","One candidate for list");
define("_GENCONS3","Groups and Lists but no ballots for candidates");
define("_GENCONS4","More candidates for list");
define("_GENCONS5","Groups and Lists and ballots for candidates");
define("_CAMBIOPWD","Change Password");
define("_CHGPWD","Password change");
define("_ERRPWD","WARNING: ERROR INSERTING PASSWORD!");
define("_OLDPWD","Old Password");
define("_NEWPWD1","New Password");
define("_NEWPWD2","New Password again");
define("_YES","Yes");
define("_ISCRITTI","Enrolled");
define("_INSEZ","in the section");
define("_PERC","Perc.");
define("_DOMAGGIORNA","Really do you wont to change voters number in");
define("_UPDATE","Update");
define("_ERRORE","Error");
define("_COME","How to vote");
define("_NUMERI","Useful numbers");
define("_SERVIZI","Services");
define("_LINK","Useful links");
define("_CONSULTAZIONI","Elections");
define("_OPERATORI","Operators");
define("_AGGIUNGI","Add");
define("_COLLEGI","Districts");
define("_DEFCOMUNE","Cities");
define("_CODICE","Code");
define("_CENTRALINO","Telephone");
define("_EMAIL","E-mail");
define("_FILTRO","Search mask");
define("_INSCOMUNE","Authorize Cities");
define("_CONSULTAZIONE_ADM","Election");
define("_AMMINISTRATORI", "Administrators");
define("_PASSWORD","Password");
define("_RIPETI","Password again");
define("_COMPLESSIVO","all");
define("_CONTR_CONS","Verification of the ballots to the lists");
define("_CONTR_GRUP","Verification of the ballots to the groups");
define("_DATAIN","Starting Date");
define("_DATAFINE","Ending Date");
define("_GEST","Managing");
define("_MODIFY","Modify");
define("_ESCI","Exit");
define("_POPOLA","Import");
define("_SOSPESO","Suspended");
define("_IMPOSTA_DATI","Administrator");
define("_INSERISCE_DATI","Operator");
define("_UTENTE","User");
define("_PERMESSI","Privileges");
define("_NULLA","NOT VALID");
define("_ATTIVA","IN USE");
define("_ATTIVO","In use");
define("_CHIUSA","CLOSED");
define("_ASOLA_LISTA","to the List");
define("_ASOLO_GRUPPO","to the Groups only");
define("_COLLEGIO","district");
define("_A","to");
define("_DA","from");
define("_DI","of");
define("_COMUNE","City");
define("_VIS_PERC","Show percentages");
define("_SEZIONE","Section");
define("_SEZIONI","Sections");
define("_UOMINI","Men");
define("_DONNE","Women");
define("_COMPLESSIVI","in total");
define("_VOTIE","Express ballots");
define("_SEZNOS","Sections to be Counted");
define("_SEZSCR","Counted Sections");
define("_LISTA","List");
define("_PREFLISTA","Ballots to the list");
define("_CANDIDATO","Candidate");
define("_GESAMMIN","Admin Management ");
define("_DESCR","Description");
define("_IMMCONS","Insert Election");
define("_DOMCANCELLA","Are you sure to delete ");
define("_FUNZIONI","Modify function ");
define("_NEXT_MATCH","Next");
define("_PREV_MATCH","Previous");
define("_NEXT","Next");
define("_PREV","Previous");
define("_SCELTA","Choose");
define("_SCEGLI","Choose ");
define("_SEDE","Electoral Center ");
define("_NUM","Number ");
define("_IDCONS","Id election ");
define("_IMM","Inserting");
define("_TEL","Telephone");
define("_INDIRIZZO","Address");
define("_FAX","Fax");
define("_RESP","Section head");
define("_MASCHI","Men ");
define("_FEMMINE","Women ");
define("_TOTS","Totals ");
define("_TOT","Total ");
define("_TOTPREF","Sum of ballots");
define("_GESTIMM","Logo Management");
define("_SIMBOLO","Logo");
define("_INVIOFILE","<font color=\"red\">File upload (jpg,gif or png) for Logo</font>");
define("_FILEDAINVIARE","Choose the file to upload");
define("_CANCELLAFILE","<font color=\"red\">Delete Logo file</font>");
define("_SCELTAFILE","Choose the file to delete");
define("_LISTALOGO","List Logo");
define("_COGNOME","Surname");
define("_NOME","Name");
define("_FOTO","Photo");
define("_NOTE","Notes");
define("_GESSPOGLIO","Managing Electoral Operations");
define("_SPOGLIO","Vote counting");
define("_VOTI","Ballots");
define("_VOTANTI","Electors");
define("_PREFERENZE","Ballots");
define("_ORA","Time");
define("_TITOLO","Title");
define("_PREAMBOLO","Summary");
define("_CONTENUTO","Text");
define("_DATA","Date");
define("_VOTID","Women Ballots");
define("_VOTIU","Men Ballots");
define("_VOTIT","Total of Ballots");
define("_VALIDI","Valid Ballots");
define("_NULLI","Non Valid Ballots");
define("_VOTINULLI","Non Valid Votes");
define("_NULLI_LISTE","Non Valid Votes to Lists");
define("_BIANCHI","Blank Ballots");
define("_CONTESTATI","Contested Ballots");
define("_CONTESTATI_LISTE","Contested Ballots to Lists");
define("_TOTALEVOTI","Total of Ballots");
define("_TOT_ULT","Voters at end");
define("_VOTIINS","Inserted Ballots");
define("_CANDINS","Inserted Candidates");
define("_TOTNON","Total of non valid Ballots");
define("_CANDIDATI","Candidates");
define("_DATIG","General Informations");
define("_AVENTI","Electors"); //Aventi Diritto
define("_SI","Yes");
define("_NO","No");
define("_AFFLUENZE","Affluence");
define("_NOTA","The information in this pages, susceptible of modifications, are unofficial. They have pure informative value.");
define("_ORE","time");
define("_ALLE","at");
define("_DEL","of the");
define("_STATO","State");
define("_OK","Ok");
define("_ANCHE","also");
define("_VISUALIZZA","Show the data");
define("_TIPO","Type");
define("_CONSULTA","Election");
define("_PERCE","Percentages");
define("_RISULTA","Results");
define("_PER","for");
define("_SEZSCRU","Scrutinate Sections ");
define("_SU","on");
define("_LA","the");
define("_ADMINID","User");
define("_ADMINCOME","HOW TO VOTE - Administration");
define("_EDITORIAL","General Informations");
define("_EDITORIALADMIN","Managing Informations");
define("_EDITINFO","Edit informations");
define("_EDIT","Edit");
define("_ADD","Add");
define("_NEW","New");
define("_DELETE","Delete");
define("_COPIA","Copy");
define("_STRUTTURA","Structure");
define("_ADDCOME","Add information");
define("_ADDPRES","Add candidate for president");
define("_ALLCOME","Inserted Informations");
define("_REMOVEINFO","Are you sure to delete this information? ");
define("_IMAGE","Immagine informazione");
define("_CONTINUA","continue <img src=\"images/site.gif\" align=\"center\" border=\"0\">");
define("_MESSAGEPREAMBLE","Preamble (max 500 char)");
define("_ADMINNUMERI","Numbers - Administration");
define("_ADMINSERVIZI","Services - Administration");
define("_ADMINLINK","Links - Administration");
define("_CONTR_ESPR","Ballots Verification");
define("_CONTR_PREF","Preferences Verification");
// Note
//define("_ENTE","Comune di Guidonia Montecelio (Provincia di Roma)");
//define("_NOTACSV","Notes: I dati sono estratti dal sito del ");
//define("_DISC1","Ogni rappresentazione ed uso e' consentita citando la fonte dei dati");
//define("_SITO","http://www.guidonia.org ");
// Copyright
define("_SORALDO","Eleonline: Modulo elettorale");
define("_VERS","versione 1.0 beta ");
define("_NON","Not");
define("_EXPORT","Export");
define("_TABULA","(tab formatted)");
define("_GRAFICI","Diagrams ");
define("_ALL","All ");
//define("_MAIN","Qui sono e saranno presenti i dati e i risultati delle
//consultazioni elettorali svolte nel ");
define("_THEMES","Tema Grafico");
define("_ACTIVE","Activ ");
define("_BLOCCHI","Lateral blocks");
define("_BLOCKS","Blocks");
define("_MENUCONF","Configuration Menu for graphical aspect");
define("_GESFILE","Image Files Managing");
define("_LOGO","Image or Logo");
define("_ELETTORI","Enrolled");
define("_EDIFICIO","Building");
define("_MAPPA","Map");
define("_LINK","Link");
define("_NUMERITEL","Telephon");
define("_DESCRAPP","Deep Description");
define("_DESCRLINK","Short description for the link");
define("_HELPHTML","You can use all HTML tags. Example: <font color=\"#ff0000\">&lt br &gt </font>new line</pre>");
define("_SUPER","S<br>U<br>P<br>E<br>R<br>U<br>S<br>E<br>R");
define("_ADMIN","A<br>D<br>M<br>I<br>N<br>I<br>S<br>T<br>R<br>A<br>T<br>O<br>R");
define("_OPER","O<br>P<br>E<br>R<br>A<br>T<br>O<br>R");
define("_SCELTA_CONS","Choose an Election");
define("_WIDGET","Widget");
define("_PLUGINS","Plugins");
define("_CONFIGWIDGET","Widget Configuration");
?>
