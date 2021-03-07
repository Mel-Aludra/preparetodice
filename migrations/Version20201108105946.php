<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201108105946 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE action (id INT AUTO_INCREMENT NOT NULL, battle_id INT NOT NULL, launcher_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, team VARCHAR(255) NOT NULL, turn INT NOT NULL, INDEX IDX_47CC8C92C9732719 (battle_id), INDEX IDX_47CC8C922724B909 (launcher_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE target (id INT AUTO_INCREMENT NOT NULL, game_character_id INT NOT NULL, action_id INT NOT NULL, team VARCHAR(255) NOT NULL, INDEX IDX_466F2FFCFFE68A1B (game_character_id), INDEX IDX_466F2FFC9D32F035 (action_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE action ADD CONSTRAINT FK_47CC8C92C9732719 FOREIGN KEY (battle_id) REFERENCES battle (id)');
        $this->addSql('ALTER TABLE action ADD CONSTRAINT FK_47CC8C922724B909 FOREIGN KEY (launcher_id) REFERENCES game_character (id)');
        $this->addSql('ALTER TABLE target ADD CONSTRAINT FK_466F2FFCFFE68A1B FOREIGN KEY (game_character_id) REFERENCES game_character (id)');
        $this->addSql('ALTER TABLE target ADD CONSTRAINT FK_466F2FFC9D32F035 FOREIGN KEY (action_id) REFERENCES action (id)');
        $this->addSql('ALTER TABLE skill_cost ADD action_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE skill_cost ADD CONSTRAINT FK_5F67084E9D32F035 FOREIGN KEY (action_id) REFERENCES action (id)');
        $this->addSql('CREATE INDEX IDX_5F67084E9D32F035 ON skill_cost (action_id)');
        $this->addSql('ALTER TABLE skill_damage_effect ADD action_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE skill_damage_effect ADD CONSTRAINT FK_4B06845D9D32F035 FOREIGN KEY (action_id) REFERENCES action (id)');
        $this->addSql('CREATE INDEX IDX_4B06845D9D32F035 ON skill_damage_effect (action_id)');
        $this->addSql('ALTER TABLE skill_gain ADD action_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE skill_gain ADD CONSTRAINT FK_97D4B1B29D32F035 FOREIGN KEY (action_id) REFERENCES action (id)');
        $this->addSql('CREATE INDEX IDX_97D4B1B29D32F035 ON skill_gain (action_id)');
        $this->addSql('ALTER TABLE skill_heal_effect ADD action_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE skill_heal_effect ADD CONSTRAINT FK_162319759D32F035 FOREIGN KEY (action_id) REFERENCES action (id)');
        $this->addSql('CREATE INDEX IDX_162319759D32F035 ON skill_heal_effect (action_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE skill_cost DROP FOREIGN KEY FK_5F67084E9D32F035');
        $this->addSql('ALTER TABLE skill_damage_effect DROP FOREIGN KEY FK_4B06845D9D32F035');
        $this->addSql('ALTER TABLE skill_gain DROP FOREIGN KEY FK_97D4B1B29D32F035');
        $this->addSql('ALTER TABLE skill_heal_effect DROP FOREIGN KEY FK_162319759D32F035');
        $this->addSql('ALTER TABLE target DROP FOREIGN KEY FK_466F2FFC9D32F035');
        $this->addSql('DROP TABLE action');
        $this->addSql('DROP TABLE target');
        $this->addSql('DROP INDEX IDX_5F67084E9D32F035 ON skill_cost');
        $this->addSql('ALTER TABLE skill_cost DROP action_id');
        $this->addSql('DROP INDEX IDX_4B06845D9D32F035 ON skill_damage_effect');
        $this->addSql('ALTER TABLE skill_damage_effect DROP action_id');
        $this->addSql('DROP INDEX IDX_97D4B1B29D32F035 ON skill_gain');
        $this->addSql('ALTER TABLE skill_gain DROP action_id');
        $this->addSql('DROP INDEX IDX_162319759D32F035 ON skill_heal_effect');
        $this->addSql('ALTER TABLE skill_heal_effect DROP action_id');
    }
}
