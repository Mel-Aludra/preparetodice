<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201107203631 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attribute DROP FOREIGN KEY FK_FA7AEFFBE48FD905');
        $this->addSql('ALTER TABLE attribute ADD CONSTRAINT FK_FA7AEFFBE48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE attribute_alteration DROP FOREIGN KEY FK_9B8680A1B6E62EFA');
        $this->addSql('ALTER TABLE attribute_alteration ADD CONSTRAINT FK_9B8680A1B6E62EFA FOREIGN KEY (attribute_id) REFERENCES attribute (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE character_attribute DROP FOREIGN KEY FK_7D2A4DC0FFE68A1B');
        $this->addSql('ALTER TABLE character_attribute ADD CONSTRAINT FK_7D2A4DC0FFE68A1B FOREIGN KEY (game_character_id) REFERENCES game_character (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE character_passive DROP FOREIGN KEY FK_1F4A7DF26D157422');
        $this->addSql('ALTER TABLE character_passive DROP FOREIGN KEY FK_1F4A7DF2FFE68A1B');
        $this->addSql('ALTER TABLE character_passive ADD CONSTRAINT FK_1F4A7DF26D157422 FOREIGN KEY (passive_id) REFERENCES passive (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE character_passive ADD CONSTRAINT FK_1F4A7DF2FFE68A1B FOREIGN KEY (game_character_id) REFERENCES game_character (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE character_resource DROP FOREIGN KEY FK_E4901D8789329D25');
        $this->addSql('ALTER TABLE character_resource DROP FOREIGN KEY FK_E4901D87FFE68A1B');
        $this->addSql('ALTER TABLE character_resource ADD CONSTRAINT FK_E4901D8789329D25 FOREIGN KEY (resource_id) REFERENCES resource (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE character_resource ADD CONSTRAINT FK_E4901D87FFE68A1B FOREIGN KEY (game_character_id) REFERENCES game_character (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE character_skill DROP FOREIGN KEY FK_A0FE03155585C142');
        $this->addSql('ALTER TABLE character_skill DROP FOREIGN KEY FK_A0FE0315FFE68A1B');
        $this->addSql('ALTER TABLE character_skill ADD CONSTRAINT FK_A0FE03155585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE character_skill ADD CONSTRAINT FK_A0FE0315FFE68A1B FOREIGN KEY (game_character_id) REFERENCES game_character (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE consumable DROP FOREIGN KEY FK_4475F095E48FD905');
        $this->addSql('ALTER TABLE consumable ADD CONSTRAINT FK_4475F095E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE damage_nature DROP FOREIGN KEY FK_A2229AB4E48FD905');
        $this->addSql('ALTER TABLE damage_nature ADD CONSTRAINT FK_A2229AB4E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE damage_over_time DROP FOREIGN KEY FK_A5088C6689329D25');
        $this->addSql('ALTER TABLE damage_over_time DROP FOREIGN KEY FK_A5088C66FAD8B02A');
        $this->addSql('ALTER TABLE damage_over_time ADD CONSTRAINT FK_A5088C6689329D25 FOREIGN KEY (resource_id) REFERENCES resource (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE damage_over_time ADD CONSTRAINT FK_A5088C66FAD8B02A FOREIGN KEY (damage_nature_id) REFERENCES damage_nature (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE defense DROP FOREIGN KEY FK_DBA5F575B6E62EFA');
        $this->addSql('ALTER TABLE defense DROP FOREIGN KEY FK_DBA5F575FAD8B02A');
        $this->addSql('ALTER TABLE defense ADD CONSTRAINT FK_DBA5F575B6E62EFA FOREIGN KEY (attribute_id) REFERENCES attribute (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE defense ADD CONSTRAINT FK_DBA5F575FAD8B02A FOREIGN KEY (damage_nature_id) REFERENCES damage_nature (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_character DROP FOREIGN KEY FK_41DC7136E48FD905');
        $this->addSql('ALTER TABLE game_character ADD CONSTRAINT FK_41DC7136E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE gear DROP FOREIGN KEY FK_B44539BE48FD905');
        $this->addSql('ALTER TABLE gear ADD CONSTRAINT FK_B44539BE48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE heal_over_time DROP FOREIGN KEY FK_5ED77E6189329D25');
        $this->addSql('ALTER TABLE heal_over_time ADD CONSTRAINT FK_5ED77E6189329D25 FOREIGN KEY (resource_id) REFERENCES resource (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE inventory_consumable DROP FOREIGN KEY FK_79BA516A94ADB61');
        $this->addSql('ALTER TABLE inventory_consumable DROP FOREIGN KEY FK_79BA516FFE68A1B');
        $this->addSql('ALTER TABLE inventory_consumable ADD CONSTRAINT FK_79BA516A94ADB61 FOREIGN KEY (consumable_id) REFERENCES consumable (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE inventory_consumable ADD CONSTRAINT FK_79BA516FFE68A1B FOREIGN KEY (game_character_id) REFERENCES game_character (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE inventory_gear DROP FOREIGN KEY FK_41E29CB577201934');
        $this->addSql('ALTER TABLE inventory_gear DROP FOREIGN KEY FK_41E29CB5FFE68A1B');
        $this->addSql('ALTER TABLE inventory_gear ADD CONSTRAINT FK_41E29CB577201934 FOREIGN KEY (gear_id) REFERENCES gear (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE inventory_gear ADD CONSTRAINT FK_41E29CB5FFE68A1B FOREIGN KEY (game_character_id) REFERENCES game_character (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE inventory_item DROP FOREIGN KEY FK_55BDEA30126F525E');
        $this->addSql('ALTER TABLE inventory_item DROP FOREIGN KEY FK_55BDEA30FFE68A1B');
        $this->addSql('ALTER TABLE inventory_item ADD CONSTRAINT FK_55BDEA30126F525E FOREIGN KEY (item_id) REFERENCES item (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE inventory_item ADD CONSTRAINT FK_55BDEA30FFE68A1B FOREIGN KEY (game_character_id) REFERENCES game_character (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE inventory_weapon DROP FOREIGN KEY FK_69EF3B4D95B82273');
        $this->addSql('ALTER TABLE inventory_weapon DROP FOREIGN KEY FK_69EF3B4DFFE68A1B');
        $this->addSql('ALTER TABLE inventory_weapon ADD CONSTRAINT FK_69EF3B4D95B82273 FOREIGN KEY (weapon_id) REFERENCES weapon (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE inventory_weapon ADD CONSTRAINT FK_69EF3B4DFFE68A1B FOREIGN KEY (game_character_id) REFERENCES game_character (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251EE48FD905');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251EE48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lore_block DROP FOREIGN KEY FK_2491ED4FE48FD905');
        $this->addSql('ALTER TABLE lore_block ADD CONSTRAINT FK_2491ED4FE48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lore_block_element DROP FOREIGN KEY FK_45B9E4F0715F219A');
        $this->addSql('ALTER TABLE lore_block_element ADD CONSTRAINT FK_45B9E4F0715F219A FOREIGN KEY (lore_block_id) REFERENCES lore_block (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lore_tag DROP FOREIGN KEY FK_E7067303E48FD905');
        $this->addSql('ALTER TABLE lore_tag ADD CONSTRAINT FK_E7067303E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE passive DROP FOREIGN KEY FK_76EFFDCFE48FD905');
        $this->addSql('ALTER TABLE passive ADD CONSTRAINT FK_76EFFDCFE48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE resource DROP FOREIGN KEY FK_BC91F416E48FD905');
        $this->addSql('ALTER TABLE resource ADD CONSTRAINT FK_BC91F416E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE resource_alteration DROP FOREIGN KEY FK_FFF8C04289329D25');
        $this->addSql('ALTER TABLE resource_alteration ADD CONSTRAINT FK_FFF8C04289329D25 FOREIGN KEY (resource_id) REFERENCES resource (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE skill DROP FOREIGN KEY FK_5E3DE477E48FD905');
        $this->addSql('ALTER TABLE skill ADD CONSTRAINT FK_5E3DE477E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE skill_cost DROP FOREIGN KEY FK_5F67084E89329D25');
        $this->addSql('ALTER TABLE skill_cost ADD CONSTRAINT FK_5F67084E89329D25 FOREIGN KEY (resource_id) REFERENCES resource (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE skill_damage_effect DROP FOREIGN KEY FK_4B06845D89329D25');
        $this->addSql('ALTER TABLE skill_damage_effect DROP FOREIGN KEY FK_4B06845DFAD8B02A');
        $this->addSql('ALTER TABLE skill_damage_effect ADD CONSTRAINT FK_4B06845D89329D25 FOREIGN KEY (resource_id) REFERENCES resource (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE skill_damage_effect ADD CONSTRAINT FK_4B06845DFAD8B02A FOREIGN KEY (damage_nature_id) REFERENCES damage_nature (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE skill_gain DROP FOREIGN KEY FK_97D4B1B289329D25');
        $this->addSql('ALTER TABLE skill_gain ADD CONSTRAINT FK_97D4B1B289329D25 FOREIGN KEY (resource_id) REFERENCES resource (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE skill_heal_effect DROP FOREIGN KEY FK_1623197589329D25');
        $this->addSql('ALTER TABLE skill_heal_effect ADD CONSTRAINT FK_1623197589329D25 FOREIGN KEY (resource_id) REFERENCES resource (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE skill_status_effect DROP FOREIGN KEY FK_E5B634037D7C387A');
        $this->addSql('ALTER TABLE skill_status_effect ADD CONSTRAINT FK_E5B634037D7C387A FOREIGN KEY (status_effect_id) REFERENCES status_effect (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE status_effect DROP FOREIGN KEY FK_B2A39BFE48FD905');
        $this->addSql('ALTER TABLE status_effect ADD CONSTRAINT FK_B2A39BFE48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_game DROP FOREIGN KEY FK_59AA7D45A76ED395');
        $this->addSql('ALTER TABLE user_game DROP FOREIGN KEY FK_59AA7D45E48FD905');
        $this->addSql('ALTER TABLE user_game ADD CONSTRAINT FK_59AA7D45A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_game ADD CONSTRAINT FK_59AA7D45E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_game_character DROP FOREIGN KEY FK_2A59AE6FBC82C70F');
        $this->addSql('ALTER TABLE user_game_character DROP FOREIGN KEY FK_2A59AE6FFFE68A1B');
        $this->addSql('ALTER TABLE user_game_character ADD CONSTRAINT FK_2A59AE6FBC82C70F FOREIGN KEY (user_game_id) REFERENCES user_game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_game_character ADD CONSTRAINT FK_2A59AE6FFFE68A1B FOREIGN KEY (game_character_id) REFERENCES game_character (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE weapon DROP FOREIGN KEY FK_6933A7E6E48FD905');
        $this->addSql('ALTER TABLE weapon ADD CONSTRAINT FK_6933A7E6E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attribute DROP FOREIGN KEY FK_FA7AEFFBE48FD905');
        $this->addSql('ALTER TABLE attribute ADD CONSTRAINT FK_FA7AEFFBE48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE attribute_alteration DROP FOREIGN KEY FK_9B8680A1B6E62EFA');
        $this->addSql('ALTER TABLE attribute_alteration ADD CONSTRAINT FK_9B8680A1B6E62EFA FOREIGN KEY (attribute_id) REFERENCES attribute (id)');
        $this->addSql('ALTER TABLE character_attribute DROP FOREIGN KEY FK_7D2A4DC0FFE68A1B');
        $this->addSql('ALTER TABLE character_attribute ADD CONSTRAINT FK_7D2A4DC0FFE68A1B FOREIGN KEY (game_character_id) REFERENCES game_character (id)');
        $this->addSql('ALTER TABLE character_passive DROP FOREIGN KEY FK_1F4A7DF2FFE68A1B');
        $this->addSql('ALTER TABLE character_passive DROP FOREIGN KEY FK_1F4A7DF26D157422');
        $this->addSql('ALTER TABLE character_passive ADD CONSTRAINT FK_1F4A7DF2FFE68A1B FOREIGN KEY (game_character_id) REFERENCES game_character (id)');
        $this->addSql('ALTER TABLE character_passive ADD CONSTRAINT FK_1F4A7DF26D157422 FOREIGN KEY (passive_id) REFERENCES passive (id)');
        $this->addSql('ALTER TABLE character_resource DROP FOREIGN KEY FK_E4901D87FFE68A1B');
        $this->addSql('ALTER TABLE character_resource DROP FOREIGN KEY FK_E4901D8789329D25');
        $this->addSql('ALTER TABLE character_resource ADD CONSTRAINT FK_E4901D87FFE68A1B FOREIGN KEY (game_character_id) REFERENCES game_character (id)');
        $this->addSql('ALTER TABLE character_resource ADD CONSTRAINT FK_E4901D8789329D25 FOREIGN KEY (resource_id) REFERENCES resource (id)');
        $this->addSql('ALTER TABLE character_skill DROP FOREIGN KEY FK_A0FE0315FFE68A1B');
        $this->addSql('ALTER TABLE character_skill DROP FOREIGN KEY FK_A0FE03155585C142');
        $this->addSql('ALTER TABLE character_skill ADD CONSTRAINT FK_A0FE0315FFE68A1B FOREIGN KEY (game_character_id) REFERENCES game_character (id)');
        $this->addSql('ALTER TABLE character_skill ADD CONSTRAINT FK_A0FE03155585C142 FOREIGN KEY (skill_id) REFERENCES skill (id)');
        $this->addSql('ALTER TABLE consumable DROP FOREIGN KEY FK_4475F095E48FD905');
        $this->addSql('ALTER TABLE consumable ADD CONSTRAINT FK_4475F095E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE damage_nature DROP FOREIGN KEY FK_A2229AB4E48FD905');
        $this->addSql('ALTER TABLE damage_nature ADD CONSTRAINT FK_A2229AB4E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE damage_over_time DROP FOREIGN KEY FK_A5088C66FAD8B02A');
        $this->addSql('ALTER TABLE damage_over_time DROP FOREIGN KEY FK_A5088C6689329D25');
        $this->addSql('ALTER TABLE damage_over_time ADD CONSTRAINT FK_A5088C66FAD8B02A FOREIGN KEY (damage_nature_id) REFERENCES damage_nature (id)');
        $this->addSql('ALTER TABLE damage_over_time ADD CONSTRAINT FK_A5088C6689329D25 FOREIGN KEY (resource_id) REFERENCES resource (id)');
        $this->addSql('ALTER TABLE defense DROP FOREIGN KEY FK_DBA5F575B6E62EFA');
        $this->addSql('ALTER TABLE defense DROP FOREIGN KEY FK_DBA5F575FAD8B02A');
        $this->addSql('ALTER TABLE defense ADD CONSTRAINT FK_DBA5F575B6E62EFA FOREIGN KEY (attribute_id) REFERENCES attribute (id)');
        $this->addSql('ALTER TABLE defense ADD CONSTRAINT FK_DBA5F575FAD8B02A FOREIGN KEY (damage_nature_id) REFERENCES damage_nature (id)');
        $this->addSql('ALTER TABLE game_character DROP FOREIGN KEY FK_41DC7136E48FD905');
        $this->addSql('ALTER TABLE game_character ADD CONSTRAINT FK_41DC7136E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE gear DROP FOREIGN KEY FK_B44539BE48FD905');
        $this->addSql('ALTER TABLE gear ADD CONSTRAINT FK_B44539BE48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE heal_over_time DROP FOREIGN KEY FK_5ED77E6189329D25');
        $this->addSql('ALTER TABLE heal_over_time ADD CONSTRAINT FK_5ED77E6189329D25 FOREIGN KEY (resource_id) REFERENCES resource (id)');
        $this->addSql('ALTER TABLE inventory_consumable DROP FOREIGN KEY FK_79BA516FFE68A1B');
        $this->addSql('ALTER TABLE inventory_consumable DROP FOREIGN KEY FK_79BA516A94ADB61');
        $this->addSql('ALTER TABLE inventory_consumable ADD CONSTRAINT FK_79BA516FFE68A1B FOREIGN KEY (game_character_id) REFERENCES game_character (id)');
        $this->addSql('ALTER TABLE inventory_consumable ADD CONSTRAINT FK_79BA516A94ADB61 FOREIGN KEY (consumable_id) REFERENCES consumable (id)');
        $this->addSql('ALTER TABLE inventory_gear DROP FOREIGN KEY FK_41E29CB5FFE68A1B');
        $this->addSql('ALTER TABLE inventory_gear DROP FOREIGN KEY FK_41E29CB577201934');
        $this->addSql('ALTER TABLE inventory_gear ADD CONSTRAINT FK_41E29CB5FFE68A1B FOREIGN KEY (game_character_id) REFERENCES game_character (id)');
        $this->addSql('ALTER TABLE inventory_gear ADD CONSTRAINT FK_41E29CB577201934 FOREIGN KEY (gear_id) REFERENCES gear (id)');
        $this->addSql('ALTER TABLE inventory_item DROP FOREIGN KEY FK_55BDEA30FFE68A1B');
        $this->addSql('ALTER TABLE inventory_item DROP FOREIGN KEY FK_55BDEA30126F525E');
        $this->addSql('ALTER TABLE inventory_item ADD CONSTRAINT FK_55BDEA30FFE68A1B FOREIGN KEY (game_character_id) REFERENCES game_character (id)');
        $this->addSql('ALTER TABLE inventory_item ADD CONSTRAINT FK_55BDEA30126F525E FOREIGN KEY (item_id) REFERENCES item (id)');
        $this->addSql('ALTER TABLE inventory_weapon DROP FOREIGN KEY FK_69EF3B4DFFE68A1B');
        $this->addSql('ALTER TABLE inventory_weapon DROP FOREIGN KEY FK_69EF3B4D95B82273');
        $this->addSql('ALTER TABLE inventory_weapon ADD CONSTRAINT FK_69EF3B4DFFE68A1B FOREIGN KEY (game_character_id) REFERENCES game_character (id)');
        $this->addSql('ALTER TABLE inventory_weapon ADD CONSTRAINT FK_69EF3B4D95B82273 FOREIGN KEY (weapon_id) REFERENCES weapon (id)');
        $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251EE48FD905');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251EE48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE lore_block DROP FOREIGN KEY FK_2491ED4FE48FD905');
        $this->addSql('ALTER TABLE lore_block ADD CONSTRAINT FK_2491ED4FE48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE lore_block_element DROP FOREIGN KEY FK_45B9E4F0715F219A');
        $this->addSql('ALTER TABLE lore_block_element ADD CONSTRAINT FK_45B9E4F0715F219A FOREIGN KEY (lore_block_id) REFERENCES lore_block (id)');
        $this->addSql('ALTER TABLE lore_tag DROP FOREIGN KEY FK_E7067303E48FD905');
        $this->addSql('ALTER TABLE lore_tag ADD CONSTRAINT FK_E7067303E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE passive DROP FOREIGN KEY FK_76EFFDCFE48FD905');
        $this->addSql('ALTER TABLE passive ADD CONSTRAINT FK_76EFFDCFE48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE resource DROP FOREIGN KEY FK_BC91F416E48FD905');
        $this->addSql('ALTER TABLE resource ADD CONSTRAINT FK_BC91F416E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE resource_alteration DROP FOREIGN KEY FK_FFF8C04289329D25');
        $this->addSql('ALTER TABLE resource_alteration ADD CONSTRAINT FK_FFF8C04289329D25 FOREIGN KEY (resource_id) REFERENCES resource (id)');
        $this->addSql('ALTER TABLE skill DROP FOREIGN KEY FK_5E3DE477E48FD905');
        $this->addSql('ALTER TABLE skill ADD CONSTRAINT FK_5E3DE477E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE skill_cost DROP FOREIGN KEY FK_5F67084E89329D25');
        $this->addSql('ALTER TABLE skill_cost ADD CONSTRAINT FK_5F67084E89329D25 FOREIGN KEY (resource_id) REFERENCES resource (id)');
        $this->addSql('ALTER TABLE skill_damage_effect DROP FOREIGN KEY FK_4B06845DFAD8B02A');
        $this->addSql('ALTER TABLE skill_damage_effect DROP FOREIGN KEY FK_4B06845D89329D25');
        $this->addSql('ALTER TABLE skill_damage_effect ADD CONSTRAINT FK_4B06845DFAD8B02A FOREIGN KEY (damage_nature_id) REFERENCES damage_nature (id)');
        $this->addSql('ALTER TABLE skill_damage_effect ADD CONSTRAINT FK_4B06845D89329D25 FOREIGN KEY (resource_id) REFERENCES resource (id)');
        $this->addSql('ALTER TABLE skill_gain DROP FOREIGN KEY FK_97D4B1B289329D25');
        $this->addSql('ALTER TABLE skill_gain ADD CONSTRAINT FK_97D4B1B289329D25 FOREIGN KEY (resource_id) REFERENCES resource (id)');
        $this->addSql('ALTER TABLE skill_heal_effect DROP FOREIGN KEY FK_1623197589329D25');
        $this->addSql('ALTER TABLE skill_heal_effect ADD CONSTRAINT FK_1623197589329D25 FOREIGN KEY (resource_id) REFERENCES resource (id)');
        $this->addSql('ALTER TABLE skill_status_effect DROP FOREIGN KEY FK_E5B634037D7C387A');
        $this->addSql('ALTER TABLE skill_status_effect ADD CONSTRAINT FK_E5B634037D7C387A FOREIGN KEY (status_effect_id) REFERENCES status_effect (id)');
        $this->addSql('ALTER TABLE status_effect DROP FOREIGN KEY FK_B2A39BFE48FD905');
        $this->addSql('ALTER TABLE status_effect ADD CONSTRAINT FK_B2A39BFE48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE user_game DROP FOREIGN KEY FK_59AA7D45A76ED395');
        $this->addSql('ALTER TABLE user_game DROP FOREIGN KEY FK_59AA7D45E48FD905');
        $this->addSql('ALTER TABLE user_game ADD CONSTRAINT FK_59AA7D45A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_game ADD CONSTRAINT FK_59AA7D45E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE user_game_character DROP FOREIGN KEY FK_2A59AE6FBC82C70F');
        $this->addSql('ALTER TABLE user_game_character DROP FOREIGN KEY FK_2A59AE6FFFE68A1B');
        $this->addSql('ALTER TABLE user_game_character ADD CONSTRAINT FK_2A59AE6FBC82C70F FOREIGN KEY (user_game_id) REFERENCES user_game (id)');
        $this->addSql('ALTER TABLE user_game_character ADD CONSTRAINT FK_2A59AE6FFFE68A1B FOREIGN KEY (game_character_id) REFERENCES game_character (id)');
        $this->addSql('ALTER TABLE weapon DROP FOREIGN KEY FK_6933A7E6E48FD905');
        $this->addSql('ALTER TABLE weapon ADD CONSTRAINT FK_6933A7E6E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
    }
}
