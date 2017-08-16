<?php    
    
    /*  */

    function return_create_data () {
        $data = Array(
            'title'         => "Create account",
            'method'        => "POST",
            'form_data'     => Array (
                'id'            => 0,
                'nickname'      => "",
                'colour'        => "",
                'pet'           => ""
            )
        );
        return $data;
    }
    function return_edit_data ($user_id) {
        $data = Array(
            'title'         => "Edit account",
            'method'        => "PUT"
        );
        $sql = "SELECT * FROM user WHERE id = " . $user_id;
        $result = db_select($sql);
        if ( $result && count($result) ) {
            $data['form_data'] = Array();
            foreach ( $result[0] as $key => $value )
                $data['form_data'][$key] = $value;
            return $data;
        }
        return return_create_data();
    }
    
    function check_user ($user_data) {
        
        $sql = "SELECT id FROM user WHERE ";
        $started = 0;
        foreach ($user_data as $key => $value ) {
            if ( $started )
                $sql .= " AND ";
            $started = 1;
            $sql .= $key . " = '" . $value . "'";
        }
        $sql .= " ORDER BY id DESC LIMIT 1";
        $result = db_select($sql);
        if ( count($result) )
            return $result[0]['id'];
        
        return 0;
    }
    
    /*  */
    
    function put () {
        
        $id = (int) $_POST['id'];
        
        if ( !$id )
            return get();
        
        $sql = "SELECT * FROM user WHERE id = " . $id;
        $result = db_select($sql);
        
        if ( !count($result) ) {
            $_SESSION['user_id'] = 0;
            $_SESSION['auth_status'] = "logged_out";
            header("Location: " . BASE_URL);
        }
        
        $data = Array();
        $tmp_colour = trim($_POST['colour']);
        $tmp_pet = trim($_POST['pet']);
        if ( $tmp_colour && $tmp_colour != $result[0]['colour'] )
            $data['colour'] = mysql_real_escape_string($tmp_colour);
        if ( $tmp_pet && $tmp_pet != $result[0]['pet'] )
            $data['pet'] = mysql_real_escape_string($tmp_pet);
        
        if ( count($data) ) {
            $sql = "UPDATE user SET ";
            $started = 0;
            foreach ( $data as $key => $value ) {
                if ( $started )
                    $sql .= ", ";
                $started = 1;
                $sql .= $key . " = '" . $value . "'";
            }
            $sql .= " WHERE id = " . $id;
            $success = db_execute($sql);
        }
        
        $location = BASE_URL . "user/" . $id . "/" . preg_replace("/\W+/", "", $result[0]['nickname']);
        header("Location: $location");
    }
    function delete () {
        $_SESSION['user_id'] = 0;
        $_SESSION['auth_status'] = "logged_out";
        header("Location: " . BASE_URL);
    }
    
    function post () {
        
        if ( $_POST['method'] && $_POST['method'] == "PUT" )
            return put();
        
        if ( $_POST['method'] && $_POST['method'] == "DELETE" )
            return delete();
        
        if ( $_POST['nickname'] && trim($_POST['nickname']) ) {
            $data = Array(
                'nickname'      => mysql_real_escape_string(trim($_POST['nickname'])),
                'colour'        => mysql_real_escape_string(trim($_POST['colour'])),
                'pet'           => mysql_real_escape_string(trim($_POST['pet']))
            );
            $sql = "INSERT INTO user (nickname, colour, pet) VALUES('" . implode("', '", $data) . "')";
            if ( db_execute($sql) ) {
                $id = check_user($data);
                if ( $id ) {
                    $_SESSION['user_id'] = $id;
                    $_SESSION['auth_status'] = "logged_in";
                    $location = BASE_URL . "user/" . $id . "/" . preg_replace("/\W+/", "", trim($_POST['nickname']));
                    header("Location: $location");
                }
            }
        }
        
        return get();
    }

    function get () {
        
        $display_data = Array (
            'data'          => ($_SESSION['user_id']) ? return_edit_data($_SESSION['user_id']) : return_create_data(),
            'includes'      => Array (
                "head",
                "account",
                "body_end"
            )
        );
        
        return $display_data;
    }
?>
