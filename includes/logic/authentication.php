<?php
    session_start();
    $user_id = ($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
    $username = "";
    
    if ( $user_id ) {
        $sql = "SELECT nickname FROM user WHERE id = " . $user_id;
        $result = db_select($sql);
        if ( empty($result) )
            $user_id = 0;
        else
            $username = $result[0]['nickname'];
    }

    $_SESSION['user_id'] = $user_id;
    $_SESSION['auth_status'] = ($user_id) ? "logged_in" : "logged_out";
?>
