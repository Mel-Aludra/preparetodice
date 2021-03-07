<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201107203228 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE character_attribute DROP FOREIGN KEY FK_7D2A4DC0B6E62EFA');
        $this->addSql('ALTER TABLE character_attribute ADD CONSTRAINT FK_7D2A4DC0B6E62EFA FOREIGN KEY (attribute_id) REFERENCES attribute (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE character_attribute DROP FOREIGN KEY FK_7D2A4DC0B6E62EFA');
        $this->addSql('ALTER TABLE character_attribute ADD CONSTRAINT FK_7D2A4DC0B6E62EFA FOREIGN KEY (attribute_id) REFERENCES attribute (id)');
    }
}
