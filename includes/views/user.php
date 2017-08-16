<?php
    
    $nickname = $configuration['display']['data']['user_data']['nickname'];
    $colour = "";
    if ( $configuration['display']['data']['user_data']['colour'] )
        $colour = "<br>" . $nickname . "'s favourite colour is <i>" . $configuration['display']['data']['user_data']['colour'] . "</i>";
    $pet = "";
    if ( $configuration['display']['data']['user_data']['pet'] )
        $pet = "<br>" . $nickname . "'s favourite pet is <i>" . $configuration['display']['data']['user_data']['pet'] . "</i>";

    $home = <<<HOME

            This is the page of <b>$nickname</b>
            <br>
            $colour
            $pet
            
            <div class="user_list">    

HOME;
    
    echo $home;
    
    $msg_url = BASE_URL . implode("/", $page_components);
    
    if ( !empty($configuration['display']['data']['messages']) && $configuration['display']['data']['its_me'] ) {
        $form = <<<FORM
                <form method="POST" action="$msg_url">
                    <input type="hidden" name="method" value="DELETE">
                    <input type="hidden" name="id" value="0">
                </form>
                <script type="text/javascript">
                    function delete_msg (id) {
                        var form = document.forms[document.forms.length - 1];
                        form.id.value = id;
                        form.submit();
                    }
                </script>
FORM;
        echo $form;
    }
    
    for ( $msg_count = 0; $msg_count < count($configuration['display']['data']['messages']); $msg_count++ ) {
        $single_message = $configuration['display']['data']['messages'][$msg_count];
        
        $silver = ($msg_count % 2) ? "silver" : "";
        $sender_id = $single_message['sender'];
        $the_nickname = $single_message['nickname'];
        $sender_profile = BASE_URL . "user/" . $sender_id . "/" . preg_replace("/\W+/", "", $the_nickname);
        $msg_formatted = nl2br(htmlspecialchars($single_message['msg']));
        $id = $single_message['id'];
        $delete_button = ($_SESSION['user_id'] == $single_message['recipient']) ? "<b class='delete_bt' title='DELETE' onclick='delete_msg($id)'>&nbsp; X &nbsp;</b>" : "";
        
        $msg = <<<MSG
                <p class="msg_paragraph $silver">
                    <span class="sender_identification" onclick="location.href = '$sender_profile'">
                        &nbsp;&nbsp;
                        $the_nickname
                    </span>
                    $msg_formatted
                    $delete_button
                    <br>
                </p>
MSG;
        
        echo $msg;
    }
    
    echo "</div>";
    
    if ( $_SESSION['user_id'] && !$configuration['display']['data']['its_me'] ) {
        $msg = <<<MSG
            <div class="user_list">
                <small>
                    Write a message to <i>$nickname</i>...
                </small>
                <br>
                <form method="POST" action="$msg_url">
                    <textarea name="msg" cols="40" rows="8"></textarea>
                    <br>
                    <input type="submit" value=" Send ">
                </form>
            </div>
                
MSG;
        echo $msg;
    }
    
?>
