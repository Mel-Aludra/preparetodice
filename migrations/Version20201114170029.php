<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201114170029 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE attribute_effect (id INT AUTO_INCREMENT NOT NULL, attribute_id INT NOT NULL, resource_id INT NOT NULL, is_negative TINYINT(1) NOT NULL, calculation_type VARCHAR(255) NOT NULL, value_per_point INT NOT NULL, INDEX IDX_9481BFA8B6E62EFA (attribute_id), INDEX IDX_9481BFA889329D25 (resource_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE attribute_effect ADD CONSTRAINT FK_9481BFA8B6E62EFA FOREIGN KEY (attribute_id) REFERENCES attribute (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE attribute_effect ADD CONSTRAINT FK_9481BFA889329D25 FOREIGN KEY (resource_id) REFERENCES resource (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE attribute_effect');
    }
}
