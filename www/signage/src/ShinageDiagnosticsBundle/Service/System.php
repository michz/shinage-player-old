<?php

namespace mztx\ShinageDiagnosticsBundle\Service;

use mztx\ShinageDiagnosticsBundle\Entity\SystemLoad;

class System
{

    public function poweroff()
    {
        exec("sudo /sbin/poweroff &", $output, $exitCode);
        if ($exitCode !== 0) {
            throw new \RuntimeException(
                'Could not poweroff. '.PHP_EOL.'Exit code: '.$exitCode.PHP_EOL.PHP_EOL.
                'Output from terminal:'.PHP_EOL.implode("\n", $output)
            );
        }
    }

    public function reboot()
    {
        exec("sudo /sbin/reboot &", $output, $exitCode);
        if ($exitCode !== 0) {
            throw new \RuntimeException(
                'Could not reboot. '.PHP_EOL.'Exit code: '.$exitCode.PHP_EOL.PHP_EOL.
                'Output from terminal:'.PHP_EOL.implode("\n", $output)
            );
        }
    }

    public function getLoadavg()
    {
        $raw = exec('cat /proc/loadavg');
        $parts = explode(' ', $raw);
        return [
            '1min'  => $parts[0],
            '5min'  => $parts[1],
            '15min' => $parts[2],
        ];
    }

    public function getCmdline()
    {
        return exec('cat /proc/cmdline');
    }

    public function getLoad()
    {
        $load = new SystemLoad();

        $data = $this->getMeminfo();
        $load->MemTotal     = $data['MemTotal'];
        $load->MemFree      = $data['MemFree'];
        $load->MemAvailable = $data['MemAvailable'];
        $load->SwapTotal    = $data['SwapTotal'];
        $load->SwapFree     = $data['SwapFree'];

        $loadavg = $this->getLoadavg();
        $load->LoadAvg1min  = $loadavg['1min'];
        $load->LoadAvg5min  = $loadavg['5min'];
        $load->LoadAvg15min = $loadavg['15min'];

        return $load;
    }

    public function getMeminfo()
    {
        exec('cat /proc/meminfo', $lines);
        preg_match_all("/^\s*([a-zA-Z\(\)]+)\:\s*([0-9]+)/im", implode("\n", $lines), $matches, PREG_SET_ORDER);

        $data = [];
        foreach ($matches as $match) {
            $data[$match[1]] = $match[2];
        }
        return $data;
    }
}
