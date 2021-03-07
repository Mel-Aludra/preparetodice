<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201109073348 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE battle_log (id INT AUTO_INCREMENT NOT NULL, battle_id INT DEFAULT NULL, action_id INT DEFAULT NULL, launcher_id INT DEFAULT NULL, target_id INT DEFAULT NULL, targeted_resource_id INT DEFAULT NULL, type VARCHAR(255) NOT NULL, turn INT NOT NULL, name VARCHAR(255) NOT NULL, launcher_team VARCHAR(255) NOT NULL, target_team VARCHAR(255) NOT NULL, initial_value INT DEFAULT NULL, additional_potency_value INT DEFAULT NULL, roll_potency_result INT DEFAULT NULL, roll_action_result INT DEFAULT NULL, defense_value INT DEFAULT NULL, rationalize_value INT DEFAULT NULL, final_value INT DEFAULT NULL, INDEX IDX_8049DBB1C9732719 (battle_id), INDEX IDX_8049DBB19D32F035 (action_id), INDEX IDX_8049DBB12724B909 (launcher_id), INDEX IDX_8049DBB1158E0B66 (target_id), INDEX IDX_8049DBB1809B260 (targeted_resource_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE battle_log ADD CONSTRAINT FK_8049DBB1C9732719 FOREIGN KEY (battle_id) REFERENCES battle (id)');
        $this->addSql('ALTER TABLE battle_log ADD CONSTRAINT FK_8049DBB19D32F035 FOREIGN KEY (action_id) REFERENCES action (id)');
        $this->addSql('ALTER TABLE battle_log ADD CONSTRAINT FK_8049DBB12724B909 FOREIGN KEY (launcher_id) REFERENCES game_character (id)');
        $this->addSql('ALTER TABLE battle_log ADD CONSTRAINT FK_8049DBB1158E0B66 FOREIGN KEY (target_id) REFERENCES game_character (id)');
        $this->addSql('ALTER TABLE battle_log ADD CONSTRAINT FK_8049DBB1809B260 FOREIGN KEY (targeted_resource_id) REFERENCES resource (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE battle_log');
    }
}
