<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230328135643 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE book_book_genre (book_id INTEGER NOT NULL, book_genre_id VARCHAR(255) NOT NULL, PRIMARY KEY(book_id, book_genre_id), CONSTRAINT FK_123F6C3216A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_123F6C325B69C546 FOREIGN KEY (book_genre_id) REFERENCES book_genre (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_123F6C3216A2B381 ON book_book_genre (book_id)');
        $this->addSql('CREATE INDEX IDX_123F6C325B69C546 ON book_book_genre (book_genre_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__comment AS SELECT id, title, email, content, published_at, author FROM comment');
        $this->addSql('DROP TABLE comment');
        $this->addSql('CREATE TABLE comment (id VARCHAR(255) NOT NULL, book_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, content CLOB NOT NULL, published_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , author VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id), CONSTRAINT FK_9474526C16A2B381 FOREIGN KEY (book_id) REFERENCES book (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO comment (id, title, email, content, published_at, author) SELECT id, title, email, content, published_at, author FROM __temp__comment');
        $this->addSql('DROP TABLE __temp__comment');
        $this->addSql('CREATE INDEX IDX_9474526C16A2B381 ON comment (book_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE book_book_genre');
        $this->addSql('CREATE TEMPORARY TABLE __temp__comment AS SELECT id, title, email, content, published_at, author FROM comment');
        $this->addSql('DROP TABLE comment');
        $this->addSql('CREATE TABLE comment (id VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, content CLOB NOT NULL, published_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , author VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO comment (id, title, email, content, published_at, author) SELECT id, title, email, content, published_at, author FROM __temp__comment');
        $this->addSql('DROP TABLE __temp__comment');
    }
}
