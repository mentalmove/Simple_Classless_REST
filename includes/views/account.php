<?php
    $homepage = BASE_URL;
    $account_url = BASE_URL . "account";
    
    $method = $configuration['display']['data']['method'];
    $id = $configuration['display']['data']['form_data']['id'];
    $nickname_disabled = "";
    if ( $id )
        $nickname_disabled = " disabled";
    $nickname = $configuration['display']['data']['form_data']['nickname'];
    $colour = $configuration['display']['data']['form_data']['colour'];
    $pet = $configuration['display']['data']['form_data']['pet'];
    
    $form_body = <<<FORM_BODY
	<body>
            
            <div class="header">
                <div class="title_zone" onclick="location.href = '$homepage'">
                    <small>
                        Cancel
                    </small>
                </div>
                <div style="clear: both"> </div>
            </div>
            
            <form method="POST" action="">
                <input type="hidden" name="id" value="$id">
                <input type="hidden" name="method" value="$method">
                <table align="center" width="50%" cellpadding="12" border="0">
                    <tr>
                        <td>
                            Nickname
                        </td>
                        <td>
                            <input type="text" name="nickname" size="40" $nickname_disabled value="$nickname">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Favourite colour
                        </td>
                        <td>
                            <input type="text" name="colour" size="40" value="$colour">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Favourite pet
                        </td>
                        <td>
                            <input type="text" name="pet" size="40" value="$pet">
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type="submit" value=" Send ">
                        </td>
                    </tr>
                </table>
            </form>

FORM_BODY;
        
        echo $form_body;
?>
