<?php
// src/Command/CreateUserCommand.php
namespace Toolkit\Console;

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
      // outputs multiple lines to the console (adding "\n" at the end of each line)
      $output->writeln([
        'User Creator',
        '============',
        '',
      ]);

      // outputs a message followed by a "\n"
      $output->writeln('Whoa!');

      // outputs a message without adding a "\n" at the end of the line
      $output->write('You are about to ');
      $output->write('create a user.');
    }
}
