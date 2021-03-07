<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201028151450 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attribute ADD color_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE attribute ADD CONSTRAINT FK_FA7AEFFB7ADA1FB5 FOREIGN KEY (color_id) REFERENCES color (id)');
        $this->addSql('CREATE INDEX IDX_FA7AEFFB7ADA1FB5 ON attribute (color_id)');
        $this->addSql('ALTER TABLE resource ADD color_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE resource ADD CONSTRAINT FK_BC91F4167ADA1FB5 FOREIGN KEY (color_id) REFERENCES color (id)');
        $this->addSql('CREATE INDEX IDX_BC91F4167ADA1FB5 ON resource (color_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attribute DROP FOREIGN KEY FK_FA7AEFFB7ADA1FB5');
        $this->addSql('DROP INDEX IDX_FA7AEFFB7ADA1FB5 ON attribute');
        $this->addSql('ALTER TABLE attribute DROP color_id');
        $this->addSql('ALTER TABLE resource DROP FOREIGN KEY FK_BC91F4167ADA1FB5');
        $this->addSql('DROP INDEX IDX_BC91F4167ADA1FB5 ON resource');
        $this->addSql('ALTER TABLE resource DROP color_id');
    }
}
