<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231102221309 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE agent (id INT AUTO_INCREMENT NOT NULL, poste_id INT NOT NULL, sous_structure_id INT NOT NULL, type_agent_id INT NOT NULL, prenom VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, date_naissance DATE NOT NULL, lieu_naissance VARCHAR(255) NOT NULL, genre VARCHAR(255) NOT NULL, matricule VARCHAR(255) NOT NULL, fonction VARCHAR(255) NOT NULL, INDEX IDX_268B9C9DA0905086 (poste_id), INDEX IDX_268B9C9D9AA458EE (sous_structure_id), INDEX IDX_268B9C9DF9EB56F7 (type_agent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE attribution (id INT AUTO_INCREMENT NOT NULL, matos_id INT NOT NULL, agent_id INT NOT NULL, qr_code_attribution LONGTEXT NOT NULL, date_attribution DATE NOT NULL, INDEX IDX_C751ED4968569149 (matos_id), INDEX IDX_C751ED493414710B (agent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE carte_pro (id INT AUTO_INCREMENT NOT NULL, agent_id INT NOT NULL, date_delivrance DATE NOT NULL, date_expiration DATE NOT NULL, qrcode_agent LONGTEXT NOT NULL, photo_agent VARCHAR(255) DEFAULT NULL, status_impression VARCHAR(255) NOT NULL, INDEX IDX_22AB6F1B3414710B (agent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie_materiel (id INT AUTO_INCREMENT NOT NULL, nom_categorie_matos VARCHAR(255) NOT NULL, description_categorie_matos LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fournisseur (id INT AUTO_INCREMENT NOT NULL, nom_fournisseur VARCHAR(255) NOT NULL, contact_fournisseur LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE historique_rh (id INT AUTO_INCREMENT NOT NULL, date_action DATETIME NOT NULL, type_action VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE historiques (id INT AUTO_INCREMENT NOT NULL, compte_id INT NOT NULL, type_action VARCHAR(255) NOT NULL, date_action DATETIME NOT NULL, INDEX IDX_B25FDE8DF2C56620 (compte_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE maintenance (id INT AUTO_INCREMENT NOT NULL, matos_id INT NOT NULL, date_maintenance DATE NOT NULL, status_matos VARCHAR(255) NOT NULL, date_sortie DATE NOT NULL, INDEX IDX_2F84F8E968569149 (matos_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE marque_matos (id INT AUTO_INCREMENT NOT NULL, nom_marque_matos VARCHAR(255) NOT NULL, description_marque_matos LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE materiel (id INT AUTO_INCREMENT NOT NULL, type_matos_id INT NOT NULL, fournisseur_id INT NOT NULL, marque_matos_id INT NOT NULL, modele_matos VARCHAR(255) NOT NULL, sn_matos VARCHAR(255) NOT NULL, date_reception DATETIME NOT NULL, info_matos LONGTEXT NOT NULL, INDEX IDX_18D2B091A5A9B6B5 (type_matos_id), INDEX IDX_18D2B091670C757F (fournisseur_id), INDEX IDX_18D2B091552AF01 (marque_matos_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messages (id INT AUTO_INCREMENT NOT NULL, destinataire_id INT NOT NULL, expediteur_id INT NOT NULL, titre VARCHAR(255) NOT NULL, contenu LONGTEXT NOT NULL, date_envoi DATE NOT NULL, status VARCHAR(255) NOT NULL, INDEX IDX_DB021E96A4F84F6E (destinataire_id), INDEX IDX_DB021E9610335F61 (expediteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notification (id INT AUTO_INCREMENT NOT NULL, ticket_id INT NOT NULL, titre VARCHAR(255) NOT NULL, contenu LONGTEXT NOT NULL, date_notification DATETIME NOT NULL, status TINYINT(1) NOT NULL, INDEX IDX_BF5476CA700047D2 (ticket_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE poste (id INT AUTO_INCREMENT NOT NULL, nom_poste VARCHAR(255) NOT NULL, description_poste LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sous_structure (id INT AUTO_INCREMENT NOT NULL, type_sous_structure_id INT NOT NULL, structure_id INT NOT NULL, nom_sous_structure VARCHAR(255) NOT NULL, description_sous_structure LONGTEXT NOT NULL, INDEX IDX_7408DCA526954475 (type_sous_structure_id), INDEX IDX_7408DCA52534008B (structure_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE statut_agent (id INT AUTO_INCREMENT NOT NULL, agent_id INT NOT NULL, echellon VARCHAR(255) NOT NULL, grade VARCHAR(255) NOT NULL, hierarchie VARCHAR(255) NOT NULL, date_prise_service DATE NOT NULL, date_avancement DATE NOT NULL, INDEX IDX_1476F3E33414710B (agent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE structure (id INT AUTO_INCREMENT NOT NULL, type_structure_id INT NOT NULL, nom_structure VARCHAR(255) NOT NULL, description_structure LONGTEXT NOT NULL, INDEX IDX_6F0137EAA277BA8E (type_structure_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE technicien (id INT AUTO_INCREMENT NOT NULL, info_technicien_id INT NOT NULL, INDEX IDX_96282C4C5BDA99CA (info_technicien_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ticket (id INT AUTO_INCREMENT NOT NULL, matos_id INT NOT NULL, technicien_id INT NOT NULL, description_proprietaire LONGTEXT NOT NULL, date_declaration DATETIME NOT NULL, observation_technicien LONGTEXT NOT NULL, solution_apportee LONGTEXT NOT NULL, date_sortie DATETIME NOT NULL, status_ticket VARCHAR(255) NOT NULL, type_urgence VARCHAR(255) NOT NULL, statut_matos VARCHAR(255) NOT NULL, INDEX IDX_97A0ADA368569149 (matos_id), INDEX IDX_97A0ADA313457256 (technicien_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_agent (id INT AUTO_INCREMENT NOT NULL, nom_type_agent VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_materiel (id INT AUTO_INCREMENT NOT NULL, categorie_matos_id INT NOT NULL, nom_type_matos VARCHAR(255) NOT NULL, INDEX IDX_D52D976D50D1D023 (categorie_matos_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_sous_structure (id INT AUTO_INCREMENT NOT NULL, nom_type_sous_structure VARCHAR(255) NOT NULL, description_type_sous_structure LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_structure (id INT AUTO_INCREMENT NOT NULL, nom_type_structure VARCHAR(255) NOT NULL, description_type_structure LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, agent_id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, nb_connect INT DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D6493414710B (agent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE agent ADD CONSTRAINT FK_268B9C9DA0905086 FOREIGN KEY (poste_id) REFERENCES poste (id)');
        $this->addSql('ALTER TABLE agent ADD CONSTRAINT FK_268B9C9D9AA458EE FOREIGN KEY (sous_structure_id) REFERENCES sous_structure (id)');
        $this->addSql('ALTER TABLE agent ADD CONSTRAINT FK_268B9C9DF9EB56F7 FOREIGN KEY (type_agent_id) REFERENCES type_agent (id)');
        $this->addSql('ALTER TABLE attribution ADD CONSTRAINT FK_C751ED4968569149 FOREIGN KEY (matos_id) REFERENCES materiel (id)');
        $this->addSql('ALTER TABLE attribution ADD CONSTRAINT FK_C751ED493414710B FOREIGN KEY (agent_id) REFERENCES agent (id)');
        $this->addSql('ALTER TABLE carte_pro ADD CONSTRAINT FK_22AB6F1B3414710B FOREIGN KEY (agent_id) REFERENCES agent (id)');
        $this->addSql('ALTER TABLE historiques ADD CONSTRAINT FK_B25FDE8DF2C56620 FOREIGN KEY (compte_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE maintenance ADD CONSTRAINT FK_2F84F8E968569149 FOREIGN KEY (matos_id) REFERENCES materiel (id)');
        $this->addSql('ALTER TABLE materiel ADD CONSTRAINT FK_18D2B091A5A9B6B5 FOREIGN KEY (type_matos_id) REFERENCES type_materiel (id)');
        $this->addSql('ALTER TABLE materiel ADD CONSTRAINT FK_18D2B091670C757F FOREIGN KEY (fournisseur_id) REFERENCES fournisseur (id)');
        $this->addSql('ALTER TABLE materiel ADD CONSTRAINT FK_18D2B091552AF01 FOREIGN KEY (marque_matos_id) REFERENCES marque_matos (id)');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT FK_DB021E96A4F84F6E FOREIGN KEY (destinataire_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT FK_DB021E9610335F61 FOREIGN KEY (expediteur_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CA700047D2 FOREIGN KEY (ticket_id) REFERENCES ticket (id)');
        $this->addSql('ALTER TABLE sous_structure ADD CONSTRAINT FK_7408DCA526954475 FOREIGN KEY (type_sous_structure_id) REFERENCES type_sous_structure (id)');
        $this->addSql('ALTER TABLE sous_structure ADD CONSTRAINT FK_7408DCA52534008B FOREIGN KEY (structure_id) REFERENCES structure (id)');
        $this->addSql('ALTER TABLE statut_agent ADD CONSTRAINT FK_1476F3E33414710B FOREIGN KEY (agent_id) REFERENCES agent (id)');
        $this->addSql('ALTER TABLE structure ADD CONSTRAINT FK_6F0137EAA277BA8E FOREIGN KEY (type_structure_id) REFERENCES type_structure (id)');
        $this->addSql('ALTER TABLE technicien ADD CONSTRAINT FK_96282C4C5BDA99CA FOREIGN KEY (info_technicien_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA368569149 FOREIGN KEY (matos_id) REFERENCES materiel (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA313457256 FOREIGN KEY (technicien_id) REFERENCES technicien (id)');
        $this->addSql('ALTER TABLE type_materiel ADD CONSTRAINT FK_D52D976D50D1D023 FOREIGN KEY (categorie_matos_id) REFERENCES categorie_materiel (id)');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D6493414710B FOREIGN KEY (agent_id) REFERENCES agent (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE agent DROP FOREIGN KEY FK_268B9C9DA0905086');
        $this->addSql('ALTER TABLE agent DROP FOREIGN KEY FK_268B9C9D9AA458EE');
        $this->addSql('ALTER TABLE agent DROP FOREIGN KEY FK_268B9C9DF9EB56F7');
        $this->addSql('ALTER TABLE attribution DROP FOREIGN KEY FK_C751ED4968569149');
        $this->addSql('ALTER TABLE attribution DROP FOREIGN KEY FK_C751ED493414710B');
        $this->addSql('ALTER TABLE carte_pro DROP FOREIGN KEY FK_22AB6F1B3414710B');
        $this->addSql('ALTER TABLE historiques DROP FOREIGN KEY FK_B25FDE8DF2C56620');
        $this->addSql('ALTER TABLE maintenance DROP FOREIGN KEY FK_2F84F8E968569149');
        $this->addSql('ALTER TABLE materiel DROP FOREIGN KEY FK_18D2B091A5A9B6B5');
        $this->addSql('ALTER TABLE materiel DROP FOREIGN KEY FK_18D2B091670C757F');
        $this->addSql('ALTER TABLE materiel DROP FOREIGN KEY FK_18D2B091552AF01');
        $this->addSql('ALTER TABLE messages DROP FOREIGN KEY FK_DB021E96A4F84F6E');
        $this->addSql('ALTER TABLE messages DROP FOREIGN KEY FK_DB021E9610335F61');
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CA700047D2');
        $this->addSql('ALTER TABLE sous_structure DROP FOREIGN KEY FK_7408DCA526954475');
        $this->addSql('ALTER TABLE sous_structure DROP FOREIGN KEY FK_7408DCA52534008B');
        $this->addSql('ALTER TABLE statut_agent DROP FOREIGN KEY FK_1476F3E33414710B');
        $this->addSql('ALTER TABLE structure DROP FOREIGN KEY FK_6F0137EAA277BA8E');
        $this->addSql('ALTER TABLE technicien DROP FOREIGN KEY FK_96282C4C5BDA99CA');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA368569149');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA313457256');
        $this->addSql('ALTER TABLE type_materiel DROP FOREIGN KEY FK_D52D976D50D1D023');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D6493414710B');
        $this->addSql('DROP TABLE agent');
        $this->addSql('DROP TABLE attribution');
        $this->addSql('DROP TABLE carte_pro');
        $this->addSql('DROP TABLE categorie_materiel');
        $this->addSql('DROP TABLE fournisseur');
        $this->addSql('DROP TABLE historique_rh');
        $this->addSql('DROP TABLE historiques');
        $this->addSql('DROP TABLE maintenance');
        $this->addSql('DROP TABLE marque_matos');
        $this->addSql('DROP TABLE materiel');
        $this->addSql('DROP TABLE messages');
        $this->addSql('DROP TABLE notification');
        $this->addSql('DROP TABLE poste');
        $this->addSql('DROP TABLE sous_structure');
        $this->addSql('DROP TABLE statut_agent');
        $this->addSql('DROP TABLE structure');
        $this->addSql('DROP TABLE technicien');
        $this->addSql('DROP TABLE ticket');
        $this->addSql('DROP TABLE type_agent');
        $this->addSql('DROP TABLE type_materiel');
        $this->addSql('DROP TABLE type_sous_structure');
        $this->addSql('DROP TABLE type_structure');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
