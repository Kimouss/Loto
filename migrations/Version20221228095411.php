<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221228095411 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE draw (id INT AUTO_INCREMENT NOT NULL, nb_draw VARCHAR(255) DEFAULT NULL, day VARCHAR(255) DEFAULT NULL, date DATE DEFAULT NULL, ball1 INT DEFAULT NULL, ball2 INT DEFAULT NULL, ball3 INT DEFAULT NULL, ball4 INT DEFAULT NULL, ball5 INT DEFAULT NULL, lucky_ball INT DEFAULT NULL, win_combo_asc VARCHAR(255) DEFAULT NULL, nb_win_rank1 INT DEFAULT NULL, amount_rank1 DOUBLE PRECISION DEFAULT NULL, nb_win_rank2 INT DEFAULT NULL, amount_rank2 DOUBLE PRECISION DEFAULT NULL, nb_win_rank3 INT DEFAULT NULL, amount_rank3 DOUBLE PRECISION DEFAULT NULL, nb_win_rank4 INT DEFAULT NULL, amount_rank4 DOUBLE PRECISION DEFAULT NULL, nb_win_rank5 INT DEFAULT NULL, amount_rank5 DOUBLE PRECISION DEFAULT NULL, nb_win_rank6 INT DEFAULT NULL, amount_rank6 DOUBLE PRECISION DEFAULT NULL, nb_win_rank7 INT DEFAULT NULL, amount_rank7 DOUBLE PRECISION DEFAULT NULL, nb_win_rank8 INT DEFAULT NULL, amount_rank8 DOUBLE PRECISION DEFAULT NULL, nb_win_rank9 INT DEFAULT NULL, amount_rank9 DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE draw');
    }
}
