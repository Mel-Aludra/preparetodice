<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210131170858 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE game_character_lore_block');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE game_character_lore_block (game_character_id INT NOT NULL, lore_block_id INT NOT NULL, INDEX IDX_898A0290715F219A (lore_block_id), INDEX IDX_898A0290FFE68A1B (game_character_id), PRIMARY KEY(game_character_id, lore_block_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE game_character_lore_block ADD CONSTRAINT FK_898A0290715F219A FOREIGN KEY (lore_block_id) REFERENCES lore_block (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_character_lore_block ADD CONSTRAINT FK_898A0290FFE68A1B FOREIGN KEY (game_character_id) REFERENCES game_character (id) ON DELETE CASCADE');
    }
}
