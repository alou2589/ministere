<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240308110101 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE affectation (id INT AUTO_INCREMENT NOT NULL, agent_id INT DEFAULT NULL, sous_structure_id INT DEFAULT NULL, poste_id INT DEFAULT NULL, status_affectation VARCHAR(255) DEFAULT NULL, INDEX IDX_F4DD61D33414710B (agent_id), INDEX IDX_F4DD61D39AA458EE (sous_structure_id), INDEX IDX_F4DD61D3A0905086 (poste_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE affectation ADD CONSTRAINT FK_F4DD61D33414710B FOREIGN KEY (agent_id) REFERENCES agent (id)');
        $this->addSql('ALTER TABLE affectation ADD CONSTRAINT FK_F4DD61D39AA458EE FOREIGN KEY (sous_structure_id) REFERENCES sous_structure (id)');
        $this->addSql('ALTER TABLE affectation ADD CONSTRAINT FK_F4DD61D3A0905086 FOREIGN KEY (poste_id) REFERENCES poste (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE affectation DROP FOREIGN KEY FK_F4DD61D33414710B');
        $this->addSql('ALTER TABLE affectation DROP FOREIGN KEY FK_F4DD61D39AA458EE');
        $this->addSql('ALTER TABLE affectation DROP FOREIGN KEY FK_F4DD61D3A0905086');
        $this->addSql('DROP TABLE affectation');
    }
}
