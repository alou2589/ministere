<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240422114937 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE conge_absence DROP FOREIGN KEY FK_A6D6BB6A65F4147');
        $this->addSql('DROP INDEX IDX_A6D6BB6A65F4147 ON conge_absence');
        $this->addSql('ALTER TABLE conge_absence DROP ty?pe_absence_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE conge_absence ADD ty?pe_absence_id INT NOT NULL');
        $this->addSql('ALTER TABLE conge_absence ADD CONSTRAINT FK_A6D6BB6A65F4147 FOREIGN KEY (ty?pe_absence_id) REFERENCES type_absence (id)');
        $this->addSql('CREATE INDEX IDX_A6D6BB6A65F4147 ON conge_absence (ty?pe_absence_id)');
    }
}
