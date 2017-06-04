<?php
/**
 * @package signage
 * @author Michael Zapf <michi.zapf@mztx.de>
 * @version 0.1
 * @copyright (C) 2016 Michael Zapf <michi.zapf@mztx.de>
 */

require_once('config.php');

$url = 'http://' . $cfg->getLocalHost() . '/frame.php';

header('Location:'.$url);
exit;

