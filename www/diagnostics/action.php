<?php
/**
 * @package signage
 * @author Michael Zapf <michi.zapf@mztx.de>
 * @version 0.1
 * @copyright (C) 2016 Michael Zapf <michi.zapf@mztx.de>
 */

$action = null;

if (isset($_GET['action']))     $action = $_GET['action'];
if (isset($_POST['action']))    $action = $_POST['action'];

if (!$action) header('Location:./index.php');


switch ($action) {
case 'poweroff':
    exec("sudo /sbin/poweroff > /dev/null &");
    break;
case 'reboot':
    exec("sudo /sbin/reboot > /dev/null &");
    break;
}

header('Location:./index.php');
exit;


?>
