<?php

namespace mztx\ShinageDiagnosticsBundle\Controller;

use mztx\ShinageDiagnosticsBundle\Entity\SystemLoad;
use mztx\ShinageDiagnosticsBundle\Service\System;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SystemController extends Controller
{

    public function poweroffAction()
    {
        /** @var System $system */
        $system = $this->get('shinage.diagnostics.system');
        $system->poweroff();
    }

    public function rebootAction()
    {
        /** @var System $system */
        $system = $this->get('shinage.diagnostics.system');
        $system->reboot();
    }

    public function getLoadAction()
    {
        /** @var System $system */
        $system = $this->get('shinage.diagnostics.system');
        $load = $system->getLoad();
        return $this->json($load);
    }
}
