<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230124163323 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE historiques_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE historiques (id INT NOT NULL, compte_id INT NOT NULL, type_action VARCHAR(255) NOT NULL, date_action TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B25FDE8DF2C56620 ON historiques (compte_id)');
        $this->addSql('ALTER TABLE historiques ADD CONSTRAINT FK_B25FDE8DF2C56620 FOREIGN KEY (compte_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE historiques_id_seq CASCADE');
        $this->addSql('ALTER TABLE historiques DROP CONSTRAINT FK_B25FDE8DF2C56620');
        $this->addSql('DROP TABLE historiques');
    }
}
