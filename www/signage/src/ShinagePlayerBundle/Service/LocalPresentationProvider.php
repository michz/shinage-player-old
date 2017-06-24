<?php

namespace mztx\ShinagePlayerBundle\Service;

use mztx\ShinagePlayerBundle\Entity\CurrentPresentation;
use mztx\ShinagePlayerBundle\Model\Playable;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpKernel\Kernel;

class LocalPresentationProvider
{
    // @TODO Mögliche Dateinamenserweiterungen konfigurierbar machen
    private static $EXT_IMAGE    = array('png', 'jpg', 'jpeg', 'gif', 'tif', 'tiff');
    private static $EXT_VIDEO    = array('mp4', 'wmv', 'm4v', 'mov', 'ogg', 'avi');
    private static $EXT_VECTOR   = array('svg');

    /** @var Kernel */
    protected $kernel;

    /** @var string */
    protected $basePath = '';

    /** @var LocalPresentationLoader */
    protected $presentationLoader;

    /** @var array */
    protected $cachedDrives = [];

    /**
     * @param Kernel $kernel
     * @param string $basePath
     * @param LocalPresentationLoader $presentationLoader
     */
    public function __construct($kernel, $basePath, $presentationLoader)
    {
        $this->kernel = $kernel;
        $this->basePath = $basePath;
        $this->presentationLoader = $presentationLoader;
    }

    public function getPresentationList()
    {
        $presentations = [];
        $drives = $this->getDrives();

        /** @var Router $router */
        $router = $this->kernel->getContainer()->get('router');

        foreach ($drives as $drive) {
            $presentation = new CurrentPresentation();
            $presentation->url = $router->generate('shinage.player.presentation.local', ['name' => $drive]);
            $presentation->lastModified = 0;
            $presentations[] = $presentation;
        }
        return $presentations;
    }


    public function getDrives()
    {
        if (!empty($this->cachedDrives)) {
            return $this->cachedDrives;
        }
        $this->cachedDrives = [];
        $it = new \DirectoryIterator($this->basePath);

        /** @var \SplFileInfo $fileInfo */
        foreach ($it as $fileInfo) {
            if (!$fileInfo->isDir() || !$fileInfo->isReadable()) {
                // ignore files and unreadable directories
                continue;
            }

            $absolutePath = $fileInfo->getRealPath();
            if (strpos($fileInfo->getFilename(), 'usbhd-') === 0 &&
                !file_exists($absolutePath . '/signage_ignore') &&
                !file_exists($absolutePath . '/signage_ignore.txt') &&
                self::containsPlayableDirectoryContents($absolutePath)) {
                $this->cachedDrives[] = $fileInfo->getFilename();
            }
        }
        return $this->cachedDrives;
    }



    public static function getPlayableDirectoryContents($path)
    {
        $playables = array();

        $it = new \DirectoryIterator($path);
        foreach ($it as $fileInfo) {
            if (in_array($fileInfo->getExtension(), self::$EXT_IMAGE)) {
                $p = new Playable('Image', $fileInfo->getFilename());
                $playables[] = $p;
            }
        }

        return $playables;
    }

    public static function containsPlayableDirectoryContents($path)
    {
        $c = self::getPlayableDirectoryContents($path);
        return (count($c) > 0);
    }
}
