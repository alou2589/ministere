<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230124162125 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE materiel_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE materiel (id INT NOT NULL, type_matos_id INT NOT NULL, modele_matos VARCHAR(255) NOT NULL, sn_matos VARCHAR(255) NOT NULL, stockage_matos VARCHAR(255) DEFAULT NULL, ram_matos VARCHAR(255) DEFAULT NULL, os_matos VARCHAR(255) DEFAULT NULL, processeur_matos VARCHAR(255) DEFAULT NULL, date_reception TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_18D2B091A5A9B6B5 ON materiel (type_matos_id)');
        $this->addSql('ALTER TABLE materiel ADD CONSTRAINT FK_18D2B091A5A9B6B5 FOREIGN KEY (type_matos_id) REFERENCES type_materiel (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE materiel_id_seq CASCADE');
        $this->addSql('ALTER TABLE materiel DROP CONSTRAINT FK_18D2B091A5A9B6B5');
        $this->addSql('DROP TABLE materiel');
    }
}
