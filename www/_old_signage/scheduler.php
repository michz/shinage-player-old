<?php
/**
 * @package signage
 * @author Michael Zapf <michi.zapf@mztx.de>
 * @version 0.1
 * @copyright (C) 2016 Michael Zapf <michi.zapf@mztx.de>
 */

require_once(__DIR__ . '/FileSystem.php');
require_once(__DIR__ . '/config.php');


// first check if usb stick is mounted and if it contains displayable files
$usb_drives = FileSystem::getUsbDrives();

if (count($usb_drives) > 0) {
    // TODO: check if there are displayable files
    
    echo "http://".$cfg->getLocalHost()."/usb.php?dev=" . $usb_drives[0];
    exit;
}



echo "http://".$cfg->getLocalHost()."/".$cfg->empty_pres;


