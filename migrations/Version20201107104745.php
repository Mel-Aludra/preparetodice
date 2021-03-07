<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201107104745 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE character_skill (id INT AUTO_INCREMENT NOT NULL, game_character_id INT NOT NULL, skill_id INT NOT NULL, current_cooldown INT DEFAULT NULL, INDEX IDX_A0FE0315FFE68A1B (game_character_id), INDEX IDX_A0FE03155585C142 (skill_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE character_skill ADD CONSTRAINT FK_A0FE0315FFE68A1B FOREIGN KEY (game_character_id) REFERENCES game_character (id)');
        $this->addSql('ALTER TABLE character_skill ADD CONSTRAINT FK_A0FE03155585C142 FOREIGN KEY (skill_id) REFERENCES skill (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE character_skill');
    }
}
