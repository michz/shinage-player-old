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

    /** @var Remote */
    protected $remote;

    /** @var bool */
    protected $enabledLocal = true;

    /** @var bool */
    protected $enabledRemote = true;

    /**
     * @param LocalPresentationProvider $localProvider
     * @param Heartbeat $heartbeat
     */
    public function __construct(LocalPresentationProvider $localProvider, Heartbeat $heartbeat, Remote $remote)
    {
        $this->localProvider = $localProvider;
        $this->heartbeat = $heartbeat;
        $this->remote = $remote;
    }

    /**
     * Checks if a usb stick is mounted and which presentation should be played.
     * @return CurrentPresentation
     */
    public function getCurrentPresentation()
    {
        // First check if we can play a local presentation
        // @TODO check if local presentations are enabled/disabled in config
        $localPresentations = $this->localProvider->getPresentationList();

        if (!empty($localPresentations)) {
            $current = $localPresentations[0];
            return $current;
        }

        // Now check if we can play a remote presentation
        // @TODO Check if remote presentations are enabled/disabled in config
        try {
            /** @var HeartbeatAnswer $heartbeatAnswer */
            $heartbeatAnswer = $this->heartbeat->beat();
            if (!empty($heartbeatAnswer->presentation)) {
                // Show remote presentation.
                $current = new CurrentPresentation();
                $current->lastModified = $heartbeatAnswer->last_modified;
                $current->url = '/p/remote/'.$heartbeatAnswer->presentation;
                return $current;
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
