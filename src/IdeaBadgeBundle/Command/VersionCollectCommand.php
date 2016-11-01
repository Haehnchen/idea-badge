<?php

namespace espend\IdeaBadgeBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Daniel Espendiller <daniel@espendiller.net>
 */
class VersionCollectCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('espend_idea_badge:version_collect_command')
            ->setDescription('Collect all known versions');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $provider = $this->getContainer()
            ->get('espend_idea_badge.generator_manager')
            ->get('downloads');

        $keys = $this->getContainer()
            ->get('espend.idea_badge.poser.provider.poser_last_month_storage')
            ->keys();

        $output->writeln(sprintf('Plugins to visit: %s', implode(',', $keys)));

        foreach($keys as $id) {
            $poser = $provider->getPoser($id);
            $output->writeln(sprintf('[%s] Fetched: %s', $id, $poser->getStatus()));
        }
    }
}
