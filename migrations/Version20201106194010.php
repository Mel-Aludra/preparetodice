<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201106194010 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE skill_status_effect (id INT AUTO_INCREMENT NOT NULL, skill_id INT NOT NULL, status_effect_id INT NOT NULL, duration INT NOT NULL, INDEX IDX_E5B634035585C142 (skill_id), INDEX IDX_E5B634037D7C387A (status_effect_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE skill_status_effect ADD CONSTRAINT FK_E5B634035585C142 FOREIGN KEY (skill_id) REFERENCES skill (id)');
        $this->addSql('ALTER TABLE skill_status_effect ADD CONSTRAINT FK_E5B634037D7C387A FOREIGN KEY (status_effect_id) REFERENCES status_effect (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE skill_status_effect');
    }
}
