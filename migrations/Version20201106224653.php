<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201106224653 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE passive (id INT AUTO_INCREMENT NOT NULL, game_id INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_76EFFDCFE48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE passive ADD CONSTRAINT FK_76EFFDCFE48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE attribute_alteration ADD passive_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE attribute_alteration ADD CONSTRAINT FK_9B8680A16D157422 FOREIGN KEY (passive_id) REFERENCES passive (id)');
        $this->addSql('CREATE INDEX IDX_9B8680A16D157422 ON attribute_alteration (passive_id)');
        $this->addSql('ALTER TABLE damage_over_time ADD passive_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE damage_over_time ADD CONSTRAINT FK_A5088C666D157422 FOREIGN KEY (passive_id) REFERENCES passive (id)');
        $this->addSql('CREATE INDEX IDX_A5088C666D157422 ON damage_over_time (passive_id)');
        $this->addSql('ALTER TABLE heal_over_time ADD passive_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE heal_over_time ADD CONSTRAINT FK_5ED77E616D157422 FOREIGN KEY (passive_id) REFERENCES passive (id)');
        $this->addSql('CREATE INDEX IDX_5ED77E616D157422 ON heal_over_time (passive_id)');
        $this->addSql('ALTER TABLE resource_alteration ADD passive_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE resource_alteration ADD CONSTRAINT FK_FFF8C0426D157422 FOREIGN KEY (passive_id) REFERENCES passive (id)');
        $this->addSql('CREATE INDEX IDX_FFF8C0426D157422 ON resource_alteration (passive_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attribute_alteration DROP FOREIGN KEY FK_9B8680A16D157422');
        $this->addSql('ALTER TABLE damage_over_time DROP FOREIGN KEY FK_A5088C666D157422');
        $this->addSql('ALTER TABLE heal_over_time DROP FOREIGN KEY FK_5ED77E616D157422');
        $this->addSql('ALTER TABLE resource_alteration DROP FOREIGN KEY FK_FFF8C0426D157422');
        $this->addSql('DROP TABLE passive');
        $this->addSql('DROP INDEX IDX_9B8680A16D157422 ON attribute_alteration');
        $this->addSql('ALTER TABLE attribute_alteration DROP passive_id');
        $this->addSql('DROP INDEX IDX_A5088C666D157422 ON damage_over_time');
        $this->addSql('ALTER TABLE damage_over_time DROP passive_id');
        $this->addSql('DROP INDEX IDX_5ED77E616D157422 ON heal_over_time');
        $this->addSql('ALTER TABLE heal_over_time DROP passive_id');
        $this->addSql('DROP INDEX IDX_FFF8C0426D157422 ON resource_alteration');
        $this->addSql('ALTER TABLE resource_alteration DROP passive_id');
    }
}
