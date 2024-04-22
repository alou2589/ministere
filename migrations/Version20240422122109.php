<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240422122109 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE conge_absence ADD type_absence_id INT NOT NULL, ADD nombre_jour INT NOT NULL, DROP ty?pe_absence_id, DROP nombre_jours, CHANGE fichier fichier VARCHAR(255) NOT NULL, CHANGE date_fin date�_fi DATE NOT NULL');
        $this->addSql('ALTER TABLE conge_absence ADD CONSTRAINT FK_A6D6BB6A30FCF5AA FOREIGN KEY (type_absence_id) REFERENCES type_absence (id)');
        $this->addSql('CREATE INDEX IDX_A6D6BB6A30FCF5AA ON conge_absence (type_absence_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE conge_absence DROP FOREIGN KEY FK_A6D6BB6A30FCF5AA');
        $this->addSql('DROP INDEX IDX_A6D6BB6A30FCF5AA ON conge_absence');
        $this->addSql('ALTER TABLE conge_absence ADD ty?pe_absence_id INT NOT NULL, ADD nombre_jours INT NOT NULL, DROP type_absence_id, DROP nombre_jour, CHANGE fichier fichier VARCHAR(255) DEFAULT NULL, CHANGE date�_fi date_fin DATE NOT NULL');
    }
}
