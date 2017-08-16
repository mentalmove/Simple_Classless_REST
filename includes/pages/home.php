<?php
    
    function get_users () {
        $sql = "SELECT * FROM user";
        return db_select($sql);
    }
    function format_user_list ($collection) {
        if ( empty($collection) )
            return "<a href=\"javascript: void(1*1)\">No registered users yet!</a>";
        $stars = ($_SESSION['user_id'] == $collection[0]['id']) ? " *** " : "";
        $user_list = "<a href=\"" . BASE_URL . "user/" . $collection[0]['id'] . "/" . preg_replace("/\W+/", "", $collection[0]['nickname']) . "\">" . $stars . $collection[0]['nickname'] . $stars . "</a>";
        for ( $i = 1; $i < count($collection); $i++ ) {
            $stars = ($_SESSION['user_id'] == $collection[$i]['id']) ? " *** " : "";
            $user_list .= "<br><a href=\"" . BASE_URL . "user/" . $collection[$i]['id'] . "/" . preg_replace("/\W+/", "", $collection[$i]['nickname']) . "\">" . $stars . $collection[$i]['nickname'] . $stars . "</a>";
        }
        
        return $user_list;
    }
    
    /*  */
    
    function post () {
        
        if ( $_POST['nickname'] && trim($_POST['nickname']) ) {
            $nickname = mysql_real_escape_string($_POST['nickname']);
            $sql = "SELECT id, nickname FROM user WHERE nickname = '" . $nickname . "' ORDER BY id DESC LIMIT 1";
            $result = db_select($sql);
            if ( count($result) ) {
                $id = $result[0]['id'];
                $_SESSION['user_id'] = $id;
                $_SESSION['auth_status'] = "logged_in";
                global $username;
                $username = $result[0]['nickname'];
            }
        }
        
        return get();
    }

    function get () {
        
        $display_data = Array (
            'data'          => Array (
                'title'         => "Homepage",
                'user_list'     => get_users()
            ),
            'includes'      => Array (
                $_SESSION['auth_status'],
                "head",
                "body_start",
                "home",
                "body_end"
            )
        );
        
        return $display_data;
    }
?>
