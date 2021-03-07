<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201108122927 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE target DROP FOREIGN KEY FK_466F2FFCFFE68A1B');
        $this->addSql('ALTER TABLE target ADD CONSTRAINT FK_466F2FFCFFE68A1B FOREIGN KEY (game_character_id) REFERENCES game_character (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE target DROP FOREIGN KEY FK_466F2FFCFFE68A1B');
        $this->addSql('ALTER TABLE target ADD CONSTRAINT FK_466F2FFCFFE68A1B FOREIGN KEY (game_character_id) REFERENCES game_character (id)');
    }
}
