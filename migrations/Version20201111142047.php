<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201111142047 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE battle_log DROP FOREIGN KEY FK_8049DBB19D32F035');
        $this->addSql('ALTER TABLE battle_log ADD CONSTRAINT FK_8049DBB19D32F035 FOREIGN KEY (action_id) REFERENCES action (id) ON DELETE SET NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE battle_log DROP FOREIGN KEY FK_8049DBB19D32F035');
        $this->addSql('ALTER TABLE battle_log ADD CONSTRAINT FK_8049DBB19D32F035 FOREIGN KEY (action_id) REFERENCES action (id) ON DELETE CASCADE');
    }
}
