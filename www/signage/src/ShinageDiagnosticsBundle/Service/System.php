<?php

namespace mztx\ShinageDiagnosticsBundle\Service;

class System
{

    public function poweroff()
    {
        exec("sudo /sbin/poweroff > /dev/null &");
    }

    public function reboot()
    {
        exec("sudo /sbin/reboot > /dev/null &");
    }

    public function getLoadavg()
    {
        return exec('cat /proc/loadavg');
    }

    public function getCmdline()
    {
        return exec('cat /proc/cmdline');
    }
}
