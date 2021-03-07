<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200921192503 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_game_character (id INT AUTO_INCREMENT NOT NULL, user_game_id INT NOT NULL, game_character_id INT NOT NULL, access_type VARCHAR(255) NOT NULL, INDEX IDX_2A59AE6FBC82C70F (user_game_id), INDEX IDX_2A59AE6FFFE68A1B (game_character_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_game_character ADD CONSTRAINT FK_2A59AE6FBC82C70F FOREIGN KEY (user_game_id) REFERENCES user_game (id)');
        $this->addSql('ALTER TABLE user_game_character ADD CONSTRAINT FK_2A59AE6FFFE68A1B FOREIGN KEY (game_character_id) REFERENCES game_character (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user_game_character');
    }
}
