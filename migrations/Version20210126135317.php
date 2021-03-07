<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210126135317 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE characteristic_calculation (id INT AUTO_INCREMENT NOT NULL, game_character_id INT NOT NULL, pool_number INT NOT NULL, source VARCHAR(255) NOT NULL, is_negative TINYINT(1) NOT NULL, characteristic VARCHAR(255) NOT NULL, value INT NOT NULL, calculation VARCHAR(255) NOT NULL, INDEX IDX_FCA334E2FFE68A1B (game_character_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE characteristic_calculation ADD CONSTRAINT FK_FCA334E2FFE68A1B FOREIGN KEY (game_character_id) REFERENCES game_character (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE characteristic_calculation');
    }
}
