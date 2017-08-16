<?php
    foreach ( $configuration['db'] as $key => $value )
        define(strtoupper($key), $value);
    
    function db_select ($sql) {
        
        $connect = mysqli_connect(SERVER, USER, PASSWORD, DB);
        //mysqli_set_charset($connect, "utf8");                                 should be database property

        if ( mysqli_connect_errno() ) {
            return Array();
        }

        $raw_result = mysqli_query($connect, $sql);
        $result = Array();

        mysqli_close($connect);
        
        if ( $raw_result )
            while ( $row = mysqli_fetch_assoc($raw_result) )
		$result[] = $row;
            
        return $result;
    }
    function db_execute ($sql) {
        
        $connect = mysqli_connect(SERVER, USER, PASSWORD, DB);
        //mysqli_set_charset($connect, "utf8");                                 should be database property

        if ( mysqli_connect_errno() ) {
            return 0;
        }
        
        $success = mysqli_query($connect, $sql);
        if ( $success )
            mysqli_commit($connect);

        mysqli_close($connect);

        return $success;
    }
?>
