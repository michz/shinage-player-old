<?php
/**
 * @package signage
 * @author Michael Zapf <michi.zapf@mztx.de>
 * @version 0.1
 * @copyright (C) 2016 Michael Zapf <michi.zapf@mztx.de>
 */

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset='utf-8'>
    <title>Signage Display</title>

    <style>
        html,body { margin:0; padding:0; overflow:visible; width:100%; height:100%; }
        #fullcontent { position:absolute; margin:0; padding:0; border:0;
                        top:0; left:0; right:0; bottom:0;
                        width:100%; height:100%; }
    </style>
</head>
<body>

    <iframe src="" id="fullcontent"></iframe>


    <script src="./js/jquery-3.1.1.min.js"></script>
    <script>
        var currentUrl = ''; // remember which presentation is loaded currently

        // When page is loaded: Ask server which presentation to load.
        $(document).ready(function() {
            recheck();
        });

        // Ask server which presentation to load and load it into iframe.
        var recheck = function() {
            $.get('./scheduler.php')
                .done(function(data) {
                    if (data != currentUrl) {
                        currentUrl = data;
                        $('#fullcontent').attr('src', data);
                    }
                })
                .fail(function(jqXHR, textStatus, errorThrown) {
                    // TODO Fehler verarbeiten
                });
            setTimeout(recheck, 15000);
        };
    </script>
</body>
</html>
