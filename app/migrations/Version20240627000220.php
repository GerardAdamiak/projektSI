<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240627000220 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS comments');
        // This up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE comments (
            id INT AUTO_INCREMENT NOT NULL,
            post_id INT NOT NULL,
            email VARCHAR(255) NOT NULL,
            nick VARCHAR(255) NOT NULL,
            content LONGTEXT NOT NULL,
            INDEX IDX_5F9E962A4B89032C (post_id),
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A4B89032C FOREIGN KEY (post_id) REFERENCES posts (id)');
    }

    public function down(Schema $schema): void
    {
        // This down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE comments');
    }
}