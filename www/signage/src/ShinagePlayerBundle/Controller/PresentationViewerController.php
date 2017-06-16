<?php
namespace mztx\ShinagePlayerBundle\Controller;

use mztx\ShinagePlayerBundle\Entity\CurrentPresentation;
use mztx\ShinagePlayerBundle\Service\LocalPresentationLoader;
use mztx\ShinagePlayerBundle\Service\LocalScheduler;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;

class PresentationViewerController extends Controller
{

    public function currentAction()
    {
        /** @var LocalScheduler $scheduler */
        $scheduler = $this->container->get('shinage.player.local_scheduler');
        /** @var CurrentPresentation $current */
        $current = $scheduler->getCurrentPresentation();
        return new Response(json_encode($current));
    }

    public function splashAction()
    {
        $slide1 = new \stdClass();
        $slide1->type = 'Image';
        $slide1->title = 'Shinage';
        $slide1->duration = 0;
        $slide1->transition = 'none';
        $slide1->src = 'http://localhost/assets/img/logo-base-dark.png';

        $presentation = new \stdClass();
        $presentation->slides = [
            $slide1
        ];
        $presentation->settings = new \stdClass();
        $presentation->settings->backgroundColor = '#000';

        return new Response(json_encode($presentation));
    }

    public function localAction($name)
    {
        /** @var LocalPresentationLoader $loader */
        $loader = $this->get('shinage.player.local_presentation_loader');
        $presentation = $loader->getByName($name);
        return new Response(json_encode($presentation));
    }

    public function localFileAction($presentation, $file)
    {
        /** @var LocalPresentationLoader $loader */
        $loader = $this->get('shinage.player.local_presentation_loader');
        $mime = '';
        $data = $loader->getFileByName($presentation, $file, $mime);

        return new Response($data, 200, ['Content-type' => $mime]);
    }

    public function testAction()
    {
        $slide1 = new \stdClass();
        $slide1->type = 'Image';
        $slide1->title = 'Test-Slide 1';
        $slide1->duration = 2000;
        $slide1->transition = 'none';
        $slide1->src = 'https://placehold.it/800x600';

        $slide2 = new \stdClass();
        $slide2->type = 'Image';
        $slide2->title = 'Test-Slide 2';
        $slide2->duration = 2000;
        $slide2->transition = 'none';
        $slide2->src = 'https://placehold.it/960x600';

        $slide3 = new \stdClass();
        $slide3->type = 'Image';
        $slide3->title = 'Test-Slide 3';
        $slide3->duration = 2000;
        $slide3->transition = 'none';
        $slide3->src = 'https://placehold.it/300x400';

        $slide4 = new \stdClass();
        $slide4->type = 'Image';
        $slide4->title = 'Test-Slide 4';
        $slide4->duration = 0;
        $slide4->transition = 'none';
        $slide4->src = 'https://www.w3schools.com/html/mov_bbb.mp4';
        // EXAMPLE VIDEO: Video courtesy of (https://www.bigbuckbunny.org/) (Big Buck Bunny)

        $presentation = new \stdClass();
        $presentation->slides = [
            $slide1, $slide2, $slide3, $slide4
        ];
        $presentation->settings = new \stdClass();
        $presentation->settings->backgroundColor = '#000';

        return new Response(json_encode($presentation));
    }
}
