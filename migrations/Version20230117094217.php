<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230117094217 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE carte_pro_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE carte_pro (id INT NOT NULL, agent_id INT NOT NULL, date_delivrance DATE NOT NULL, date_expiration DATE NOT NULL, qrcode_agent TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_22AB6F1B3414710B ON carte_pro (agent_id)');
        $this->addSql('ALTER TABLE carte_pro ADD CONSTRAINT FK_22AB6F1B3414710B FOREIGN KEY (agent_id) REFERENCES agent (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE carte_pro_id_seq CASCADE');
        $this->addSql('ALTER TABLE carte_pro DROP CONSTRAINT FK_22AB6F1B3414710B');
        $this->addSql('DROP TABLE carte_pro');
    }
}
