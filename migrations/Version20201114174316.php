<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201114174316 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE attribute_job (attribute_id INT NOT NULL, job_id INT NOT NULL, INDEX IDX_CDD27547B6E62EFA (attribute_id), INDEX IDX_CDD27547BE04EA9 (job_id), PRIMARY KEY(attribute_id, job_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gear_job (gear_id INT NOT NULL, job_id INT NOT NULL, INDEX IDX_B1CF5CC777201934 (gear_id), INDEX IDX_B1CF5CC7BE04EA9 (job_id), PRIMARY KEY(gear_id, job_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE resource_job (resource_id INT NOT NULL, job_id INT NOT NULL, INDEX IDX_DB816EB189329D25 (resource_id), INDEX IDX_DB816EB1BE04EA9 (job_id), PRIMARY KEY(resource_id, job_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skill_job (skill_id INT NOT NULL, job_id INT NOT NULL, INDEX IDX_88B2D165585C142 (skill_id), INDEX IDX_88B2D16BE04EA9 (job_id), PRIMARY KEY(skill_id, job_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE weapon_job (weapon_id INT NOT NULL, job_id INT NOT NULL, INDEX IDX_599510CF95B82273 (weapon_id), INDEX IDX_599510CFBE04EA9 (job_id), PRIMARY KEY(weapon_id, job_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE attribute_job ADD CONSTRAINT FK_CDD27547B6E62EFA FOREIGN KEY (attribute_id) REFERENCES attribute (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE attribute_job ADD CONSTRAINT FK_CDD27547BE04EA9 FOREIGN KEY (job_id) REFERENCES job (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE gear_job ADD CONSTRAINT FK_B1CF5CC777201934 FOREIGN KEY (gear_id) REFERENCES gear (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE gear_job ADD CONSTRAINT FK_B1CF5CC7BE04EA9 FOREIGN KEY (job_id) REFERENCES job (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE resource_job ADD CONSTRAINT FK_DB816EB189329D25 FOREIGN KEY (resource_id) REFERENCES resource (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE resource_job ADD CONSTRAINT FK_DB816EB1BE04EA9 FOREIGN KEY (job_id) REFERENCES job (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE skill_job ADD CONSTRAINT FK_88B2D165585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE skill_job ADD CONSTRAINT FK_88B2D16BE04EA9 FOREIGN KEY (job_id) REFERENCES job (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE weapon_job ADD CONSTRAINT FK_599510CF95B82273 FOREIGN KEY (weapon_id) REFERENCES weapon (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE weapon_job ADD CONSTRAINT FK_599510CFBE04EA9 FOREIGN KEY (job_id) REFERENCES job (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE attribute_job');
        $this->addSql('DROP TABLE gear_job');
        $this->addSql('DROP TABLE resource_job');
        $this->addSql('DROP TABLE skill_job');
        $this->addSql('DROP TABLE weapon_job');
    }
}
