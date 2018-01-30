<?php

/**
 * This command should do the following tasks:
 */

namespace Toolkit\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ProvisionCommand extends Command
{
    protected function configure()
    {
      $this->setName('env:provision')
           ->setDescription('Make provision of Cloud9.')
           ->setHelp('This command allows you to use Cloud9 with toolkit...');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
      // Update system and required packages.
      exec("sudo yum update -y");
      exec("sudo yum -y install php56-pecl-xdebug");
      exec("sudo sed -i \"/^;xdebug.remote_enable/axdebug.remote_enable = 1\" /etc/php-5.6.d/15-xdebug.ini");
      exec("sudo yum -y remove mysql-config mysql55-libs mysql55-server perl-DBD-MySQL55");
      exec("sudo yum -y install mysql56-server");
      exec("sudo yum -y install phpMyAdmin");

      // Setup services selenium, mysql and apache.
      exec("docker swarm init");
      exec("docker stack deploy -c ./resources/selenium.yml selenium");
      exec("sudo service mysqld start");
      exec("sudo sed -i /^Listen/s/80/8080/ /etc/httpd/conf/httpd.conf ");
      exec("sudo service httpd start");
      exec("sudo sed -i /memory_limit/s/128M/1G/ /etc/php.ini");
      exec("for x in httpd mysqld;do sudo chkconfig $x on;done");
      exec("mkdir build");
      exec("sudo cp /etc/httpd/conf/httpd.conf /etc/httpd/conf/httpd.conf.OLD");
      exec("sudo sed -i '/var\/www\/html/s/var\/www\/html/home\/ec2-user\/environment\/build/' /etc/httpd/conf/httpd.conf");
      exec("sudo sed -i \"/User apache/s/apache/ec2-user/\" /etc/httpd/conf/httpd.conf");
      exec("sudo sed -i \"/Group apache/s/apache/ec2-user/\" /etc/httpd/conf/httpd.conf");
      exec("sudo sed -i \"/AllowOverride None/s/AllowOverride None/AllowOverride All/\" /etc/httpd/conf/httpd.conf");
      exec("sudo sed -i \"/AllowOverride none/s/AllowOverride none/AllowOverride All/\" /etc/httpd/conf/httpd.conf");
      exec("sudo service httpd restart");

      // outputs a message followed by a "\n"
      $output->writeln('Provision of cloud9 Complete!');
    }
}
