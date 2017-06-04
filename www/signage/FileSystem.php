<?php
/**
 * @package signage
 * @author Michael Zapf <michi.zapf@mztx.de>
 * @version 0.1
 * @copyright (C) 2016 Michael Zapf <michi.zapf@mztx.de>
 */



class FileSystem {
    static $EXT_IMAGE    = array('png', 'jpg', 'jpeg', 'gif', 'tif', 'tiff');
    static $EXT_VIDEO    = array('mp4', 'wmv', 'm4v', 'mov');
    static $EXT_VECTOR   = array('svg');

    public function __construct() {
    }


    public static function getUsbDrives() {
        global $cfg;

        $base = $cfg->usb_base;
        $drives = self::getDirectoryContents($base);
        $r = array();

        foreach ($drives as $d) {
            $abs = $base . '/' . $d;
            if (substr($d, 0, 6) == 'usbhd-' && is_dir($abs) &&
                !file_exists($abs . '/signage_ignore') &&
                !file_exists($abs . '/signage_ignore.txt') &&
                self::containsPlayableDirectoryContents($abs)) {
                    $r[] = $abs;
            }
        }

        return $r;
    }

    public static function getDirectoryContents($path) {
        $r = array();

		if ($handle = opendir($path)) {
			while (false !== ($entry = readdir($handle))) {
				$r[] = $entry;
			}
			closedir($handle);
        }

        return $r;
    }

    public static function getPlayableDirectoryContents($path) {
        $r = array();

        $contents = self::getDirectoryContents($path);
        foreach ($contents as $f) {
            $abs = $path . '/' . $f;
            $i = pathinfo($abs);

            if (in_array($i['extension'], self::$EXT_IMAGE)) {
                $p = new Playable('img', $f);
                $r[] = $p;
            }
        }

        return $r;
    }

    public static function containsPlayableDirectoryContents($path) {
        $c = self::getPlayableDirectoryContents($path);
        return (count($c) > 0);
    }
}


class Playable {
    var $type = '';
    var $file = '';

    public function __construct($type, $file) {
        $this->type = $type;
        $this->file = $file;
    }
}

