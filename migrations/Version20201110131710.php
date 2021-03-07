<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201110131710 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE skill_damage_effect DROP FOREIGN KEY FK_4B06845D5585C142');
        $this->addSql('ALTER TABLE skill_damage_effect DROP FOREIGN KEY FK_4B06845D95B82273');
        $this->addSql('ALTER TABLE skill_damage_effect DROP FOREIGN KEY FK_4B06845D9D32F035');
        $this->addSql('ALTER TABLE skill_damage_effect DROP FOREIGN KEY FK_4B06845DA94ADB61');
        $this->addSql('ALTER TABLE skill_damage_effect ADD CONSTRAINT FK_4B06845D5585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE skill_damage_effect ADD CONSTRAINT FK_4B06845D95B82273 FOREIGN KEY (weapon_id) REFERENCES weapon (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE skill_damage_effect ADD CONSTRAINT FK_4B06845D9D32F035 FOREIGN KEY (action_id) REFERENCES action (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE skill_damage_effect ADD CONSTRAINT FK_4B06845DA94ADB61 FOREIGN KEY (consumable_id) REFERENCES consumable (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE skill_heal_effect DROP FOREIGN KEY FK_162319755585C142');
        $this->addSql('ALTER TABLE skill_heal_effect DROP FOREIGN KEY FK_1623197595B82273');
        $this->addSql('ALTER TABLE skill_heal_effect DROP FOREIGN KEY FK_162319759D32F035');
        $this->addSql('ALTER TABLE skill_heal_effect DROP FOREIGN KEY FK_16231975A94ADB61');
        $this->addSql('ALTER TABLE skill_heal_effect ADD CONSTRAINT FK_162319755585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE skill_heal_effect ADD CONSTRAINT FK_1623197595B82273 FOREIGN KEY (weapon_id) REFERENCES weapon (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE skill_heal_effect ADD CONSTRAINT FK_162319759D32F035 FOREIGN KEY (action_id) REFERENCES action (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE skill_heal_effect ADD CONSTRAINT FK_16231975A94ADB61 FOREIGN KEY (consumable_id) REFERENCES consumable (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE skill_status_effect DROP FOREIGN KEY FK_E5B634035585C142');
        $this->addSql('ALTER TABLE skill_status_effect DROP FOREIGN KEY FK_E5B6340395B82273');
        $this->addSql('ALTER TABLE skill_status_effect DROP FOREIGN KEY FK_E5B634039D32F035');
        $this->addSql('ALTER TABLE skill_status_effect DROP FOREIGN KEY FK_E5B63403A94ADB61');
        $this->addSql('ALTER TABLE skill_status_effect ADD CONSTRAINT FK_E5B634035585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE skill_status_effect ADD CONSTRAINT FK_E5B6340395B82273 FOREIGN KEY (weapon_id) REFERENCES weapon (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE skill_status_effect ADD CONSTRAINT FK_E5B634039D32F035 FOREIGN KEY (action_id) REFERENCES action (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE skill_status_effect ADD CONSTRAINT FK_E5B63403A94ADB61 FOREIGN KEY (consumable_id) REFERENCES consumable (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE skill_damage_effect DROP FOREIGN KEY FK_4B06845D5585C142');
        $this->addSql('ALTER TABLE skill_damage_effect DROP FOREIGN KEY FK_4B06845D95B82273');
        $this->addSql('ALTER TABLE skill_damage_effect DROP FOREIGN KEY FK_4B06845DA94ADB61');
        $this->addSql('ALTER TABLE skill_damage_effect DROP FOREIGN KEY FK_4B06845D9D32F035');
        $this->addSql('ALTER TABLE skill_damage_effect ADD CONSTRAINT FK_4B06845D5585C142 FOREIGN KEY (skill_id) REFERENCES skill (id)');
        $this->addSql('ALTER TABLE skill_damage_effect ADD CONSTRAINT FK_4B06845D95B82273 FOREIGN KEY (weapon_id) REFERENCES weapon (id)');
        $this->addSql('ALTER TABLE skill_damage_effect ADD CONSTRAINT FK_4B06845DA94ADB61 FOREIGN KEY (consumable_id) REFERENCES consumable (id)');
        $this->addSql('ALTER TABLE skill_damage_effect ADD CONSTRAINT FK_4B06845D9D32F035 FOREIGN KEY (action_id) REFERENCES action (id)');
        $this->addSql('ALTER TABLE skill_heal_effect DROP FOREIGN KEY FK_162319755585C142');
        $this->addSql('ALTER TABLE skill_heal_effect DROP FOREIGN KEY FK_1623197595B82273');
        $this->addSql('ALTER TABLE skill_heal_effect DROP FOREIGN KEY FK_16231975A94ADB61');
        $this->addSql('ALTER TABLE skill_heal_effect DROP FOREIGN KEY FK_162319759D32F035');
        $this->addSql('ALTER TABLE skill_heal_effect ADD CONSTRAINT FK_162319755585C142 FOREIGN KEY (skill_id) REFERENCES skill (id)');
        $this->addSql('ALTER TABLE skill_heal_effect ADD CONSTRAINT FK_1623197595B82273 FOREIGN KEY (weapon_id) REFERENCES weapon (id)');
        $this->addSql('ALTER TABLE skill_heal_effect ADD CONSTRAINT FK_16231975A94ADB61 FOREIGN KEY (consumable_id) REFERENCES consumable (id)');
        $this->addSql('ALTER TABLE skill_heal_effect ADD CONSTRAINT FK_162319759D32F035 FOREIGN KEY (action_id) REFERENCES action (id)');
        $this->addSql('ALTER TABLE skill_status_effect DROP FOREIGN KEY FK_E5B634035585C142');
        $this->addSql('ALTER TABLE skill_status_effect DROP FOREIGN KEY FK_E5B6340395B82273');
        $this->addSql('ALTER TABLE skill_status_effect DROP FOREIGN KEY FK_E5B63403A94ADB61');
        $this->addSql('ALTER TABLE skill_status_effect DROP FOREIGN KEY FK_E5B634039D32F035');
        $this->addSql('ALTER TABLE skill_status_effect ADD CONSTRAINT FK_E5B634035585C142 FOREIGN KEY (skill_id) REFERENCES skill (id)');
        $this->addSql('ALTER TABLE skill_status_effect ADD CONSTRAINT FK_E5B6340395B82273 FOREIGN KEY (weapon_id) REFERENCES weapon (id)');
        $this->addSql('ALTER TABLE skill_status_effect ADD CONSTRAINT FK_E5B63403A94ADB61 FOREIGN KEY (consumable_id) REFERENCES consumable (id)');
        $this->addSql('ALTER TABLE skill_status_effect ADD CONSTRAINT FK_E5B634039D32F035 FOREIGN KEY (action_id) REFERENCES action (id)');
    }
}
