<?php

/**
 * This command should do the following tasks:
 */

namespace Toolkit\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Question\ChoiceQuestion;

class CreateProjectCommand extends Command
{
    protected function configure()
    {
        $this->setName('toolkit:new')
           ->setDescription('Create a new project based in toolkit.')
           ->setHelp('Install toolkit in the current folder.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Update system and required packages.
        $silentOutput = [];
        $output->writeln('Toolkit installation started!');
        exec("rm -rf temp/ build/ 2> /dev/null");
        exec("composer create-project ec-europa/subsite temp dev-master");
        exec("mv -f temp/* ./ 2> /dev/null");
        exec("mv -f temp/.* ./ 2> /dev/null");
        exec("rm -rf temp 2> /dev/null");
        // outputs a message followed by a "\n"
        $output->writeln('Toolkit installation complete!');
    }
}
