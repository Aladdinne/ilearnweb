<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221117053314 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article (idarticle INT AUTO_INCREMENT NOT NULL, nomarticle VARCHAR(150) NOT NULL, idcreateur VARCHAR(255) NOT NULL, datecreation DATETIME NOT NULL, contenu VARCHAR(150) NOT NULL, etatarticle VARCHAR(150) NOT NULL, PRIMARY KEY(idarticle)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categoryrec (id INT AUTO_INCREMENT NOT NULL, category VARCHAR(150) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE command (idcommand INT AUTO_INCREMENT NOT NULL, datecommand DATETIME NOT NULL, total INT NOT NULL, etat VARCHAR(150) NOT NULL, iduser INT NOT NULL, PRIMARY KEY(idcommand)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaire (idcommentaire INT AUTO_INCREMENT NOT NULL, parent_id INT NOT NULL, contentcommentaire VARCHAR(150) NOT NULL, emailcommentaire VARCHAR(150) NOT NULL, nickname INT NOT NULL, created_at DATETIME NOT NULL, rgpd TINYINT(1) NOT NULL, PRIMARY KEY(idcommentaire)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cour (id INT AUTO_INCREMENT NOT NULL, idformation_id INT NOT NULL, nomcour VARCHAR(150) NOT NULL, nomformateur VARCHAR(150) NOT NULL, pdf VARCHAR(150) NOT NULL, video VARCHAR(150) NOT NULL, INDEX IDX_A71F964F14AF5727 (idformation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE devoir (id INT AUTO_INCREMENT NOT NULL, namedevoir VARCHAR(150) NOT NULL, dureedevoir VARCHAR(150) NOT NULL, datecreation VARCHAR(150) NOT NULL, contenu VARCHAR(150) NOT NULL, category VARCHAR(150) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evenement (idevenement INT AUTO_INCREMENT NOT NULL, nom_evenement VARCHAR(150) NOT NULL, sujetev VARCHAR(150) NOT NULL, dateev DATETIME NOT NULL, heureev DATETIME NOT NULL, lieuev VARCHAR(150) NOT NULL, nomcreateurev VARCHAR(150) NOT NULL, PRIMARY KEY(idevenement)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formation (id INT AUTO_INCREMENT NOT NULL, nomformation VARCHAR(150) NOT NULL, description VARCHAR(150) NOT NULL, datecreation DATETIME NOT NULL, duree VARCHAR(150) NOT NULL, category VARCHAR(150) NOT NULL, prix DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lignecommande (idlignecommand INT AUTO_INCREMENT NOT NULL, prix DOUBLE PRECISION NOT NULL, idcommand INT NOT NULL, idformation INT NOT NULL, PRIMARY KEY(idlignecommand)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (idmessage INT AUTO_INCREMENT NOT NULL, idemetteur INT NOT NULL, idroom INT NOT NULL, message VARCHAR(150) NOT NULL, PRIMARY KEY(idmessage)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, iddevoir_id INT DEFAULT NULL, numquestion INT NOT NULL, contenu VARCHAR(150) NOT NULL, reponse VARCHAR(150) NOT NULL, point DOUBLE PRECISION NOT NULL, INDEX IDX_B6F7494EBB98FABB (iddevoir_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reclamation (id VARCHAR(255) NOT NULL, iduser_id INT DEFAULT NULL, idcategory_id INT DEFAULT NULL, datereclamation DATETIME NOT NULL, contenu VARCHAR(150) NOT NULL, etatreclamation VARCHAR(150) NOT NULL, UNIQUE INDEX UNIQ_CE606404786A81FB (iduser_id), INDEX IDX_CE606404D487ED4D (idcategory_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rendezvous (idrdv INT AUTO_INCREMENT NOT NULL, daterdv DATETIME NOT NULL, dureerdv VARCHAR(150) NOT NULL, tel INT NOT NULL, motif VARCHAR(150) NOT NULL, etatrdv VARCHAR(150) NOT NULL, idformateur INT NOT NULL, idclient INT NOT NULL, PRIMARY KEY(idrdv)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reponse (idreponse INT AUTO_INCREMENT NOT NULL, idquestion_id INT DEFAULT NULL, idetudiant_id INT DEFAULT NULL, contenu VARCHAR(150) NOT NULL, note INT NOT NULL, etat TINYINT(1) NOT NULL, INDEX IDX_5FB6DEC7D8E68610 (idquestion_id), INDEX IDX_5FB6DEC71B2BC10C (idetudiant_id), PRIMARY KEY(idreponse)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE room (idroom INT AUTO_INCREMENT NOT NULL, nomroom VARCHAR(150) NOT NULL, nomcreator VARCHAR(150) NOT NULL, nomrecepteur VARCHAR(150) NOT NULL, PRIMARY KEY(idroom)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(150) NOT NULL, username VARCHAR(150) NOT NULL, userpwd INT NOT NULL, daten DATETIME NOT NULL, email VARCHAR(150) NOT NULL, role VARCHAR(150) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cour ADD CONSTRAINT FK_A71F964F14AF5727 FOREIGN KEY (idformation_id) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494EBB98FABB FOREIGN KEY (iddevoir_id) REFERENCES devoir (id)');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE606404786A81FB FOREIGN KEY (iduser_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE606404D487ED4D FOREIGN KEY (idcategory_id) REFERENCES categoryrec (id)');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC7D8E68610 FOREIGN KEY (idquestion_id) REFERENCES question (id)');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC71B2BC10C FOREIGN KEY (idetudiant_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cour DROP FOREIGN KEY FK_A71F964F14AF5727');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494EBB98FABB');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE606404786A81FB');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE606404D487ED4D');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC7D8E68610');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC71B2BC10C');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE categoryrec');
        $this->addSql('DROP TABLE command');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE cour');
        $this->addSql('DROP TABLE devoir');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE formation');
        $this->addSql('DROP TABLE lignecommande');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE reclamation');
        $this->addSql('DROP TABLE rendezvous');
        $this->addSql('DROP TABLE reponse');
        $this->addSql('DROP TABLE room');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
