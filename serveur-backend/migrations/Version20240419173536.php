<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240419173536 extends AbstractMigration
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
        $this->addSql('CREATE TABLE tpa_users (id INT AUTO_INCREMENT NOT NULL, roles_id INT DEFAULT NULL, email VARCHAR(50) NOT NULL, lastname VARCHAR(50) NOT NULL, firstname VARCHAR(50) NOT NULL, user_password VARCHAR(50) NOT NULL, user_create_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX tpa_users_email_ikey (email), INDEX tpa_roles_id_users_ikey (roles_id), INDEX tpa_users_create_at_ikey (user_create_at), UNIQUE INDEX tpa_users_email_ukey (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tpa_subtasks ADD CONSTRAINT FK_7EBC9ADAE3272D31 FOREIGN KEY (tasks_id) REFERENCES tpa_tasks (id)');
        $this->addSql('ALTER TABLE tpa_tasks ADD CONSTRAINT FK_A175781E67B3B43D FOREIGN KEY (users_id) REFERENCES tpa_users (id)');
        $this->addSql('ALTER TABLE tpa_users ADD CONSTRAINT FK_E5AEB86038C751C4 FOREIGN KEY (roles_id) REFERENCES tpa_roles (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tpa_subtasks DROP FOREIGN KEY FK_7EBC9ADAE3272D31');
        $this->addSql('ALTER TABLE tpa_tasks DROP FOREIGN KEY FK_A175781E67B3B43D');
        $this->addSql('ALTER TABLE tpa_users DROP FOREIGN KEY FK_E5AEB86038C751C4');
        $this->addSql('DROP TABLE tpa_roles');
        $this->addSql('DROP TABLE tpa_subtasks');
        $this->addSql('DROP TABLE tpa_tasks');
        $this->addSql('DROP TABLE tpa_users');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
