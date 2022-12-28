<?php

namespace App\Utils;

use App\Manager\DrawManager;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\OutputInterface;

class ImportLotoFile
{
    public function __construct(
        private readonly DrawManager $drawManager,
        private readonly CsvReader $csvReader,
    )
    {
    }

    public function importLotoFile(OutputInterface $output, string $file)
    {
        $fp = file($file, FILE_SKIP_EMPTY_LINES);
        $progressBar = new ProgressBar($output, count($fp));
        $rows = $this->csvReader->readCsv($file);

        $parts = explode("_", basename($file));
        $name = $parts[0];

        $this->drawManager->import($rows, $progressBar, str_replace('.csv', '', $name));

        $progressBar->finish();
    }
}
