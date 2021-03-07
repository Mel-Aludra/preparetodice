<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201106211638 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE gear (id INT AUTO_INCREMENT NOT NULL, game_id INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_B44539BE48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE gear ADD CONSTRAINT FK_B44539BE48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE attribute_alteration ADD gear_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE attribute_alteration ADD CONSTRAINT FK_9B8680A177201934 FOREIGN KEY (gear_id) REFERENCES gear (id)');
        $this->addSql('CREATE INDEX IDX_9B8680A177201934 ON attribute_alteration (gear_id)');
        $this->addSql('ALTER TABLE damage_over_time ADD gear_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE damage_over_time ADD CONSTRAINT FK_A5088C6677201934 FOREIGN KEY (gear_id) REFERENCES gear (id)');
        $this->addSql('CREATE INDEX IDX_A5088C6677201934 ON damage_over_time (gear_id)');
        $this->addSql('ALTER TABLE heal_over_time ADD gear_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE heal_over_time ADD CONSTRAINT FK_5ED77E6177201934 FOREIGN KEY (gear_id) REFERENCES gear (id)');
        $this->addSql('CREATE INDEX IDX_5ED77E6177201934 ON heal_over_time (gear_id)');
        $this->addSql('ALTER TABLE resource_alteration ADD gear_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE resource_alteration ADD CONSTRAINT FK_FFF8C04277201934 FOREIGN KEY (gear_id) REFERENCES gear (id)');
        $this->addSql('CREATE INDEX IDX_FFF8C04277201934 ON resource_alteration (gear_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attribute_alteration DROP FOREIGN KEY FK_9B8680A177201934');
        $this->addSql('ALTER TABLE damage_over_time DROP FOREIGN KEY FK_A5088C6677201934');
        $this->addSql('ALTER TABLE heal_over_time DROP FOREIGN KEY FK_5ED77E6177201934');
        $this->addSql('ALTER TABLE resource_alteration DROP FOREIGN KEY FK_FFF8C04277201934');
        $this->addSql('DROP TABLE gear');
        $this->addSql('DROP INDEX IDX_9B8680A177201934 ON attribute_alteration');
        $this->addSql('ALTER TABLE attribute_alteration DROP gear_id');
        $this->addSql('DROP INDEX IDX_A5088C6677201934 ON damage_over_time');
        $this->addSql('ALTER TABLE damage_over_time DROP gear_id');
        $this->addSql('DROP INDEX IDX_5ED77E6177201934 ON heal_over_time');
        $this->addSql('ALTER TABLE heal_over_time DROP gear_id');
        $this->addSql('DROP INDEX IDX_FFF8C04277201934 ON resource_alteration');
        $this->addSql('ALTER TABLE resource_alteration DROP gear_id');
    }
}
