<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260408123800 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Ajout de l entite categorie et de la relation many-to-many produit/categorie';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_497DD6346C6E55A5 (nom), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit_categorie (produit_id INT NOT NULL, categorie_id INT NOT NULL, INDEX IDX_AA47B95CF347EFB (produit_id), INDEX IDX_AA47B95CBCF5E72D (categorie_id), PRIMARY KEY(produit_id, categorie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE produit_categorie ADD CONSTRAINT FK_AA47B95CF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE produit_categorie ADD CONSTRAINT FK_AA47B95CBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE produit_categorie DROP FOREIGN KEY FK_AA47B95CF347EFB');
        $this->addSql('ALTER TABLE produit_categorie DROP FOREIGN KEY FK_AA47B95CBCF5E72D');
        $this->addSql('DROP TABLE produit_categorie');
        $this->addSql('DROP TABLE categorie');
    }
}
