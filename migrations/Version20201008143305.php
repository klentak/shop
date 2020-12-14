<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201008143305 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `limit` (id INT AUTO_INCREMENT NOT NULL, location_id INT NOT NULL, worth NUMERIC(10, 2) NOT NULL, date_start DATE NOT NULL, date_end DATE NOT NULL, INDEX IDX_7F96E86064D218E (location_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, location_id INT NOT NULL, worth NUMERIC(10, 2) NOT NULL, date DATE NOT NULL, transport TINYINT(1) NOT NULL, INDEX IDX_F529939864D218E (location_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `limit` ADD CONSTRAINT FK_7F96E86064D218E FOREIGN KEY (location_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F529939864D218E FOREIGN KEY (location_id) REFERENCES location (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE `limit`');
        $this->addSql('DROP TABLE `order`');
    }
}
