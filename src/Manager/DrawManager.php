<?php

namespace App\Manager;

use App\Entity\Draw;
use App\Repository\DrawRepository;

class DrawManager
{
    public function __construct(
        private readonly DrawRepository $drawRepository
    )
    {
    }

    public function createFromCsv(array $row, bool $flush = false): Draw
    {
        $draw = $this->drawRepository->findOneBy(['nbDraw' => $row['annee_numero_de_tirage']]);
        if ($draw instanceof Draw) {
            return $draw;
        }
dd($row['nombre_de_gagnant_au_rang7']);
        $draw = new Draw();
        $draw
            ->setNbDraw($row['annee_numero_de_tirage'])
            ->setDay($row['jour_de_tirage'])
            ->setDate(new \DateTime($row['date_de_tirage']))
            ->setBall1((int) $row['boule_1'])
            ->setBall2((int) $row['boule_2'])
            ->setBall3((int) $row['boule_3'])
            ->setBall4((int) $row['boule_4'])
            ->setBall5((int) $row['boule_5'])
            ->setLuckyBall((int) $row['numero_chance'])
            ->setWinComboAsc($row['combinaison_gagnante_en_ordre_croissant'])
            ->setNbWinRank1((int) $row['nombre_de_gagnant_au_rang1'])
            ->setAmountRank1((float) $row['rapport_du_rang1'])
            ->setNbWinRank2((int) $row['nombre_de_gagnant_au_rang2'])
            ->setAmountRank2((float) $row['rapport_du_rang2'])
            ->setNbWinRank3((int) $row['nombre_de_gagnant_au_rang3'])
            ->setAmountRank3((float) $row['rapport_du_rang3'])
            ->setNbWinRank4((int) $row['nombre_de_gagnant_au_rang4'])
            ->setAmountRank4((float) $row['rapport_du_rang4'])
            ->setNbWinRank5((int) $row['nombre_de_gagnant_au_rang5'])
            ->setAmountRank5((float) $row['rapport_du_rang5'])
            ->setNbWinRank6((int) $row['nombre_de_gagnant_au_rang6'])
            ->setAmountRank6((float) $row['rapport_du_rang6'])
            ->setNbWinRank7((int) $row['nombre_de_gagnant_au_rang7'])
            ->setAmountRank7((float) $row['rapport_du_rang7'])
            ->setNbWinRank8((int) $row['nombre_de_gagnant_au_rang8'])
            ->setAmountRank8((float) $row['rapport_du_rang8'])
            ->setNbWinRank9((int) $row['nombre_de_gagnant_au_rang9'])
            ->setAmountRank9((float) $row['rapport_du_rang9'])
            ;

        $this->drawRepository->save($draw, $flush);

        return $draw;
    }
}
