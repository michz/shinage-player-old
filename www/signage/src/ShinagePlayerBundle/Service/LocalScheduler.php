<?php

namespace mztx\ShinagePlayerBundle\Service;

use mztx\ShinagePlayerBundle\Entity\CurrentPresentation;
use mztx\ShinagePlayerBundle\Entity\HeartbeatAnswer;

class LocalScheduler
{

    /** @var LocalPresentationProvider */
    protected $localProvider;

    /** @var Heartbeat */
    protected $heartbeat;

    /**
     * @param LocalPresentationProvider $localProvider
     * @param Heartbeat $heartbeat
     */
    public function __construct(LocalPresentationProvider $localProvider, Heartbeat $heartbeat)
    {
        $this->localProvider = $localProvider;
        $this->heartbeat = $heartbeat;
    }

    /**
     * Checks if a usb stick is mounted and which presentation should be played.
     * @return CurrentPresentation
     */
    public function getCurrentPresentation()
    {
        // First check if we can play a local presentation
        // @TODO check if local presentations are enabled/disabled
        $localPresentations = $this->localProvider->getPresentationList();

        if (!empty($localPresentations)) {
            $current = $localPresentations[0];
            return $current;
        }

        // Now check if we can play a remote presentation
        // @TODO Heartbeat
        try {
            /** @var HeartbeatAnswer $heartbeatAnswer */
            $heartbeatAnswer = $this->heartbeat->beat();
            if (!empty($heartbeatAnswer->presentation)) {
                // @TODO Fetch presentation from remote
            }
        } catch (\Exception $ex) {
            // @TODO Log the error somehow.
        }

        // No presentation found. Show splash.
        $current = new CurrentPresentation();
        $current->lastModified = 123;
        $current->url = '/p/splash';

        return $current;
    }
}
