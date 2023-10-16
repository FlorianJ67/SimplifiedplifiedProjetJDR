<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231016044901 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE perso_objet DROP FOREIGN KEY FK_5E286C001221E019');
        $this->addSql('ALTER TABLE perso_objet DROP FOREIGN KEY FK_5E286C00F520CF5A');
        $this->addSql('DROP TABLE perso_objet');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE perso_objet (perso_id INT NOT NULL, objet_id INT NOT NULL, INDEX IDX_5E286C001221E019 (perso_id), INDEX IDX_5E286C00F520CF5A (objet_id), PRIMARY KEY(perso_id, objet_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE perso_objet ADD CONSTRAINT FK_5E286C001221E019 FOREIGN KEY (perso_id) REFERENCES perso (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE perso_objet ADD CONSTRAINT FK_5E286C00F520CF5A FOREIGN KEY (objet_id) REFERENCES objet (id) ON UPDATE NO ACTION ON DELETE CASCADE');
    }
}
