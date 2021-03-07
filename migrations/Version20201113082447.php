<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201113082447 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE potency_augmentator DROP FOREIGN KEY FK_5251DBEFE48FD905');
        $this->addSql('ALTER TABLE potency_augmentator CHANGE value value INT DEFAULT NULL');
        $this->addSql('ALTER TABLE potency_augmentator ADD CONSTRAINT FK_5251DBEFE48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE potency_augmentator DROP FOREIGN KEY FK_5251DBEFE48FD905');
        $this->addSql('ALTER TABLE potency_augmentator CHANGE value value INT NOT NULL');
        $this->addSql('ALTER TABLE potency_augmentator ADD CONSTRAINT FK_5251DBEFE48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
    }
}
