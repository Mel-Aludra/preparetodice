<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201111141846 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE skill_cost DROP FOREIGN KEY FK_5F67084E9D32F035');
        $this->addSql('ALTER TABLE skill_cost ADD CONSTRAINT FK_5F67084E9D32F035 FOREIGN KEY (action_id) REFERENCES action (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE skill_gain DROP FOREIGN KEY FK_97D4B1B29D32F035');
        $this->addSql('ALTER TABLE skill_gain ADD CONSTRAINT FK_97D4B1B29D32F035 FOREIGN KEY (action_id) REFERENCES action (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE skill_cost DROP FOREIGN KEY FK_5F67084E9D32F035');
        $this->addSql('ALTER TABLE skill_cost ADD CONSTRAINT FK_5F67084E9D32F035 FOREIGN KEY (action_id) REFERENCES action (id)');
        $this->addSql('ALTER TABLE skill_gain DROP FOREIGN KEY FK_97D4B1B29D32F035');
        $this->addSql('ALTER TABLE skill_gain ADD CONSTRAINT FK_97D4B1B29D32F035 FOREIGN KEY (action_id) REFERENCES action (id)');
    }
}
