<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240623115212 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE posts CHANGE event_date post_date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE posts RENAME INDEX idx_5387574a12469de2 TO IDX_885DBAFA12469DE2');
        $this->addSql('ALTER TABLE posts RENAME INDEX idx_5387574af675f31b TO IDX_885DBAFAF675F31B');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE posts CHANGE post_date event_date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE posts RENAME INDEX idx_885dbafa12469de2 TO IDX_5387574A12469DE2');
        $this->addSql('ALTER TABLE posts RENAME INDEX idx_885dbafaf675f31b TO IDX_5387574AF675F31B');
    }
}
