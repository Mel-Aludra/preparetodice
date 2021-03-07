<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201113075228 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE potency_augmentator (id INT AUTO_INCREMENT NOT NULL, attribute_id INT NOT NULL, type VARCHAR(255) NOT NULL, value INT NOT NULL, percent_ceiling INT DEFAULT NULL, INDEX IDX_5251DBEFB6E62EFA (attribute_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skill_damage_effect_potency_augmentator (skill_damage_effect_id INT NOT NULL, potency_augmentator_id INT NOT NULL, INDEX IDX_D88BE758B4A980E2 (skill_damage_effect_id), INDEX IDX_D88BE758BA5F2F49 (potency_augmentator_id), PRIMARY KEY(skill_damage_effect_id, potency_augmentator_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skill_heal_effect_potency_augmentator (skill_heal_effect_id INT NOT NULL, potency_augmentator_id INT NOT NULL, INDEX IDX_C194C8D1CB7F7 (skill_heal_effect_id), INDEX IDX_C194C8BA5F2F49 (potency_augmentator_id), PRIMARY KEY(skill_heal_effect_id, potency_augmentator_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE potency_augmentator ADD CONSTRAINT FK_5251DBEFB6E62EFA FOREIGN KEY (attribute_id) REFERENCES attribute (id)');
        $this->addSql('ALTER TABLE skill_damage_effect_potency_augmentator ADD CONSTRAINT FK_D88BE758B4A980E2 FOREIGN KEY (skill_damage_effect_id) REFERENCES skill_damage_effect (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE skill_damage_effect_potency_augmentator ADD CONSTRAINT FK_D88BE758BA5F2F49 FOREIGN KEY (potency_augmentator_id) REFERENCES potency_augmentator (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE skill_heal_effect_potency_augmentator ADD CONSTRAINT FK_C194C8D1CB7F7 FOREIGN KEY (skill_heal_effect_id) REFERENCES skill_heal_effect (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE skill_heal_effect_potency_augmentator ADD CONSTRAINT FK_C194C8BA5F2F49 FOREIGN KEY (potency_augmentator_id) REFERENCES potency_augmentator (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE skill_damage_effect_potency_augmentator DROP FOREIGN KEY FK_D88BE758BA5F2F49');
        $this->addSql('ALTER TABLE skill_heal_effect_potency_augmentator DROP FOREIGN KEY FK_C194C8BA5F2F49');
        $this->addSql('DROP TABLE potency_augmentator');
        $this->addSql('DROP TABLE skill_damage_effect_potency_augmentator');
        $this->addSql('DROP TABLE skill_heal_effect_potency_augmentator');
    }
}
