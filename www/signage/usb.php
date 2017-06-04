<?php
/**
 * @package signage
 * @author Michael Zapf <michi.zapf@mztx.de>
 * @version 0.1
 * @copyright (C) 2016 Michael Zapf <michi.zapf@mztx.de>
 */

require_once(__DIR__ . '/FileSystem.php');


$dev = $_GET['dev'];

$files = FileSystem::getPlayableDirectoryContents($dev);


$json_a = array();
foreach ($files as $f) {
	$json_a[] = "{'type':'".$f->type."', 'duration':3000, 'file':'usbfile.php?file=".$dev.'/'.urlencode($f->file)."'}";
}

$json_s = implode(",\n", $json_a);


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset=utf-8 />
    <title>Presentation</title>
    <link rel="stylesheet" type="text/css" media="screen" href="css/sign.css" />
</head>
<body>
    <div id="block-loading">
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>Loading...</p>
        <p><img src='img/spin.gif'></p>
    </div>

    <!-- javascripts following -->

    <script>
    var slides = [
        <?php echo $json_s; ?>
    ];
    </script>
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/sign.js"></script>
</body>
</html>

