<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230329144012 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE movie ADD COLUMN rated VARCHAR(15) DEFAULT NULL');
        $this->addSql('ALTER TABLE movie ADD COLUMN imdb_id VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__movie AS SELECT id, title, poster, plot, released_at, country, price FROM movie');
        $this->addSql('DROP TABLE movie');
        $this->addSql('CREATE TABLE movie (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, poster VARCHAR(255) NOT NULL, plot CLOB NOT NULL, released_at DATE NOT NULL --(DC2Type:date_immutable)
        , country VARCHAR(255) NOT NULL, price INTEGER DEFAULT NULL)');
        $this->addSql('INSERT INTO movie (id, title, poster, plot, released_at, country, price) SELECT id, title, poster, plot, released_at, country, price FROM __temp__movie');
        $this->addSql('DROP TABLE __temp__movie');
    }
}