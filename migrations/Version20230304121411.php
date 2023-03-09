<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230304121411 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE historique_rh_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE type_action_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE historique_rh (id INT NOT NULL, type_action_id INT NOT NULL, date_action TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C1A8F4EF29F4B125 ON historique_rh (type_action_id)');
        $this->addSql('CREATE TABLE type_action (id INT NOT NULL, nom_type_action VARCHAR(255) NOT NULL, date_action TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE historique_rh ADD CONSTRAINT FK_C1A8F4EF29F4B125 FOREIGN KEY (type_action_id) REFERENCES type_action (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE historique_rh_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE type_action_id_seq CASCADE');
        $this->addSql('ALTER TABLE historique_rh DROP CONSTRAINT FK_C1A8F4EF29F4B125');
        $this->addSql('DROP TABLE historique_rh');
        $this->addSql('DROP TABLE type_action');
    }
}
