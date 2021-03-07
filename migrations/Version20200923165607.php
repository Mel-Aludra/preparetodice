<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200923165607 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE lore_block (id INT AUTO_INCREMENT NOT NULL, game_id INT NOT NULL, access_type VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, INDEX IDX_2491ED4FE48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lore_block_lore_tag (lore_block_id INT NOT NULL, lore_tag_id INT NOT NULL, INDEX IDX_5BAF0AD715F219A (lore_block_id), INDEX IDX_5BAF0AD8976F48E (lore_tag_id), PRIMARY KEY(lore_block_id, lore_tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE lore_block ADD CONSTRAINT FK_2491ED4FE48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE lore_block_lore_tag ADD CONSTRAINT FK_5BAF0AD715F219A FOREIGN KEY (lore_block_id) REFERENCES lore_block (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lore_block_lore_tag ADD CONSTRAINT FK_5BAF0AD8976F48E FOREIGN KEY (lore_tag_id) REFERENCES lore_tag (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lore_block_lore_tag DROP FOREIGN KEY FK_5BAF0AD715F219A');
        $this->addSql('DROP TABLE lore_block');
        $this->addSql('DROP TABLE lore_block_lore_tag');
    }
}
