<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240416223638 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX tpa_tasks_ukey ON tpa_tasks');
        $this->addSql('CREATE UNIQUE INDEX tpa_tasks_name_roles_id_ukey ON tpa_tasks (task_name, users_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX tpa_tasks_name_roles_id_ukey ON tpa_tasks');
        $this->addSql('CREATE UNIQUE INDEX tpa_tasks_ukey ON tpa_tasks (task_name, task_create_at)');
    }
}
