<?php
    $user_list = format_user_list($configuration['display']['data']['user_list']);

    $home = <<<HOME

            This is the home page
            
            <div class="user_list">
                $user_list
            </div>

HOME;
    
    echo $home;
?>
