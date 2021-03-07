<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201110131337 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE target DROP FOREIGN KEY FK_466F2FFCB4A980E2');
        $this->addSql('ALTER TABLE target DROP FOREIGN KEY FK_466F2FFCD1CB7F7');
        $this->addSql('ALTER TABLE target DROP FOREIGN KEY FK_466F2FFCFD2F9EC2');
        $this->addSql('ALTER TABLE target ADD CONSTRAINT FK_466F2FFCB4A980E2 FOREIGN KEY (skill_damage_effect_id) REFERENCES skill_damage_effect (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE target ADD CONSTRAINT FK_466F2FFCD1CB7F7 FOREIGN KEY (skill_heal_effect_id) REFERENCES skill_heal_effect (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE target ADD CONSTRAINT FK_466F2FFCFD2F9EC2 FOREIGN KEY (skill_status_effect_id) REFERENCES skill_status_effect (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE target DROP FOREIGN KEY FK_466F2FFCD1CB7F7');
        $this->addSql('ALTER TABLE target DROP FOREIGN KEY FK_466F2FFCB4A980E2');
        $this->addSql('ALTER TABLE target DROP FOREIGN KEY FK_466F2FFCFD2F9EC2');
        $this->addSql('ALTER TABLE target ADD CONSTRAINT FK_466F2FFCD1CB7F7 FOREIGN KEY (skill_heal_effect_id) REFERENCES skill_heal_effect (id)');
        $this->addSql('ALTER TABLE target ADD CONSTRAINT FK_466F2FFCB4A980E2 FOREIGN KEY (skill_damage_effect_id) REFERENCES skill_damage_effect (id)');
        $this->addSql('ALTER TABLE target ADD CONSTRAINT FK_466F2FFCFD2F9EC2 FOREIGN KEY (skill_status_effect_id) REFERENCES skill_status_effect (id)');
    }
}
