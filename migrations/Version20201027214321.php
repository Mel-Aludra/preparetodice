<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201027214321 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE character_attribute (id INT AUTO_INCREMENT NOT NULL, game_character_id INT NOT NULL, attribute_id INT NOT NULL, active TINYINT(1) NOT NULL, value INT NOT NULL, final_value INT NOT NULL, INDEX IDX_7D2A4DC0FFE68A1B (game_character_id), INDEX IDX_7D2A4DC0B6E62EFA (attribute_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE character_resource (id INT AUTO_INCREMENT NOT NULL, game_character_id INT NOT NULL, resource_id INT NOT NULL, active TINYINT(1) NOT NULL, value INT NOT NULL, final_value INT NOT NULL, current_value INT NOT NULL, INDEX IDX_E4901D87FFE68A1B (game_character_id), INDEX IDX_E4901D8789329D25 (resource_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE character_attribute ADD CONSTRAINT FK_7D2A4DC0FFE68A1B FOREIGN KEY (game_character_id) REFERENCES game_character (id)');
        $this->addSql('ALTER TABLE character_attribute ADD CONSTRAINT FK_7D2A4DC0B6E62EFA FOREIGN KEY (attribute_id) REFERENCES attribute (id)');
        $this->addSql('ALTER TABLE character_resource ADD CONSTRAINT FK_E4901D87FFE68A1B FOREIGN KEY (game_character_id) REFERENCES game_character (id)');
        $this->addSql('ALTER TABLE character_resource ADD CONSTRAINT FK_E4901D8789329D25 FOREIGN KEY (resource_id) REFERENCES resource (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE character_attribute');
        $this->addSql('DROP TABLE character_resource');
    }
}
