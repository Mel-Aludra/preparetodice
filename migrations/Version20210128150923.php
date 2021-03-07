<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210128150923 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lore_block ADD tag_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE lore_block ADD CONSTRAINT FK_2491ED4FBAD26311 FOREIGN KEY (tag_id) REFERENCES lore_tag (id)');
        $this->addSql('CREATE INDEX IDX_2491ED4FBAD26311 ON lore_block (tag_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lore_block DROP FOREIGN KEY FK_2491ED4FBAD26311');
        $this->addSql('DROP INDEX IDX_2491ED4FBAD26311 ON lore_block');
        $this->addSql('ALTER TABLE lore_block DROP tag_id');
    }
}
