<?php

$path = getcwd();

$upload_path = $path . '/uploads/';

echo $upload_path;

if(isset($_REQUEST['image']))
{
    if ($_REQUEST['image']) 
    {
        $imgData = base64_decode($_REQUEST['image']);

        $file = $upload_path . date('Ymdgisu') . '.jpg';
        //	$file = '/uploads/'.date('Ymdgisu').'.jpg';

        if (file_exists($file)) {
            unlink($file);
        }
        error_log("Error to check if file exists");
        $fp = fopen($file, 'w');
        fwrite($fp, $imgData);
        fclose($fp);
    }
}
else
{
    echo "</br>";
    echo "not set";
}
?>
