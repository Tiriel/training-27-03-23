<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230328101659 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE genre (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, poster VARCHAR(255) DEFAULT NULL)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__comment AS SELECT id, title, email, content, published_at, author FROM comment');
        $this->addSql('DROP TABLE comment');
        $this->addSql('CREATE TABLE comment (id VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, content CLOB NOT NULL, published_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , author VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO comment (id, title, email, content, published_at, author) SELECT id, title, email, content, published_at, author FROM __temp__comment');
        $this->addSql('DROP TABLE __temp__comment');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE genre');
        $this->addSql('CREATE TEMPORARY TABLE __temp__comment AS SELECT id, title, email, content, published_at, author FROM comment');
        $this->addSql('DROP TABLE comment');
        $this->addSql('CREATE TABLE comment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, content CLOB NOT NULL, published_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , author VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO comment (id, title, email, content, published_at, author) SELECT id, title, email, content, published_at, author FROM __temp__comment');
        $this->addSql('DROP TABLE __temp__comment');
    }
}
