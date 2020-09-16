<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200913203444 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE worker DROP FOREIGN KEY FK_9FB2BF629C24126');
        $this->addSql('DROP INDEX IDX_9FB2BF629C24126 ON worker');
        $this->addSql('ALTER TABLE worker DROP day_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE worker ADD day_id INT NOT NULL');
        $this->addSql('ALTER TABLE worker ADD CONSTRAINT FK_9FB2BF629C24126 FOREIGN KEY (day_id) REFERENCES day (id)');
        $this->addSql('CREATE INDEX IDX_9FB2BF629C24126 ON worker (day_id)');
    }
}
