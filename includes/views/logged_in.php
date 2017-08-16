<?php

    $welcome = ($username) ? "<b>Hello, " . $username . "!</b>" : "";
    
    $edit_account = BASE_URL . "account";
    $comment_start = "";
    $comment_end = "";
    if ( $page == "user" && !$configuration['display']['data']['its_me'] ) {
        $comment_start = "<!--";
        $comment_end = "-->";
    }
    
    $log_zone = <<<LOG

            $welcome
            <p>
                $comment_start
                <a href="$edit_account">Edit account</a>
                $comment_end
            </p>
            <p>
                <form method="POST" action="$edit_account">
                    <input type="hidden" name="method" value="DELETE">
                    <a href="" onclick="this.parentNode.submit(); return false">Log out</a>
                </form>
            </p>

LOG;
?>