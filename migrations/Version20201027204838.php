<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201027204838 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE damage_nature (id INT AUTO_INCREMENT NOT NULL, game_id INT NOT NULL, name VARCHAR(255) NOT NULL, abreviation VARCHAR(3) NOT NULL, INDEX IDX_A2229AB4E48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE defense (id INT AUTO_INCREMENT NOT NULL, attribute_id INT NOT NULL, damage_nature_id INT NOT NULL, efficiency INT NOT NULL, INDEX IDX_DBA5F575B6E62EFA (attribute_id), INDEX IDX_DBA5F575FAD8B02A (damage_nature_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE damage_nature ADD CONSTRAINT FK_A2229AB4E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE defense ADD CONSTRAINT FK_DBA5F575B6E62EFA FOREIGN KEY (attribute_id) REFERENCES attribute (id)');
        $this->addSql('ALTER TABLE defense ADD CONSTRAINT FK_DBA5F575FAD8B02A FOREIGN KEY (damage_nature_id) REFERENCES damage_nature (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE defense DROP FOREIGN KEY FK_DBA5F575FAD8B02A');
        $this->addSql('DROP TABLE damage_nature');
        $this->addSql('DROP TABLE defense');
    }
}
