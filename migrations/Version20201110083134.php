<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201110083134 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE battle_log ADD status_effect_id INT DEFAULT NULL, ADD status_effect_turns INT DEFAULT NULL');
        $this->addSql('ALTER TABLE battle_log ADD CONSTRAINT FK_8049DBB17D7C387A FOREIGN KEY (status_effect_id) REFERENCES status_effect (id)');
        $this->addSql('CREATE INDEX IDX_8049DBB17D7C387A ON battle_log (status_effect_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE battle_log DROP FOREIGN KEY FK_8049DBB17D7C387A');
        $this->addSql('DROP INDEX IDX_8049DBB17D7C387A ON battle_log');
        $this->addSql('ALTER TABLE battle_log DROP status_effect_id, DROP status_effect_turns');
    }
}
