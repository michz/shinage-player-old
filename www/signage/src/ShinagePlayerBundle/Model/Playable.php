<?php

namespace mztx\ShinagePlayerBundle\Model;

class Playable
{
    public $type = '';
    public $file = '';

    public function __construct($type, $file)
    {
        $this->type = $type;
        $this->file = $file;
    }
}
