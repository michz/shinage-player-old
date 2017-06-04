<?php
/**
 * @package signage
 * @author Michael Zapf <michi.zapf@mztx.de>
 * @version 0.1
 * @copyright (C) 2016 Michael Zapf <michi.zapf@mztx.de>
 */


require_once(__DIR__ . '/FileSystem.php');


$usb = FileSystem::getUsbDrives();

var_dump($usb);

?>
