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

class BuildProjectCommand extends Command
{
    protected function configure()
    {
      $this->setName('toolkit:build')
           ->setDescription('Create a new project based in toolkit.')
           ->setHelp('Install toolkit in the current folder.');
          //  ->addArgument(
          //       'names',
          //       InputArgument::IS_ARRAY | InputArgument::REQUIRED,
          //       'Who do you want to greet (separate multiple names with a space)?'
          //   );
          // ->addOption('colors', null, InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
          //     'Which colors do you like?',
          //     array('blue', 'red')
          // );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

      // Update system and required packages.
      $availableProfiles = [
        'multisite_drupal_standard',
        'multisite_drupal_communities',
        'other',
      ];

      $output->writeln('Start project build!');
      exec("toolkit/phing build-platform build-subsite-dev");
      $output->writeln('Build complete!');

      // Init assistant to populate required settings.
      // Asda credentials and database connection.
      // $names = $input->getArgument('names');
      // if (count($names) > 0) {
      //     $output->writeln(implode(', ', $names));
      // }

      // $helper = $this->getHelper('question');
      // $question = new Question('Please enter the name of the bundle: ', 'AcmeDemoBundle');

      // $bundle = $helper->ask($input, $output, $question);

      $helper = $this->getHelper('question');
      $question = new ChoiceQuestion(
          'Please select the profile to install (defaults to standard)',
          $availableProfiles,
          0
      );
      $question->setErrorMessage('Profile %s is invalid.');

      $profile = $helper->ask($input, $output, $question);

      // Set profile and version.

      switch ($profile) {
        case 'multisite_drupal_standard':
          # code...
          break;
        case 'multisite_drupal_communities':
            # code...
            break;
        default:
          # code...
          break;
      }

      $output->writeln('You have just selected: '. $profile);

    }
}
