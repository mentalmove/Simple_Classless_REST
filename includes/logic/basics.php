<?php
    $configuration = parse_ini_file("includes/configuration/config.ini", TRUE);
    
    if ( !$configuration )
        die( "Reading configuration data failed" );
    
    if ( isset($configuration['includes']) && $configuration['includes'] && isset($configuration['includes']['mandatory']) && $configuration['includes']['mandatory'] ) {
        for ( $i = 0; $i < count($configuration['includes']['mandatory']); $i++ ) {
            $file_name = $configuration['includes']['mandatory'][$i];
            $file = "includes/logic/" . $file_name . ".php";
            if ( !file_exists($file) )
                die( ucfirst($file_name) . " could not be loaded" );
            include_once $file;
        }
    }

    define("BASE_URL", str_replace("index.php", "", $_SERVER['SCRIPT_NAME']));
?>
