<?php
/**
 * @package signage
 * @author Michael Zapf <michi.zapf@mztx.de>
 * @version 0.1
 * @copyright (C) 2016 Michael Zapf <michi.zapf@mztx.de>
 */

require_once(__DIR__ . '/FileSystem.php');
require_once(__DIR__ . '/config.php');


// file must be located beyond /mnt/usb
$i = pathinfo($_GET['file']);
$len = strlen($cfg->usb_base);

if (substr($i['dirname'], 0, $len) == $cfg->usb_base) {
    // TODO Load error image instead
    exit;
}


readfile($_GET['file']);

?>
