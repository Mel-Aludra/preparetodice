<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201107112052 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE character_passive (id INT AUTO_INCREMENT NOT NULL, game_character_id INT NOT NULL, passive_id INT NOT NULL, INDEX IDX_1F4A7DF2FFE68A1B (game_character_id), INDEX IDX_1F4A7DF26D157422 (passive_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE character_passive ADD CONSTRAINT FK_1F4A7DF2FFE68A1B FOREIGN KEY (game_character_id) REFERENCES game_character (id)');
        $this->addSql('ALTER TABLE character_passive ADD CONSTRAINT FK_1F4A7DF26D157422 FOREIGN KEY (passive_id) REFERENCES passive (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE character_passive');
    }
}
