<?php

    function get_single_user ($id) {
        $sql = "SELECT * FROM user WHERE id = " . $id;
        $result = db_select($sql);
        if ( empty($result) )
            return NULL;
        return $result[0];
    }
    
    function get_messages ($id) {
        $sql = "SELECT "
                    . "m.*,"
                    . "u.nickname "
                . "FROM "
                    . "message m, "
                    . "user u "
                . "WHERE "
                    . "m.recipient = " . $id . " "
                . "AND "
                    . "m.sender = u.id "
                . "ORDER BY m.id ASC";
        return db_select($sql);
    }
    
    /*  */
    
    /**
     * IN PRODUCTION USAGE, MESSAGES WOULD
     *      **NEVER**
     * BE DELETED BUT MARKED AS INACTIVE
     */
    function delete () {
        
        $id = (int) $_POST['id'];
        
        $sql = "DELETE FROM message WHERE id = " . $id . " AND recipient = " . $_SESSION['user_id'];
        $unchecked = db_execute($sql);
        
        return get();
    }
    
    function post () {
        
        if ( $_POST['method'] && $_POST['method'] == "DELETE" )
            return delete();
        
        global $requested_subpage;
        $recipient = (int) $requested_subpage;
        $sender = $_SESSION['user_id'];
        
        $limit = 255;
        
        if ( $_POST['msg'] && trim($_POST['msg']) ) {
            $msg = trim($_POST['msg']);
            $messages = Array();
            if ( strlen($msg) <= $limit )
                $messages[0] = $msg;
            else {
                $tmp_messages = preg_split("/\s/", $msg);
                $counter = 0;
                $messages[0] = "";
                for ( $i = 0; $i < count($tmp_messages); $i++ ) {
                    if ( !$tmp_messages[$i] )
                        continue;
                    if ( strlen($tmp_messages[$i]) > $limit )
                        $tmp_messages[$i] = substr($tmp_messages[$i], 0, ($limit - 3)) . "...";
                    if ( strlen($messages[$counter]) + strlen($tmp_messages[$i]) < $limit )
                        $messages[$counter] .= " " . $tmp_messages[$i];
                    else
                        $messages[++$counter] = $tmp_messages[$i];
                }
            }
            for ( $i = 0; $i < count($messages); $i++ ) {
                $sql = "INSERT INTO message (sender, recipient, msg) VALUES(" . $sender . ", " . $recipient . ", '" . mysql_real_escape_string($messages[$i]) . "')";
                $unchecked = db_execute($sql);
            }
        }
        
        return get();
    }
    
    function get () {
        
        global $requested_subpage;
        $user_id = (int) $requested_subpage;
        $user_data = get_single_user($user_id);
        
        if ( empty($user_data) )
            header("Location: " . BASE_URL);
        
        $display_data = Array (
            'data'          => Array (
                'title'         => "Page of " . $user_data['nickname'],
                'its_me'        => ($_SESSION['user_id'] == $user_data['id']),
                'user_data'     => $user_data,
                'messages'      => get_messages($user_id)
            ),
            'includes'      => Array (
                $_SESSION['auth_status'],
                "head",
                "body_start",
                "user",
                "body_end"
            )
        );
        
        return $display_data;
    }
?>
