<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231023095204 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE maintenance ADD matos_id INT NOT NULL, CHANGE date_maintenance date_attribution DATE NOT NULL');
        $this->addSql('ALTER TABLE maintenance ADD CONSTRAINT FK_2F84F8E968569149 FOREIGN KEY (matos_id) REFERENCES materiel (id)');
        $this->addSql('CREATE INDEX IDX_2F84F8E968569149 ON maintenance (matos_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE maintenance DROP FOREIGN KEY FK_2F84F8E968569149');
        $this->addSql('DROP INDEX IDX_2F84F8E968569149 ON maintenance');
        $this->addSql('ALTER TABLE maintenance DROP matos_id, CHANGE date_attribution date_maintenance DATE NOT NULL');
    }
}
