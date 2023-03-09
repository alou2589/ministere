<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230111160205 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE structure_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE structure (id INT NOT NULL, type_structure_id INT NOT NULL, nom_structure VARCHAR(255) NOT NULL, description_structure TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6F0137EAA277BA8E ON structure (type_structure_id)');
        $this->addSql('ALTER TABLE structure ADD CONSTRAINT FK_6F0137EAA277BA8E FOREIGN KEY (type_structure_id) REFERENCES type_structure (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE structure_id_seq CASCADE');
        $this->addSql('ALTER TABLE structure DROP CONSTRAINT FK_6F0137EAA277BA8E');
        $this->addSql('DROP TABLE structure');
    }
}
