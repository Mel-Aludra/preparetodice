<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201029184718 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE skill_damage_effect (id INT AUTO_INCREMENT NOT NULL, skill_id INT NOT NULL, damage_nature_id INT NOT NULL, resource_id INT NOT NULL, calculation_type VARCHAR(255) NOT NULL, value INT NOT NULL, ignore_defense TINYINT(1) NOT NULL, INDEX IDX_4B06845D5585C142 (skill_id), INDEX IDX_4B06845DFAD8B02A (damage_nature_id), INDEX IDX_4B06845D89329D25 (resource_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skill_heal_effect (id INT AUTO_INCREMENT NOT NULL, skill_id INT NOT NULL, resource_id INT NOT NULL, calculation_type VARCHAR(255) NOT NULL, value INT NOT NULL, INDEX IDX_162319755585C142 (skill_id), INDEX IDX_1623197589329D25 (resource_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE skill_damage_effect ADD CONSTRAINT FK_4B06845D5585C142 FOREIGN KEY (skill_id) REFERENCES skill (id)');
        $this->addSql('ALTER TABLE skill_damage_effect ADD CONSTRAINT FK_4B06845DFAD8B02A FOREIGN KEY (damage_nature_id) REFERENCES damage_nature (id)');
        $this->addSql('ALTER TABLE skill_damage_effect ADD CONSTRAINT FK_4B06845D89329D25 FOREIGN KEY (resource_id) REFERENCES resource (id)');
        $this->addSql('ALTER TABLE skill_heal_effect ADD CONSTRAINT FK_162319755585C142 FOREIGN KEY (skill_id) REFERENCES skill (id)');
        $this->addSql('ALTER TABLE skill_heal_effect ADD CONSTRAINT FK_1623197589329D25 FOREIGN KEY (resource_id) REFERENCES resource (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE skill_damage_effect');
        $this->addSql('DROP TABLE skill_heal_effect');
    }
}
