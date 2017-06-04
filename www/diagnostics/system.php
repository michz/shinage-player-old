<?php
/**
 * @package signage
 * @author Michael Zapf <michi.zapf@mztx.de>
 * @version 0.1
 * @copyright (C) 2016 Michael Zapf <michi.zapf@mztx.de>
 */


class SystemInfo {


    public static function getLoadavg() {
        return exec('cat /proc/loadavg');
    }
}

?>
