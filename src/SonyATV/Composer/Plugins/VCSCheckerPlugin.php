<?php

namespace SonyATV\Composer\Plugins;

use Composer\Composer;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;
use Composer\Plugin\PluginEvents;
use Composer\Plugin\CommandEvent;

class VCSCheckerPlugin implements PluginInterface, EventSubscriberInterface
{
    protected $composer;
    protected $io;

    public function activate(Composer $composer, IOInterface $io)
    {
        $this->composer = $composer;
        $this->io = $io;
    }

    public static function getSubscribedEvents()
    {
        return array(
            PluginEvents::COMMAND => array(
                array('onCommand', 0)
            )
        );
    }

    public function onCommand(CommandEvent $event)
    {
        $command = $event->getCommandName();
        $input = $event->getInput();
        $output = $event->getOutput();

        if ($command == 'status') {
            $output->writeln('The "composer status" command was invoked.');
        }
        if ($command == 'validate') {
            $output->writeln('The "composer validate" command was invoked.');
        }
    }
}
