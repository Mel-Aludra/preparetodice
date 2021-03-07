<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210124102321 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE equipped_gear (id INT AUTO_INCREMENT NOT NULL, game_character_id INT NOT NULL, equipment_slot_id INT NOT NULL, inventory_gear_id INT NOT NULL, INDEX IDX_879B9B89FFE68A1B (game_character_id), INDEX IDX_879B9B892F9EDE73 (equipment_slot_id), INDEX IDX_879B9B893624BFC8 (inventory_gear_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE equipped_gear ADD CONSTRAINT FK_879B9B89FFE68A1B FOREIGN KEY (game_character_id) REFERENCES game_character (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE equipped_gear ADD CONSTRAINT FK_879B9B892F9EDE73 FOREIGN KEY (equipment_slot_id) REFERENCES equipment_slot (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE equipped_gear ADD CONSTRAINT FK_879B9B893624BFC8 FOREIGN KEY (inventory_gear_id) REFERENCES inventory_gear (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE equipped_gear');
    }
}
