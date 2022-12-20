<?php

namespace App\Command;

use App\Manager\DrawManager;
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
    private const BATCH_SIZE = 50;

    public function __construct(
        private readonly DrawManager $drawManager
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

        $fp = file($filePath, FILE_SKIP_EMPTY_LINES);
        $progressBar = new ProgressBar($output, count($fp));
        $rows = $this->readCsv($filePath);
        $this->import($rows, $progressBar);

        $progressBar->finish();
        $io->newLine(2);
        $io->success('File imported');

        return Command::SUCCESS;
    }

    private function readCsv(string $filePath): array
    {
        $row = 1;
        $result = [];
        if (($handle = fopen($filePath, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                if ($row === 1) {
                    $header = $data;
                } else {
                    $result[] = array_combine($header, $data);
                }
                $row++;
            }
            fclose($handle);
        }

        return $result;
    }

    private function import(array $rows, ProgressBar $progressBar)
    {
        for ($i = 0; $i < count($rows); $i++) {
            $flush = false;
            if (($i % 50) === 0) {
                $flush = true;
            }

            $this->drawManager->createFromCsv($rows[$i], $flush);
            $progressBar->advance();
        }
    }
}
