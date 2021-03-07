<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201107114331 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE inventory_consumable (id INT AUTO_INCREMENT NOT NULL, game_character_id INT NOT NULL, consumable_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_79BA516FFE68A1B (game_character_id), INDEX IDX_79BA516A94ADB61 (consumable_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inventory_gear (id INT AUTO_INCREMENT NOT NULL, game_character_id INT NOT NULL, gear_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_41E29CB5FFE68A1B (game_character_id), INDEX IDX_41E29CB577201934 (gear_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inventory_item (id INT AUTO_INCREMENT NOT NULL, game_character_id INT NOT NULL, item_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_55BDEA30FFE68A1B (game_character_id), INDEX IDX_55BDEA30126F525E (item_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inventory_weapon (id INT AUTO_INCREMENT NOT NULL, game_character_id INT NOT NULL, weapon_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_69EF3B4DFFE68A1B (game_character_id), INDEX IDX_69EF3B4D95B82273 (weapon_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE inventory_consumable ADD CONSTRAINT FK_79BA516FFE68A1B FOREIGN KEY (game_character_id) REFERENCES game_character (id)');
        $this->addSql('ALTER TABLE inventory_consumable ADD CONSTRAINT FK_79BA516A94ADB61 FOREIGN KEY (consumable_id) REFERENCES consumable (id)');
        $this->addSql('ALTER TABLE inventory_gear ADD CONSTRAINT FK_41E29CB5FFE68A1B FOREIGN KEY (game_character_id) REFERENCES game_character (id)');
        $this->addSql('ALTER TABLE inventory_gear ADD CONSTRAINT FK_41E29CB577201934 FOREIGN KEY (gear_id) REFERENCES gear (id)');
        $this->addSql('ALTER TABLE inventory_item ADD CONSTRAINT FK_55BDEA30FFE68A1B FOREIGN KEY (game_character_id) REFERENCES game_character (id)');
        $this->addSql('ALTER TABLE inventory_item ADD CONSTRAINT FK_55BDEA30126F525E FOREIGN KEY (item_id) REFERENCES item (id)');
        $this->addSql('ALTER TABLE inventory_weapon ADD CONSTRAINT FK_69EF3B4DFFE68A1B FOREIGN KEY (game_character_id) REFERENCES game_character (id)');
        $this->addSql('ALTER TABLE inventory_weapon ADD CONSTRAINT FK_69EF3B4D95B82273 FOREIGN KEY (weapon_id) REFERENCES weapon (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE inventory_consumable');
        $this->addSql('DROP TABLE inventory_gear');
        $this->addSql('DROP TABLE inventory_item');
        $this->addSql('DROP TABLE inventory_weapon');
    }
}
