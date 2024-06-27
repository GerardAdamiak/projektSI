<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240627112929 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Consolidated migration';
    }

    public function up(Schema $schema): void
    {

        $this->addSql('CREATE TABLE categories (
            id INT AUTO_INCREMENT NOT NULL,
            created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\',
            updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\',
            title VARCHAR(255) NOT NULL,
            slug VARCHAR(64) NOT NULL,
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        // Adding unique constraint on title column
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3AF3466876E3B90 ON categories (title)');
        // Create initial tables
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX email_idx (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE posts (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, author_id INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', title VARCHAR(255) NOT NULL, post_date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', content VARCHAR(1000) NOT NULL, INDEX IDX_885DBAFA12469DE2 (category_id), INDEX IDX_885DBAFAF675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('ALTER TABLE posts ADD CONSTRAINT FK_885DBAFA12469DE2 FOREIGN KEY (category_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE posts ADD CONSTRAINT FK_885DBAFAF675F31B FOREIGN KEY (author_id) REFERENCES users (id)');

        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_4C62E638E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE comments (id INT AUTO_INCREMENT NOT NULL, post_id INT NOT NULL, email VARCHAR(255) NOT NULL, nick VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_5F9E962A4B89032C (post_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A4B89032C FOREIGN KEY (post_id) REFERENCES posts (id)');
    }

    public function down(Schema $schema): void
    {
        // Drop tables in reverse order
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962A4B89032C');
        $this->addSql('DROP TABLE comments');

        $this->addSql('DROP TABLE contact');

        $this->addSql('ALTER TABLE posts DROP FOREIGN KEY FK_885DBAFA12469DE2');
        $this->addSql('ALTER TABLE posts DROP FOREIGN KEY FK_885DBAFAF675F31B');
        $this->addSql('DROP TABLE posts');

        $this->addSql('DROP TABLE users');
    }
}
