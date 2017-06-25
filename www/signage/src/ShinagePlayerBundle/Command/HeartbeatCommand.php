<?php

namespace mztx\ShinagePlayerBundle\Command;

use mztx\ShinagePlayerBundle\Entity\HeartbeatAnswer;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class HeartbeatCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName("shinage:player:heartbeat")
            ->setHelp("Tries to ping the control server configured in config files.")
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $heartbeat = $this->getContainer()->get("shinage.player.remote.heartbeat");
        /** @var HeartbeatAnswer $answer */
        $answer = $heartbeat->beat();
        $output->writeln("<info>".var_export($answer, true)."</info>");
    }
}
