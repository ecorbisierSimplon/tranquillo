<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240416224027 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX tpa_subtasks_name_create_at_ukey ON tpa_subtasks');
        $this->addSql('CREATE UNIQUE INDEX tpa_subtasks_name_tasks_id_ukey ON tpa_subtasks (subtask_name, tasks_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX tpa_subtasks_name_tasks_id_ukey ON tpa_subtasks');
        $this->addSql('CREATE UNIQUE INDEX tpa_subtasks_name_create_at_ukey ON tpa_subtasks (subtask_name, subtask_create_at)');
    }
}
