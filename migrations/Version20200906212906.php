<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200906212906 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE day (id INT AUTO_INCREMENT NOT NULL, location_id INT NOT NULL, date DATE NOT NULL, INDEX IDX_E5A0299064D218E (location_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE expenses (id INT AUTO_INCREMENT NOT NULL, day_id INT NOT NULL, name VARCHAR(255) NOT NULL, worth NUMERIC(10, 2) NOT NULL, date DATETIME NOT NULL, INDEX IDX_2496F35B9C24126 (day_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE location (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sold (id INT AUTO_INCREMENT NOT NULL, day_id INT NOT NULL, product VARCHAR(255) NOT NULL, price NUMERIC(10, 2) NOT NULL, purchse_price NUMERIC(10, 2) NOT NULL, facture TINYINT(1) NOT NULL, phone_model VARCHAR(255) NOT NULL, sale INT NOT NULL, date DATETIME NOT NULL, INDEX IDX_98D2DD999C24126 (day_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE worker (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, day_id INT NOT NULL, hour_start TIME NOT NULL, hour_end TIME NOT NULL, main_seller TINYINT(1) NOT NULL, INDEX IDX_9FB2BF62A76ED395 (user_id), INDEX IDX_9FB2BF629C24126 (day_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE day ADD CONSTRAINT FK_E5A0299064D218E FOREIGN KEY (location_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE expenses ADD CONSTRAINT FK_2496F35B9C24126 FOREIGN KEY (day_id) REFERENCES day (id)');
        $this->addSql('ALTER TABLE sold ADD CONSTRAINT FK_98D2DD999C24126 FOREIGN KEY (day_id) REFERENCES day (id)');
        $this->addSql('ALTER TABLE worker ADD CONSTRAINT FK_9FB2BF62A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE worker ADD CONSTRAINT FK_9FB2BF629C24126 FOREIGN KEY (day_id) REFERENCES day (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE expenses DROP FOREIGN KEY FK_2496F35B9C24126');
        $this->addSql('ALTER TABLE sold DROP FOREIGN KEY FK_98D2DD999C24126');
        $this->addSql('ALTER TABLE worker DROP FOREIGN KEY FK_9FB2BF629C24126');
        $this->addSql('ALTER TABLE day DROP FOREIGN KEY FK_E5A0299064D218E');
        $this->addSql('DROP TABLE day');
        $this->addSql('DROP TABLE expenses');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP TABLE sold');
        $this->addSql('DROP TABLE worker');
    }
}
