<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210124101744 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game_character ADD equipped_weapon_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE game_character ADD CONSTRAINT FK_41DC71362D828532 FOREIGN KEY (equipped_weapon_id) REFERENCES inventory_weapon (id)');
        $this->addSql('CREATE INDEX IDX_41DC71362D828532 ON game_character (equipped_weapon_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game_character DROP FOREIGN KEY FK_41DC71362D828532');
        $this->addSql('DROP INDEX IDX_41DC71362D828532 ON game_character');
        $this->addSql('ALTER TABLE game_character DROP equipped_weapon_id');
    }
}
