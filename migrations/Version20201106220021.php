<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201106220021 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE consumable (id INT AUTO_INCREMENT NOT NULL, game_id INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_4475F095E48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE consumable ADD CONSTRAINT FK_4475F095E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE skill_damage_effect ADD consumable_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE skill_damage_effect ADD CONSTRAINT FK_4B06845DA94ADB61 FOREIGN KEY (consumable_id) REFERENCES consumable (id)');
        $this->addSql('CREATE INDEX IDX_4B06845DA94ADB61 ON skill_damage_effect (consumable_id)');
        $this->addSql('ALTER TABLE skill_heal_effect ADD consumable_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE skill_heal_effect ADD CONSTRAINT FK_16231975A94ADB61 FOREIGN KEY (consumable_id) REFERENCES consumable (id)');
        $this->addSql('CREATE INDEX IDX_16231975A94ADB61 ON skill_heal_effect (consumable_id)');
        $this->addSql('ALTER TABLE skill_status_effect ADD consumable_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE skill_status_effect ADD CONSTRAINT FK_E5B63403A94ADB61 FOREIGN KEY (consumable_id) REFERENCES consumable (id)');
        $this->addSql('CREATE INDEX IDX_E5B63403A94ADB61 ON skill_status_effect (consumable_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE skill_damage_effect DROP FOREIGN KEY FK_4B06845DA94ADB61');
        $this->addSql('ALTER TABLE skill_heal_effect DROP FOREIGN KEY FK_16231975A94ADB61');
        $this->addSql('ALTER TABLE skill_status_effect DROP FOREIGN KEY FK_E5B63403A94ADB61');
        $this->addSql('DROP TABLE consumable');
        $this->addSql('DROP INDEX IDX_4B06845DA94ADB61 ON skill_damage_effect');
        $this->addSql('ALTER TABLE skill_damage_effect DROP consumable_id');
        $this->addSql('DROP INDEX IDX_16231975A94ADB61 ON skill_heal_effect');
        $this->addSql('ALTER TABLE skill_heal_effect DROP consumable_id');
        $this->addSql('DROP INDEX IDX_E5B63403A94ADB61 ON skill_status_effect');
        $this->addSql('ALTER TABLE skill_status_effect DROP consumable_id');
    }
}
