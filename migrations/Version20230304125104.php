<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230304125104 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE historique_rh DROP CONSTRAINT fk_c1a8f4ef29f4b125');
        $this->addSql('DROP SEQUENCE type_action_id_seq CASCADE');
        $this->addSql('DROP TABLE type_action');
        $this->addSql('DROP INDEX idx_c1a8f4ef29f4b125');
        $this->addSql('ALTER TABLE historique_rh ADD type_action VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE historique_rh DROP type_action_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE type_action_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE type_action (id INT NOT NULL, nom_type_action VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE historique_rh ADD type_action_id INT NOT NULL');
        $this->addSql('ALTER TABLE historique_rh DROP type_action');
        $this->addSql('ALTER TABLE historique_rh ADD CONSTRAINT fk_c1a8f4ef29f4b125 FOREIGN KEY (type_action_id) REFERENCES type_action (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_c1a8f4ef29f4b125 ON historique_rh (type_action_id)');
    }
}
