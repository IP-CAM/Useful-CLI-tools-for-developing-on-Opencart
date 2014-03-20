<?php

namespace Ocli\Command\Module;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CreateCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('module:create')
            ->setDescription('Do you wanna create some hotsie-totsie module?')
            ->addArgument(
                'name',
                InputArgument::REQUIRED,
                'Name of the module?'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');
        $text = 'Created '. $name . '.';

        $output->writeln($text);
    }
}
