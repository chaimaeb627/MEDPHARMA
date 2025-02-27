<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250226001541 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produit CHANGE prix prix NUMERIC(10, 2) NOT NULL, CHANGE prix_promo prix_promo NUMERIC(10, 2) DEFAULT NULL, CHANGE description description VARCHAR(500) DEFAULT NULL, CHANGE image image VARCHAR(255) DEFAULT NULL, CHANGE categorie categorie VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produit CHANGE description description VARCHAR(255) NOT NULL, CHANGE prix prix NUMERIC(7, 2) NOT NULL, CHANGE prix_promo prix_promo NUMERIC(7, 2) NOT NULL, CHANGE image image VARCHAR(255) NOT NULL, CHANGE categorie categorie VARCHAR(100) NOT NULL');
    }
}
