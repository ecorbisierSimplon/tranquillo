<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240416163340 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tpa_tasks DROP FOREIGN KEY FK_A175781ED373EA13');
        $this->addSql('DROP INDEX IDX_A175781ED373EA13 ON tpa_tasks');
        $this->addSql('ALTER TABLE tpa_tasks CHANGE users_email_id users_id INT NOT NULL');
        $this->addSql('ALTER TABLE tpa_tasks ADD CONSTRAINT FK_A175781ED373EA13 FOREIGN KEY (users_id) REFERENCES tpa_users (id)');
        $this->addSql('CREATE INDEX IDX_A175781ED373EA13 ON tpa_tasks (users_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tpa_tasks DROP FOREIGN KEY FK_A175781ED373EA13');
        $this->addSql('DROP INDEX IDX_A175781ED373EA13 ON tpa_tasks');
        $this->addSql('ALTER TABLE tpa_tasks CHANGE users_id users_email_id INT NOT NULL');
        $this->addSql('ALTER TABLE tpa_tasks ADD CONSTRAINT FK_A175781ED373EA13 FOREIGN KEY (users_email_id) REFERENCES tpa_users (id)');
        $this->addSql('CREATE INDEX IDX_A175781ED373EA13 ON tpa_tasks (users_email_id)');
    }
}