<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210526212127 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE groups (id INT NOT NULL, title VARCHAR(300) NOT NULL, country VARCHAR(3) DEFAULT NULL, date_add TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, thumb VARCHAR(300) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP TABLE "group"');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE "group" (id INT NOT NULL, title VARCHAR(300) NOT NULL, country VARCHAR(3) DEFAULT NULL, date_add TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, thumb VARCHAR(300) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP TABLE groups');
    }
}
