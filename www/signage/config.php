<?php
/**
 * @package signage
 * @author Michael Zapf <michi.zapf@mztx.de>
 * @version 0.1
 * @copyright (C) 2016 Michael Zapf <michi.zapf@mztx.de>
 */

if (!class_exists('SignageConfig')) {

class SignageConfig {
    var $empty_pres = 'nopres.php';
    var $usb_base   = '/mnt/usb';

    public function __construct() {
    }

    public function getLocalHost() {
        list($h,) = explode(':', $_SERVER['HTTP_HOST']);
        return $h . ':8001';
    }

}

$cfg = new SignageConfig();


}

