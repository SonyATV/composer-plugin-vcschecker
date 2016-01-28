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
            $repos = array();

            foreach ($this->composer->getConfig()->getRepositories() as $key => $repository) {
                if ($repository['type'] == 'vcs') {
                    $protocol = parse_url($repository['url'], PHP_URL_SCHEME);

                    if ($protocol == 'file') {
                        $repos[] = $repository['url'];
                    }                   
                }
            }

            if (!empty($repos)) {
                $this->io->write('[composer-plugin-vcschecker: Begin]');
                $this->io->write('<error>The following file protocol URLs were detected in the composer.json repositories section:</error>');

                $indentedRepos = implode("\n", array_map(function ($line) {
                    return '    ' . ltrim($line);
                }, $repos));
                $this->io->write($indentedRepos);

                $this->io->write('<error>Please correct the URLs to point to their correct remote location.</error>');
                $this->io->write('[composer-plugin-vcschecker: End]');

                $this->io->writeError('');
            }
        }
    }
}
