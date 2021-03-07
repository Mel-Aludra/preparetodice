<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201110114620 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE target ADD skill_status_effect_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE target ADD CONSTRAINT FK_466F2FFCFD2F9EC2 FOREIGN KEY (skill_status_effect_id) REFERENCES skill_status_effect (id)');
        $this->addSql('CREATE INDEX IDX_466F2FFCFD2F9EC2 ON target (skill_status_effect_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE target DROP FOREIGN KEY FK_466F2FFCFD2F9EC2');
        $this->addSql('DROP INDEX IDX_466F2FFCFD2F9EC2 ON target');
        $this->addSql('ALTER TABLE target DROP skill_status_effect_id');
    }
}
