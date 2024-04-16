<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240416164625 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tpa_subtasks (id INT AUTO_INCREMENT NOT NULL, tasks_id INT NOT NULL, subtask_name VARCHAR(50) NOT NULL, subtask_create_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', substask_order INT DEFAULT NULL, subtask_is_finished TINYINT(1) DEFAULT NULL, INDEX IDX_7EBC9ADAE3272D31 (tasks_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tpa_subtasks ADD CONSTRAINT FK_7EBC9ADAE3272D31 FOREIGN KEY (tasks_id) REFERENCES tpa_tasks (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tpa_subtasks DROP FOREIGN KEY FK_7EBC9ADAE3272D31');
        $this->addSql('DROP TABLE tpa_subtasks');
    }
}
