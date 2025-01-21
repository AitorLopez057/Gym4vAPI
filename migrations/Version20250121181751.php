<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250121181751 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE activity_monitor (id INT AUTO_INCREMENT NOT NULL, activity_id INT DEFAULT NULL, monitor_id INT DEFAULT NULL, INDEX IDX_E147EF6581C06096 (activity_id), INDEX IDX_E147EF654CE1C902 (monitor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE activity_monitor ADD CONSTRAINT FK_E147EF6581C06096 FOREIGN KEY (activity_id) REFERENCES activity (id)');
        $this->addSql('ALTER TABLE activity_monitor ADD CONSTRAINT FK_E147EF654CE1C902 FOREIGN KEY (monitor_id) REFERENCES monitor (id)');
        $this->addSql('ALTER TABLE activity ADD activity_type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE activity ADD CONSTRAINT FK_AC74095AC51EFA73 FOREIGN KEY (activity_type_id) REFERENCES activity_type (id)');
        $this->addSql('CREATE INDEX IDX_AC74095AC51EFA73 ON activity (activity_type_id)');
        $this->addSql('ALTER TABLE activity_type DROP FOREIGN KEY FK_8F1A8CBB81C06096');
        $this->addSql('DROP INDEX IDX_8F1A8CBB81C06096 ON activity_type');
        $this->addSql('ALTER TABLE activity_type DROP activity_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activity_monitor DROP FOREIGN KEY FK_E147EF6581C06096');
        $this->addSql('ALTER TABLE activity_monitor DROP FOREIGN KEY FK_E147EF654CE1C902');
        $this->addSql('DROP TABLE activity_monitor');
        $this->addSql('ALTER TABLE activity DROP FOREIGN KEY FK_AC74095AC51EFA73');
        $this->addSql('DROP INDEX IDX_AC74095AC51EFA73 ON activity');
        $this->addSql('ALTER TABLE activity DROP activity_type_id');
        $this->addSql('ALTER TABLE activity_type ADD activity_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE activity_type ADD CONSTRAINT FK_8F1A8CBB81C06096 FOREIGN KEY (activity_id) REFERENCES activity (id)');
        $this->addSql('CREATE INDEX IDX_8F1A8CBB81C06096 ON activity_type (activity_id)');
    }
}
