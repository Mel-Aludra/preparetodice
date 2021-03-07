<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201207074932 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE character_status_effect (id INT AUTO_INCREMENT NOT NULL, game_character_id INT NOT NULL, status_effect_id INT NOT NULL, remaining_turns INT DEFAULT NULL, wipe_if_reset TINYINT(1) NOT NULL, INDEX IDX_3F9B84C6FFE68A1B (game_character_id), INDEX IDX_3F9B84C67D7C387A (status_effect_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE character_status_effect ADD CONSTRAINT FK_3F9B84C6FFE68A1B FOREIGN KEY (game_character_id) REFERENCES game_character (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE character_status_effect ADD CONSTRAINT FK_3F9B84C67D7C387A FOREIGN KEY (status_effect_id) REFERENCES status_effect (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE character_status_effect');
    }
}
