<?php

namespace App\Command;

use App\Manager\DrawManager;
use App\Utils\CsvReader;
use App\Utils\ImportLotoFile;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:import:csv',
    description: 'This command import CSV file',
)]
class ImportCsvCommand extends Command
{
    public function __construct(
        private readonly ImportLotoFile $importLotoFile,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('file_path', InputArgument::REQUIRED, 'Csv file path')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $filePath = $input->getArgument('file_path');
        if (!is_file($filePath)) {
            $io->error(sprintf('%s is not a file', $filePath));

            return Command::FAILURE;
        } else {
            $io->note(sprintf('You passed an argument: %s', $filePath));
        }

        $this->importLotoFile->importLotoFile($output, $filePath);

        $io->newLine(2);
        $io->success('File imported');

        return Command::SUCCESS;
    }
}
