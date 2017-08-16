<?php
    $create_account = BASE_URL . "account";
    $log_in = BASE_URL;
    $comment_start = "";
    $comment_end = "";
    if ( isset($configuration) && isset($configuration['display']) && isset($configuration['display']['data']) && isset($configuration['display']['data']['user_list']) && empty($configuration['display']['data']['user_list']) ) {
        $comment_start = "<!--";
        $comment_end = "-->";
    }
    $log_zone = <<<LOG

            <p>
                $comment_start
                <form method="POST" action="$log_in">
                    <a href="" onclick="this.parentNode.submit(); return false">Log in</a>
                    &nbsp;&nbsp;
                    <input type="text" name="nickname" size="16" maxlength="40">
                </form>
                $comment_end
            </p>
            <p>
                <a href="$create_account">Create account</a>
            </p>

LOG;
?>