<?php

namespace App\Manager;

use App\Entity\Draw;
use App\Repository\DrawRepository;
use App\Utils\ArrayKeyExists;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Helper\ProgressBar;

class DrawManager
{
    private const BATCH_SIZE = 200;

    public function __construct(
        private readonly DrawRepository $drawRepository,
        private readonly ArrayKeyExists $arrayKeyExists,
        private readonly EntityManagerInterface $entityManager,
    )
    {
    }

    public function import(array $rows, ProgressBar $progressBar, $name): void
    {
        for ($i = 0; $i < count($rows); $i++) {
            $flush = false;
            if (($i % self::BATCH_SIZE) === 0) {
                $flush = true;
            }

            $this->createFromCsv($rows[$i], $name, $flush);
            $progressBar->advance();
        }

        $this->entityManager->flush();
    }

    public function createFromCsv(array $row, string $name, bool $flush = false): Draw
    {
        $draw = $this->drawRepository->findOneBy(['nbDraw' => $row['annee_numero_de_tirage'].'_'.$name]);
        if ($draw instanceof Draw) {
            return $draw;
        }

        $date = null;
        if (array_key_exists('date_de_tirage', $row)) {
            $rowDate = $row['date_de_tirage'];
            if (!strpos($rowDate, '/')) {
                $date = DateTime::createFromFormat('Ymd', $rowDate);
            } else {
                $date = DateTime::createFromFormat('d/m/Y', $rowDate);
            }
        }

        $comboWin = $this->arrayKeyExists->getOrNull($row, 'combinaison_gagnante_en_ordre_croissant');
        if (is_null($comboWin)) {
            $comboWin = $this->arrayKeyExists->getOrNull($row, 'boules_gagnantes_en_ordre_croissant');
        }

        $draw = new Draw();
        $draw
            ->setNbDraw($this->arrayKeyExists->getOrNull($row, 'annee_numero_de_tirage', 'int').'_'.$name)
            ->setDay($row['jour_de_tirage'])
            ->setDate($date)
            ->setBall1($this->arrayKeyExists->getOrNull($row, 'boule_1', 'int'))
            ->setBall2($this->arrayKeyExists->getOrNull($row, 'boule_2', 'int'))
            ->setBall3($this->arrayKeyExists->getOrNull($row, 'boule_3', 'int'))
            ->setBall4($this->arrayKeyExists->getOrNull($row, 'boule_4', 'int'))
            ->setBall5($this->arrayKeyExists->getOrNull($row, 'boule_5', 'int'))
            ->setLuckyBall($this->arrayKeyExists->getOrNull($row, 'numero_chance', 'int'))
            ->setWinComboAsc($comboWin)
            ->setNbWinRank1($this->arrayKeyExists->getOrNull($row, 'nombre_de_gagnant_au_rang1', 'int'))
            ->setAmountRank1($this->arrayKeyExists->getOrNull($row, 'rapport_du_rang1', 'float'))
            ->setNbWinRank2($this->arrayKeyExists->getOrNull($row, 'nombre_de_gagnant_au_rang2', 'int'))
            ->setAmountRank2($this->arrayKeyExists->getOrNull($row, 'rapport_du_rang2', 'float'))
            ->setNbWinRank3($this->arrayKeyExists->getOrNull($row, 'nombre_de_gagnant_au_rang3', 'int'))
            ->setAmountRank3($this->arrayKeyExists->getOrNull($row, 'rapport_du_rang3', 'float'))
            ->setNbWinRank4($this->arrayKeyExists->getOrNull($row, 'nombre_de_gagnant_au_rang4', 'int'))
            ->setAmountRank4($this->arrayKeyExists->getOrNull($row, 'rapport_du_rang4', 'float'))
            ->setNbWinRank5($this->arrayKeyExists->getOrNull($row, 'nombre_de_gagnant_au_rang5', 'int'))
            ->setAmountRank5($this->arrayKeyExists->getOrNull($row, 'rapport_du_rang5', 'float'))
            ->setNbWinRank6($this->arrayKeyExists->getOrNull($row, 'nombre_de_gagnant_au_rang6', 'int'))
            ->setAmountRank6($this->arrayKeyExists->getOrNull($row, 'rapport_du_rang6', 'float'))
            ->setNbWinRank7($this->arrayKeyExists->getOrNull($row, 'nombre_de_gagnant_au_rang7', 'int'))
            ->setAmountRank7($this->arrayKeyExists->getOrNull($row, 'rapport_du_rang7', 'float'))
            ->setNbWinRank8($this->arrayKeyExists->getOrNull($row, 'nombre_de_gagnant_au_rang8', 'int'))
            ->setAmountRank8($this->arrayKeyExists->getOrNull($row, 'rapport_du_rang8', 'float'))
            ->setNbWinRank9($this->arrayKeyExists->getOrNull($row, 'nombre_de_gagnant_au_rang9', 'int'))
            ->setAmountRank9($this->arrayKeyExists->getOrNull($row, 'rapport_du_rang9', 'float'))
            ;

        $this->drawRepository->save($draw, $flush);

        return $draw;
    }

    public function getAverageAll(): array
    {
        $all = $this->drawRepository->getAllBalls();
        $selects = ['ball1', 'ball2', 'ball3', 'ball4', 'ball5'];
        $countAll = count($all) * count($selects);

        $count = [];
        /** @var Draw $stat */
        foreach ($all as $stat) {
            foreach ($selects as $select) {
                if (!array_key_exists($stat[$select], $count)) {
                    $count[$stat[$select]] = 0;
                }
                $count[$stat[$select]]++;
            }
        }
        arsort($count);
        $flipped = array_flip($count);
        $flipped = array_slice($flipped, 0, 10);

        krsort($count);
        $result = [];
        $tenMost = [];
        foreach ($count as $key => $value) {
            $result[$key] = $this->arrayTransformer($key, $value, $countAll);
            if (in_array($key, $flipped)) {
                $tenMost[$key] = $this->arrayTransformer($key, $value, $countAll);
                $result[$key]['attr'] = ['bold' => true];
            }
        }

        ksort($result);
        usort($tenMost, function($a, $b) {
            return $b['count'] <=> $a['count'];
        });

        return [
            'result' => $result,
            'ten_most' => $tenMost,
        ];
    }

    private function arrayTransformer($key, $value, $countAll): array
    {
        return [
            'ball' => $key,
            'count' => $value,
            'percent' => $value * 100 / $countAll,
        ];
    }
}
