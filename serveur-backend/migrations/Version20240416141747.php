<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240416141747 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tpa_subtasks DROP FOREIGN KEY tpa_subtasks_tasks_fkey');
        $this->addSql('ALTER TABLE tpa_tasks DROP FOREIGN KEY tpa_tasks_users_fkey');
        $this->addSql('ALTER TABLE tpa_users DROP FOREIGN KEY tpa_users_tpa_roles_fkey');
        $this->addSql('DROP TABLE tpa_subtasks');
        $this->addSql('DROP TABLE tpa_roles');
        $this->addSql('DROP TABLE tpa_tasks');
        $this->addSql('DROP TABLE tpa_users');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tpa_subtasks (subtask_id INT AUTO_INCREMENT NOT NULL, tasks_id INT NOT NULL, subtask_name VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, subtask_datetime_create DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, subtask_order INT NOT NULL, is_finished INT NOT NULL, UNIQUE INDEX tpa_subtasks_ukey (subtask_name, subtask_datetime_create), INDEX tpa_subtasks_tasks_fkey (tasks_id), PRIMARY KEY(subtask_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE tpa_roles (role_id INT AUTO_INCREMENT NOT NULL, role_code VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, role_name VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, UNIQUE INDEX tpa_roles_code_ukey (role_code), PRIMARY KEY(role_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE tpa_tasks (task_id INT AUTO_INCREMENT NOT NULL, users_id INT NOT NULL, task_name VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, task_datetime_create DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, task_description TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, reminder VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, datetime_start DATETIME DEFAULT NULL, datetime_end DATETIME DEFAULT NULL, INDEX tpa_tasks_users_fkey (users_id), UNIQUE INDEX tpa_tasks_ukey (task_name, task_datetime_create), PRIMARY KEY(task_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE tpa_users (user_id INT AUTO_INCREMENT NOT NULL, roles_id INT NOT NULL, email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, lastname VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, firstname VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, user_password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, UNIQUE INDEX tpa_users_ukey (email), INDEX tpa_users_tpa_roles_fkey (roles_id), PRIMARY KEY(user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE tpa_subtasks ADD CONSTRAINT tpa_subtasks_tasks_fkey FOREIGN KEY (tasks_id) REFERENCES tpa_tasks (task_id)');
        $this->addSql('ALTER TABLE tpa_tasks ADD CONSTRAINT tpa_tasks_users_fkey FOREIGN KEY (users_id) REFERENCES tpa_users (user_id)');
        $this->addSql('ALTER TABLE tpa_users ADD CONSTRAINT tpa_users_tpa_roles_fkey FOREIGN KEY (roles_id) REFERENCES tpa_roles (role_id)');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
