<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230126123940 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE materiel DROP stockage_matos');
        $this->addSql('ALTER TABLE materiel DROP ram_matos');
        $this->addSql('ALTER TABLE materiel DROP os_matos');
        $this->addSql('ALTER TABLE materiel DROP processeur_matos');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE materiel ADD stockage_matos VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE materiel ADD ram_matos VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE materiel ADD os_matos VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE materiel ADD processeur_matos VARCHAR(255) DEFAULT NULL');
    }
}
