<?php

namespace mztx\ShinagePlayerBundle\Service;

use mztx\ShinagePlayerBundle\Entity\CurrentPresentation;

class LocalScheduler
{

    /** @var LocalPresentationProvider */
    protected $localProvider;

    /**
     * @param LocalPresentationProvider $localProvider
     */
    public function __construct(LocalPresentationProvider $localProvider)
    {
        $this->localProvider = $localProvider;
    }

    /**
     * Checks if a usb stick is mounted and which presentation should be played.
     * @return CurrentPresentation
     */
    public function getCurrentPresentation()
    {

        $localPresentations = $this->localProvider->getPresentationList();

        if (empty($localPresentations)) {
            $current = new CurrentPresentation();
            $current->lastModified = 123;
            $current->url = '/splash';
        } else {
            $current = $localPresentations[0];
        }

        return $current;
    }
}
