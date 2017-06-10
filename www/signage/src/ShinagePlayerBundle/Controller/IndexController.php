<?php

namespace mztx\ShinagePlayerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends Controller
{

    public function indexAction()
    {
        $rootDir = $this->get('kernel')->getRootDir() . '/../web/player.html';
        $appContent = file_get_contents($rootDir);
        return new Response($appContent);
    }
}
