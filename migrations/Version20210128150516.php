<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210128150516 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE lore_block_lore_tag');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE lore_block_lore_tag (lore_block_id INT NOT NULL, lore_tag_id INT NOT NULL, INDEX IDX_5BAF0AD8976F48E (lore_tag_id), INDEX IDX_5BAF0AD715F219A (lore_block_id), PRIMARY KEY(lore_block_id, lore_tag_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE lore_block_lore_tag ADD CONSTRAINT FK_5BAF0AD715F219A FOREIGN KEY (lore_block_id) REFERENCES lore_block (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lore_block_lore_tag ADD CONSTRAINT FK_5BAF0AD8976F48E FOREIGN KEY (lore_tag_id) REFERENCES lore_tag (id) ON DELETE CASCADE');
    }
}
