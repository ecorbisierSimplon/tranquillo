<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240502123046 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tpa_subtasks DROP FOREIGN KEY tpa_subtasks_tasks_fkey');
        $this->addSql('DROP TABLE tpa_subtasks');
        $this->addSql('ALTER TABLE tpa_tasks DROP FOREIGN KEY tpa_tasks_users_fkey');
        $this->addSql('DROP INDEX tpa_tasks_ukey ON tpa_tasks');
        $this->addSql('ALTER TABLE tpa_tasks CHANGE users_id users_id VARCHAR(255) NOT NULL, CHANGE task_name task_name VARCHAR(255) NOT NULL, CHANGE task_description task_description VARCHAR(255) NOT NULL, CHANGE task_reminder task_reminder INT NOT NULL, CHANGE task_start_at task_start_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE task_end_at task_end_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE task_create_at task_create_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE tpa_tasks RENAME INDEX tpa_tasks_users_fkey TO tpa_users_id_tasks_ikey');
        $this->addSql('DROP INDEX tpa_users_lastname_ikey ON tpa_users');
        $this->addSql('DROP INDEX tpa_users_firstname_ikey ON tpa_users');
        $this->addSql('DROP INDEX tpa_users_ukey ON tpa_users');
        $this->addSql('DROP INDEX tpa_users_create_at_ikey ON tpa_users');
        $this->addSql('DROP INDEX tpa_users_email_ikey ON tpa_users');
        $this->addSql('ALTER TABLE tpa_users CHANGE email email VARCHAR(255) NOT NULL, CHANGE lastname lastname VARCHAR(255) NOT NULL, CHANGE firstname firstname VARCHAR(255) NOT NULL, CHANGE user_role user_role JSON NOT NULL COMMENT \'(DC2Type:json)\', CHANGE user_create_at user_create_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tpa_subtasks (subtask_id INT AUTO_INCREMENT NOT NULL, tasks_id INT NOT NULL, subtask_name VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, subtask_create_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, subtask_order INT DEFAULT NULL, is_finished INT NOT NULL, INDEX tpa_subtasks_create_at_ikey (subtask_create_at), INDEX tpa_subtasks_tasks_fkey (tasks_id), INDEX tpa_subtasks_name_ikey (subtask_name), UNIQUE INDEX tpa_subtasks_ukey (subtask_name, subtask_create_at), PRIMARY KEY(subtask_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE tpa_subtasks ADD CONSTRAINT tpa_subtasks_tasks_fkey FOREIGN KEY (tasks_id) REFERENCES tpa_tasks (task_id)');
        $this->addSql('ALTER TABLE tpa_tasks CHANGE task_name task_name VARCHAR(50) NOT NULL, CHANGE task_description task_description TEXT DEFAULT NULL, CHANGE task_reminder task_reminder INT DEFAULT NULL, CHANGE task_start_at task_start_at DATETIME DEFAULT NULL, CHANGE task_end_at task_end_at DATETIME DEFAULT NULL, CHANGE task_create_at task_create_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE users_id users_id INT NOT NULL');
        $this->addSql('ALTER TABLE tpa_tasks ADD CONSTRAINT tpa_tasks_users_fkey FOREIGN KEY (users_id) REFERENCES tpa_users (user_id)');
        $this->addSql('CREATE UNIQUE INDEX tpa_tasks_ukey ON tpa_tasks (task_name, task_create_at)');
        $this->addSql('ALTER TABLE tpa_tasks RENAME INDEX tpa_users_id_tasks_ikey TO tpa_tasks_users_fkey');
        $this->addSql('ALTER TABLE tpa_users CHANGE email email VARCHAR(180) NOT NULL, CHANGE user_role user_role VARCHAR(255) DEFAULT NULL, CHANGE lastname lastname VARCHAR(50) NOT NULL, CHANGE firstname firstname VARCHAR(50) NOT NULL, CHANGE user_create_at user_create_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('CREATE INDEX tpa_users_lastname_ikey ON tpa_users (lastname)');
        $this->addSql('CREATE INDEX tpa_users_firstname_ikey ON tpa_users (firstname)');
        $this->addSql('CREATE UNIQUE INDEX tpa_users_ukey ON tpa_users (email)');
        $this->addSql('CREATE INDEX tpa_users_create_at_ikey ON tpa_users (user_create_at)');
        $this->addSql('CREATE INDEX tpa_users_email_ikey ON tpa_users (email)');
    }
}
