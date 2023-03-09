<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230111160412 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE sous_structure_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE sous_structure (id INT NOT NULL, type_sous_structure_id INT NOT NULL, structure_id INT NOT NULL, nom_sous_structure VARCHAR(255) NOT NULL, description_sous_structure TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7408DCA526954475 ON sous_structure (type_sous_structure_id)');
        $this->addSql('CREATE INDEX IDX_7408DCA52534008B ON sous_structure (structure_id)');
        $this->addSql('ALTER TABLE sous_structure ADD CONSTRAINT FK_7408DCA526954475 FOREIGN KEY (type_sous_structure_id) REFERENCES type_sous_structure (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE sous_structure ADD CONSTRAINT FK_7408DCA52534008B FOREIGN KEY (structure_id) REFERENCES structure (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE sous_structure_id_seq CASCADE');
        $this->addSql('ALTER TABLE sous_structure DROP CONSTRAINT FK_7408DCA526954475');
        $this->addSql('ALTER TABLE sous_structure DROP CONSTRAINT FK_7408DCA52534008B');
        $this->addSql('DROP TABLE sous_structure');
    }
}
