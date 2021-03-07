<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201029184232 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE skill_cost (id INT AUTO_INCREMENT NOT NULL, skill_id INT NOT NULL, resource_id INT NOT NULL, calculation_type VARCHAR(255) NOT NULL, value INT NOT NULL, INDEX IDX_5F67084E5585C142 (skill_id), INDEX IDX_5F67084E89329D25 (resource_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skill_gain (id INT AUTO_INCREMENT NOT NULL, skill_id INT NOT NULL, resource_id INT NOT NULL, calculation_type VARCHAR(255) NOT NULL, value INT NOT NULL, INDEX IDX_97D4B1B25585C142 (skill_id), INDEX IDX_97D4B1B289329D25 (resource_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE skill_cost ADD CONSTRAINT FK_5F67084E5585C142 FOREIGN KEY (skill_id) REFERENCES skill (id)');
        $this->addSql('ALTER TABLE skill_cost ADD CONSTRAINT FK_5F67084E89329D25 FOREIGN KEY (resource_id) REFERENCES resource (id)');
        $this->addSql('ALTER TABLE skill_gain ADD CONSTRAINT FK_97D4B1B25585C142 FOREIGN KEY (skill_id) REFERENCES skill (id)');
        $this->addSql('ALTER TABLE skill_gain ADD CONSTRAINT FK_97D4B1B289329D25 FOREIGN KEY (resource_id) REFERENCES resource (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE skill_cost');
        $this->addSql('DROP TABLE skill_gain');
    }
}
