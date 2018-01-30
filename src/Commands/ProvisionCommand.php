<?php
// src/Command/CreateUserCommand.php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ProvisionCommand extends Command
{
    protected function configure()
    {
      $this->setName('toolkit-console:provision')
           ->setDescription('Make provision of Cloud9.')
           ->setHelp('This command allows you to use Cloud9 with toolkit...');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // ...
    }
}
