<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use ZipArchive;

#[AsCommand(
    name: 'app:extract:result-csv',
    description: 'Get all csv file from FDJ since 2009-01-01',
)]
class ExtractResultCommand extends Command
{
    private const CONFIRMATION_TEXT = 'I am sure!';
    private const ARRAY_LOTO_URL = [
        'https://media.fdj.fr/static-draws/csv/loto/loto_',
        'https://media.fdj.fr/static-draws/csv/loto/superloto_',
        'https://media.fdj.fr/static-draws/csv/loto/lotonoel_',
        'https://media.fdj.fr/static-draws/csv/loto/grandloto_',
        'https://media.fdj.fr/static-draws/csv/euromillions/euromillions_',
    ];

    private int $count;

    public function __construct(
        private readonly HttpClientInterface $client,
    )
    {
        $this->count = 0;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('date', InputArgument::OPTIONAL, 'Date format "Y-m-d" (2009-01-01)', '2009-01-01')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
//        if (!$this->confirmation($io)) {
//            return Command::FAILURE;
//        }

        $start = strtotime($input->getArgument('date'));
        $end = new \DateTime();
        $end = strtotime($end->format("Y-m-d"));

        for ($i = $start; $i <= $end; $i = strtotime("+1 month", $i)) {
            $date = date("Ym", $i);
            foreach (self::ARRAY_LOTO_URL as $lotoUrl) {
                $url = $lotoUrl.$date.'.zip';
                $response = $this->client->request('GET', $url);

                if ($response->getStatusCode() == 200) {
                    $this->getZipAndExtract($io, $url);
                }
            }
        }

        $io->success(sprintf('%s files have been extracted', $this->count));

        return Command::SUCCESS;
    }

    private function confirmation(SymfonyStyle $io)
    {
        $io->section('Confirmation');
        $io->caution([
            'This command will do multiples GET.',
            'Make sure you have activated your VPN',
            'If you are sure, copy the following sentence:',
            self::CONFIRMATION_TEXT,
        ]);

        $valid = $io->ask('Are you sure ?', null, static function ($response) {
            return self::CONFIRMATION_TEXT === $response;
        });

        if (!$valid) {
            $io->error('Invalid confirmation phrase');

            return false;
        }

        $io->success('Good passphrase. Fly you fool !');

        return true;
    }

    private function getZipAndExtract(SymfonyStyle $io, string $url)
    {
        $fileNameZip = basename($url);
        $fileNameZip = \dirname(__DIR__).'/../data/'.$fileNameZip;
        file_put_contents($fileNameZip, file_get_contents($url));

        $zip = new ZipArchive;
        if ($zip->open($fileNameZip) === TRUE) {
            $zipName = str_replace('.zip', '', $zip->getNameIndex(0));
            $originalName = str_replace('.zip', '', $fileNameZip);
            $pathExtract = \dirname(__DIR__).'/../data/'.$zipName;

            if (file_exists($pathExtract)) {
                rename($pathExtract, $originalName.'_'.uniqid().'.csv');
            }

            $zip->extractTo(\dirname(__DIR__).'/../data/');
            $zip->close();
            unlink($fileNameZip);

            $io->info(sprintf('%s have been extracted', $fileNameZip));
            $this->count++;
        }
    }
}
