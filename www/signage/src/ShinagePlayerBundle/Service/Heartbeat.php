<?php

namespace mztx\ShinagePlayerBundle\Service;

class Heartbeat
{
    /** @var  UrlBuilder */
    protected $urlBuilder;


    public function beat()
    {
        $url = $this->urlBuilder->getControllerUrl('heartbeat');

    }
}
