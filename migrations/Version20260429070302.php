<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260429070302 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cabinet_medecin (cabinet_id INT NOT NULL, medecin_id INT NOT NULL, INDEX IDX_DC85F6AFD351EC (cabinet_id), INDEX IDX_DC85F6AF4F31A84 (medecin_id), PRIMARY KEY (cabinet_id, medecin_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE rendezvous (id INT AUTO_INCREMENT NOT NULL, date_heure DATETIME NOT NULL, duree_minutes INT NOT NULL, statut VARCHAR(255) NOT NULL, motif VARCHAR(255) NOT NULL, medecin_id INT NOT NULL, patient_id INT NOT NULL, INDEX IDX_C09A9BA84F31A84 (medecin_id), INDEX IDX_C09A9BA86B899279 (patient_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE cabinet_medecin ADD CONSTRAINT FK_DC85F6AFD351EC FOREIGN KEY (cabinet_id) REFERENCES cabinet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cabinet_medecin ADD CONSTRAINT FK_DC85F6AF4F31A84 FOREIGN KEY (medecin_id) REFERENCES medecin (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rendezvous ADD CONSTRAINT FK_C09A9BA84F31A84 FOREIGN KEY (medecin_id) REFERENCES medecin (id)');
        $this->addSql('ALTER TABLE rendezvous ADD CONSTRAINT FK_C09A9BA86B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE medecin_cabinet DROP FOREIGN KEY `FK_32C4C08D4F31A84`');
        $this->addSql('ALTER TABLE medecin_cabinet DROP FOREIGN KEY `FK_32C4C08DD351EC`');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY `FK_65E8AA0AA1799A53`');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY `FK_65E8AA0ACE0312AE`');
        $this->addSql('DROP TABLE medecin_cabinet');
        $this->addSql('DROP TABLE rendez_vous');
        $this->addSql('ALTER TABLE cabinet CHANGE nom nom VARCHAR(255) NOT NULL, CHANGE telephone telephone VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE consultation DROP FOREIGN KEY `FK_964685A6AC89C3AC`');
        $this->addSql('DROP INDEX UNIQ_964685A6AC89C3AC ON consultation');
        $this->addSql('ALTER TABLE consultation CHANGE id_rendez_vous_id rendez_vous_id INT NOT NULL');
        $this->addSql('ALTER TABLE consultation ADD CONSTRAINT FK_964685A691EF7EAA FOREIGN KEY (rendez_vous_id) REFERENCES rendezvous (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_964685A691EF7EAA ON consultation (rendez_vous_id)');
        $this->addSql('ALTER TABLE medecin CHANGE nom nom VARCHAR(255) NOT NULL, CHANGE prenom prenom VARCHAR(255) NOT NULL, CHANGE telephone telephone VARCHAR(15) NOT NULL, CHANGE email email VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE medicament CHANGE nom nom VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE ordonnance DROP FOREIGN KEY `FK_924B326C8BA1AF57`');
        $this->addSql('DROP INDEX UNIQ_924B326C8BA1AF57 ON ordonnance');
        $this->addSql('ALTER TABLE ordonnance CHANGE id_consultation_id consultation_id INT NOT NULL');
        $this->addSql('ALTER TABLE ordonnance ADD CONSTRAINT FK_924B326C62FF6CDF FOREIGN KEY (consultation_id) REFERENCES consultation (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_924B326C62FF6CDF ON ordonnance (consultation_id)');
        $this->addSql('ALTER TABLE patient CHANGE nom nom VARCHAR(255) NOT NULL, CHANGE prenom prenom VARCHAR(255) NOT NULL, CHANGE sexe sexe VARCHAR(1) NOT NULL, CHANGE telephone telephone VARCHAR(15) NOT NULL, CHANGE email email VARCHAR(255) NOT NULL, CHANGE numero_secu numero_secu VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE prescription DROP FOREIGN KEY `FK_1FBFB8D91525B092`');
        $this->addSql('ALTER TABLE prescription DROP FOREIGN KEY `FK_1FBFB8D995DAEAEA`');
        $this->addSql('DROP INDEX IDX_1FBFB8D995DAEAEA ON prescription');
        $this->addSql('DROP INDEX IDX_1FBFB8D91525B092 ON prescription');
        $this->addSql('ALTER TABLE prescription ADD ordonnance_id INT NOT NULL, ADD medicament_id INT NOT NULL, DROP id_medicament_id, DROP id_ordonnance_id');
        $this->addSql('ALTER TABLE prescription ADD CONSTRAINT FK_1FBFB8D92BF23B8F FOREIGN KEY (ordonnance_id) REFERENCES ordonnance (id)');
        $this->addSql('ALTER TABLE prescription ADD CONSTRAINT FK_1FBFB8D9AB0D61F7 FOREIGN KEY (medicament_id) REFERENCES medicament (id)');
        $this->addSql('CREATE INDEX IDX_1FBFB8D92BF23B8F ON prescription (ordonnance_id)');
        $this->addSql('CREATE INDEX IDX_1FBFB8D9AB0D61F7 ON prescription (medicament_id)');
        $this->addSql('ALTER TABLE specialite CHANGE description description VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE medecin_cabinet (medecin_id INT NOT NULL, cabinet_id INT NOT NULL, INDEX IDX_32C4C08DD351EC (cabinet_id), INDEX IDX_32C4C08D4F31A84 (medecin_id), PRIMARY KEY (medecin_id, cabinet_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE rendez_vous (id INT AUTO_INCREMENT NOT NULL, date_heure DATETIME NOT NULL, duree_minutes INT NOT NULL, statut VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, motif VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, id_patient_id INT NOT NULL, id_medecin_id INT NOT NULL, INDEX IDX_65E8AA0ACE0312AE (id_patient_id), INDEX IDX_65E8AA0AA1799A53 (id_medecin_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE medecin_cabinet ADD CONSTRAINT `FK_32C4C08D4F31A84` FOREIGN KEY (medecin_id) REFERENCES medecin (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE medecin_cabinet ADD CONSTRAINT `FK_32C4C08DD351EC` FOREIGN KEY (cabinet_id) REFERENCES cabinet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT `FK_65E8AA0AA1799A53` FOREIGN KEY (id_medecin_id) REFERENCES medecin (id)');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT `FK_65E8AA0ACE0312AE` FOREIGN KEY (id_patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE cabinet_medecin DROP FOREIGN KEY FK_DC85F6AFD351EC');
        $this->addSql('ALTER TABLE cabinet_medecin DROP FOREIGN KEY FK_DC85F6AF4F31A84');
        $this->addSql('ALTER TABLE rendezvous DROP FOREIGN KEY FK_C09A9BA84F31A84');
        $this->addSql('ALTER TABLE rendezvous DROP FOREIGN KEY FK_C09A9BA86B899279');
        $this->addSql('DROP TABLE cabinet_medecin');
        $this->addSql('DROP TABLE rendezvous');
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE cabinet CHANGE nom nom VARCHAR(50) NOT NULL, CHANGE telephone telephone VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE consultation DROP FOREIGN KEY FK_964685A691EF7EAA');
        $this->addSql('DROP INDEX UNIQ_964685A691EF7EAA ON consultation');
        $this->addSql('ALTER TABLE consultation CHANGE rendez_vous_id id_rendez_vous_id INT NOT NULL');
        $this->addSql('ALTER TABLE consultation ADD CONSTRAINT `FK_964685A6AC89C3AC` FOREIGN KEY (id_rendez_vous_id) REFERENCES rendez_vous (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_964685A6AC89C3AC ON consultation (id_rendez_vous_id)');
        $this->addSql('ALTER TABLE medecin CHANGE nom nom VARCHAR(50) NOT NULL, CHANGE prenom prenom VARCHAR(50) NOT NULL, CHANGE telephone telephone VARCHAR(20) NOT NULL, CHANGE email email VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE medicament CHANGE nom nom VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE ordonnance DROP FOREIGN KEY FK_924B326C62FF6CDF');
        $this->addSql('DROP INDEX UNIQ_924B326C62FF6CDF ON ordonnance');
        $this->addSql('ALTER TABLE ordonnance CHANGE consultation_id id_consultation_id INT NOT NULL');
        $this->addSql('ALTER TABLE ordonnance ADD CONSTRAINT `FK_924B326C8BA1AF57` FOREIGN KEY (id_consultation_id) REFERENCES consultation (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_924B326C8BA1AF57 ON ordonnance (id_consultation_id)');
        $this->addSql('ALTER TABLE patient CHANGE nom nom VARCHAR(50) NOT NULL, CHANGE prenom prenom VARCHAR(50) NOT NULL, CHANGE sexe sexe VARCHAR(10) NOT NULL, CHANGE telephone telephone VARCHAR(20) NOT NULL, CHANGE email email VARCHAR(50) NOT NULL, CHANGE numero_secu numero_secu VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE prescription DROP FOREIGN KEY FK_1FBFB8D92BF23B8F');
        $this->addSql('ALTER TABLE prescription DROP FOREIGN KEY FK_1FBFB8D9AB0D61F7');
        $this->addSql('DROP INDEX IDX_1FBFB8D92BF23B8F ON prescription');
        $this->addSql('DROP INDEX IDX_1FBFB8D9AB0D61F7 ON prescription');
        $this->addSql('ALTER TABLE prescription ADD id_medicament_id INT NOT NULL, ADD id_ordonnance_id INT NOT NULL, DROP ordonnance_id, DROP medicament_id');
        $this->addSql('ALTER TABLE prescription ADD CONSTRAINT `FK_1FBFB8D91525B092` FOREIGN KEY (id_medicament_id) REFERENCES medicament (id)');
        $this->addSql('ALTER TABLE prescription ADD CONSTRAINT `FK_1FBFB8D995DAEAEA` FOREIGN KEY (id_ordonnance_id) REFERENCES ordonnance (id)');
        $this->addSql('CREATE INDEX IDX_1FBFB8D995DAEAEA ON prescription (id_ordonnance_id)');
        $this->addSql('CREATE INDEX IDX_1FBFB8D91525B092 ON prescription (id_medicament_id)');
        $this->addSql('ALTER TABLE specialite CHANGE description description VARCHAR(255) NOT NULL');
    }
}
