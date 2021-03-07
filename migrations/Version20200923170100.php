<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200923170100 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE lore_block_element (id INT AUTO_INCREMENT NOT NULL, lore_block_id INT NOT NULL, access_type VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, text LONGTEXT NOT NULL, INDEX IDX_45B9E4F0715F219A (lore_block_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE lore_block_element ADD CONSTRAINT FK_45B9E4F0715F219A FOREIGN KEY (lore_block_id) REFERENCES lore_block (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE lore_block_element');
    }
}
