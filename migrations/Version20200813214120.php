<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200813214120 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_19E62F8412469DE2');
        $this->addSql('CREATE TEMPORARY TABLE __temp__bidding AS SELECT id, category_id, name, content, image, expire_at FROM bidding');
        $this->addSql('DROP TABLE bidding');
        $this->addSql('CREATE TABLE bidding (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, category_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, content CLOB NOT NULL COLLATE BINARY, image VARCHAR(255) NOT NULL COLLATE BINARY, expire_at DATETIME NOT NULL, CONSTRAINT FK_19E62F8412469DE2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO bidding (id, category_id, name, content, image, expire_at) SELECT id, category_id, name, content, image, expire_at FROM __temp__bidding');
        $this->addSql('DROP TABLE __temp__bidding');
        $this->addSql('CREATE INDEX IDX_19E62F8412469DE2 ON bidding (category_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_19E62F8412469DE2');
        $this->addSql('CREATE TEMPORARY TABLE __temp__bidding AS SELECT id, category_id, name, content, image, expire_at FROM bidding');
        $this->addSql('DROP TABLE bidding');
        $this->addSql('CREATE TABLE bidding (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, category_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, content CLOB NOT NULL, image VARCHAR(255) NOT NULL, expire_at DATETIME DEFAULT NULL)');
        $this->addSql('INSERT INTO bidding (id, category_id, name, content, image, expire_at) SELECT id, category_id, name, content, image, expire_at FROM __temp__bidding');
        $this->addSql('DROP TABLE __temp__bidding');
        $this->addSql('CREATE INDEX IDX_19E62F8412469DE2 ON bidding (category_id)');
    }
}
