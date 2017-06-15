<?php

namespace mztx\ShinagePlayerBundle\Controller;

use mztx\ShinagePlayerBundle\Service\GuidCreator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends Controller
{

    public function indexAction()
    {
        /** @var GuidCreator $guidCreator */
        #$guidCreator = $this->get('shinage.player.guid_creator');
        #var_dump($guidCreator); exit;

        $rootDir = $this->get('kernel')->getRootDir() . '/../web/player.html';
        $appContent = file_get_contents($rootDir);
        return new Response($appContent);
    }
}
