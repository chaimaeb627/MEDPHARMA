<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250225235534 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commande_medicament (commande_id INT NOT NULL, medicament_id INT NOT NULL, INDEX IDX_25E5EDC82EA2E54 (commande_id), INDEX IDX_25E5EDCAB0D61F7 (medicament_id), PRIMARY KEY(commande_id, medicament_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commande_medicament ADD CONSTRAINT FK_25E5EDC82EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commande_medicament ADD CONSTRAINT FK_25E5EDCAB0D61F7 FOREIGN KEY (medicament_id) REFERENCES medicament (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commande CHANGE medicammentcommande medicamentcommande VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE produit CHANGE prix prix NUMERIC(10, 2) NOT NULL, CHANGE prix_promo prix_promo NUMERIC(10, 2) DEFAULT NULL, CHANGE description description VARCHAR(500) DEFAULT NULL, CHANGE image image VARCHAR(255) DEFAULT NULL, CHANGE categorie categorie VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande_medicament DROP FOREIGN KEY FK_25E5EDC82EA2E54');
        $this->addSql('ALTER TABLE commande_medicament DROP FOREIGN KEY FK_25E5EDCAB0D61F7');
        $this->addSql('DROP TABLE commande_medicament');
        $this->addSql('ALTER TABLE commande CHANGE medicamentcommande medicammentcommande VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE produit CHANGE description description VARCHAR(255) NOT NULL, CHANGE prix prix NUMERIC(7, 2) NOT NULL, CHANGE prix_promo prix_promo NUMERIC(7, 2) NOT NULL, CHANGE image image VARCHAR(255) NOT NULL, CHANGE categorie categorie VARCHAR(100) NOT NULL');
    }
}
