<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231206135341 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE fichiers_agent (id INT AUTO_INCREMENT NOT NULL, type_fichier_id INT NOT NULL, agent_id INT NOT NULL, nom_fichier VARCHAR(255) NOT NULL, numero_dossier VARCHAR(255) NOT NULL, INDEX IDX_8C9BC2C312928ADB (type_fichier_id), INDEX IDX_8C9BC2C33414710B (agent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fichiers_agent ADD CONSTRAINT FK_8C9BC2C312928ADB FOREIGN KEY (type_fichier_id) REFERENCES type_fichier (id)');
        $this->addSql('ALTER TABLE fichiers_agent ADD CONSTRAINT FK_8C9BC2C33414710B FOREIGN KEY (agent_id) REFERENCES agent (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fichiers_agent DROP FOREIGN KEY FK_8C9BC2C312928ADB');
        $this->addSql('ALTER TABLE fichiers_agent DROP FOREIGN KEY FK_8C9BC2C33414710B');
        $this->addSql('DROP TABLE fichiers_agent');
    }
}
