<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221220230104 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE draw (id INT AUTO_INCREMENT NOT NULL, nb_draw INT NOT NULL, day VARCHAR(255) NOT NULL, date DATE NOT NULL, ball1 INT NOT NULL, ball2 INT NOT NULL, ball3 INT NOT NULL, ball4 INT NOT NULL, ball5 INT NOT NULL, lucky_ball INT NOT NULL, win_combo_asc VARCHAR(255) NOT NULL, nb_win_rank1 INT NOT NULL, amount_rank1 DOUBLE PRECISION NOT NULL, nb_win_rank2 INT NOT NULL, amount_rank2 DOUBLE PRECISION NOT NULL, nb_win_rank3 INT NOT NULL, amount_rank3 DOUBLE PRECISION NOT NULL, nb_win_rank4 INT NOT NULL, amount_rank4 DOUBLE PRECISION NOT NULL, nb_win_rank5 INT NOT NULL, amount_rank5 DOUBLE PRECISION NOT NULL, nb_win_rank6 INT NOT NULL, amount_rank6 DOUBLE PRECISION NOT NULL, nb_win_rank7 INT NOT NULL, amount_rank7 DOUBLE PRECISION NOT NULL, nb_win_rank8 INT NOT NULL, amount_rank8 DOUBLE PRECISION NOT NULL, nb_win_rank9 INT NOT NULL, amount_rank9 DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE draw');
    }
}
