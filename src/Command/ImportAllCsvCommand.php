<?php

namespace App\Command;

use App\Utils\ImportLotoFile;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:import:all-csv',
    description: 'This command import CSV file',
)]
class ImportAllCsvCommand extends Command
{
    private const BATCH_SIZE = 200;

    public function __construct(
        private readonly ImportLotoFile $importLotoFile,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $files = scandir(\dirname(__DIR__).'/../data');
        $banFileName = ['.', '..', '.gitkeep', '.gitignore'];
        foreach ($files as $file) {
            if (in_array($file, $banFileName)) {
                continue;
            }

            $this->importLotoFile->importLotoFile($output, \dirname(__DIR__).'/../data/'.$file);

            $io->newLine(2);
            $io->success(sprintf('File %s have been imported', $file));
        }

        return Command::SUCCESS;
    }
}
