<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240422114130 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE conge_absence (id INT AUTO_INCREMENT NOT NULL, tyÃpe_absence_id INT NOT NULL, statut_agent_id INT NOT NULL, operateur_id INT NOT NULL, nombre_jours INT NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, fichier VARCHAR(255) DEFAULT NULL, INDEX IDX_A6D6BB6A65F4147 (tyÃpe_absence_id), INDEX IDX_A6D6BB6A4B12CDAA (statut_agent_id), INDEX IDX_A6D6BB6A3F192FC (operateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE conge_absence ADD CONSTRAINT FK_A6D6BB6A65F4147 FOREIGN KEY (tyÃpe_absence_id) REFERENCES type_absence (id)');
        $this->addSql('ALTER TABLE conge_absence ADD CONSTRAINT FK_A6D6BB6A4B12CDAA FOREIGN KEY (statut_agent_id) REFERENCES statut_agent (id)');
        $this->addSql('ALTER TABLE conge_absence ADD CONSTRAINT FK_A6D6BB6A3F192FC FOREIGN KEY (operateur_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE conge_absence DROP FOREIGN KEY FK_A6D6BB6A65F4147');
        $this->addSql('ALTER TABLE conge_absence DROP FOREIGN KEY FK_A6D6BB6A4B12CDAA');
        $this->addSql('ALTER TABLE conge_absence DROP FOREIGN KEY FK_A6D6BB6A3F192FC');
        $this->addSql('DROP TABLE conge_absence');
    }
}
