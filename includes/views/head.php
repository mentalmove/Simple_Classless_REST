<?php
    $title = $configuration['display']['data']['title'];
    $css_url = BASE_URL . "public/main.css";

    $head = <<<HEAD
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>$title</title>
            
		<link rel="stylesheet" type="text/css" href="$css_url">
	</head>

HEAD;
    
    echo $head;
?>
