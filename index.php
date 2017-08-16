<?php
    function v ($mixed) {
	echo "<pre>";
	print_r($mixed);
	echo "</pre>";
    }
    
    $method = $_SERVER['REQUEST_METHOD'];
    
    include_once "includes/logic/basics.php";
    if ( !isset($configuration) )
        die( "Reading configuration data failed" );
    
    define("PAGES_FOLDER", "includes/pages/");
    define("VIEW_FOLDER", "includes/views/");
    
    $page_components = explode("/", trim($_SERVER['PATH_INFO'], "/"));
    $requested_page = $page_components[0];
    $requested_subpage = (count($page_components) > 1 ) ? $page_components[1] : "";
    $page = "home";
    if ( $requested_page && file_exists(PAGES_FOLDER . $requested_page . ".php") )
        $page = $requested_page;

    include_once PAGES_FOLDER . $page . ".php";
    
    
    if ( is_callable(strtolower($method)) )
        $configuration['display'] = call_user_func( strtolower($method) );
    else {
        die( /**/ "An unknown error occurred" /**/ );
    }
    
    if ( isset($configuration['display']['includes']) && $configuration['display']['includes'] ) {
        for ( $i = 0; $i < count($configuration['display']['includes']); $i++ ) {
            $file = VIEW_FOLDER . $configuration['display']['includes'][$i] . ".php";
            if ( file_exists($file) ) {
                include_once $file;
            }
        }
    }
?>
