<?php

namespace Ocli\Command\Module;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Ocli\ModuleFactory;

class CreateCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('module:create')
            ->setDescription('Do you wanna create some hotsie-totsie module?')
            ->addArgument(
                'path',
                InputArgument::REQUIRED,
                'Path of the module?'
            )
            ->addArgument(
                'theme',
                InputArgument::REQUIRED,
                'Current theme?'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $path = $input->getArgument('path');
        $theme = $input->getArgument('theme');

        $factory = new ModuleFactory($path, $theme);
        $factory->createFiles();

        $output->writeln('Module has been created.');
    }
}
