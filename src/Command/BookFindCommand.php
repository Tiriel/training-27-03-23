<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:book:find',
    description: 'Command to find a book in database'
)]
class BookFindCommand extends Command
{
    protected function configure()
    {
        $this
            ->addArgument('lastname', InputArgument::REQUIRED, 'Your lastname')
            ->addArgument('firstname', InputArgument::IS_ARRAY, 'Your firstname')
            ->addOption('gender',null,  InputOption::VALUE_REQUIRED|InputOption::VALUE_IS_ARRAY, 'Your gender')
            ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $firstname = $input->getArgument('firstname');
        $lastname = $input->getArgument('lastname');
        $gender = $input->getOption('gender');

        $io->note(sprintf("You gave a lastname! %s", $lastname));
        if ($firstname) {
            $io->text(sprintf("Your firstname : %s", implode(', ', $firstname)));
        }

        if (null !== $gender) {
            $io->info(sprintf("You passed a gender : %s", implode(', ', $gender)));
        }

        $io->success('It\'s alive!');

        return Command::SUCCESS;
    }
}
