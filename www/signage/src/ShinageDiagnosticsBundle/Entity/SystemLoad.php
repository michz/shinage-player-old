<?php

namespace mztx\ShinageDiagnosticsBundle\Entity;

/**
 * Created by solutionDrive GmbH.
 *
 * @author   :  Michael Zapf <mz@solutionDrive.de>
 * @date     :  04.01.18
 * @time     :  13:25
 * @copyright:  2018 solutionDrive GmbH
 */
class SystemLoad
{
    public $MemTotal        = '';
    public $MemFree         = '';
    public $MemAvailable    = '';
    public $SwapTotal       = '';
    public $SwapFree        = '';
    public $LoadAvg1min     = '';
    public $LoadAvg5min     = '';
    public $LoadAvg15min    = '';
}
