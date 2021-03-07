<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201106075233 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE attribute_alteration (id INT AUTO_INCREMENT NOT NULL, status_effect_id INT DEFAULT NULL, attribute_id INT NOT NULL, is_negative TINYINT(1) NOT NULL, calculation_type VARCHAR(255) NOT NULL, value INT NOT NULL, INDEX IDX_9B8680A17D7C387A (status_effect_id), INDEX IDX_9B8680A1B6E62EFA (attribute_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE damage_over_time (id INT AUTO_INCREMENT NOT NULL, status_effect_id INT DEFAULT NULL, damage_nature_id INT NOT NULL, resource_id INT NOT NULL, calculation_type VARCHAR(255) NOT NULL, value INT NOT NULL, ignore_defense TINYINT(1) NOT NULL, INDEX IDX_A5088C667D7C387A (status_effect_id), INDEX IDX_A5088C66FAD8B02A (damage_nature_id), INDEX IDX_A5088C6689329D25 (resource_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE heal_over_time (id INT AUTO_INCREMENT NOT NULL, status_effect_id INT DEFAULT NULL, resource_id INT NOT NULL, calculation_type VARCHAR(255) NOT NULL, value INT NOT NULL, INDEX IDX_5ED77E617D7C387A (status_effect_id), INDEX IDX_5ED77E6189329D25 (resource_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE resource_alteration (id INT AUTO_INCREMENT NOT NULL, status_effect_id INT DEFAULT NULL, resource_id INT NOT NULL, is_negative TINYINT(1) NOT NULL, calculation_type VARCHAR(255) NOT NULL, value INT NOT NULL, INDEX IDX_FFF8C0427D7C387A (status_effect_id), INDEX IDX_FFF8C04289329D25 (resource_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE status_effect (id INT AUTO_INCREMENT NOT NULL, game_id INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_B2A39BFE48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE attribute_alteration ADD CONSTRAINT FK_9B8680A17D7C387A FOREIGN KEY (status_effect_id) REFERENCES status_effect (id)');
        $this->addSql('ALTER TABLE attribute_alteration ADD CONSTRAINT FK_9B8680A1B6E62EFA FOREIGN KEY (attribute_id) REFERENCES attribute (id)');
        $this->addSql('ALTER TABLE damage_over_time ADD CONSTRAINT FK_A5088C667D7C387A FOREIGN KEY (status_effect_id) REFERENCES status_effect (id)');
        $this->addSql('ALTER TABLE damage_over_time ADD CONSTRAINT FK_A5088C66FAD8B02A FOREIGN KEY (damage_nature_id) REFERENCES damage_nature (id)');
        $this->addSql('ALTER TABLE damage_over_time ADD CONSTRAINT FK_A5088C6689329D25 FOREIGN KEY (resource_id) REFERENCES resource (id)');
        $this->addSql('ALTER TABLE heal_over_time ADD CONSTRAINT FK_5ED77E617D7C387A FOREIGN KEY (status_effect_id) REFERENCES status_effect (id)');
        $this->addSql('ALTER TABLE heal_over_time ADD CONSTRAINT FK_5ED77E6189329D25 FOREIGN KEY (resource_id) REFERENCES resource (id)');
        $this->addSql('ALTER TABLE resource_alteration ADD CONSTRAINT FK_FFF8C0427D7C387A FOREIGN KEY (status_effect_id) REFERENCES status_effect (id)');
        $this->addSql('ALTER TABLE resource_alteration ADD CONSTRAINT FK_FFF8C04289329D25 FOREIGN KEY (resource_id) REFERENCES resource (id)');
        $this->addSql('ALTER TABLE status_effect ADD CONSTRAINT FK_B2A39BFE48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attribute_alteration DROP FOREIGN KEY FK_9B8680A17D7C387A');
        $this->addSql('ALTER TABLE damage_over_time DROP FOREIGN KEY FK_A5088C667D7C387A');
        $this->addSql('ALTER TABLE heal_over_time DROP FOREIGN KEY FK_5ED77E617D7C387A');
        $this->addSql('ALTER TABLE resource_alteration DROP FOREIGN KEY FK_FFF8C0427D7C387A');
        $this->addSql('DROP TABLE attribute_alteration');
        $this->addSql('DROP TABLE damage_over_time');
        $this->addSql('DROP TABLE heal_over_time');
        $this->addSql('DROP TABLE resource_alteration');
        $this->addSql('DROP TABLE status_effect');
    }
}
