<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201108110626 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE action DROP FOREIGN KEY FK_47CC8C92C9732719');
        $this->addSql('ALTER TABLE action ADD CONSTRAINT FK_47CC8C92C9732719 FOREIGN KEY (battle_id) REFERENCES battle (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE target DROP FOREIGN KEY FK_466F2FFC9D32F035');
        $this->addSql('ALTER TABLE target DROP FOREIGN KEY FK_466F2FFCFFE68A1B');
        $this->addSql('ALTER TABLE target ADD CONSTRAINT FK_466F2FFC9D32F035 FOREIGN KEY (action_id) REFERENCES action (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE target ADD CONSTRAINT FK_466F2FFCFFE68A1B FOREIGN KEY (game_character_id) REFERENCES game_character (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE action DROP FOREIGN KEY FK_47CC8C92C9732719');
        $this->addSql('ALTER TABLE action ADD CONSTRAINT FK_47CC8C92C9732719 FOREIGN KEY (battle_id) REFERENCES battle (id)');
        $this->addSql('ALTER TABLE target DROP FOREIGN KEY FK_466F2FFCFFE68A1B');
        $this->addSql('ALTER TABLE target DROP FOREIGN KEY FK_466F2FFC9D32F035');
        $this->addSql('ALTER TABLE target ADD CONSTRAINT FK_466F2FFCFFE68A1B FOREIGN KEY (game_character_id) REFERENCES game_character (id)');
        $this->addSql('ALTER TABLE target ADD CONSTRAINT FK_466F2FFC9D32F035 FOREIGN KEY (action_id) REFERENCES action (id)');
    }
}
