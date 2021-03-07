<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201106202834 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE weapon (id INT AUTO_INCREMENT NOT NULL, game_id INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_6933A7E6E48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE weapon ADD CONSTRAINT FK_6933A7E6E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE skill_cost ADD weapon_id INT DEFAULT NULL, CHANGE skill_id skill_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE skill_cost ADD CONSTRAINT FK_5F67084E95B82273 FOREIGN KEY (weapon_id) REFERENCES weapon (id)');
        $this->addSql('CREATE INDEX IDX_5F67084E95B82273 ON skill_cost (weapon_id)');
        $this->addSql('ALTER TABLE skill_damage_effect ADD weapon_id INT DEFAULT NULL, CHANGE skill_id skill_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE skill_damage_effect ADD CONSTRAINT FK_4B06845D95B82273 FOREIGN KEY (weapon_id) REFERENCES weapon (id)');
        $this->addSql('CREATE INDEX IDX_4B06845D95B82273 ON skill_damage_effect (weapon_id)');
        $this->addSql('ALTER TABLE skill_gain ADD weapon_id INT DEFAULT NULL, CHANGE skill_id skill_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE skill_gain ADD CONSTRAINT FK_97D4B1B295B82273 FOREIGN KEY (weapon_id) REFERENCES weapon (id)');
        $this->addSql('CREATE INDEX IDX_97D4B1B295B82273 ON skill_gain (weapon_id)');
        $this->addSql('ALTER TABLE skill_heal_effect ADD weapon_id INT DEFAULT NULL, CHANGE skill_id skill_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE skill_heal_effect ADD CONSTRAINT FK_1623197595B82273 FOREIGN KEY (weapon_id) REFERENCES weapon (id)');
        $this->addSql('CREATE INDEX IDX_1623197595B82273 ON skill_heal_effect (weapon_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE skill_cost DROP FOREIGN KEY FK_5F67084E95B82273');
        $this->addSql('ALTER TABLE skill_damage_effect DROP FOREIGN KEY FK_4B06845D95B82273');
        $this->addSql('ALTER TABLE skill_gain DROP FOREIGN KEY FK_97D4B1B295B82273');
        $this->addSql('ALTER TABLE skill_heal_effect DROP FOREIGN KEY FK_1623197595B82273');
        $this->addSql('DROP TABLE weapon');
        $this->addSql('DROP INDEX IDX_5F67084E95B82273 ON skill_cost');
        $this->addSql('ALTER TABLE skill_cost DROP weapon_id, CHANGE skill_id skill_id INT NOT NULL');
        $this->addSql('DROP INDEX IDX_4B06845D95B82273 ON skill_damage_effect');
        $this->addSql('ALTER TABLE skill_damage_effect DROP weapon_id, CHANGE skill_id skill_id INT NOT NULL');
        $this->addSql('DROP INDEX IDX_97D4B1B295B82273 ON skill_gain');
        $this->addSql('ALTER TABLE skill_gain DROP weapon_id, CHANGE skill_id skill_id INT NOT NULL');
        $this->addSql('DROP INDEX IDX_1623197595B82273 ON skill_heal_effect');
        $this->addSql('ALTER TABLE skill_heal_effect DROP weapon_id, CHANGE skill_id skill_id INT NOT NULL');
    }
}
