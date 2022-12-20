<?php

namespace App\Entity;

use App\Repository\DrawRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: DrawRepository::class)]
#[UniqueEntity('nbDraw')]
class Draw
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $nbDraw = null;

    #[ORM\Column(length: 255)]
    private ?string $day = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column]
    private ?int $ball1 = null;

    #[ORM\Column]
    private ?int $ball2 = null;

    #[ORM\Column]
    private ?int $ball3 = null;

    #[ORM\Column]
    private ?int $ball4 = null;

    #[ORM\Column]
    private ?int $ball5 = null;

    #[ORM\Column]
    private ?int $luckyBall = null;

    #[ORM\Column(length: 255)]
    private ?string $winComboAsc = null;

    #[ORM\Column]
    private ?int $nbWinRank1 = null;

    #[ORM\Column]
    private ?float $amountRank1 = null;

    #[ORM\Column]
    private ?int $nbWinRank2 = null;

    #[ORM\Column]
    private ?float $amountRank2 = null;

    #[ORM\Column]
    private ?int $nbWinRank3 = null;

    #[ORM\Column]
    private ?float $amountRank3 = null;

    #[ORM\Column]
    private ?int $nbWinRank4 = null;

    #[ORM\Column]
    private ?float $amountRank4 = null;

    #[ORM\Column]
    private ?int $nbWinRank5 = null;

    #[ORM\Column]
    private ?float $amountRank5 = null;

    #[ORM\Column]
    private ?int $nbWinRank6 = null;

    #[ORM\Column]
    private ?float $amountRank6 = null;

    #[ORM\Column]
    private ?int $nbWinRank7 = null;

    #[ORM\Column]
    private ?float $amountRank7 = null;

    #[ORM\Column]
    private ?int $nbWinRank8 = null;

    #[ORM\Column]
    private ?float $amountRank8 = null;

    #[ORM\Column]
    private ?int $nbWinRank9 = null;

    #[ORM\Column]
    private ?float $amountRank9 = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbDraw(): ?int
    {
        return $this->nbDraw;
    }

    public function setNbDraw(int $nbDraw): self
    {
        $this->nbDraw = $nbDraw;

        return $this;
    }

    public function getDay(): ?string
    {
        return $this->day;
    }

    public function setDay(string $day): self
    {
        $this->day = $day;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getBall1(): ?int
    {
        return $this->ball1;
    }

    public function setBall1(int $ball1): self
    {
        $this->ball1 = $ball1;

        return $this;
    }

    public function getBall2(): ?int
    {
        return $this->ball2;
    }

    public function setBall2(int $ball2): self
    {
        $this->ball2 = $ball2;

        return $this;
    }

    public function getBall3(): ?int
    {
        return $this->ball3;
    }

    public function setBall3(int $ball3): self
    {
        $this->ball3 = $ball3;

        return $this;
    }

    public function getBall4(): ?int
    {
        return $this->ball4;
    }

    public function setBall4(int $ball4): self
    {
        $this->ball4 = $ball4;

        return $this;
    }

    public function getBall5(): ?int
    {
        return $this->ball5;
    }

    public function setBall5(int $ball5): self
    {
        $this->ball5 = $ball5;

        return $this;
    }

    public function getLuckyBall(): ?int
    {
        return $this->luckyBall;
    }

    public function setLuckyBall(int $luckyBall): self
    {
        $this->luckyBall = $luckyBall;

        return $this;
    }

    public function getWinComboAsc(): ?string
    {
        return $this->winComboAsc;
    }

    public function setWinComboAsc(string $winComboAsc): self
    {
        $this->winComboAsc = $winComboAsc;

        return $this;
    }

    public function getNbWinRank1(): ?int
    {
        return $this->nbWinRank1;
    }

    public function setNbWinRank1(int $nbWinRank1): self
    {
        $this->nbWinRank1 = $nbWinRank1;

        return $this;
    }

    public function getAmountRank1(): ?float
    {
        return $this->amountRank1;
    }

    public function setAmountRank1(float $amountRank1): self
    {
        $this->amountRank1 = $amountRank1;

        return $this;
    }

    public function getNbWinRank2(): ?int
    {
        return $this->nbWinRank2;
    }

    public function setNbWinRank2(int $nbWinRank2): self
    {
        $this->nbWinRank2 = $nbWinRank2;

        return $this;
    }

    public function getAmountRank2(): ?float
    {
        return $this->amountRank2;
    }

    public function setAmountRank2(float $amountRank2): self
    {
        $this->amountRank2 = $amountRank2;

        return $this;
    }

    public function getNbWinRank3(): ?int
    {
        return $this->nbWinRank3;
    }

    public function setNbWinRank3(int $nbWinRank3): self
    {
        $this->nbWinRank3 = $nbWinRank3;

        return $this;
    }

    public function getAmountRank3(): ?float
    {
        return $this->amountRank3;
    }

    public function setAmountRank3(float $amountRank3): self
    {
        $this->amountRank3 = $amountRank3;

        return $this;
    }

    public function getNbWinRank4(): ?int
    {
        return $this->nbWinRank4;
    }

    public function setNbWinRank4(int $nbWinRank4): self
    {
        $this->nbWinRank4 = $nbWinRank4;

        return $this;
    }

    public function getAmountRank4(): ?float
    {
        return $this->amountRank4;
    }

    public function setAmountRank4(float $amountRank4): self
    {
        $this->amountRank4 = $amountRank4;

        return $this;
    }

    public function getNbWinRank5(): ?int
    {
        return $this->nbWinRank5;
    }

    public function setNbWinRank5(int $nbWinRank5): self
    {
        $this->nbWinRank5 = $nbWinRank5;

        return $this;
    }

    public function getAmountRank5(): ?float
    {
        return $this->amountRank5;
    }

    public function setAmountRank5(float $amountRank5): self
    {
        $this->amountRank5 = $amountRank5;

        return $this;
    }

    public function getNbWinRank6(): ?int
    {
        return $this->nbWinRank6;
    }

    public function setNbWinRank6(int $nbWinRank6): self
    {
        $this->nbWinRank6 = $nbWinRank6;

        return $this;
    }

    public function getAmountRank6(): ?float
    {
        return $this->amountRank6;
    }

    public function setAmountRank6(float $amountRank6): self
    {
        $this->amountRank6 = $amountRank6;

        return $this;
    }

    public function getNbWinRank7(): ?int
    {
        return $this->nbWinRank7;
    }

    public function setNbWinRank7(int $nbWinRank7): self
    {
        $this->nbWinRank7 = $nbWinRank7;

        return $this;
    }

    public function getAmountRank7(): ?float
    {
        return $this->amountRank7;
    }

    public function setAmountRank7(float $amountRank7): self
    {
        $this->amountRank7 = $amountRank7;

        return $this;
    }

    public function getNbWinRank8(): ?int
    {
        return $this->nbWinRank8;
    }

    public function setNbWinRank8(int $nbWinRank8): self
    {
        $this->nbWinRank8 = $nbWinRank8;

        return $this;
    }

    public function getAmountRank8(): ?float
    {
        return $this->amountRank8;
    }

    public function setAmountRank8(float $amountRank8): self
    {
        $this->amountRank8 = $amountRank8;

        return $this;
    }

    public function getNbWinRank9(): ?int
    {
        return $this->nbWinRank9;
    }

    public function setNbWinRank9(int $nbWinRank9): self
    {
        $this->nbWinRank9 = $nbWinRank9;

        return $this;
    }

    public function getAmountRank9(): ?float
    {
        return $this->amountRank9;
    }

    public function setAmountRank9(float $amountRank9): self
    {
        $this->amountRank9 = $amountRank9;

        return $this;
    }
}
