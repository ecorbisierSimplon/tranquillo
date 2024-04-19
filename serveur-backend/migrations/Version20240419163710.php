<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240419163710 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tpa_roles (id INT AUTO_INCREMENT NOT NULL, role_code VARCHAR(50) NOT NULL, role_name VARCHAR(50) NOT NULL, INDEX tpa_roles_code_ikey (role_code), UNIQUE INDEX tpa_roles_code_ukey (role_code), UNIQUE INDEX tpa_roles_name_ukey (role_name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tpa_subtasks (id INT AUTO_INCREMENT NOT NULL, tasks_id INT NOT NULL, subtask_name VARCHAR(100) NOT NULL, subtask_create_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', subtask_order INT DEFAULT NULL, subtask_is_finished TINYINT(1) DEFAULT NULL, INDEX tpa_subtasks_name_ikey (subtask_name), INDEX tpa_subtasks_create_at_ikey (subtask_create_at), INDEX tpa_tasks_id_substask_ikey (tasks_id), UNIQUE INDEX tpa_subtasks_name_tasks_id_ukey (subtask_name, tasks_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tpa_tasks (id INT AUTO_INCREMENT NOT NULL, users_id INT NOT NULL, task_name VARCHAR(100) NOT NULL, task_create_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', task_description LONGTEXT NOT NULL, task_reminder INT DEFAULT NULL, task_start_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', task_end_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX tpa_users_id_tasks_ikey (users_id), INDEX tpa_tasks_name_ikey (task_name), INDEX tpa_tasks_create_at_ikey (task_create_at), UNIQUE INDEX tpa_tasks_name_roles_id_ukey (task_name, users_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tpa_subtasks ADD CONSTRAINT FK_7EBC9ADAE3272D31 FOREIGN KEY (tasks_id) REFERENCES tpa_tasks (id)');
        $this->addSql('ALTER TABLE tpa_tasks ADD CONSTRAINT FK_A175781E67B3B43D FOREIGN KEY (users_id) REFERENCES tpa_users (id)');
        $this->addSql('ALTER TABLE tpa_users ADD roles_id INT DEFAULT NULL, ADD email VARCHAR(50) NOT NULL, ADD lastname VARCHAR(50) NOT NULL, ADD firstname VARCHAR(50) NOT NULL, ADD user_password VARCHAR(50) NOT NULL, ADD user_create_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE tpa_users ADD CONSTRAINT FK_E5AEB86038C751C4 FOREIGN KEY (roles_id) REFERENCES tpa_roles (id)');
        $this->addSql('CREATE INDEX tpa_users_email_ikey ON tpa_users (email)');
        $this->addSql('CREATE INDEX tpa_roles_id_users_ikey ON tpa_users (roles_id)');
        $this->addSql('CREATE INDEX tpa_users_create_at_ikey ON tpa_users (user_create_at)');
        $this->addSql('CREATE UNIQUE INDEX tpa_users_email_ukey ON tpa_users (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tpa_users DROP FOREIGN KEY FK_E5AEB86038C751C4');
        $this->addSql('ALTER TABLE tpa_subtasks DROP FOREIGN KEY FK_7EBC9ADAE3272D31');
        $this->addSql('ALTER TABLE tpa_tasks DROP FOREIGN KEY FK_A175781E67B3B43D');
        $this->addSql('DROP TABLE tpa_roles');
        $this->addSql('DROP TABLE tpa_subtasks');
        $this->addSql('DROP TABLE tpa_tasks');
        $this->addSql('DROP INDEX tpa_users_email_ikey ON tpa_users');
        $this->addSql('DROP INDEX tpa_roles_id_users_ikey ON tpa_users');
        $this->addSql('DROP INDEX tpa_users_create_at_ikey ON tpa_users');
        $this->addSql('DROP INDEX tpa_users_email_ukey ON tpa_users');
        $this->addSql('ALTER TABLE tpa_users DROP roles_id, DROP email, DROP lastname, DROP firstname, DROP user_password, DROP user_create_at');
    }
}
