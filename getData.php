<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    $path = 'title/'; // '.' for current
    $data =array();
    foreach (new DirectoryIterator($path) as $file)
    {
        if($file->isDot()) continue;

        if($file->isFile())
        {
            $data[]=array(
                'image_url' =>"http://localhost/almoe/image/".file_get_contents('image_url/'.$file),
                'text'      =>file_get_contents('title/'.$file)
            ) ;
        }
    }
	$response['data']=$data;
	
	$json_response = json_encode($response);
	echo $json_response;
?>