<?php

namespace mztx\ShinageDiagnosticsBundle\Controller;

use mztx\ShinageDiagnosticsBundle\Service\System;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class SystemController extends Controller
{

    public function poweroffAction()
    {
        /** @var System $system */
        $system = $this->get('shinage.diagnostics.system');
        $system->poweroff();
        return new Response('');
    }

    public function rebootAction()
    {
        /** @var System $system */
        $system = $this->get('shinage.diagnostics.system');
        $system->reboot();
        return new Response('');
    }

    public function getLoadAction()
    {
        /** @var System $system */
        $system = $this->get('shinage.diagnostics.system');
        $load = $system->getLoad();
        return $this->json($load);
    }
}
