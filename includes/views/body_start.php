<?php
    
    $homepage = BASE_URL;
    $body_start = <<<BODY_START
	<body>
            
            <div class="header">
                <div class="title_zone" onclick="location.href = '$homepage'">
                    Representational State Transfer
                </div>
                <div class="auth_zone">
                    $log_zone
                </div>
                <div style="clear: both"> </div>
            </div>

BODY_START;
    
    echo $body_start;
?>
