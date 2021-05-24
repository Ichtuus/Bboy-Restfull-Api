<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210524194722 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE artists_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE group_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE artists (id INT NOT NULL, artists_name VARCHAR(150) NOT NULL, country VARCHAR(3) DEFAULT NULL, date_add TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, thumb VARCHAR(400) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE "group" (id INT NOT NULL, title VARCHAR(300) NOT NULL, country VARCHAR(3) DEFAULT NULL, date_add TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, thumb VARCHAR(300) DEFAULT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE artists_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE group_id_seq CASCADE');
        $this->addSql('DROP TABLE artists');
        $this->addSql('DROP TABLE "group"');
    }
}
