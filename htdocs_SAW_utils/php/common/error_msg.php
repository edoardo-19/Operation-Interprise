<?php
//funzione di supporto per stampare gli errori
    function errorDetected($errorDetected)
    {
        if ($errorDetected == 1) { echo '
            <div class="error-div">
                <div class="error-card">
                    <p class="message-error error1">' . $GLOBALS['EDmsg1'] . '</p>
                    <p class="message-error">' . $GLOBALS['EDmsg2'] . '</p>
                </div>
            </div>';
        }
    }
?>