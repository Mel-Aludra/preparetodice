<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201112152715 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game ADD life_resource_id INT DEFAULT NULL, ADD action_points_resource_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C8D0D03F0 FOREIGN KEY (life_resource_id) REFERENCES resource (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C4622D19D FOREIGN KEY (action_points_resource_id) REFERENCES resource (id)');
        $this->addSql('CREATE INDEX IDX_232B318C8D0D03F0 ON game (life_resource_id)');
        $this->addSql('CREATE INDEX IDX_232B318C4622D19D ON game (action_points_resource_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C8D0D03F0');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C4622D19D');
        $this->addSql('DROP INDEX IDX_232B318C8D0D03F0 ON game');
        $this->addSql('DROP INDEX IDX_232B318C4622D19D ON game');
        $this->addSql('ALTER TABLE game DROP life_resource_id, DROP action_points_resource_id');
    }
}
