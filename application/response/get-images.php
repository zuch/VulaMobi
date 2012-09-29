<?php
	//$dir = $_GET['path']. "/";
	$dir = 'uploads/';
	$dh = opendir($dir);
	$files = array();
	
	while(($file = readdir($dh)) !== false){
		if($file != '.' AND $file != '..'){
			$path_parts = pathinfo($dir. $file);
			if(filetype($dir . $file) == 'file' AND $path_parts['extension'] == 'jpg') {
				$files[] = array (
					'name' => $file,
					'size' => filesize($dir. $file). ' bytes',
					'date' => date( "F d Y H:i:s", filemtime($dir . $file)),
					'path' => 'http://'. $_SERVER['SERVER_NAME'].'/'.$dir .$file,
					'thumb'=> 'http://'. $_SERVER['SERVER_NAME']. '/'.$dir .'thumbs/thumb_'.$file
				);
			}
		}
	}
	closedir($dh);
	
	echo(json_encode(array('files'=> $files)));

?>
