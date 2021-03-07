<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201108122817 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE target (id INT AUTO_INCREMENT NOT NULL, game_character_id INT NOT NULL, skill_heal_effect_id INT DEFAULT NULL, skill_damage_effect_id INT DEFAULT NULL, INDEX IDX_466F2FFCFFE68A1B (game_character_id), INDEX IDX_466F2FFCD1CB7F7 (skill_heal_effect_id), INDEX IDX_466F2FFCB4A980E2 (skill_damage_effect_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE target ADD CONSTRAINT FK_466F2FFCFFE68A1B FOREIGN KEY (game_character_id) REFERENCES game_character (id)');
        $this->addSql('ALTER TABLE target ADD CONSTRAINT FK_466F2FFCD1CB7F7 FOREIGN KEY (skill_heal_effect_id) REFERENCES skill_heal_effect (id)');
        $this->addSql('ALTER TABLE target ADD CONSTRAINT FK_466F2FFCB4A980E2 FOREIGN KEY (skill_damage_effect_id) REFERENCES skill_damage_effect (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE target');
    }
}
