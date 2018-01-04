<?php

namespace mztx\ShinageDiagnosticsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends Controller
{

    public function indexAction()
    {
        return $this->render('ShinageDiagnosticsBundle::index.html.twig', [
            'uuid' => $this->getParameter('shinage.player.uuid'),
            'remote_host' => $this->getParameter('shinage.player.remote.host'),
            'remote_protocol' => $this->getParameter('shinage.player.remote.protocol'),
            'remote_base' => $this->getParameter('shinage.player.remote.base_path'),
            'remote_controllers' => $this->getParameter('shinage.player.remote.controllers'),
        ]);
    }
}
