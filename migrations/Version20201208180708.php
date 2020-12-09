<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201208180708 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE book_translations (id SERIAL NOT NULL, object_id INT DEFAULT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9F5610DF232D562B ON book_translations (object_id)');
        $this->addSql('CREATE UNIQUE INDEX lookup_unique_idx ON book_translations (locale, object_id, field)');
        $this->addSql('ALTER TABLE book_translations ADD CONSTRAINT FK_9F5610DF232D562B FOREIGN KEY (object_id) REFERENCES book (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE book_translations');
    }
}
