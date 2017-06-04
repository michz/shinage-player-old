<?php
/**
 * @package signage
 * @author Michael Zapf <michi.zapf@mztx.de>
 * @version 0.1
 * @copyright (C) 2016 Michael Zapf <michi.zapf@mztx.de>
 */




class ShinageConnector {
    private $guid;

    public function __construct() {
        // TODO get guid and create if neccessary
    }

    public function getGUID() {
        return $guid;
    }

    public function createGUID() {
		return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
		  mt_rand(0, 0xffff), mt_rand(0, 0xffff),
		  mt_rand(0, 0xffff),
		  mt_rand(0, 0x0fff) | 0x4000,
		  mt_rand(0, 0x3fff) | 0x8000,
		  mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
		);
    }
}


