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
use Symfony\Component\Console\Style\SymfonyStyle;

class QualityAssuranceCommand extends Command
{
    public $project = '';
    public $prNumber = '';

    protected function configure()
    {
        $this->setName('qa:mjolnir')
          ->setDescription('Check pull-request with everything.')
          ->setHelp('Check pull-request with everything.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $io->section('Requesting information about project:');
        $this->requestInformation($input, $output);

        $io->section('Download source code:');
        $this->downloadProject();

    }

    private function requestInformation(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');
        $question = new Question('Please enter the project-id: ', 'Toolkit');
        $this->project = $helper->ask($input, $output, $question);


        $question = new Question('Please enter the PR number: ', '#1');
        $this->prNumber= $helper->ask($input, $output, $question);
    }

    private function downloadProject()
    {
        exec("mkdir " . $this->project . " 2> /dev/null");
        exec("cd " . $this->project);
        exec("git init 2> /dev/null");
        exec("git remote add origin https://github.com/ec-europa/" . $this->project . "-reference.git");
        exec("git fetch --no-tags origin +refs/pull/" . $this->$prNumber . "/merge:");
        exec("git checkout -qf FETCH_HEAD");
        exec("git submodule update --init --recursive");
    }

    private function installProject()
    {

    }

}
