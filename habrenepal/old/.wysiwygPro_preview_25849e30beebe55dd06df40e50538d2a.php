<?php
if ($_GET['randomId'] != "DajFchEOFXiiwNDPMaKnvfCDHGLrKMqM1WESefRaOrTu1jDe7XtQsYrSg4Z7IbOY") {
    echo "Access Denied";
    exit();
}

// display the HTML code:
echo stripslashes($_POST['wproPreviewHTML']);

?>  
