<?php

namespace App\Manager;

use App\Entity\Draw;
use App\Repository\DrawRepository;
use App\Utils\ArrayKeyExists;
use DateTime;

class DrawManager
{
    public function __construct(
        private readonly DrawRepository $drawRepository,
        private readonly ArrayKeyExists $arrayKeyExists,
    )
    {
    }

    public function createFromCsv(array $row, bool $flush = false): Draw
    {
        $draw = $this->drawRepository->findOneBy(['nbDraw' => $row['annee_numero_de_tirage']]);
        if ($draw instanceof Draw) {
            return $draw;
        }

        $date = null;
        if (array_key_exists('date_de_tirage', $row)) {
            $timestamp = strtotime('27/02/2017');
            $date = new DateTime($timestamp);
        }
        $comboWin = $this->arrayKeyExists->getOrNull($row, 'combinaison_gagnante_en_ordre_croissant');
        if (is_null($comboWin)) {
            $comboWin = $this->arrayKeyExists->getOrNull($row, 'boules_gagnantes_en_ordre_croissant');
        }

        $draw = new Draw();
        $draw
            ->setNbDraw($this->arrayKeyExists->getOrNull($row, 'annee_numero_de_tirage', 'int'))
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
}
