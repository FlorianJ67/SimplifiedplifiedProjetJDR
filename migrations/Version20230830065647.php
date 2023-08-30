<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230830065647 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE caracteristique (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE caracteristique_perso (id INT AUTO_INCREMENT NOT NULL, caracteristique_id INT DEFAULT NULL, perso_id INT DEFAULT NULL, valeur INT NOT NULL, INDEX IDX_A3E653BF1704EEB7 (caracteristique_id), INDEX IDX_A3E653BF1221E019 (perso_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, perso_id INT NOT NULL, contenu VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_67F068BCA76ED395 (user_id), INDEX IDX_67F068BC1221E019 (perso_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE competence (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE competence_influe_carac (id INT AUTO_INCREMENT NOT NULL, competence_id INT DEFAULT NULL, caracteristique_id INT DEFAULT NULL, valeur_bonus VARCHAR(255) NOT NULL, INDEX IDX_56A3445E15761DAB (competence_id), INDEX IDX_56A3445E1704EEB7 (caracteristique_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE competence_perso (id INT AUTO_INCREMENT NOT NULL, competence_id INT DEFAULT NULL, perso_id INT DEFAULT NULL, valeur INT NOT NULL, INDEX IDX_3740ABC715761DAB (competence_id), INDEX IDX_3740ABC71221E019 (perso_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inventaire (id INT AUTO_INCREMENT NOT NULL, objets_id INT NOT NULL, persos_id INT NOT NULL, quantite INT NOT NULL, INDEX IDX_338920E06C3A2500 (objets_id), INDEX IDX_338920E083083405 (persos_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE objet (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, valeur VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE perso (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, espece VARCHAR(255) NOT NULL, origine VARCHAR(255) NOT NULL, age VARCHAR(255) NOT NULL, sante INT NOT NULL, sante_max INT DEFAULT NULL, taille VARCHAR(255) NOT NULL, poids VARCHAR(255) NOT NULL, sex VARCHAR(255) NOT NULL, INDEX IDX_BD62FA21A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE perso_objet (perso_id INT NOT NULL, objet_id INT NOT NULL, INDEX IDX_5E286C001221E019 (perso_id), INDEX IDX_5E286C00F520CF5A (objet_id), PRIMARY KEY(perso_id, objet_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_perso (user_id INT NOT NULL, perso_id INT NOT NULL, INDEX IDX_5FA00179A76ED395 (user_id), INDEX IDX_5FA001791221E019 (perso_id), PRIMARY KEY(user_id, perso_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE caracteristique_perso ADD CONSTRAINT FK_A3E653BF1704EEB7 FOREIGN KEY (caracteristique_id) REFERENCES caracteristique (id)');
        $this->addSql('ALTER TABLE caracteristique_perso ADD CONSTRAINT FK_A3E653BF1221E019 FOREIGN KEY (perso_id) REFERENCES perso (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC1221E019 FOREIGN KEY (perso_id) REFERENCES perso (id)');
        $this->addSql('ALTER TABLE competence_influe_carac ADD CONSTRAINT FK_56A3445E15761DAB FOREIGN KEY (competence_id) REFERENCES competence (id)');
        $this->addSql('ALTER TABLE competence_influe_carac ADD CONSTRAINT FK_56A3445E1704EEB7 FOREIGN KEY (caracteristique_id) REFERENCES caracteristique (id)');
        $this->addSql('ALTER TABLE competence_perso ADD CONSTRAINT FK_3740ABC715761DAB FOREIGN KEY (competence_id) REFERENCES competence (id)');
        $this->addSql('ALTER TABLE competence_perso ADD CONSTRAINT FK_3740ABC71221E019 FOREIGN KEY (perso_id) REFERENCES perso (id)');
        $this->addSql('ALTER TABLE inventaire ADD CONSTRAINT FK_338920E06C3A2500 FOREIGN KEY (objets_id) REFERENCES objet (id)');
        $this->addSql('ALTER TABLE inventaire ADD CONSTRAINT FK_338920E083083405 FOREIGN KEY (persos_id) REFERENCES perso (id)');
        $this->addSql('ALTER TABLE perso ADD CONSTRAINT FK_BD62FA21A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE perso_objet ADD CONSTRAINT FK_5E286C001221E019 FOREIGN KEY (perso_id) REFERENCES perso (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE perso_objet ADD CONSTRAINT FK_5E286C00F520CF5A FOREIGN KEY (objet_id) REFERENCES objet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_perso ADD CONSTRAINT FK_5FA00179A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_perso ADD CONSTRAINT FK_5FA001791221E019 FOREIGN KEY (perso_id) REFERENCES perso (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE caracteristique_perso DROP FOREIGN KEY FK_A3E653BF1704EEB7');
        $this->addSql('ALTER TABLE caracteristique_perso DROP FOREIGN KEY FK_A3E653BF1221E019');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCA76ED395');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC1221E019');
        $this->addSql('ALTER TABLE competence_influe_carac DROP FOREIGN KEY FK_56A3445E15761DAB');
        $this->addSql('ALTER TABLE competence_influe_carac DROP FOREIGN KEY FK_56A3445E1704EEB7');
        $this->addSql('ALTER TABLE competence_perso DROP FOREIGN KEY FK_3740ABC715761DAB');
        $this->addSql('ALTER TABLE competence_perso DROP FOREIGN KEY FK_3740ABC71221E019');
        $this->addSql('ALTER TABLE inventaire DROP FOREIGN KEY FK_338920E06C3A2500');
        $this->addSql('ALTER TABLE inventaire DROP FOREIGN KEY FK_338920E083083405');
        $this->addSql('ALTER TABLE perso DROP FOREIGN KEY FK_BD62FA21A76ED395');
        $this->addSql('ALTER TABLE perso_objet DROP FOREIGN KEY FK_5E286C001221E019');
        $this->addSql('ALTER TABLE perso_objet DROP FOREIGN KEY FK_5E286C00F520CF5A');
        $this->addSql('ALTER TABLE user_perso DROP FOREIGN KEY FK_5FA00179A76ED395');
        $this->addSql('ALTER TABLE user_perso DROP FOREIGN KEY FK_5FA001791221E019');
        $this->addSql('DROP TABLE caracteristique');
        $this->addSql('DROP TABLE caracteristique_perso');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE competence');
        $this->addSql('DROP TABLE competence_influe_carac');
        $this->addSql('DROP TABLE competence_perso');
        $this->addSql('DROP TABLE inventaire');
        $this->addSql('DROP TABLE objet');
        $this->addSql('DROP TABLE perso');
        $this->addSql('DROP TABLE perso_objet');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE user_perso');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
