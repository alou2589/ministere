<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241008133648 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE affectation_vehicule (id INT AUTO_INCREMENT NOT NULL, vehicule_id INT DEFAULT NULL, affectation_id INT DEFAULT NULL, etat_vehicule_id INT DEFAULT NULL, date_affectation_vehicule DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_72335E2E4A4A3511 (vehicule_id), INDEX IDX_72335E2E6D0ABA22 (affectation_id), INDEX IDX_72335E2E273E9DC6 (etat_vehicule_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE affectation_vehicule ADD CONSTRAINT FK_72335E2E4A4A3511 FOREIGN KEY (vehicule_id) REFERENCES vehicule (id)');
        $this->addSql('ALTER TABLE affectation_vehicule ADD CONSTRAINT FK_72335E2E6D0ABA22 FOREIGN KEY (affectation_id) REFERENCES affectation (id)');
        $this->addSql('ALTER TABLE affectation_vehicule ADD CONSTRAINT FK_72335E2E273E9DC6 FOREIGN KEY (etat_vehicule_id) REFERENCES etat_vehicule (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE affectation_vehicule DROP FOREIGN KEY FK_72335E2E4A4A3511');
        $this->addSql('ALTER TABLE affectation_vehicule DROP FOREIGN KEY FK_72335E2E6D0ABA22');
        $this->addSql('ALTER TABLE affectation_vehicule DROP FOREIGN KEY FK_72335E2E273E9DC6');
        $this->addSql('DROP TABLE affectation_vehicule');
    }
}
