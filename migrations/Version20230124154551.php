<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230124154551 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE type_materiel_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE type_materiel (id INT NOT NULL, categorie_matos_id INT NOT NULL, nom_type_matos VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D52D976D50D1D023 ON type_materiel (categorie_matos_id)');
        $this->addSql('ALTER TABLE type_materiel ADD CONSTRAINT FK_D52D976D50D1D023 FOREIGN KEY (categorie_matos_id) REFERENCES categorie_materiel (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE type_materiel_id_seq CASCADE');
        $this->addSql('ALTER TABLE type_materiel DROP CONSTRAINT FK_D52D976D50D1D023');
        $this->addSql('DROP TABLE type_materiel');
    }
}
