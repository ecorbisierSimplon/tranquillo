<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240416162912 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tpa_users ADD roles_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tpa_users ADD CONSTRAINT FK_E5AEB86038C751C4 FOREIGN KEY (roles_id) REFERENCES tpa_roles (id)');
        $this->addSql('CREATE INDEX IDX_E5AEB86038C751C4 ON tpa_users (roles_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tpa_users DROP FOREIGN KEY FK_E5AEB86038C751C4');
        $this->addSql('DROP INDEX IDX_E5AEB86038C751C4 ON tpa_users');
        $this->addSql('ALTER TABLE tpa_users DROP roles_id');
    }
}
