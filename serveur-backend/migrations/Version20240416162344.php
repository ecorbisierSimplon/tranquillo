<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240416162344 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tpa_roles (id INT AUTO_INCREMENT NOT NULL, role_code VARCHAR(50) NOT NULL, role_name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tpa_tasks (id INT AUTO_INCREMENT NOT NULL, users_email_id INT NOT NULL, task_name VARCHAR(50) NOT NULL, task_create_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', task_description LONGTEXT NOT NULL, tpa_description LONGTEXT DEFAULT NULL, task_reminder INT DEFAULT NULL, task_start_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', task_end_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_A175781ED373EA13 (users_email_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tpa_tasks ADD CONSTRAINT FK_A175781ED373EA13 FOREIGN KEY (users_email_id) REFERENCES tpa_users (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tpa_tasks DROP FOREIGN KEY FK_A175781ED373EA13');
        $this->addSql('DROP TABLE tpa_roles');
        $this->addSql('DROP TABLE tpa_tasks');
    }
}
