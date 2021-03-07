<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201106204142 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE skill_status_effect ADD weapon_id INT DEFAULT NULL, CHANGE skill_id skill_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE skill_status_effect ADD CONSTRAINT FK_E5B6340395B82273 FOREIGN KEY (weapon_id) REFERENCES weapon (id)');
        $this->addSql('CREATE INDEX IDX_E5B6340395B82273 ON skill_status_effect (weapon_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE skill_status_effect DROP FOREIGN KEY FK_E5B6340395B82273');
        $this->addSql('DROP INDEX IDX_E5B6340395B82273 ON skill_status_effect');
        $this->addSql('ALTER TABLE skill_status_effect DROP weapon_id, CHANGE skill_id skill_id INT NOT NULL');
    }
}
