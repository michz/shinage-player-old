<?php

namespace mztx\ShinagePlayerBundle\Service;

use mztx\ShinagePlayerBundle\Entity\CurrentPresentation;
use mztx\ShinagePlayerBundle\Entity\Presentation;
use mztx\ShinagePlayerBundle\Entity\Slide;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpKernel\Kernel;

class LocalPresentationLoader
{
    const PRESENTATION_FILENAME = 'presentation.json';

    // @TODO Mögliche Dateinamenserweiterungen konfigurierbar machen
    private static $EXT_IMAGE    = array('png', 'jpg', 'jpeg', 'gif', 'tif', 'tiff');
    private static $EXT_VIDEO    = array('mp4', 'wmv', 'm4v', 'mov', 'ogg', 'avi');
    private static $EXT_VECTOR   = array('svg');

    /** @var string */
    protected $basePath = '';

    /** @var Kernel */
    protected $kernel;

    /**
     * LocalPresentationLoader constructor.
     *
     * @param string $basePath
     */
    public function __construct($kernel, $basePath)
    {
        $this->kernel = $kernel;
        $this->basePath = $basePath;
    }

    public function getFileByName($presentation, $file, &$mime = '')
    {
        $path = $this->basePath.DIRECTORY_SEPARATOR.$presentation.DIRECTORY_SEPARATOR.$file;
        $mime = mime_content_type($path);
        return file_get_contents($path);
    }

    public function getByName($name)
    {
        return $this->getFromDirectory($name, $this->basePath.DIRECTORY_SEPARATOR.$name);
    }

    /**
     * Loads a presentation from the given path.
     * @param string $path
     * @return Presentation
     */
    public function getFromDirectory($name, $path)
    {
        // @TODO check validity of presentation.json.
        if ($this->hasValidConfigFile($path)) {
            return $this->loadWithConfig($name, $path);
        }
        return $this->loadWithoutConfig($name, $path);
    }

    protected function hasValidConfigFile($path)
    {
        // @TODO check validity of presentation.json.
        if (file_exists($path.DIRECTORY_SEPARATOR.''.self::PRESENTATION_FILENAME)) {
            return true;
        }
        return false;
    }

    protected function loadWithoutConfig($name, $path)
    {
        $slides = [];

        /** @var Router $router */
        $router = $this->kernel->getContainer()->get('router');

        $it = new \DirectoryIterator($path);
        foreach ($it as $fileInfo) {
            $type = $this->getFileType($fileInfo);
            if (!$type) {
                // don't know file type => ignore
                continue;
            }

            $slide = new Slide();
            $slide->type = $type;
            $slide->title = $fileInfo->getFilename();
            $slide->src = $router->generate(
                'shinage.player.file.local',
                ['presentation' => $name, 'file' => $fileInfo->getFilename()]
            );
            $slides[] = $slide;
        }
        $presentation = new Presentation();
        $presentation->slides = $slides;
        return $presentation;
    }

    /**
     * @param \SplFileInfo $fileInfo
     * @return string|null
     */
    protected function getFileType($fileInfo)
    {
        $ext = $fileInfo->getExtension();
        if (in_array($ext, self::$EXT_IMAGE)) {
            return 'Image';
        }
        if (in_array($ext, self::$EXT_VIDEO)) {
            return 'Video';
        }
        if (in_array($ext, self::$EXT_VECTOR)) {
            #return 'Vector';
        }
        return null;
    }

    protected function loadWithConfig($name, $path)
    {
        // @TODO Load presentation based on config file.
        $presentation = new Presentation();
        return $presentation;
    }
}
